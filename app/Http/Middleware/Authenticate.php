<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateMiddleware
{
    public function handle($request, Closure $next)
    {
        $ngrok_link = config('app.ngrok_Link');
        if (Auth::check()) {
            // User is authenticated, allow access
            return redirect()->route('/ajaxcrud/index')->with('ngrok_link', $ngrokLink);  // Redirect to the login page
        }

        // User is not authenticated, redirect to login page or return unauthorized response
        return redirect()->route('auth/login')->with('ngrok_link', $ngrokLink); ; // Redirect to the login page
        // return response()->json(['error' => 'Unauthorized'], 401); // Return unauthorized response for APIs
    }
}
