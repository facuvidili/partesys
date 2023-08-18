<?php

namespace App\Http\Livewire\Home;

use App\Models\PurchaseOrder;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class PurchaseOrderEventPDF extends Component
{

    public $purchaseOrder;
    public $openEvent;

    protected $listeners = [
        'showEvent', 'downloadPdf'
    ];
/* 
    public function render()
    {
        return view('livewire.home.daily-reports-event');
    } */

    public function showEvent($eventId)
    {
        //ENCUENTRA EL REPORTE POR ID PARA MOSTRAR
        $this->purchaseOrder = PurchaseOrder::find($eventId);

        $this->openEvent = true;
    }

    public function downloadPdf($id)
    {
        $purchaseOrder = PurchaseOrder::find($id);
        $pdfContent = PDF::loadView('livewire.home.purchase-order-eventPDF', 
        ['purchaseOrderShow' => $purchaseOrder, 
        'contador'=>Auth::user()])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "Order_Compra_Nro_" . $purchaseOrder->id . ".pdf"
        );
    }

    public function render()
    {
        return view('livewire.home.purchase-order-event-p-d-f');
    }
}
