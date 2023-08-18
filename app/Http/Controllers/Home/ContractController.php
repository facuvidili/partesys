<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Crew;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        return view('home.contracts.index');
    }

    public function create()
    {

        return view('home.contracts.create');
    }

    public function store(Request $request)
    {
        if (Crew::find($request->crew_id)->activeContract()->isEmpty()) {



            $request->validate([
                'start_date' => 'required',
                'months_duration' => 'required',
                'total_price' => 'required|min:4',
                'account_id' => 'required',
                'crew_id' => 'required',
            ]);

            $endDate = new Carbon($request->start_date);
            $endDate = $endDate->addMonths($request->months_duration);

            $contract = Contract::create([
                'start_date' => $request->start_date,
                'months_duration' => $request->months_duration,
                'end_date' => $endDate,
                'total_price' => $request->total_price,

            ]);

            $contract->crew()->associate($request->crew_id);
            $contract->account()->associate($request->account_id);
            $contract->save();
            $crew = Crew::find($request->crew_id);
            $crew->hour_price = null;
            $crew->save();


            return redirect()->route('home.contracts.index')->with('info', 'El contrato se generó correctamente');
        } else {
            return redirect()->route('home.contracts.index')->with('danger', 'El contrato no se pudo generar porque ya existe contrato activo para la cuadrilla');
        }
    }
}
