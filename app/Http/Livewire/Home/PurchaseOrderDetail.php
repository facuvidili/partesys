<?php

namespace App\Http\Livewire\Home;


use App\Models\PurchaseOrder;
use Livewire\Component;
use Livewire\WithPagination;

class PurchaseOrderDetail extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    //public $search;
    public $sort = 'id';
    public $direction = 'desc';

    public $purchaseOrder;

    public function mount(PurchaseOrder $purchaseOrder)
    {
        $this->purchaseOrder = $purchaseOrder;
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

    public function render()
    {
        $purchaseOrder = PurchaseOrder::whereId($this->purchaseOrder->id)
            ->orderBy($this->sort, $this->direction);//->paginate(10);

        return view('livewire.home.purchase-order-detail', compact('purchaseOrder'));
    }
}
