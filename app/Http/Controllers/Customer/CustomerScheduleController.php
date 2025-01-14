<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CaseDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerScheduleController extends Controller
{
    /**
 * Display the customer's dashboard schedule.
 *
 * This function retrieves the list of appointments associated with the authenticated customer
 * and separates them into all schedules and upcoming schedules based on the appointment date.
 * It then returns the schedules to the view for display.
 *
 * @return \Illuminate\View\View
 */
    public function customer_dashboard_schedule()
    {
        try{

            $schedules = Appointment::with('getAttornies')->where('customer_id',auth()->user()->id)->get();

            $schedules_upcoming = Appointment::with('getAttornies')
            ->where('customer_id',auth()->user()->id)
            ->where('date','>=',Carbon::today())
            ->orderby('date','Asc')
            ->get();

            return view('customer.schedule',compact('schedules','schedules_upcoming'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
    /**
 * Show the page to schedule a new appointment.
 *
 * This function retrieves the list of cases for the authenticated user that have the status
 * 'Accepted' and are associated with attorneys. The retrieved cases are passed to the view for scheduling.
 *
 * @return \Illuminate\View\View
 */
    public function customer_dashboard_schedule_appointment()
    {
        try{

            $cases = CaseDetail::with('getCaseLaw','getCaseAttornies')
            ->where('user_id', auth()->user()->id)
            ->where('case_status','Accepted')
            ->orderby('id','ASC')
            ->get();

            return view('customer.schedule-appointment',compact('cases'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }

    /**
 * Store a newly scheduled appointment for the customer.
 *
 * This function validates the input data, creates a new appointment entry in the database
 * with the provided details (case number, attorney, date, time, case type, and summary),
 * and sends an email notification to the assigned attorney regarding the new appointment.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
    public function customer_dashboard_schedule_appointment_store(Request $request)
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
            $appointment->customer_id = auth()->user()->id;
            $appointment->attorney_id = $request->attorney_id;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->case_type = $request->case_type;
            $appointment->summary = $request->summary;
            $appointment->status = 'Approved';
            $appointment->save();

            //sending email
            $this->sendEmail(
                $appointment->getAttornies->email,
                'New Appointment',
                'A customer has set an appointment. Please check your calendar for details.'
            );

            $alert = [
                'message' => 'appointment submitted successfully',
                'alert-type' => 'success'
            ];
            return to_route('customer_schedule')->with($alert);

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
}
