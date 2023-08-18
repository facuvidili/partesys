<div>
    <div class="card">

        <div class="card-body">

            {!! Form::open(['route' => 'home.contracts.store']) !!}

            <div class="form-group">
                {!! Form::label('start_date', 'Fecha de inicio *') !!}
                {!! Form::date('start_date', null, ['class' => 'form-control']) !!}

                @error('start_date')
                    <small class="text-danger">{{ $message }}</small>
                    <br>
                @enderror
            </div>

            <div class="form-group">
                {!! Form::label('months_duration', 'Duración (cantidad de meses) *') !!}
                {!! Form::number('months_duration', null, [
                    'class' => 'form-control',
                    'step' => '1',
                    'min' => 1,
                    'max' => 12,
                    'placeholder' => 'Ingrese la duracion en cantidad de meses',
                ]) !!}


                @error('months_duration')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                {!! Form::label('total_price', 'Monto total *') !!}
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <strong>$</strong> </span>
                    </div>

                    {!! Form::number('total_price', null, [
                        'class' => 'form-control',
                        'step' => '100',
                        'placeholder' => 'Ingrese el monto total',
                        'wire:model' => 'totalPrice',
                        'min' => 1000,
                        'required' => 'required',
                    ]) !!}
                </div>
                @error('total_price')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                {!! Form::label('company', 'Compañía *') !!}
                {!! Form::select('company', $companies, null, [
                    'class' => 'form-control',
                    'wire:model' => 'selectedCompany',
                    'placeholder' => '---',
                ]) !!}

                @error('company')
                    <small class="text-danger">{{ $message }}</small>
                    <br>
                @enderror
            </div>

            <div class="form-group">
                {!! Form::label('account_id', 'Cuenta *') !!}
                {!! Form::select('account_id', $accounts ? $accounts : ['---'], null, [
                    'class' => 'form-control',
                    'wire:model' => 'selectedAccount',
                    'placeholder' => '---',
                ]) !!}

                @error('account_id')
                    <small class="text-danger">{{ $message }}</small>
                    <br>
                @enderror
            </div>

            <div class="form-group">
                {!! Form::label('crew_id', 'Cuadrilla *') !!}
                {!! Form::select('crew_id', $crews ? $crews : ['---'], null, [
                    'class' => 'form-control',
                    'placeholder' => '---',
                ]) !!}


                @error('crew_id')
                    <small class="text-danger">{{ $message }}</small>
                    <br>
                @enderror
            </div>
            {!! Form::submit('Crear contrato', ['class' => 'btn btn-outline-primary']) !!}

        </div>
    </div>

</div>

