<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::MDASHBOARD;

    public function redirectTo()
    {
        // $for = [
        //     'manager' => 'managementDashboard',
        //     'staff'  => 'staffDashboard',
        // ];
        // return $this->redirectTo = route($for[auth()->user()->role]);
        return $this->redirectTo = route(Auth::user()->getRedirectRoute());
    }


    /**
     * Create a new controller instance.
     *
     * This function initializes a new instance of the controller class.
     * It sets up the middleware to handle guest sessions and exclude the 'logout' route.
     *
     * @return void
     */
    public function __construct()
    {
        // Set up middleware for guest sessions
        $this->middleware('guest')->except('logout');
    }
}
