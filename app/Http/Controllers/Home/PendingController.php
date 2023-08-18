<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Consolidation;
use App\Models\Crew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.pending.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::pluck('name', 'id');
        //$crews = Crew::pluck('name', 'id');
        $crews = Crew::all()->dailyReports->where('consolidation_id', null); // cuadrillas que tengan consolidaciones pendientes
        
        return $crews;
        //return view('home.pending.create', compact('companies', 'contractors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /* public function store(Request $request)
    {
        $request->validate([
            'crew_id' => 'required',
            'extraordinary_concepts' => 'required|numeric|between:0,99999999999999.99',
            'discount' => 'required|numeric|between:0,99999999999999.99'
        ]);

        $consolidation = Consolidation::create([
            'crew_id' => $request->crew_id,
            'month' => $request->month,
            'year' => $request->year,
            'user_id' => Auth::user()->id
        ]);


        if ($request->contractors) {
            //se añade los contracotrs a la tabla intermedia
            $account->contractors()->attach($request->contractors);
        }

        return redirect()->route('home.accounts.edit', $account)->with('info', 'La cuenta se agregó correctamente');
    } */
}
