<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CaseDetail;
use App\Models\CaseMedia;
use Illuminate\Http\Request;

class CustomerMediaController extends Controller
{
    /**
 * Display the media associated with a user's cases.
 *
 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
 */
    public function media()
    {
        try {

            $medias = CaseDetail::with('getCaseMedia')->where('user_id',auth()->user()->id)->paginate(5);

            return view('customer.media',compact('medias'));

        } catch (\Throwable $th) {
            $alert = [
                'message' => 'Error :'.$th->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($alert);
        }
    }
}
