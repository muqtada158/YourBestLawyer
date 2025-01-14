<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use App\Http\Traits\NumberGeneratorTrait;
use App\Http\Traits\StripePaymentTrait;
use App\Models\AttorneyPaymentsToYbl;
use App\Models\CaseAttornies;
use App\Models\CaseBid;
use App\Models\CaseDetail;
use App\Models\Contracts;
use App\Models\CustomerContract;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\PaymentIntent;

class AttorneyContractController extends Controller
{
    use NumberGeneratorTrait;
    use StripePaymentTrait;

    /**
 * Fetches and displays all accepted contracts for the authenticated attorney.
 *
 * This method retrieves all contracts that have been accepted by customers
 * and are associated with the authenticated attorney. The contracts are
 * paginated and displayed on the 'attorney.contracts-accepted' view.
 *
 * @return \Illuminate\View\View The view displaying the list of accepted contracts.
 */
    public function contract_accepted()
    {
        try {

            $contracts = CustomerContract::with('getCustomer.getUserDetails','getCaseDetail','getContract')
            ->where('attorney_id',auth()->user()->id)
            ->where('status','Accepted')
            ->orderby('id','DESC')
            ->paginate(10);

            return view('attorney.contracts-accepted',compact('contracts'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    /**
 * Fetches and displays all new contracts that are pending for the authenticated attorney.
 *
 * This method retrieves contracts that are in the 'Pending' status and associated
 * with the authenticated attorney. The contracts are paginated and displayed
 * on the 'attorney.contracts-new' view.
 *
 * @return \Illuminate\View\View The view displaying the list of new pending contracts.
 */
    public function contract_new()
    {
        try {

            $contracts = CustomerContract::with('getCustomer.getUserDetails','getCaseDetail','getContract')
            ->where('attorney_id',auth()->user()->id)
            ->where('status','Pending')
            ->orderby('id','DESC')
            ->paginate(10);

            return view('attorney.contracts-new',compact('contracts'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Displays the details of a specific contract for the authenticated attorney.
 *
 * This method retrieves detailed information about a specific contract, including
 * related case and attorney details. The contract details are displayed on the
 * 'attorney.contract-details' view.
 *
 * @param  int  $contract_id The ID of the contract to retrieve details for.
 * @return \Illuminate\View\View The view displaying the contract details.
 */
    public function contracts_details($contract_id)
    {
        $case_attornies = CustomerContract::where('id',$contract_id)->first();
        $contract = CaseAttornies::with('getAttornies.getUserDetails','getCaseDetails')
        ->where('case_id',$case_attornies->case_id)
        ->where('attorney_id',$case_attornies->attorney_id)
        ->first();
        $getLawContract = Contracts::first();
        $paymentPlan = PaymentPlan::where('customer_id',$case_attornies->customer_id)
        ->where('case_id',$contract->getCaseDetails->id)
        ->where('status','Enabled')
        ->first();
        $getAttorneyBid = CaseAttornies::where('case_id',$contract->getCaseDetails->id)
        ->where('attorney_id',$contract->getAttornies->id)
        // ->where('status','Interested')
        ->first();
        return view('attorney.contract-details',compact('contract','getLawContract','case_attornies','paymentPlan','getAttorneyBid'));
    }

    /**
 * Handles accepting a contract by the authenticated attorney.
 *
 * This method validates the attorney's signature and updates the contract status
 * to 'Accepted'. It uses a database transaction to ensure the changes are applied
 * atomically.
 *
 * @param  \Illuminate\Http\Request  $request The incoming request containing contract ID and signature.
 * @return \Illuminate\Http\RedirectResponse A redirect response to the contract page with a success or failure message.
 */
    public function attorney_accept_contract(Request $request)
    {
        $this->validate($request, [
            'attorney_signature' => 'required',
        ], [
            'attorney_signature.required' => 'Please provide your signature and click on confirm button.',
        ]);
        DB::beginTransaction();
        try {

            $contract = CustomerContract::where('id',$request->contract_id)
            ->where('attorney_id',auth()->user()->id)->first();

            if($contract->status == 'Accepted')
            {
                $alert = [
                    'message' =>  "Error : Contract already accepted",
                    'alert-type' => 'error'
                ];
                return back()->with($alert);
            }

            if ($request->attorney_signature) {
                $base64Image = preg_replace('/data:image\/(jpeg|jpg|png);base64,/', '', $request->attorney_signature);
                $signature_image = base64_decode($base64Image);
                $filename = hexdec(uniqid()) . '.png';
                $upload_location = '/storage/attorney-contract-signatures/';
                $file_path = public_path() . $upload_location . $filename;
                file_put_contents($file_path, $signature_image);
                $save_url = $upload_location . $filename;
                $contract->attorney_signature_image = $save_url;
            }
            $contract->status = 'Accepted';
            $contract->save();

            ///////////////////////////////////////////////////////////////////////////////
            //creating transactions starts
            if($contract->getPaymentPlan)
            {
                $currentDate = Carbon::now();
                $payment_plan = $contract->getPaymentPlan()->first();

                //generating invoice number
                $payment_plan->invoice_no = $this->uniqueInvoiceNumberGenerator();
                $payment_plan->attorney_id = $contract->attorney_id;
                $payment_plan->save();

                //for only first time check attorney and deduct amount from attorney
                $attorneyCustomerId = $contract->getAttornies->getAttorneyPaymentDetails->stripe_customer_id;
                // $yblFee = intval(1);
                $yblFee = intval($payment_plan->getCaseDetails->getCasePackage->ybl_flat_fee);
                $checkAttorney = $this->checkAttorneyFunds($attorneyCustomerId,$yblFee);
                if($checkAttorney['status'] == "failed")
                {
                        $this->sendEmail(
                            $contract->getAttornies->email,
                            'Transaction Failed',
                            'Contract failed, You dont have enough amount for YourBestLawyer.com flat fee in your attached card, kindly recharge and try again.'
                        );
                    $alert = [
                        'message' =>  "You don't have enough amount in your card, kindly recharge and try again.",
                        'alert-type' => 'error'
                    ];
                    return back()->with($alert);
                }elseif($checkAttorney['status'] == "error"){
                    $alert = [
                        'message' =>  "Error : ".$checkAttorney['message'],
                        'alert-type' => 'error'
                    ];
                    return back()->with($alert);
                }

                //for personal injury scenario
                if($contract->getCaseDetail->getCasePackage->sub_cat_id == 18 || $contract->getCaseDetail->getCasePackage->sub_cat_id == 19 || $contract->getCaseDetail->getCasePackage->sub_cat_id == 20)
                {
                    $payment_plan->invoice_no = null;
                    $payment_plan->payment_status = 'Paid';
                    $payment_plan->save();

                    //charging ATTORNEY for YBL
                    $paymentIntent = PaymentIntent::retrieve($checkAttorney['payment_id']);
                    $paymentIntent->capture();

                    $chargeId = $paymentIntent->latest_charge;
                    $charge = Charge::retrieve($chargeId);
                    $receiptUrl = $charge->receipt_url;

                    $attorneyPayment = new AttorneyPaymentsToYbl();
                    $attorneyPayment->attorney_id = auth()->user()->id;
                    $attorneyPayment->case_id = $payment_plan->case_id;
                    $attorneyPayment->invoice_no = $this->uniqueInvoiceNumberGeneratorForAttorney();
                    $attorneyPayment->intent_id = $paymentIntent->id;
                    $attorneyPayment->amount = $yblFee;
                    $attorneyPayment->stripe_invoice_url = isset($receiptUrl) ? $receiptUrl : null;
                    $attorneyPayment->status = 'Paid';
                    $attorneyPayment->save();
                }
                else //for rest of the cases
                {

                    if($payment_plan->installments == "yes")
                    {
                        $cycle_amount_per_month = ($payment_plan->total_amount - $payment_plan->getTransactionDownpayment->amount) / $payment_plan->installment_cycle;
                        for($i = 1; $i <= $payment_plan->installment_cycle; $i++)
                        {
                            $transaction = new Transactions();
                            $transaction->payment_plan_id = $payment_plan->id;
                            $transaction->customer_id = $payment_plan->customer_id;
                            $transaction->attorney_id = $contract->attorney_id;
                            $transaction->case_id = $payment_plan->case_id;
                            $transaction->installment_cycle_no = $i;
                            $transaction->amount = (int)round($cycle_amount_per_month);
                            $transaction->date_of_charge = $currentDate->copy()->addMonths($i)->toDateString();
                            $transaction->status = 'Pending';
                            $transaction->save();
                        }
                        //setting values for charging first (downpayment amount) starts
                            $customerStripeId = $contract->getCustomer->getCustomerPaymentDetails->stripe_customer_id;
                            $paymentMethodId = $this->getCustomerDefaultPaymentMethodId($customerStripeId); //fetching payment_id
                            $amount = (int)round($payment_plan->getTransactionDownpayment->amount * 100);
                            $description = "YBL Invoice # ".$payment_plan->invoice_no." DownPayment. ".$payment_plan->installment_cycle." Installments Remaining.";
                            $platformFee = 0;
                            $vendorStripeConnectAccountId = $contract->getAttornies->getAttorneyPaymentDetails->stripe_attorney_connect_id;

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
                                $downpayment = $payment_plan->getTransactionDownpayment()->first();
                                //updating transactions table
                                if ($downpayment) {
                                    $downpayment->attorney_id = $contract->attorney_id;
                                    $downpayment->date_of_charge = $currentDate;
                                    $downpayment->stripe_charge_id = $charge->id;
                                    $downpayment->stripe_charge_ybl_fee = 0;
                                    $downpayment->stripe_charge_json = json_encode($charge); // Ensure it's serialized as JSON
                                    $downpayment->status = 'Success';
                                    $downpayment->save();

                                } else {
                                    $alert = [
                                        'message' =>  'Error occured : Downpayment not found',
                                        'alert-type' => 'error'
                                    ];
                                    return back()->with($alert);
                                }

                                //update paymentplan status
                                $payment_plan->payment_status = 'PartiallyPaid';
                                $payment_plan->save();

                                //charging ATTORNEY for YBL
                                $paymentIntent = PaymentIntent::retrieve($checkAttorney['payment_id']);
                                $paymentIntent->capture();

                                $chargeId = $paymentIntent->latest_charge;
                                $charge = Charge::retrieve($chargeId);
                                $receiptUrl = $charge->receipt_url;

                                $attorneyPayment = new AttorneyPaymentsToYbl();
                                $attorneyPayment->attorney_id = auth()->user()->id;
                                $attorneyPayment->case_id = $payment_plan->case_id;
                                $attorneyPayment->invoice_no = $this->uniqueInvoiceNumberGeneratorForAttorney();
                                $attorneyPayment->intent_id = $paymentIntent->id;
                                $attorneyPayment->amount = $yblFee;
                                $attorneyPayment->stripe_invoice_url = isset($receiptUrl) ? $receiptUrl : null;
                                $attorneyPayment->status = 'Paid';
                                $attorneyPayment->save();

                            }else{
                                $alert = [
                                    'message' =>  'Error occured : '.$charge->status,
                                    'alert-type' => 'error'
                                ];
                                return back()->with($alert);
                            }
                        //setting values for charging first (downpayment amount) ends
                    }
                    else
                    {
                        $transaction = Transactions::where('payment_plan_id',$payment_plan->id)
                        ->where('customer_id',$payment_plan->customer_id)
                        ->where('case_id',$payment_plan->case_id)
                        ->where('status','Pending')
                        ->first();
                        $transaction->attorney_id = $contract->attorney_id;
                        $transaction->amount = (int)round($payment_plan->total_amount);
                        $transaction->date_of_charge = $currentDate;
                        $transaction->status = 'Pending';
                        $transaction->save();
                        //setting values for charging fullamount starts
                            $customerStripeId = $contract->getCustomer->getCustomerPaymentDetails->stripe_customer_id;
                            $paymentMethodId = $this->getCustomerDefaultPaymentMethodId($customerStripeId); //fetching payment_id
                            // $amount = (int)round(1 * 100);
                            $amount = (int)round($transaction->amount * 100);
                            $description = "YBL Invoice # ".$payment_plan->invoice_no." Full Payment.";
                            $platformFee = 0; // 10% coming from helper
                            $vendorStripeConnectAccountId = $contract->getAttornies->getAttorneyPaymentDetails->stripe_attorney_connect_id;

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
                                $transaction->stripe_charge_id = $charge->id;
                                $transaction->stripe_charge_ybl_fee = 0;
                                $transaction->stripe_charge_json = $charge;
                                $transaction->status = 'Success';
                                $transaction->save();

                                $payment_plan->payment_status = 'Paid';
                                $payment_plan->save();

                                //charging ATTORNEY for YBL
                                $paymentIntent = PaymentIntent::retrieve($checkAttorney['payment_id']);
                                $paymentIntent->capture();

                                $chargeId = $paymentIntent->latest_charge;
                                $charge = Charge::retrieve($chargeId);
                                $receiptUrl = $charge->receipt_url;

                                $attorneyPayment = new AttorneyPaymentsToYbl();
                                $attorneyPayment->attorney_id = auth()->user()->id;
                                $attorneyPayment->case_id = $payment_plan->case_id;
                                $attorneyPayment->invoice_no = $this->uniqueInvoiceNumberGeneratorForAttorney();
                                $attorneyPayment->intent_id = $paymentIntent->id;
                                $attorneyPayment->amount = $yblFee;
                                $attorneyPayment->stripe_invoice_url = isset($receiptUrl) ? $receiptUrl : null;
                                $attorneyPayment->status = 'Paid';
                                $attorneyPayment->save();
                            }else{
                                $alert = [
                                    'message' =>  'Error occured : '.$charge->status,
                                    'alert-type' => 'error'
                                ];
                                return back()->with($alert);
                            }
                        //setting values for charging fullamount ends
                    }

                    $this->sendEmail(
                        $contract->getAttornies->email,
                        'Transaction processed',
                        'Your payment against Case Sr No # '.$contract->getCaseDetail->sr_no.' has been successfully processed. Thank you'
                    );
                }
            }
            //creating transactions ends

            ///////////////////////////////////////////////////////////////////////////////

            $case = CaseDetail::where('id',$contract->case_id)->update(['case_status'=>'Accepted']);

            $getUser = User::where('id',$contract->customer_id)->first();
            if($getUser->restricted_steps == 17)
            {
                $updateUserRestrictedStep = User::where('id',$contract->customer_id)->update(['restricted_steps'=> 18]);
            }

            //sending email to customer
            $this->sendEmail(
                $getUser->email,
                'Your contract has been accepted.',
                'Congratulations, Your contract has been accepted by '.$contract->getAttornies->getUserDetails->first_name.' against Case Sr No # '.$contract->getCaseDetail->sr_no. '. Go to your case feed to see more.'
            );

            //sending email to attorney
            $this->sendEmail(
                $contract->getAttornies->email,
                'YourBestLawyer.com Flat fee deducted.',
                'YourBestLawyer.com Flat fee $'.$yblFee.' has been deducted by your YourBestLawyer.com attached card, go to transactions for more details.'
            );

            DB::commit();

            $alert = [
                'message' => 'Contract Accepted Successfully.',
                'alert-type' => 'success'
            ];
            return back()->with($alert);

        } catch (\Throwable $th) {
             //sending email to attorney
            $this->sendEmail(
                $contract->getAttornies->email,
                'Transaction Failed',
                'There was an error processing your payment. Please check your payment details and try again.'
            );
            DB::rollBack();
            $alert = [
                'message' => 'Error '.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
    public function attorney_cancel_contract($contract_id)
    {
        try {
            DB::beginTransaction();
            $contract = CustomerContract::where('id',$contract_id)
            ->where('attorney_id',auth()->user()->id)->first();
            $contract->status = 'Rejected';
            $contract->save();

            $case_details = CaseDetail::where('id',$contract->case_id)->update(['case_status'=>'Pending']);

            $case_attornies = CaseAttornies::where('case_id',$contract->case_id)->where('attorney_id',auth()->user()->id)->first();
            $case_attornies->status = "NotInterested";
            $case_attornies->save();

            //commented because we dont need to revert this because after accepting or charging payment there are no area to cancel

            //reverting attorney bid and update payment plan according to that starts
            // $customer_bid = CaseBid::where('case_id',$contract->case_id)
            // ->where('user_id',$contract->customer_id)
            // ->first();
            //     //updating payment plan
            //     $paymentPlan = PaymentPlan::where('customer_id',$contract->customer_id)
            //     ->where('case_id',$contract->case_id)
            //     ->first();
            //     $paymentPlan->status = 'Disabled';
            //     $paymentPlan->save();
            //     //creating another payment plan
            //     $newPaymentPlan = new PaymentPlan();
            //     $newPaymentPlan->customer_id = $paymentPlan->customer_id;
            //     $newPaymentPlan->attorney_id = null;
            //     $newPaymentPlan->case_id = $paymentPlan->case_id;
            //     $newPaymentPlan->sub_cat_id  = $paymentPlan->sub_cat_id;
            //     $newPaymentPlan->package_id  = $paymentPlan->package_id;
            //     $newPaymentPlan->invoice_no  = null;
            //     $newPaymentPlan->installments  = $paymentPlan->installments;
            //     $newPaymentPlan->total_amount  = $customer_bid->bid;
            //     $newPaymentPlan->installment_cycle  = $paymentPlan->installment_cycle;
            //     $newPaymentPlan->status = 'Enabled';
            //     $newPaymentPlan->payment_status = 'UnPaid';
            //     $newPaymentPlan->save();

            //     $transaction = new Transactions();
            //     $transaction->payment_plan_id = $newPaymentPlan->id;
            //     $transaction->customer_id = $newPaymentPlan->customer_id;
            //     $transaction->attorney_id = null;
            //     $transaction->case_id = $newPaymentPlan->case_id;
            //     $transaction->installment_cycle_no = 0; // 0 for downpayment
            //     $transaction->amount = (int)round($paymentPlan->getTransactionDownpayment->amount);
            //     $transaction->date_of_charge = null;
            //     $transaction->status = 'Pending';
            //     $transaction->save();
            //reverting attorney bid and update payment plan according to that ends

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
                    'Your Contract has been rejected by attorney. Go to YourBestLawyer.com to see more.'
                );
            $alert = [
                'message' => 'Contract rejected successfully',
                'alert-type' => 'success'
            ];
            return to_route('attorney_contract_accepted')->with($alert);

        } catch (\Throwable $th) {
            DB::rollBack();
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    public function contract()
    {
        return view('attorney.contract');
    }
}
