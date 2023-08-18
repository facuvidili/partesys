@extends('adminlte::page')

@section('title', 'Partesys')

@section('content_header')
    <h1 style="text-align: center;">CREAR NUEVA CUENTA</h1>
@stop

@section('content')

    <div class="card">

        <div class="card-body">

            {!! Form::open(['route' => 'home.accounts.store']) !!}

            <div class="form-group">
                {!! Form::label('company_id', 'Compañía *') !!}
                {!! Form::select('company_id', $companies, null, ['class' => 'form-control']) !!}

                @error('company_id')
                    <small class="text-danger">{{ $message }}</small>
                    <br>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('name', 'Nombre *') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre']) !!}

                @error('name')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <p class="font-weight-bold">Deficitaria *</p>

                <label class="mr-2">
                    {{ Form::radio('is_deficitary', '1', ['class' => 'form-control', 'id' => 'inlineRadio1']) }}
                    {{ Form::label('inlineRadio1', 'SI', ['class' => 'form-check-label']) }}
                </label>

                <label class="mr-2">
                    {{ Form::radio('is_deficitary', '0', ['class' => 'form-control', 'id' => 'inlineRadio2']) }}
                    {{ Form::label('inlineRadio2', 'NO', ['class' => 'form-check-label']) }}
                </label>

                @error('is_deficitary')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('budget', 'Presupuesto *') !!}
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
            <div class="form-group">
                <p class="font-weight-bold">Contratistas asociadas:</p>
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

            {!! Form::submit('Crear cuenta', ['class' => 'btn btn-outline-primary']) !!}

        </div>

    </div>

@stop
@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2023 <a href="https://adminlte.io">ParteSys</a>.</strong> Todos los derechos reservados.
    @stop
