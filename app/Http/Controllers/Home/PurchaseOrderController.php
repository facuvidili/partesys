<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Consolidation;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function show($consolidation){
        return view('home.purchaseOrders.show', compact('consolidation'));
    }
    /* 
    public function index()
    {
        return view('home.purchaseOrders.show', compact('purchaseOrder'));
    }
 */
    public function create(){
        return view('home.purchaseOrders.create');
    }

}
