<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use App\Http\Traits\NumberGeneratorTrait;
use App\Http\Traits\StripePaymentTrait;
use App\Models\AttorneyPaymentsToYbl;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttorneyPaymentTransactionController extends Controller
{
    use StripePaymentTrait;
    use NumberGeneratorTrait;

    /**
 * Displays the list of payment transactions for the logged-in attorney.
 *
 * This method retrieves all payment plans associated with the attorney, where the invoice number is not null.
 * It orders the invoices by ID in descending order and paginates the results to show 10 invoices per page.
 *
 * @return \Illuminate\Http\Response The view displaying the payment transactions.
 */
    public function payment_transactions()
    {
        $getInvoices = PaymentPlan::where('attorney_id',auth()->user()->id)
        ->where('invoice_no','!=',null)
        ->orderby('id','DESC')
        ->paginate(10);
        return view('attorney.payment-transactions',compact('getInvoices'));
    }

    /**
 * Displays the list of transactions for a specific payment plan.
 *
 * This method retrieves the invoice and associated transactions based on the given payment plan ID.
 *
 * @param  int  $id The ID of the payment plan.
 * @return \Illuminate\Http\Response The view displaying the transactions for the payment plan.
 */
    public function transactions($id)
    {
        $getInvoice = PaymentPlan::where('id',$id)->first();
        $getTransactions = Transactions::where('payment_plan_id',$id)->get();
        return view('attorney.transactions',compact('getTransactions','getInvoice'));
    }

    /**
 * Displays the list of invoices for the logged-in attorney.
 *
 * This method retrieves all invoices associated with the logged-in attorney, ordered by ID in descending order,
 * and paginates the results to show 10 invoices per page.
 *
 * @return \Illuminate\Http\Response The view displaying the attorney's invoices.
 */
    public function attorneyInvoices()
    {
        $getInvoice = AttorneyPaymentsToYbl::where('attorney_id',auth()->user()->id)->orderby('id','DESC')->paginate(10);
        return view('attorney.my-invoices',compact('getInvoice'));
    }
    public function payment_transactions_add()
    {
        return view('attorney.payment-transactions-add');
    }

/**
 * Manually applies a transaction to a payment plan.
 *
 * This method handles the manual application of a failed transaction to a payment plan. It attempts to charge the
 * customer using Stripe and updates the transaction status to "Success" or "Failed" depending on the result.
 * If the transaction is the last installment, the payment plan is marked as "Paid". Otherwise, it is marked as "PartiallyPaid".
 *
 * @param  int  $payment_plan_id The ID of the payment plan.
 * @param  int  $transaction_id The ID of the transaction to be applied.
 * @return \Illuminate\Http\RedirectResponse Redirects back with a success or error message.
 */
    public function attorneyManualTransactionApply($payment_plan_id,$transaction_id)
    {
        try {

            DB::beginTransaction();
                $payment_plan = PaymentPlan::where('id',$payment_plan_id)->first();
                $getTotalInstallment = Transactions::where('payment_plan_id',$payment_plan->id)->where('installment_cycle_no',"!=",0)->count();
                $getTransaction = Transactions::where('id',$transaction_id)->where('status','Failed')->first();
                if($getTransaction)
                {
                    $customerStripeId = $getTransaction->getCustomers->getCustomerPaymentDetails->stripe_customer_id;
                    $paymentMethodId = $this->getCustomerDefaultPaymentMethodId($customerStripeId); //fetching payment_id
                    $amount = $getTransaction->amount * 100;
                    $description = "YBL Invoice # ".$payment_plan->invoice_no." Installment No. ".$getTransaction->installment_cycle_no;
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

                        if($getTransaction->installment_cycle_no == $getTotalInstallment)
                        {
                            $payment_plan->payment_status = 'Paid';
                            $payment_plan->save();
                        }else{
                            $payment_plan->payment_status = 'PartiallyPaid';
                            $payment_plan->save();
                        }
                    }else{
                        $getTransaction->status = 'Failed';
                        $getTransaction->save();
                    }
                }else{
                    $alert = [
                        'message' =>  'Transaction cannot be processed manually.',
                        'alert-type' => 'error'
                    ];
                    return back()->with($alert);
                }

            DB::commit();

            $alert = [
                'message' =>  'Payment charged successfully',
                'alert-type' => 'success'
            ];
            return back()->with($alert);

        } catch (\Throwable $th) {
            DB::rollBack();

            $alert = [
                'message' =>  $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
}
