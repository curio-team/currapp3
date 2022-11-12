<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if(!$user->standaard_opleiding)
        {
            return view('users.standaard')->with('user', $user);
        }

        return redirect()->route('opleidingen.show', $user->standaard_opleiding);
    }

    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->standaard_opleiding = $request->opleiding_id;
        $user->save();

        return redirect()->route('home');
    }
}
