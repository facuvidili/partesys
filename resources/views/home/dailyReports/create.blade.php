@extends('adminlte::page')

@section('title', 'Partesys')

@section('content_header')
    <h1 class="text-center">CARGAR PARTE</h1>
    
@stop



@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>
                {{ session('info') }}
            </strong>
        </div>
    @endif
    @livewire('home.daily-reports-create')



@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
@vite('resources/js/app.js')
@section('js')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    
    {{-- <script defer src="https://unpkg.com/alpinejs@3.2.4/dist/cdn.min.js"></script> --}}
@stop
