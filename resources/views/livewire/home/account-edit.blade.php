<div>
<div class="card">

    <div class="card-body">

        {!! Form::model($account, [
            'route' => ['home.accounts.update', $account],
            'autocomplete' => 'off',
            'method' => 'put',
        ]) !!}
        {{-- Para editar va Form:model --}}

        <div class="form-group">
            {!! Form::label('id', 'Numero de cuenta') !!}
            {!! Form::number('id', null, ['class' => 'form-control', 'readonly']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('company_id', 'Compañía propietaria') !!}
            {!! Form::select('company_id', $companies, null, ['class' => 'form-control','readonly']) !!}

        </div>

        <div class="form-group">
            {!! Form::label('name', 'Nombre de cuenta') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre', 'maxlength' => '25']) !!}

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
                {{ Form::label('inlineRadio1', 'SI', ['class' => 'form-check-label']) }}
            </label>

            <label class="mr-2">
                {{ Form::radio('is_deficitary', '0', ['class' => 'form-control', 'id' => 'inlineRadio2']) }}
                {{ Form::label('inlineRadio2', 'NO', ['class' => 'form-check-label']) }}
            </label>
        </div>

        <div class="form-group">
            {!! Form::label('budget', 'Presupuesto (ARS)') !!}
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <strong>$</strong> </span>
                </div>
                
                {!! Form::number('budget',null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el presupuesto',
                    //'wire:model' => "budget"
                ]) !!}
            </div>

            @error('budget')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group">
            {!! Form::label('balance', 'Saldo (ARS)') !!}
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <strong>$</strong> </span>
                </div>
                
                {!! Form::number('balance', null, [
                    'class' => 'form-control',
                    'readonly',
                    // 'wire:keydown' => "suma('budget')"
                ]) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('reserved', 'Reservado (ARS)') !!}
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <strong>$</strong> </span>
                </div>

                {!! Form::text('reserved',number_format($account->totalReserved(), 2,',','.'), [
                    'class' => 'form-control',
                    'readonly'
                ]) !!}
            </div>
        </div>

        {{-- <div class="form-group">
            {!! Form::label('contractors', 'Contratistas asociados') !!}
            {!! Form::select('contractors[]', $contractors, null, ['class' => 'form-control', 'multiple' => 'multiple']) !!}

            @error('contractors')
                <small class="text-danger">
                    {{ $message }}
                </small>
                <br>
            @enderror
        </div> 
        --}}

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

        {!! Form::submit('Editar cuenta', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
</div>
