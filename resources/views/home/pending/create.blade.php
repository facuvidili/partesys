@extends('adminlte::page')

@section('title', 'Partesys')

@section('content_header')
    <h1>Generar consolidacion</h1>
@stop

@section('content')

    <div class="card">

        <div class="card-body">

            {!! Form::open(['route' => 'home.consolidations.store']) !!}

            {{-- seleccionar cuadrilla --}}

            <div class="form-group">
                {!! Form::label('company_id', 'Compañia') !!}
                {!! Form::select('company_id', $companies, null, ['class' => 'form-control']) !!}

                @error('company_id')
                    <small class="text-danger">{{ $message }}</small>
                    <br>
                @enderror
            </div>

            <div class="form-group">
                {!! Form::label('name', 'Nombre') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre']) !!}

                @error('name')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <p class="font-weight-bold">Deficitaria</p>

                <label class="mr-2">
                    {{ Form::radio('is_deficitary', '1', ['class' => 'form-control', 'id' => 'inlineRadio1']) }}
                    {{ Form::label('inlineRadio1', 'Si', ['class' => 'form-check-label']) }}
                </label>

                <label class="mr-2">
                    {{ Form::radio('is_deficitary', '0', ['class' => 'form-control', 'id' => 'inlineRadio2']) }}
                    {{ Form::label('inlineRadio2', 'No', ['class' => 'form-check-label']) }}
                </label>

                @error('is_deficitary')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                {!! Form::label('budget', 'Presupuesto') !!}
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <strong>$</strong> </span>
                    </div>
                    
                    {!! Form::number('budget', null, [
                        'class' => 'form-control',
                        'step' => '0.1',
                        'placeholder' => 'Ingrese el presupuesto',
                    ]) !!}
                </div>

                @error('budget')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- <div class="form-group">
                {!! Form::label('balance', 'Saldo') !!}
                {!! Form::number('balance', null, [
                    'class' => 'form-control',
                    'step' => '0.1',
                    'placeholder' => 'Ingrese el saldo actual',
                ]) !!}

                @error('balance')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div> --}}

            <div class="form-group">
                <p class="font-weight-bold">Contratistas asociados</p>
                @foreach ($contractors as $contractor)
                    <label class="mr-2">
                        {!! Form::checkbox('contractors[]', $contractor->id, null) !!}
                        {{ $contractor->name }}
                    </label>
                @endforeach

                @error('contractors')
                    <br>
                    <small class="text-danger">{{ $message }}</small>
                    <br>
                @enderror
            </div>

            {!! Form::submit('Crear cuenta', ['class' => 'btn btn-primary']) !!}

        </div>

    </div>

@stop
