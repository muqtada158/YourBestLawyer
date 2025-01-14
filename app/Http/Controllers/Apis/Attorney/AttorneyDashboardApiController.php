<?php

namespace App\Http\Controllers\Apis\Attorney;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CaseDetail;
use App\Models\Faq;
use App\Models\LawCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AttorneyDashboardApiController extends Controller
{

/**
 * Handle search functionality for CaseDetail and LawCategory models.
 *
 * This method accepts a search term from the request and first searches for it in the CaseDetail model's `sr_no` field.
 * If no results are found, it searches the LawCategory model by the `title` field.
 * The search results are then returned in a JSON response.
 *
 * @param Request $request The request containing the search term.
 * @return \Illuminate\Http\JsonResponse The search results in JSON format.
 */
    public function search(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'search' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $searchTerm = $request->input('search');

            // First, search in CaseDetail model by sr_no
            $caseResults = CaseDetail::where('sr_no', 'like', '%' . $searchTerm . '%')->get();
            if ($caseResults->isNotEmpty()) {
                $caseImage = asset('images/search_image/searchImage.png');
                foreach ($caseResults as $case) {
                    $case->image = $caseImage;
                }
            }

            // If no results found in CaseDetail, search in LawCategory model by title
            if ($caseResults->isEmpty()) {
                $lawCategoryResults = LawCategory::with('subCategories')->where('title', 'like', '%' . $searchTerm . '%')->get();

                if ($lawCategoryResults->isEmpty()) {
                    return response()->json([
                        'status' => true,
                        'message' => 'No results found.',
                        'search' => []
                    ], 200);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Searched successfully.',
                    'search' => $lawCategoryResults
                ], 200);
            }

            return response()->json([
                'status' => true,
                'message' => 'Searched successfully.',
                'search' => $caseResults
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }



/**
 * Fetch FAQs with 'Enabled' status.
 *
 * This method retrieves all FAQs from the database where the `faq_status` is 'Enabled'.
 * The FAQs are returned in a JSON response.
 *
 * @return \Illuminate\Http\JsonResponse The list of enabled FAQs in JSON format.
 */
    public function faqs()
    {
        try {
            //fetch faq data
            $faqs = Faq::where('faq_status','Enabled')->get();

            return response()->json([
                'status' => true,
                'message' => 'Faqs fetched successfully',
                'data'  => $faqs
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


/**
 * Get all appointments for a specific attorney.
 *
 * This method fetches all appointments for a specific attorney based on their `attorney_id`.
 * The appointments are sorted in descending order of the `id` field.
 *
 * @param Request $request The request containing the `attorney_id`.
 * @return \Illuminate\Http\JsonResponse The list of appointments for the attorney.
 */
    public function getAllCustomerAppointments(Request $request)
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

            $appointments = Appointment::where('attorney_id',$request->attorney_id)
            ->orderby('id','Desc')->get();

            return response()->json([
                'status' => true,
                'message' => 'Fetched all appointments successfully',
                'appointment' => $appointments,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }


/**
 * Get appointments for a specific customer and attorney.
 *
 * This method retrieves appointments for a customer based on their `customer_id` and the specified `attorney_id`.
 * The appointments are sorted in descending order of the `id` field.
 *
 * @param Request $request The request containing `customer_id` and `attorney_id`.
 * @return \Illuminate\Http\JsonResponse The list of appointments for the customer and attorney.
 */
    public function getCustomerAppointments(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'customer_id' => 'required',
                'attorney_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $appointments = Appointment::where('customer_id', $request->customer_id)
            ->where('attorney_id',$request->attorney_id)
            ->orderby('id','Desc')->get();

            return response()->json([
                'status' => true,
                'message' => 'Fetched appointments successfully',
                'appointment' => $appointments,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }


/**
 * Schedule an appointment for a customer and attorney.
 *
 * This method schedules an appointment for a customer with a specified attorney.
 * It checks if the `case_sr_no` exists in the `CaseDetail` model and validates the input data.
 * Upon successful scheduling, a notification is sent to the customer.
 *
 * @param Request $request The request containing appointment details such as `case_sr_no`, `customer_id`, `attorney_id`, `date`, `time`, `case_type`, and `summary`.
 * @return \Illuminate\Http\JsonResponse The result of the scheduling process.
 */
    public function scheduleAppointment(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_sr_no' => 'required',
                'customer_id' => 'required',
                'attorney_id' => 'required',
                'date' => 'required',
                'time' => 'required',
                'case_type' => 'required',
                'summary' => 'nullable',
            ], [
                'attorney_id.required' => 'The attorney field is required.',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if($request->case_sr_no){
                $check_sr_no = CaseDetail::where('sr_no',$request->case_sr_no)->exists();
                if(!$check_sr_no){
                    return response()->json([
                        'status' => false,
                        'message' => 'Case_sr_no did not exists, kindly enter valid case_sr_no.'
                    ], 500);
                }
            }

            $appointment = new Appointment();
            $appointment->case_sr_no = $request->case_sr_no;
            $appointment->customer_id = $request->customer_id;
            $appointment->attorney_id = $request->attorney_id;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->case_type = $request->case_type;
            $appointment->summary = $request->summary;
            $appointment->status = 'Approved';
            $appointment->save();

            $notification = $this->sendNotification([$request->customer_id],'Your appointment has been scheduled.',null,null);

            return response()->json([
                'status' => true,
                'message' => 'Schedule appointment successfully',
                'appointment' => $appointment,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
