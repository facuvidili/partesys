@extends('adminlte::page')

@section('title', 'Partesys')

@section('content_header')
    <h1 style="text-align:center;">CREAR NUEVO CONTRATO</h1>
@stop

@section('content')

    @livewire('home.contracts-create')

@endsection

@section('js')
    <script>
        // console.log('Hi!');
    </script>
@stop
