<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if(!$user->standaard_opleiding)
        {
            ///
            /// TIJDELIJK!!!
                if(!$user->teams->count())
                {
                    $user->teams()->attach(Team::first());
                    return redirect('/');
                }
            /// TIJDELIJK!!!
            ///

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
