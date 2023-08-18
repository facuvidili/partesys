@extends('adminlte::page')

@section('title', 'ParteSys')

@section('content_header')
    <h1 style="text-align: center;">CONTRATOS</h1>
@stop

@section('content')

@livewire('home.contracts-index')

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop