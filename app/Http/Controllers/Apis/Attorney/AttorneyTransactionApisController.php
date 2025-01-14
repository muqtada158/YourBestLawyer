<?php

namespace App\Http\Controllers\Apis\Attorney;

use App\Http\Controllers\Controller;
use App\Http\Traits\StripePaymentTrait;
use App\Models\AttorneyPaymentsToYbl;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use App\Models\UserPaymentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AttorneyTransactionApisController extends Controller
{
    use StripePaymentTrait;

/**
 * Fetches all invoices for a given attorney.
 *
 * @param \Illuminate\Http\Request $request The request object containing the attorney's ID.
 * @return \Illuminate\Http\JsonResponse A JSON response containing the status, message, and invoices data.
 */
    public function allInvoices(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'attorney_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //fetch customer invoices
            $invoices = PaymentPlan::with('getCaseDetails')
            ->where('attorney_id', $request->attorney_id)
            ->where('invoice_no','!=',null)
            ->get();

            return response()->json([
                'status' => true,
                'message' => 'Fetched invoices successfully',
                'invoices' => $invoices,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Fetches all transactions for a given invoice.
 *
 * @param \Illuminate\Http\Request $request The request object containing the invoice ID.
 * @return \Illuminate\Http\JsonResponse A JSON response containing the status, message, and transaction data.
 */
    public function invoicesTransactions(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'invoice_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //fetch customer transactions
            $transactions = Transactions::with('getCustomers.getUserDetails','getAttornies.getUserDetails','getCaseDetails')
            ->where('payment_plan_id', $request->invoice_id)
            ->get();

            return response()->json([
                'status' => true,
                'message' => 'Fetched transactions successfully',
                'transactions' => $transactions,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
/**
 * Updates the attorney's card details.
 *
 * @param \Illuminate\Http\Request $request The request object containing the attorney's card details.
 * @return \Illuminate\Http\JsonResponse A JSON response containing the status, message, and updated payment details.
 */
    public function updateAttorneyCard(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'attorney_id' => 'required',
                'card_expiry_month' => 'required',
                'card_expiry_year' => 'required',
                'card_last_four' => 'required',
                'json_response' => 'nullable',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            //attaching payment to customer
            $userPaymentDetails = UserPaymentDetails::where('user_id',$request->attorney_id)->where('status','Enabled')->first();

            $userPaymentDetails->card_expiry_month = $request->card_expiry_month;
            $userPaymentDetails->card_expiry_year = $request->card_expiry_year;
            $userPaymentDetails->card_last_four = $request->card_last_four;
            $userPaymentDetails->json_response = $request->json_response;
            $userPaymentDetails->status = 'Enabled';
            $userPaymentDetails->save();

            return response()->json([
                'status' => true,
                'message' => 'Card updated successfully',
                'paymentDetails' => $userPaymentDetails,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Updates the attorney's Stripe Connect ID.
 *
 * @param \Illuminate\Http\Request $request The request object containing the attorney's new Stripe Connect ID.
 * @return \Illuminate\Http\JsonResponse A JSON response containing the status, message, and updated payment details.
 */
    public function updateStripeConnectId(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'attorney_id' => 'required',
                'stripe_attorney_connect_id' => 'required',
                'json_response' => 'nullable',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            DB::beginTransaction();
                //disabling old connect id
                $oldUserPayment = UserPaymentDetails::where('user_id',$request->attorney_id)->where('status','Enabled')->first();
                $oldUserPayment->status = "Disabled";
                $oldUserPayment->save();

                // Create new record
                $userPayment = new UserPaymentDetails();
                $userPayment->user_id = $request->attorney_id;
                $userPayment->stripe_attorney_connect_id = $request->stripe_attorney_connect_id;
                $userPayment->json_response = $request->json_response;
                $userPayment->status = "Enabled";
                $userPayment->save();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'User Payment Details updated successfully',
                'userPayment' => $userPayment,
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

/**
 * Applies a manual transaction for the attorney.
 *
 * @param \Illuminate\Http\Request $request The request object containing the attorney's ID, payment plan ID, and transaction ID.
 * @return \Illuminate\Http\JsonResponse A JSON response containing the status and message of the transaction attempt.
 */
    public function attorneyManualTransactionApply(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'attorney_id' => 'required',
                'payment_plan_id' => 'required',
                'transaction_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            DB::beginTransaction();
                $payment_plan = PaymentPlan::where('id',$request->payment_plan_id)->first();
                $getTotalInstallment = Transactions::where('payment_plan_id',$payment_plan->id)->where('installment_cycle_no',"!=",0)->count();
                $getTransaction = Transactions::where('id',$request->transaction_id)->where('status','Failed')->first();
                if($getTransaction)
                {
                    $customerStripeId = $getTransaction->getCustomers->getCustomerPaymentDetails->stripe_customer_id;
                    $paymentMethodId = $this->getCustomerDefaultPaymentMethodId($customerStripeId); //fetching payment_id
                    $amount = $getTransaction->amount * 100;
                    $description = "YBL Invoice # ".$payment_plan->invoice_no." Installment No. ".$getTransaction->installment_cycle_no;
                    $platformFee = 0; // 10% coming from helper
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
                    return response()->json([
                        'status' => false,
                        'message' => 'Transaction cannot be processed manually.',
                    ], 200);
                }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Payment charged successfully',
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function attorneyInvoicesFromYBL(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'attorney_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $getInvoice = AttorneyPaymentsToYbl::where('attorney_id',$request->attorney_id)->orderby('id','DESC')->get();

            return response()->json([
                    'status' => true,
                    'message' => 'Fetched Transactions successfully',
                    'attorneyInvoices' => $getInvoice
                ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
