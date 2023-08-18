@extends('adminlte::page')

@section('title', 'Partesys')

@section('content_header')
    <h1>Editar cuadrilla</h1>
@stop

@section('content')
{{-- @dd($crew->totalsDailyReportsToConsolidate('10','2022')) --}}
    @if (session('info'))
        <div class="alert alert-success">
            <strong>
                {{session('info')}}
            </strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            {!! Form::model($crew, ['route' => ['home.crews.update', $crew], 'method' => 'put']) !!}
            {{-- Para editar va Form:model --}}
            <div class="form-group">
                {!! Form::label('id', 'Id cuadrilla') !!}
                {!! Form::number('id', null, ['class' => 'form-control', 'readonly']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('amount_members', 'Cantidad de integrantes') !!}
                {!! Form::number('amount_members', null, ['class' => 'form-control', 'placeholder' => 'Cantidad de integrantes', 'min' => 1, 'max' => 100]) !!}
                @error('amount_members')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('hour_price', 'Precio de hora') !!}
                {!! Form::number('hour_price', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el precio de hora de la cuadrilla','min'=> 100]) !!}
                @error('hour_price')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            {!! Form::submit('Editar cuadrilla', ['class' => 'btn btn-outline-primary']) !!}
        </div>
    </div>
@stop
@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2023 <a href="https://adminlte.io">ParteSys</a>.</strong> Todos los derechos reservados.
    @stop