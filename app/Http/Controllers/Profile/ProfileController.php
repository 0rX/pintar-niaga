<?php

namespace App\Http\Controllers\Profile;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Create a new component instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Return user profile
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('profile.profile');
    }
}
