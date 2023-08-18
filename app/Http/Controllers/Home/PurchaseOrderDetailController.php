<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseOrderDetailController extends Controller
{
   /*  public function index() {

    } */

    public function show($purchaseOrder)
    {
        return view('home.purchaseOrderDetails.show', compact('purchaseOrder'));
    }
}
