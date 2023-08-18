<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformeController extends Controller
{
        public function index()
    {
        return view('home.informe.index');
    }
    public function seleccionarFechas()
    {
        return view('home.informe.seleccionarFechas');
    }
}