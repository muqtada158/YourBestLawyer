<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CaseAttornies;
use App\Models\CaseBid;
use App\Models\CaseContracts;
use App\Models\CaseDetail;
use App\Models\Contracts;
use App\Models\CustomerContract;
use App\Models\PaymentPlan;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerContractController extends Controller
{
    /**
 * Displays a list of contracts for the authenticated customer.
 *
 * @return \Illuminate\View\View
 */
    public function contract()
    {
        try {

            $contracts = CustomerContract::with('getAttornies.getUserDetails','getCaseDetail')
            ->where('customer_id',auth()->user()->id)
            // ->where('status','Accepted')
            ->orderby('id','desc')
            ->paginate(10);
            return view('customer.contract',compact('contracts'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    /**
 * Retrieves the details of a specific contract for the authenticated customer.
 *
 * @param int $contract_id The ID of the contract.
 * @return \Illuminate\View\View
 */
    public function customer_get_contract_details($contract_id)
    {
        try {

            $contract = CustomerContract::with('getCustomer.getUserDetails','getAttornies.getUserDetails','getCaseDetail','getContract')
            ->where('id',$contract_id)
            ->first();
            $getLawContract = Contracts::first();
            $paymentPlan = PaymentPlan::where('customer_id',$contract->customer_id)
            ->where('case_id',$contract->getCaseDetail->id)
            ->where('status','Enabled')
            ->first();
            $getAttorneyBid = CaseAttornies::where('case_id',$contract->getCaseDetail->id)
            ->where('attorney_id',$contract->getAttornies->id)
            ->first();

            return view('customer.contract-details',compact('contract','getLawContract','paymentPlan','getAttorneyBid'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    /**
 * Displays the page for adding a contract for the given case and attorney.
 *
 * @param int $case_id The ID of the case.
 * @param int $attorney_id The ID of the attorney.
 * @return \Illuminate\View\View
 */
    public function customer_contract_add($case_id,$attorney_id)
    {
        try {

            $case = CaseDetail::with('getUser','getCaseBid')->where('id',$case_id)->first();
            $attorney = User::with('getUserDetails')
            ->where('id',$attorney_id)
            ->first();

            $case_type = [
                1 => 'Novice',
                2 => 'Experienced',
                3 => 'Top Notch'
            ];

            $contract = CaseContracts::where('cat_id',$case->case_type)->where('type',$case_type[$case->lawyer_type])->where('status','Enable')->first();
            $paymentPlan = PaymentPlan::where('customer_id',auth()->user()->id)
            ->where('status','Enabled')
            ->where('case_id',$case_id)
            ->first();
            $getAttorneyBid = CaseAttornies::where('case_id',$case->id)
            ->where('attorney_id',$attorney->id)
            ->where('status','Interested')
            ->first();


            return view('customer.contract-add',compact('case','attorney','contract','paymentPlan','getAttorneyBid'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    /**
 * Displays the terms and conditions page for a contract based on case category and type.
 *
 * @param int $cat_id The case category ID.
 * @param int $type The case type.
 * @return \Illuminate\View\View
 */
    public function contract_terms_and_conditions($cat_id,$type)
    {
        if(auth()->check() == false){
            return redirect()->back();
        }

        try {

            $case_type = [
                1 => 'Novice',
                2 => 'Experienced',
                3 => 'Top Notch'
            ];

            $contract = CaseContracts::where('cat_id',$cat_id)->where('type',$case_type[$type])->where('status','Enable')->first();

            return view('customer.terms-and-conditions',compact('contract'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Stores a new customer contract, updates payment plan and sends email notifications.
 *
 * @param \Illuminate\Http\Request $request The request object containing contract details.
 * @return \Illuminate\Http\RedirectResponse
 */
    public function customer_dashboard_contracts_store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'attorney_id' => 'required',
            'case_id' => 'required',
            'contract_date' => 'required',
            'contract_id' => 'required',
            'customer_signature' => 'required|string',
            'agree_terms_and_conditions'=> 'required'
            ], [
                'customer_signature.required' => 'Please provide your signature and click on confirm button.',
                'agree_terms_and_conditions.required' => 'Please check agree terms and conditions.',
            ]);
        try {
            $customer_contract = new CustomerContract();
            $customer_contract->customer_id = $request->customer_id;
            $customer_contract->attorney_id = $request->attorney_id;
            $customer_contract->case_id = $request->case_id;
            $customer_contract->contract_id = $request->contract_id;
            $customer_contract->contract_date = $request->contract_date;

            if ($request->customer_signature) {
                // Extract base64 image data from the request
                $base64Image = preg_replace('/data:image\/(jpeg|jpg|png);base64,/', '', $request->customer_signature);
                // Decode the base64 image data
                $signature_image = base64_decode($base64Image);
                // Generate a unique filename for the image
                $filename = hexdec(uniqid()) . '.png';
                // Define the upload location relative to public directory
                $upload_location = '/storage/customer-contract-signatures/';
                // Save the image file to the specified upload location
                $file_path = public_path() . $upload_location . $filename;
                file_put_contents($file_path, $signature_image);
                // Save the URL to the signature image in the database or use as needed
                $save_url = $upload_location . $filename;
                $customer_contract->signature_image = $save_url;
            }

            //get attorney bid and update payment plan according to that starts
            $attorney_bid = CaseAttornies::where('case_id',$customer_contract->case_id)
            ->where('attorney_id',$customer_contract->attorney_id)
            ->where('status','Interested')
            ->first();
                //updating payment plan
                $paymentPlan = PaymentPlan::where('customer_id',$customer_contract->customer_id)
                ->where('case_id',$customer_contract->case_id)
                ->first();
                $paymentPlan->total_amount = $attorney_bid->attorney_bid;
                $paymentPlan->save();
            //get attorney bid and update payment plan according to that ends

            $customer_contract->save();

            //sending email to attorney
            $this->sendEmail(
                $customer_contract->getAttornies->email,
                'YourBestLawyer.com Contract Received',
                ucfirst($customer_contract->getCustomer->getUserDetails->first_name).' sends you a contract, go to contracts to view details.'
            );

            $alert = [
                'message' => 'Contract submitted successfully',
                'alert-type' => 'success'
            ];
            return to_route('customer_contract')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Cancels a customer's contract and updates associated case, attorney, and payment plan statuses.
 *
 * @param int $contract_id The ID of the contract to cancel.
 * @return \Illuminate\Http\RedirectResponse
 */
    public function customer_cancel_contract($contract_id)
    {
        try {
            DB::beginTransaction();
            $contract = CustomerContract::where('id',$contract_id)
            ->where('customer_id',auth()->user()->id)->first();
            $contract->status = 'Rejected';
            $contract->save();

            $case_details = CaseDetail::where('id',$contract->case_id)->update(['case_status'=>'Pending']);

            $case_attornies = CaseAttornies::where('case_id',$contract->case_id)->where('attorney_id',$contract->attorney_id)->first();
            $case_attornies->status = "NotInterested";
            $case_attornies->save();

            //reverting attorney bid and update payment plan according to that starts
            $customer_bid = CaseBid::where('case_id',$contract->case_id)
            ->where('user_id',$contract->customer_id)
            ->first();
                //updating payment plan
                $paymentPlan = PaymentPlan::where('customer_id',$contract->customer_id)
                ->where('case_id',$contract->case_id)
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
                $newPaymentPlan->total_amount  = $customer_bid->bid;
                $newPaymentPlan->installment_cycle  = $paymentPlan->installment_cycle;
                $newPaymentPlan->status = 'Enabled';
                $newPaymentPlan->payment_status = 'UnPaid';
                $newPaymentPlan->save();

                $transaction = new Transactions();
                $transaction->payment_plan_id = $newPaymentPlan->id;
                $transaction->customer_id = $newPaymentPlan->customer_id;
                $transaction->attorney_id = null;
                $transaction->case_id = $newPaymentPlan->case_id;
                $transaction->installment_cycle_no = 0; // 0 for downpayment
                $transaction->amount = (int)round($paymentPlan->getTransactionDownpayment->amount);
                $transaction->date_of_charge = null;
                $transaction->status = 'Pending';
                $transaction->save();
            //reverting attorney bid and update payment plan according to that ends
            DB::commit();
            //sending email to attorney
            $this->sendEmail(
                $contract->getAttornies->email,
                'Your Contract has been canceled.',
                'Your Contract has been canceled by customer. Go to YourBestLawyer.com to see more.'
            );
            $alert = [
                'message' => 'Contract canceled successfully',
                'alert-type' => 'success'
            ];
            return to_route('customer_contract')->with($alert);

        } catch (\Throwable $th) {
            DB::rollBack();
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
}
