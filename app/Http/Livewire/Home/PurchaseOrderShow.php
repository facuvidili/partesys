<?php

namespace App\Http\Livewire\Home;

use App\Models\Consolidation;
use App\Models\PurchaseOrder;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseOrderShow extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $purchaseOrder;

    public $openEvent;


    //public $search;
    public $sort = 'id';
    public $direction = 'desc';

    protected $listeners = [
        'showEvent', 'downloadPdf'
    ];

    public $consolidation;

    public function mount(Consolidation $consolidation)
    {
        $this->consolidation = $consolidation;
    }

    public function render()
    {
        $purchaseOrders = PurchaseOrder::where('consolidation_id', $this->consolidation->id)
            ->orderBy($this->sort, $this->direction)->paginate(10);

        return view('livewire.home.purchase-order-show', compact('purchaseOrders'));
    }

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
        ['purchaseOrder' => $purchaseOrder, 
        'contador'=>Auth::user()])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "Order_Compra_Nro_" . $purchaseOrder->id . ".pdf"
        );
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }
}
