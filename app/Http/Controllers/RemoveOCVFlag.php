<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class RemoveOCVFlag extends Controller
{
    public function removeOCVFlag()
    {
        Session::forget('flareOCV');
        return response()->json(['message' => 'flareOCV flag removed']);
    }
}
