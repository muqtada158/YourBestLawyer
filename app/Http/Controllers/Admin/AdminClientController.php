<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminClientController extends Controller
{
    /**
 * Display a paginated list of clients.
 *
 * Retrieves a list of customers, including their details and first application case law.
 * The list is ordered by the most recent customers.
 *
 * @return \Illuminate\View\View
 */
    public function clients()
    {
        $customers = User::with('getUserDetails')->where('user_type','customer','getFirstApplicationDetails.getCaseLaw')->orderby('id','DESC')->paginate(5);
        return view('admin.clients',compact('customers'));
    }
/**
 * Display detailed information for a specific client.
 *
 * Retrieves details of a specific customer by their ID, including their associated user details.
 *
 * @param int $customer The ID of the customer to retrieve details for.
 * @return \Illuminate\View\View
 */
    public function clients_details($customer)
    {
        $customer = User::with('getUserDetails')->where('id',$customer)->first();
        return view('admin.clients-details',compact('customer'));
    }
}
