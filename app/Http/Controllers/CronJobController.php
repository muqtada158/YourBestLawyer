<?php

namespace App\Http\Controllers;

use App\Http\Traits\StripePaymentTrait;
use App\Models\CaseAttornies;
use App\Models\CaseBid;
use App\Models\CaseDetail;
use App\Models\CustomerContract;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CronJobController extends Controller
{
    use StripePaymentTrait;

/**
 * Charge customer installments for partially paid payment plans.
 *
 * This function checks all enabled payment plans with a "PartiallyPaid" status.
 * For each payment plan, it checks if there is a pending transaction for today.
 * If a pending transaction exists, it attempts to charge the customer using Stripe and updates the transaction status accordingly.
 * If the payment succeeds, the status is updated to "Success", and if all installments are paid, the payment plan status is updated to "Paid".
 * If the payment fails, the status is updated to "Failed".
 * It also sends success/failure email notifications to both the customer and attorney.
 *
 * @return string
 */
    public function chargeCustomerInstallments()
    {
        $current_date = Carbon::now()->toDateString();

        $get_payment_plans = PaymentPlan::with('getTransactions')
            ->where('status', 'Enabled')
            ->where('payment_status', 'PartiallyPaid')
            ->get();


        if ($get_payment_plans->isNotEmpty()) {
            foreach ($get_payment_plans as $payment_plan) {
                $getTotalInstallment = Transactions::where('payment_plan_id', $payment_plan->id)->where('installment_cycle_no', "!=", 0)->count();

                $getTransaction = Transactions::where('payment_plan_id', $payment_plan->id)
                    ->where('date_of_charge', $current_date)
                    ->where('status', 'Pending')
                    ->first();
                if ($getTransaction) {
                    $customerStripeId = $getTransaction->getCustomers->getCustomerPaymentDetails->stripe_customer_id;
                    $paymentMethodId = $this->getCustomerDefaultPaymentMethodId($customerStripeId); //fetching payment_id
                    $amount = $getTransaction->amount * 100;
                    $description = "YBL Invoice # " . $payment_plan->invoice_no . " Installment No. " . $getTransaction->installment_cycle_no;
                    $platformFee = 0;
                    $vendorStripeConnectAccountId = $getTransaction->getAttornies->getAttorneyPaymentDetails->stripe_attorney_connect_id;

                    $charge = $this->createStripeCharge(
                        $customerStripeId,
                        $amount,
                        $description,
                        $platformFee,
                        $vendorStripeConnectAccountId
                    );

                    // Confirm the Payment Intent if required
                    if ($charge->status === 'requires_payment_method') {
                        $charge = $this->confirmPaymentIntent($charge->id, $paymentMethodId);
                    }

                    if ($charge->status === 'succeeded') {
                        $getTransaction->stripe_charge_id = $charge->id;
                        $getTransaction->stripe_charge_ybl_fee = $charge->application_fee_amount;
                        $getTransaction->stripe_charge_json = $charge;
                        $getTransaction->status = 'Success';
                        $getTransaction->save();

                        if ($getTransaction->installment_cycle_no == $getTotalInstallment) {
                            $payment_plan->payment_status = 'Paid';
                            $payment_plan->save();
                        } else {
                            $payment_plan->payment_status = 'PartiallyPaid';
                            $payment_plan->save();
                        }

                        //sending email
                        $this->sendEmail(
                            $getTransaction->getAttornies->email,
                            'Transaction Processed & Success',
                            'Your payment against Case Sr No # ' . $getTransaction->getCaseDetails->sr_no . ' has been successfully processed. Installment no # ' . $getTransaction->installment_cycle_no . ' has been paid. Thank you'
                        );
                        $this->sendEmail(
                            $getTransaction->getCustomers->email,
                            'Transaction Processed & Success',
                            'Your payment against Case Sr No # ' . $getTransaction->getCaseDetails->sr_no . ' has been successfully processed. Installment no # ' . $getTransaction->installment_cycle_no . ' has been paid. Thank you'
                        );
                    } else {
                        $getTransaction->status = 'Failed';
                        $getTransaction->save();
                        $this->sendEmail(
                            $getTransaction->getAttornies->email,
                            'Transaction Failed',
                            'Your payment against Case Sr No # ' . $getTransaction->getCaseDetails->sr_no . ' has been failed. Kindly check your details on YourBestLawyer.com portal. Thankyou.'
                        );
                        $this->sendEmail(
                            $getTransaction->getCustomers->email,
                            'Transaction Failed',
                            'Your payment against Case Sr No # ' . $getTransaction->getCaseDetails->sr_no . ' has been failed. Kindly check your details on YourBestLawyer.com portal. Thankyou.'
                        );
                    }
                }
            }
            // dd('no matches');
        }
        return 'cronjob for installments run successfully...';
        // 0 0 * * * /usr/bin/curl -s "https://yourbestlawyer.com/charge-customer-installments"
    }

/**
 * Delete a case if it has been 48 hours without receiving a bid.
 *
 * This function checks all accepted cases that have the status "Pending". If no leads (attorneys) are associated with the case and 48 hours have passed since its creation,
 * the case is deleted, and the user’s restricted steps are updated. An email notification is sent to the user informing them of the rejection due to the expiration of the 48-hour timeframe.
 *
 * @return string
 */
    public function deleteFirstCaseAfter48Hours()
    {
        //the reset restricted_steps is 9 for application form
        $case = CaseDetail::where('application_status', 'Accepted')->where('case_status', 'Pending')->get();

        if ($case->count() > 0) {
            foreach ($case as $caseDetail) {
                $leads = CaseAttornies::where('case_id', $caseDetail->id)->get()->count();

                //check if this case got any leads
                if ($leads < 1) {
                    if ($caseDetail->created_at && $caseDetail->created_at->lt(Carbon::now()->subHours(48))) {
                        DB::beginTransaction();

                        try {
                            if ($caseDetail->getUser->restricted_steps == 13) {
                                $user = $caseDetail->getUser;
                                $user->restricted_steps = 9;
                                $user->save();
                            }

                            $caseDetail->delete();
                            $this->sendEmail(
                                $caseDetail->getUser->email,
                                'Application Rejected',
                                'Your application has been automatically rejected due to the 48-hour timeframe expiring without receiving a bid. Please consider submitting a new application with an updated bid.'
                            );

                            DB::commit();
                        } catch (\Throwable $th) {
                            DB::rollBack();
                            return $th;
                        }
                    }
                }
            }
        }


        return 'cronjob for delete application after 48 hours run successfully...';
        // 0 * * * * /usr/bin/curl -s http://yourbestlawyer.com/delete-case-application-after-48-hours

    }

/**
 * Delete a contract after 48 hours if not accepted.
 *
 * This function checks for pending contracts that have exceeded the 48-hour timeframe without being accepted by an attorney.
 * If a contract is expired, its status is changed to "Rejected", and the related case is reverted to "Pending".
 * Additionally, the case attorney's status is set to "NotInterested". An email notification is sent to the customer.
 *
 * @return string
 */
    public function deleteContractAfter48Hours() {
        $contracts = CustomerContract::where('status','Pending')->get();
        if($contracts->count() > 0){
            foreach($contracts as $contract)
            {
                if ($contract->created_at && $contract->created_at->lt(Carbon::now()->subHours(48))) {

                    DB::beginTransaction();
                    $contract->status = 'Rejected';
                    $contract->save();

                    $case_details = CaseDetail::where('id',$contract->case_id)->update(['case_status'=>'Pending']);

                    $case_attornies = CaseAttornies::where('case_id',$contract->case_id)->where('attorney_id',$contract->attorney_id)->first();
                    $case_attornies->status = "NotInterested";
                    $case_attornies->save();

                    if($contract->getCustomer->restricted_steps == 17)
                    {
                        $contract->getCustomer->restricted_steps = 13;
                        $contract->getCustomer->save();
                    }

                    DB::commit();
                    //sending email to attorney
                    $this->sendEmail(
                        $contract->getCustomer->email,
                        'Your Contract has been rejected.',
                        'Your Contract has been rejected due to the 48-hour timeframe expiring without receiving acceptance from attorney. Please consider sending a new contract to another attorney.'
                    );
                }
            }
        }
        return 'cronjob for delete contract after 48hours run successfully...';
        // 0 */6 * * * curl -s http://yourbestlawyer.com/delete-contract-after-48-hours
    }
}
