<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
//use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class logincanvas extends Controller
{
   /**
     * Handle an incoming request.
     *
     */
    public function logincanvas(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->role == 'staff') {
            // Authentication passed
            return redirect()->route('staffDashboard');
        } elseif (Auth::attempt($credentials) && Auth::user()->role == 'manager') {
            // Authentication passed
            return redirect()->route('managementDashboard');
        } else {
            // Authentication failed
            Session::put('flareOCV', true);
            return back()->withErrors([
                'email' => 'These Credentials Do Not Match Our Records',
            ]);
        }
    }

}
