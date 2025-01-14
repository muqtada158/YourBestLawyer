<?php

namespace App\Http\Controllers\Apis\Attorney;

use App\Http\Controllers\Controller;
use App\Http\Traits\NumberGeneratorTrait;
use App\Http\Traits\StripePaymentTrait as TraitsStripePaymentTrait;
use App\Models\AttorneyPaymentsToYbl;
use App\Models\CaseBid;
use App\Models\CaseContracts;
use App\Models\CustomerContract;
use App\Models\User;
use App\Models\CaseDetail;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use App\Traits\StripePaymentTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Stripe\Charge;
use Stripe\PaymentIntent;

class ContractApiController extends Controller
{
    use NumberGeneratorTrait;
    use TraitsStripePaymentTrait;

    /**
 * Fetches the new contracts for a specific attorney.
 *
 * @param \Illuminate\Http\Request $request The request object containing the 'attorney_id'.
 *
 * @return \Illuminate\Http\JsonResponse A JSON response containing the status, message, and contracts.
 */
    public function getNewContracts(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'attorney_id' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $contracts = CustomerContract::with('getCustomer.getUserDetails', 'getCaseDetail', 'getContract', 'getPaymentPlan.getTransactions')
                ->where('attorney_id', $request->attorney_id)
                ->where('status', 'Pending')
                ->orderby('id', 'DESC')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Customer contracts fetched successfully.',
                'contracts' => $contracts
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Fetches all accepted contracts for a specific attorney.
 *
 * @param \Illuminate\Http\Request $request The request object containing the 'attorney_id'.
 *
 * @return \Illuminate\Http\JsonResponse A JSON response containing the status, message, and contracts.
 */
    public function getAcceptedConracts(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'attorney_id' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $contracts = CustomerContract::with(
                'getCustomer.getUserDetails',
                'getContract',
                'caseAttorneyBid',
                'getCaseDetail.getDynamicFormValues',
                'getCaseDetail.getCaseBid',
                'getCaseDetail.getCaseLaw',
                'getCaseDetail.getCaseLawSub',
                'getCaseDetail.getCasePackage',
                'getCaseDetail.getPaymentPlan.getTransactions'
            )
                ->where('attorney_id', $request->attorney_id)
                // ->where('status','Accepted') // made it all contracts and setted the filter on mobile end
                ->orderby('id', 'DESC')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Customer contracts fetched successfully.',
                'contracts' => $contracts
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Get details of the contract.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function getContractDetails(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'contract_id' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $contract = CustomerContract::with('getCustomer.getUserDetails', 'getCaseDetail', 'getPaymentPlan.getTransactions')
                ->where('id', $request->contract_id)
                ->first();

            $contract->getContract = CaseContracts::where('cat_id',$contract->getCaseDetail->case_type)->where('type',$contract->getCaseDetail->lawyer_type)->where('status','Enable')->first();

            return response()->json([
                'status' => true,
                'message' => 'Customer contract details fetched successfully.',
                'contract' => $contract
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
 * Accept a customer contract.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function acceptContract(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'contract_id' => 'required',
                    'attorney_id' => 'required',
                    'attorney_signature_image' => 'required|image'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            DB::beginTransaction();

            $contract = CustomerContract::where('id', $request->contract_id)
                ->where('attorney_id', $request->attorney_id)->first();

            if($contract->status == 'Accepted')
            {
                return response()->json([
                    'status' => false,
                    'message' => "Error : Contract already accepted.",
                ], 500);
            }

            if ($request->hasFile('attorney_signature_image')) {
                /** Upload new image */
                $upload_location = '/storage/attorney-contract-signatures/';
                $file = $request->attorney_signature_image;
                $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . $upload_location, $name_gen);
                $save_url = $upload_location . $name_gen;

                $contract->attorney_signature_image = $save_url;
            }
            $contract->status = 'Accepted';
            $contract->save();

            //creating transactions starts
            if ($contract->getPaymentPlan) {
                $currentDate = Carbon::now();
                $payment_plan = $contract->getPaymentPlan()->first();

                //generating invoice number
                $payment_plan->invoice_no = $this->uniqueInvoiceNumberGenerator();
                $payment_plan->attorney_id = $contract->attorney_id;
                $payment_plan->save();

                //for only first time check attorney and deduct amount from attorney
                $attorneyCustomerId = $contract->getAttornies->getAttorneyPaymentDetails->stripe_customer_id;
                $yblFee = intval($payment_plan->getCaseDetails->getCasePackage->ybl_flat_fee);
                $checkAttorney = $this->checkAttorneyFunds($attorneyCustomerId, $yblFee);
                if ($checkAttorney['status'] == "failed") {
                    $notification_to_attorney = $this->sendNotification([$contract->attorney_id],"You don't have enough amount in your card, kindly recharge and try again",null,null);
                    return response()->json([
                        'status' => false,
                        'message' => "You don't have enough amount in your card, kindly recharge and try again."
                    ], 500);
                } elseif ($checkAttorney['status'] == "error") {
                    return response()->json([
                        'status' => false,
                        'message' => "Error : " . $checkAttorney['message'],
                    ], 500);
                }
                //for personal injury scenario
                if (
                    $contract->getCaseDetail->getCasePackage->sub_cat_id == 18 ||
                    $contract->getCaseDetail->getCasePackage->sub_cat_id == 19 ||
                    $contract->getCaseDetail->getCasePackage->sub_cat_id == 20
                ) {
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
                    $attorneyPayment->attorney_id = $contract->attorney_id;
                    $attorneyPayment->case_id = $payment_plan->case_id;
                    $attorneyPayment->invoice_no = $this->uniqueInvoiceNumberGeneratorForAttorney();
                    $attorneyPayment->intent_id = $paymentIntent->id;
                    $attorneyPayment->amount = $yblFee;
                    $attorneyPayment->stripe_invoice_url = isset($receiptUrl) ? $receiptUrl : null;
                    $attorneyPayment->status = 'Paid';
                    $attorneyPayment->save();


                } else //for rest of the cases
                {
                    if ($payment_plan->installments == "yes") {
                        $cycle_amount_per_month = ($payment_plan->total_amount - $payment_plan->getTransactionDownpayment->amount) / $payment_plan->installment_cycle;
                        for ($i = 1; $i <= $payment_plan->installment_cycle; $i++) {
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
                        $description = "YBL Invoice # " . $payment_plan->invoice_no . " DownPayment. " . $payment_plan->installment_cycle . " Installments Remaining.";
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
                                return response()->json([
                                    'status' => false,
                                    'message' => "Error occured : Downpayment not found",
                                ], 500);
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
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'Error occured : ' . $charge->status,
                            ], 500);
                        }
                        //setting values for charging first (downpayment amount) ends
                    } else {
                        $transaction = Transactions::where('payment_plan_id', $payment_plan->id)
                            ->where('customer_id', $payment_plan->customer_id)
                            ->where('case_id', $payment_plan->case_id)
                            ->where('status', 'Pending')
                            ->first();
                        $transaction->attorney_id = $contract->attorney_id;
                        $transaction->amount = (int)round($payment_plan->total_amount);
                        $transaction->date_of_charge = $currentDate;
                        $transaction->status = 'Pending';
                        $transaction->save();
                        //setting values for charging fullamount starts
                        $customerStripeId = $contract->getCustomer->getCustomerPaymentDetails->stripe_customer_id;
                        $paymentMethodId = $this->getCustomerDefaultPaymentMethodId($customerStripeId); //fetching payment_id
                        $amount = (int)round($transaction->amount * 100);
                        $description = "YBL Invoice # " . $payment_plan->invoice_no . " Full Payment.";
                        $platformFee = $yblFee;
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
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'Error occured : ' . $charge->status,
                            ], 500);
                        }
                        //setting values for charging fullamount ends
                    }
                }
            }
            //creating transactions ends

