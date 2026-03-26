<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TokenController extends Controller
{
    public function create(Request $request): View
    {
        $token = $request->user()->createToken(strval(time()));

        return view('users/token')->with('token', $token);
    }
}
