@extends('adminlte::page')

@section('title', 'ParteSys')

@section('content_header')
    <h1>Consolidations</h1>
@stop

@section('content')

@livewire('home.pending-index')

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>  </script>
@stop