<?php

namespace App\Http\Controllers\Apis\Customer;

use App\Http\Controllers\Controller;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionApisController extends Controller
{
        /**
     * Fetch all invoices for a given customer.
     *
     * This method validates the customer_id, then retrieves all invoices associated with the customer,
     * including the related case details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allInvoices(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'customer_id' => 'required',
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
            ->where('customer_id', $request->customer_id)
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
     * Fetch transaction details for a specific invoice.
     *
     * This method validates the invoice_id, then retrieves all transaction records associated with the
     * specified invoice, including customer, attorney, and case details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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


}
