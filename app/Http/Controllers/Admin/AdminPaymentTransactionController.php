<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttorneyPaymentsToYbl;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use App\Models\YblFee;
use Illuminate\Http\Request;

class AdminPaymentTransactionController extends Controller
{
    /**
     * Display the payment transactions page in the admin panel.
     *
     * This method retrieves the total charged amount for successful transactions,
     * the total YBL fee collected, and a list of invoices to be displayed on the
     * payment transactions page.
     *
     * @return \Illuminate\View\View
     */
    public function payment_transactions()
    {
        $total_charged_amount = Transactions::where('status','Success')->sum('amount');
        $total_ybl_fee_collected = AttorneyPaymentsToYbl::where('status','Paid')->sum('amount');
        $getInvoices = PaymentPlan::where('invoice_no','!=',null)
        ->orderby('id','DESC')
        ->paginate(10);
        return view('admin.payment-transactions',compact('getInvoices','total_charged_amount','total_ybl_fee_collected'));
    }

        /**
     * Display the transactions for a specific payment plan.
     *
     * This method retrieves the transactions associated with a specific payment plan
     * and returns them to the transactions view for display.
     *
     * @param int $id The ID of the payment plan to retrieve transactions for.
     * @return \Illuminate\View\View
     */
    public function transactions($id)
    {
        $getInvoice = PaymentPlan::where('id',$id)->first();
        $getTransactions = Transactions::where('payment_plan_id',$id)->get();
        return view('admin.transactions',compact('getTransactions','getInvoice'));
    }
    /**
     * Display the attorney invoices page in the admin panel.
     *
     * This method retrieves and displays a list of attorney invoices, ordered by
     * ID in descending order, to be displayed in the attorney invoices view.
     *
     * @return \Illuminate\View\View
     */
    public function attorneyInvoices()
    {
        $getInvoice = AttorneyPaymentsToYbl::orderby('id','DESC')->paginate(10);
        return view('admin.attorney-invoices',compact('getInvoice'));
    }

        /**
     * Update the YBL fee.
     *
     * This method validates and updates the YBL fee based on the value provided in the
     * request. The YBL fee is updated as a percentage and saved to the YblFee model.
     *
     * @param \Illuminate\Http\Request $request The request containing the new YBL fee.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateYblFee(Request $request)
    {
        $this->validate($request, [
            'ybl_fee' => 'required|integer',
        ]);

        try {
            $ybl_fee = YblFee::find(1);
            $ybl_fee->ybl_fee = $request->ybl_fee / 100;
            $ybl_fee->save();

            $alert = [
                'message' => 'YBL Fee updated successfully.',
                'alert-type' => 'success'
            ];
            return back()->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error: ' . $th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
}
