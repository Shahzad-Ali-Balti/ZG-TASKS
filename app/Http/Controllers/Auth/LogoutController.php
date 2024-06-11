<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class LogoutController extends Controller
{
    use AuthenticatesUsers;

    public function logoutUser(Request $request)
    {
        // Logout the user
        Auth::logout();

        // Check if the request came from AJAX
        if ($request->ajax()) {
            // Return success response
            return redirect('auth/login');
            return response()->json(['success' => true, 'message' => 'Logout successful.']);
        } else {
            // Redirect the user to the login page
            return redirect('auth/login');
        }
    }
    
     /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';
   /**
    * Create a new controller instance.
    *
    * @return void
    */
}