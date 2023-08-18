@extends('adminlte::page')

@section('title', 'ParteSys')

@section('content_header')
    <div class="card">
        <div class="card-body">
            <h5 style="text-align: center; font-size:29px">ORDEN DE COMPRA N° {{App\Models\PurchaseOrder::find($purchaseOrder)->id}} - {{App\Models\PurchaseOrder::find($purchaseOrder)->companyName()}} - 
                {{App\Models\PurchaseOrder::find($purchaseOrder)->consolidation->month.'/'.App\Models\PurchaseOrder::find($purchaseOrder)->consolidation->year}} - CUADRILLA N°{{App\Models\PurchaseOrder::find($purchaseOrder)->consolidation->crew->id}}</h5>
        </div>
    </div>
@stop

@section('content')

@livewire('home.purchase-order-detail-show', ['purchaseOrder' => $purchaseOrder])

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>  </script>
@stop
@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2023 <a href="https://adminlte.io">ParteSys</a>.</strong> Todos los derechos reservados.
    @stop