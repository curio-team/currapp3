<?php

namespace App\Http\Controllers;

use App\Models\Opleiding;
use Illuminate\Http\Request;

class OpleidingController extends Controller
{
    public function show(Opleiding $opleiding)
    {
        return view('opleidingen.show')->with('opleiding', $opleiding);
    }

    public function edit(Opleiding $opleiding)
    {
        //
    }

    public function update(Request $request, Opleiding $opleiding)
    {
        //
    }

    public function destroy(Opleiding $opleiding)
    {
        //
    }
}
