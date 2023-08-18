@extends('adminlte::page')

@section('title', 'Partesys')

@section('content_header')
    <h1>Editar cuenta</h1>
@stop
@section('content')
@livewire('home.account-edit',['account'=>$account])
@endsection
@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2023 <a href="https://adminlte.io">ParteSys</a>.</strong> Todos los derechos reservados.
    @stop
