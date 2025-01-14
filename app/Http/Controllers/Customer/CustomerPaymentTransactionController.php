<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use Illuminate\Http\Request;

class CustomerPaymentTransactionController extends Controller
{
    /**
 * Displays a paginated list of payment transactions for the authenticated customer.
 * This fetches all payment plans for the user where the invoice number is not null.
 *
 * @return \Illuminate\View\View The view displaying the paginated payment transactions.
 */
    public function payment_transactions()
    {
        $getInvoices = PaymentPlan::where('customer_id',auth()->user()->id)
        ->where('invoice_no','!=',null)
        ->paginate(10);
        return view('customer.payment-transactions',compact('getInvoices'));
    }

    /**
 * Displays all transactions associated with a specific payment plan (invoice).
 * The invoice ID is provided as a parameter and its related transactions are fetched.
 *
 * @param int $id The ID of the payment plan (invoice).
 * @return \Illuminate\View\View The view displaying the list of transactions for the given invoice.
 */
    public function transactions($id)
    {
        $getInvoice = PaymentPlan::where('id',$id)->first();
        $getTransactions = Transactions::where('payment_plan_id',$id)->get();
        return view('customer.transactions',compact('getTransactions','getInvoice'));
    }

    /**
 * Returns the view to add a new payment transaction.
 * This function is called when the user wants to add a new payment transaction.
 *
 * @return \Illuminate\View\View The view for adding a new payment transaction.
 */
    public function payment_transactions_add()
    {
        return view('customer.payment-transactions-add');
    }
}
