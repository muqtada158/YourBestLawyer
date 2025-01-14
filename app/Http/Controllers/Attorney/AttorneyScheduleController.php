<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CaseDetail;
use App\Models\CustomerContract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttorneyScheduleController extends Controller
{
    /**
 * Display the schedule page for the logged-in attorney.
 *
 * This method retrieves all appointments for the attorney, including both upcoming and all schedules,
 * and passes them to the view.
 *
 * @return \Illuminate\View\View
 */
    public function schedule()
    {
        try{

            $schedules = Appointment::with('getAttornies')
            ->where('attorney_id',auth()->user()->id)
            ->get();

            $schedules_upcoming = Appointment::with('getAttornies')
            ->where('attorney_id', auth()->user()->id)
            ->whereDate('date', '>=', Carbon::today()->format('m-d-Y'))
            ->orderBy('date', 'Asc')
            ->get();

            return view('attorney.schedule',compact('schedules','schedules_upcoming'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    /**
 * Display the schedule appointment page for the logged-in attorney.
 *
 * This method retrieves all customer contracts for the attorney and passes them to the view.
 *
 * @return \Illuminate\View\View
 */
    public function schedule_appointment()
    {
        try{

            $cases = CustomerContract::with([
                'getCaseDetail.getCaseLaw',
                'getCustomer.getUserDetails'
            ])
            ->where('attorney_id', auth()->user()->id)
            ->get();
            return view('attorney.schedule-appointment',compact('cases'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    /**
 * Store a new appointment for the logged-in attorney.
 *
 * This method validates the input data, creates a new appointment record,
 * and sends an email notification to the customer.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
    public function attorney_dashboard_schedule_appointment_store(Request $request)
    {
            $this->validate($request, [
                'case_sr_no' => 'required',
                'customer_id' => 'nullable',
                'attorney_id' => 'nullable',
                'date' => 'required',
                'time' => 'required',
                'case_type' => 'nullable',
                'summary' => 'nullable',
                ], [
                    'attorney_id.required' => 'The attorney field is required.',
                ]);

        try {

            $appointment = new Appointment();
            $appointment->case_sr_no = $request->case_sr_no;
            $appointment->customer_id = $request->customer_id;
            $appointment->attorney_id = auth()->user()->id;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->case_type = $request->case_type;
            $appointment->summary = $request->summary;
            $appointment->status = 'Approved';
            $appointment->save();

            //sending email
            $this->sendEmail(
                $appointment->getCustomers->email,
                'New Appointment',
                'An attorney has set an appointment. Please check your calendar for details.'
            );

            $alert = [
                'message' => 'appointment submitted successfully',
                'alert-type' => 'success'
            ];
            return to_route('attorney_schedule')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
/**
 * Retrieve appointment details for the logged-in attorney.
 *
 * This method validates the request parameters, fetches the case and contract details for the specified case,
 * and returns the information in a JSON response.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function attorney_get_appointment_details(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_sr_no' => 'required',
                'attorney_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $case = CaseDetail::where('sr_no', $request->case_sr_no)->first();

            $details = CustomerContract::with([
                'getCaseDetail.getCaseLaw',
                'getCustomer.getUserDetails'
            ])
            ->where('case_id', $case->id)
            ->where('attorney_id', $request->attorney_id)
            ->first();

            if ($details && $case) {
                $customer = $details->getCustomer->getUserDetails;
                $caseDetail = $details->getCaseDetail->getCaseLaw;

                return response()->json([
                    'success' => true,
                    'data' => [
                        'appointee_id' => $customer->user_id,
                        'appointee' => $customer->first_name . ' ' . $customer->last_name,
                        'case_type' => $caseDetail->title,
                    ]
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Case not found']);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
