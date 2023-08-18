@extends('adminlte::page')

@section('title', 'ParteSys')

@section('content_header')
    <h1>Ordenes de compra</h1>
@stop

@section('content')
@livewire('home.purchase-order-show',['consolidation' => $consolidation])
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>  </script>
@stop