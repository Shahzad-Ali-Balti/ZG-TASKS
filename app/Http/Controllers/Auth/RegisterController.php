<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    public function checkEmailExists(Request $request)
     {
         $email = $request->input('email');
         $userExists = User::where('email', $email)->exists();
         return response()->json(['exists' => $userExists]);
     }

     public function sendOTP(Request $request)
     {
         // Validate the incoming request data
         $validator = Validator::make($request->all(), [
             'email' => 'required|email',
         ]);
     
         // If validation fails, return error response
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }
     
         // Generate new OTP
         $otp = Str::random(6); // Generate 6-digit OTP
     
         // Store the OTP in the session or a temporary table for later verification
         session(['otp' => $otp, 'otp_email' => $request->email]);
     
         // Send email with new OTP
         Mail::to($request->email)->send(new EmailVerification($otp));
     
         return response()->json(['message' => 'OTP sent successfully.']);
     }
     
     public function verifyOTP(Request $request)
{
    $otp = $request->input('otp');
    $storedOTP = session('otp');

    if ($otp === $storedOTP) {
        // OTP is valid
        return response()->json(['valid' => true]);
    } else {
        // Invalid OTP
        return response()->json(['valid' => false]);
    }
}


    public function registerUser(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password']),
    ]);

    // Generate verification token

    // Save verification token to the user
    // $user->verification_token = $verificationToken;
    $user->save();

    // Send verification email

    return response()->json(['success' => true, 'message' => 'Registration successful.']);
}

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
