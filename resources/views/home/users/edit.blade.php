@extends('adminlte::page')

@section('title', 'Partesys')

@section('content_header')
    <h1 style="text-align: center;">EDITAR USUARIO</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>
                {{session('info')}}
            </strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            {!! Form::model($user, ['route' => ['home.users.update', $user], 'method' => 'put']) !!}
            {{-- Para editar va Form:model --}}
            <div class="form-group">
                {!! Form::label('name', 'Nombre y Apellido') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre y apellido']) !!}
                @error('name')
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
                {!! Form::label('email', 'Email') !!}
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese email']) !!}

                @error('email')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            @if($user->getRoleNames()[0] == 'Supervisor')
            <div class="form-group">
                {!! Form::label('company', 'Compañía') !!}
                {!! Form::text('company', $user->company->name, ['class' => 'form-control','readonly']) !!}
            </div>
            @endif
            {{-- <div class="form-group">
                {!! Form::label('rol', 'Tipo de usuario')!!}
                {!! Form::checkbox('rol', null, true, ['Administrador','Supervisor','Contador']) !!}
            </div> --}}

            {!! Form::submit('Editar usuario', ['class' => 'btn btn-outline-primary']) !!}
        </div>
    </div>
@stop
@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2023 <a href="https://adminlte.io">ParteSys</a>.</strong> Todos los derechos reservados.
    @stop