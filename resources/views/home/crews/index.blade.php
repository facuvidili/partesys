@extends('adminlte::page')

@section('title', 'ParteSys')

@section('content_header')
    <h1 style="text-align: center">CUADRILLAS</h1>
@stop

@section('content')

@livewire('home.crews-index')

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2023 <a href="https://adminlte.io">ParteSys</a>.</strong> Todos los derechos reservados.
    @stop