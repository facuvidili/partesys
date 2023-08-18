<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function create()
    {

        return view('home.dailyReports.create');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([]);
    //     $dailyReport = DailyReport::create($request->all());
    //     return redirect()->route('home.dailyReports.create', $dailyReport)->with('info', 'El Parte se ingresó correctamente');
    // }

  

}
