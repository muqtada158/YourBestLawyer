<?php

namespace App\Http\Controllers\Apis\Marketing;

use App\Http\Controllers\Controller;
use App\Models\LawCategory;
use App\Models\LawSubCategory;
use App\Models\Lawyer;
use App\Models\LawyerPageData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LawsApisController extends Controller
{
    public function createCategory(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'title' => 'required',
                'image' => 'required|image|max:5120', // Each image file can be up to 5MB
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $categories = new LawCategory();
            $categories->title = $request->title;
            if ($request->hasFile('image')) {
                /** Upload new image */
                $upload_location = '/storage/marketing_law/';
                $file = $request->image;
                $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . $upload_location, $name_gen);
                $save_url = $upload_location . $name_gen;
                $categories->image = $save_url;
            }
            $categories->save();

            return response()->json([
                'status' => true,
                'message' => 'Law category created successfully',
                'categories' => $categories,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function createSubCategory(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'cat_id' => 'required',
                'title' => 'required',
                'image' => 'required|image|max:5120', // Each image file can be up to 5MB
                'video_link' => 'nullable',    // Each video file can be up to 20MB
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $categories = new LawSubCategory();
            $categories->cat_id = $request->cat_id;
            $categories->title = $request->title;
            if ($request->hasFile('image')) {
                /** Upload new image */
                $upload_location = '/storage/marketing_law/';
                $file = $request->image;
                $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . $upload_location, $name_gen);
                $save_url = $upload_location . $name_gen;
                $categories->image = $save_url;
            }
            if ($request->hasFile('video')) {
                /** Upload new image */
                $upload_location = '/storage/marketing_law/';
                $file = $request->video;
                $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . $upload_location, $name_gen);
                $save_url = $upload_location . $name_gen;
                $categories->video = $save_url;
            }
            $categories->video_link = $request->video_link;
            $categories->save();

            return response()->json([
                'status' => true,
                'message' => 'Law subcategory created successfully',
                'categories' => $categories,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'title' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $search = LawSubCategory::with('getLaywers')->where('title', 'like', '%' . $request->title . '%')->get();

            if ($search->count() == 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'No Laws found! kindly try some other keywords',
                    'search' => $search,
                ], 200);
            }

            return response()->json([
                'status' => true,
                'message' => 'Search successfully',
                'search' => $search,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function searchDetail(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'cat_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $searchDetail = LawSubCategory::with('getLaywers')->where('cat_id', $request->cat_id)->get();

            if ($searchDetail->count() == 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'No Laws found!',
                    'search_detail' => $searchDetail,
                ], 200);
            }

            return response()->json([
                'status' => true,
                'message' => 'Search detail successfully',
                'search_detail' => $searchDetail,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function getAllCategories()
    {
        try {
            $categories = LawCategory::where('status','Enable')->orderby('id','ASC')->get();

            return response()->json([
                'status' => true,
                'message' => 'All categories fetched successfully',
                'categories' => $categories,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function getCategoriesLimit(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'limit' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $categories = LawCategory::with('subCategories')->where('status','Enable')->orderby('id','ASC')->get()->take($request->limit);

            return response()->json([
                'status' => true,
                'message' => 'Limit categories fetched successfully',
                'categories' => $categories,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function getAllCategoriesWithSubCategories()
    {
        try {
            $subCategories = LawCategory::with('subCategories')->where('status','Enable')->orderby('id','ASC')->get();

            $subCategories->each(function ($subcategory) {
                $subcategory->get_laywers = Lawyer::where('sub_cat_id',null)->get();
            });

            return response()->json([
                'status' => true,
                'message' => 'All categories with subcategories fetched successfully',
                'categories' => $subCategories,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getAllLaywyers()
    {
        try {
            $lawyers = Lawyer::where('sub_cat_id',null)->orderby('id','ASC')->get();

            return response()->json([
                'status' => true,
                'message' => 'Lawyers fetched successfully',
                'lawyers' => $lawyers,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function getLaywyersData()
    {
        try {
            $lawyers = LawyerPageData::orderby('id','ASC')->get();

            return response()->json([
                'status' => true,
                'message' => 'Lawyers data fetched successfully',
                'lawyers_data' => $lawyers,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }



}