            $case = CaseDetail::where('id', $contract->case_id)->update(['case_status' => 'Accepted']);
            $getUser = User::where('id', $contract->customer_id)->first();
            if ($getUser->restricted_steps == 17) {
                $updateUserRestrictedStep = User::where('id', $contract->customer_id)->update(['restricted_steps' => 18]);
            }

            //triggering notifications
            $notification_to_customer = $this->sendNotification([$contract->customer_id],'Congratulations, Your contract has been accepted.',null,null);
            $notification_to_attorney = $this->sendNotification([$contract->attorney_id],'YourBestLawyer.com Flat fee has been deducted. Thankyou for choosing us.',null,null);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Contract agreed successfully.',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function rejectContract(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'contract_id' => 'required',
                    'attorney_id' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            DB::beginTransaction();

            $contract = CustomerContract::where('id', $request->contract_id)
                ->where('attorney_id', $request->attorney_id)->first();
            $contract->status = 'Rejected';
            $contract->save();

            //reverting attorney bid and update payment plan according to that starts
            $customer_bid = CaseBid::where('case_id', $contract->case_id)
                ->where('user_id', $contract->customer_id)
                ->first();
            //updating payment plan
            $paymentPlan = PaymentPlan::where('customer_id', $contract->customer_id)
                ->where('case_id', $contract->case_id)
                ->first();
            $paymentPlan->status = 'Disabled';
            $paymentPlan->save();
            //creating another payment plan
            $newPaymentPlan = new PaymentPlan();
            $newPaymentPlan->customer_id = $paymentPlan->customer_id;
            $newPaymentPlan->attorney_id = null;
            $newPaymentPlan->case_id = $paymentPlan->case_id;
            $newPaymentPlan->sub_cat_id  = $paymentPlan->sub_cat_id;
            $newPaymentPlan->package_id  = $paymentPlan->package_id;
            $newPaymentPlan->invoice_no  = null;
            $newPaymentPlan->installments  = $paymentPlan->installments;
            $newPaymentPlan->total_amount  = $paymentPlan->total_amount;
            $newPaymentPlan->installment_cycle  = $paymentPlan->installment_cycle;
            $newPaymentPlan->status = 'Enabled';
            $newPaymentPlan->payment_status = 'UnPaid';
            $newPaymentPlan->save();
            //reverting attorney bid and update payment plan according to that ends

            $case_details = CaseDetail::where('id', $contract->case_id)->update(['case_status' => 'Pending']);

            $notification = $this->sendNotification([$newPaymentPlan->customer_id],'Oops your contract has been rejected by the attorney.',null,null);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Contract rejected successfully.',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
