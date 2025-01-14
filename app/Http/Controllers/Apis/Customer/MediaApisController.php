<?php

namespace App\Http\Controllers\Apis\Customer;

use App\Http\Controllers\Controller;
use App\Models\CaseDetail;
use App\Models\CaseMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaApisController extends Controller
{
    /**
     * Fetch preview of all cases for a specific user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function casesPreview(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $cases = CaseDetail::with('getCaseMedia')->where('user_id',$request->user_id)->get();

            return response()->json([
                'status' => true,
                'message' => 'Fetched case successfully',
                'cases' => $cases,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

      /**
     * Fetch and group case media for a specific user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function caseMediaPreview(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $case_media = CaseMedia::where('user_id',$request->user_id)->get();
            foreach($case_media as $k=>$item){
                 $case_media[$k]->sr_no = CaseDetail::where('id',$item->case_id)->pluck('sr_no')->first();
            }
            $grouped_by_sr_no = $case_media->groupBy('case_id');

            return response()->json([
                'status' => true,
                'message' => 'Fetched media successfully',
                'case_media' => $grouped_by_sr_no,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
/**
     * Get all cases associated with a specific user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCases(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $case = CaseDetail::where('user_id',$request->user_id)->get();

            return response()->json([
                'status' => true,
                'message' => 'Fetched cases successfully',
                'case' => $case,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

        /**
     * Upload media (image, video, document) for a case.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function caseMediaUpload(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'case_id' => 'required',
                'media_image.*' => 'nullable|image|max:5120',                   // Each image file can be up to 5MB
                'media_video.*' => 'nullable|mimetypes:video/mp4|max:20480',    // Each video file can be up to 20MB
                'media_document.*' => 'nullable|mimes:pdf,doc,docx|max:5120',   // Each document file can be up to 5MB
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!$request->hasFile('media_image') && !$request->hasFile('media_video') && !$request->hasFile('media_document'))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Please select at least one file to upload.'
                ], 422);
            }
            if ($request->hasFile('media_image')) {
                foreach ($request->media_image as $key => $image) {
                    /** Upload new image */
                    $upload_location = '/storage/case_media/';
                    $file = $image;
                    $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $case_media = new CaseMedia();
                    $case_media->user_id = $request->user_id;
                    $case_media->case_id = $request->case_id;
                    $case_media->type = 'image';
                    $case_media->media = $save_url;
                    $case_media->save();
                }
            }
            if ($request->hasFile('media_video')) {
                foreach ($request->media_video as $key => $video) {
                    /** Upload new video */
                    $upload_location = '/storage/case_media/';
                    $file = $video;
                    $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $case_media = new CaseMedia();
                    $case_media->user_id = $request->user_id;
                    $case_media->case_id = $request->case_id;
                    $case_media->type = 'video';
                    $case_media->media = $save_url;
                    $case_media->save();
                }
            }
            if ($request->hasFile('media_document')) {
                foreach ($request->media_document as $key => $document) {
                    /** Upload new document */
                    $upload_location = '/storage/case_media/';
                    $file = $document;
                    $name_gen = hexdec(uniqid() . $key) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $upload_location, $name_gen);
                    $save_url = $upload_location . $name_gen;

                    /** Saving in DB */
                    $case_media = new CaseMedia();
                    $case_media->user_id = $request->user_id;
                    $case_media->case_id = $request->case_id;
                    $case_media->type = 'document';
                    $case_media->media = $save_url;
                    $case_media->save();
                }
            }


            return response()->json([
                'status' => true,
                'message' => 'Media uploaded successfully'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

        /**
     * Delete specific case media based on the media ID.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function caseMediaDelete(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'case_media_id' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $case = CaseMedia::where('id',$request->case_media_id)->first();
            $path = ltrim($case->media, '/');

            if (File::exists($path)) {

                unlink($path);
                $case->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Case media deleted successfully'
                ], 200);

            }else{
                $case->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Case media data deleted successfully, File not exists.'
                ], 200);
            }



        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
