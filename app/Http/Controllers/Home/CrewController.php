<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Crew;
use Illuminate\Http\Request;

class CrewController extends Controller
{
    public function index()
    {
        return view('home.crews.index');
    }
    public function edit(Crew $crew)
    {
        return view('home.crews.edit', compact('crew'));
    }
    public function update(Request $request, Crew $crew)
    {
        $request ->validate([
            'amount_members' => 'required',
            'hour_price' => 'required',
        ]);
        $crew->update($request->all());
        return redirect()->route('home.crews.index')->with('info','La cuadrilla se actualizó correctamente');
    }
}
