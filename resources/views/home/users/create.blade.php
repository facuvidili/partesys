@extends('adminlte::page')

@section('title', 'Partesys')

@section('content_header')
    <h1 style="text-align: center;">CREAR NUEVO USUARIO</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'home.users.store']) !!}
            <div class="form-group">
                {!! Form::label('name', 'Nombre y Apellido *') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre y apellido', 'required','maxlenght' => '25']) !!}
                @error('name')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('dni', 'DNI *') !!}
                {!! Form::number('dni', null, ['class' => 'form-control', 'placeholder' => 'Ingrese Dni', 'required']) !!}
                @error('dni')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('email', 'E-mail *') !!}
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese e-mail', 'required']) !!}

                @error('email')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('phone_number', 'Teléfono') !!}
                {!! Form::number('phone_number', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el número de teléfono']) !!}

                @error('phone_number')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('role', 'Rol *') !!} <br>
                {!! Form::select(
                    'role',
                    ['Supervisor' => 'Supervisor', 'Contador' => 'Contador', 'Administrador' => 'Administrador'],
                    'Supervisor', ['class' => 'form-control']
                ) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Contraseña *') !!}
                {!! Form::password('password', ['placeholder' => 'Ingrese su contraseña', 'class' => 'form-control', 'required']) !!}
                @error('password')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div>
                <p>(*) Campos requeridos</p>
            </div>

            {!! Form::submit('Crear usuario', ['class' => 'btn btn-outline-primary']) !!}
        </div>
    </div>
@stop
@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2023 <a href="https://adminlte.io">ParteSys</a>.</strong> Todos los derechos reservados.
    @stop
