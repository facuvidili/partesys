<div>

    <div class="row justify-content-start">
        @foreach ($querys as $company_id => $query)
            {{-- {{$query->account_id}} --}}
            <div class="col-6">
                <div class="card">
                    <div class="card-body">

                        <label class="text-lg dropdown-toggle" data-toggle='collapse'
                            data-target={{ '#comp' . $company_id }} aria-expanded='false'
                            aria-controls={{ 'comp' . $company_id }} role="button">
                            Compañía: {{ \App\Models\Company::find($company_id)->name }}
                        </label>
                        <div wire:ignore.self class="collapse" id={{ 'comp' . $company_id }}>



                            @foreach ($query as $account_id => $q)
                                <div class="card card-body">
                                    <label class="text-lg dropdown-toggle" data-toggle='collapse'
                                        data-target={{ '#acou' . $account_id }} aria-expanded='false'
                                        aria-controls={{ 'acou' . $account_id }} role="button">Cuenta N°:
                                        {{ $account_id }} - {{App\Models\Account::find($account_id)->name}}</label>
                                    <div wire:ignore.self class="collapse" id={{ 'acou' . $account_id }}>
                                        <div>
                                            <ul class="list-group max-w-xs">
                                                <li class="list-group-item"><label>Saldo disponible:</label>
                                                    <label wire:model.defer="currentBalance"
                                                        class="text-right float-right">ARS$
                                                        {{ number_format($querys[$company_id][$account_id]['current_balance'], 2, ',', '.') }}</label>
                                                </li>
                                                <li class="list-group-item"><label>Total horas
                                                        normales: </label> <label class="text-right float-right">ARS$
                                                        {{ number_format($q['normal_hour'], 2, ',', '.') }}</label></li>
                                                <li class="list-group-item"><label>Total horas al
                                                        50%: </label> <label class="text-right float-right">ARS$
                                                        {{ number_format($q['fifty_hour'], 2, ',', '.') }}</label></li>
                                                <li class="list-group-item"><label>Total horas al
                                                        100%: </label> <label class="text-right float-right">ARS$
                                                        {{ number_format($q['hundred_hour'], 2, ',', '.') }}</label>
                                                </li>
                                                <li class="list-group-item"><label>Total Viandas: </label> <label
                                                        class="text-right float-right">ARS$
                                                        {{ number_format($q['food'], 2, ',', '.') }}</label></li>

                                                <li class="list-group-item" class="mb-3">
                                                    <label>Conceptos extraordinarios y descuentos: </label>
                                                    <div id="exCon{{ $company_id }}-{{ $account_id }}">
                                                        @foreach ($querys[$company_id][$account_id]['concepts'] as $key => $con)
                                                            <div class="input-group mb-3">
                                                                <label type="text" class="form-control rounded-md">
                                                                    {{ $con['name'] }} - Valor: ARS$
                                                                    {{ number_format($con['value'], 2, ',', '.') }}</label>
                                                                <div>
                                                                    <button type="button"
                                                                        wire:click='removeExConcept({{ $company_id }} , {{ $account_id }}, {{ $key }})'
                                                                        class="btn btn-outline-danger">X</button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </li>
                                                <li class="list-group-item"><label>Subtotal:</label> <label
                                                        class="text-right float-right">ARS$
                                                        {{ number_format($q['sub_total'], 2, ',', '.') }}</label>
                                                </li>
                                                <hr>
                                                {{-- @dump($querys[$company_id][$account_id]['concepts']) --}}
                                                <div class="input-group">
                                                    <div>
                                                        <select wire:model.defer="exConceptId"
                                                            class="form-control mb-2">
                                                            <option hidden selected>Seleccionar concepto o descuento
                                                            </option>

                                                            @foreach ($exConcepts as $exConcept)
                                                                <option value={{ $exConcept->id }}>
                                                                    {{ $exConcept->name }}</option>
                                                            @endforeach

                                                        </select>
                                                        <x-jet-input-error for="exConceptId" />
                                                    </div>


                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"> <strong>$</strong>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <input wire:model.defer="exConceptValue" type="number"
                                                                placeholder="Monto" class="form-control" min="1">
                                                        </div>

                                                    </div>
                                                    <div>
                                                        <x-jet-input-error for="exConceptValue" />
                                                    </div>

                                                </div>
                                                <div class="mt-3">
                                                    <button
                                                        wire:click.stop="addExConcept({{ $account_id }},{{ $company_id }})"
                                                        class="btn btn-secondary btn input-group-append">Agregar
                                                        concepto</button>
                                                </div>
                                        </div>

                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>
            </div>
        @endforeach
    </div>
    <div class="card-body">
        {{-- <button wire:click="store" class="btn btn-success float-right">Confirmar
            consolidación</button> --}}
        <button wire:click="$emit('newConsolidation')" class="btn btn-success float-right">Confirmar
            consolidación</button>
    </div>
    {{-- @dump($querys) --}}
    {{-- @dump($currentBalance) --}}
    {{-- @dump($prueba) --}}
</div>
@push('js')
    <script>
        Livewire.on('newConsolidation', function() {
            Swal.fire({
                title: '¿Desea confirmar la consolidación?',
                text: "No podrá deshacer esta operación.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Hecho',
                        'La consolidación ha sido creada',
                        'success'
                    )
                    Livewire.emit('store');
                }
            })
        });
        window.addEventListener('conceptRepit', event => {
            Swal.fire({
                type: 'warning',
                title: 'Error',
                text: 'No puede agregar el mismo concepto o descuento dos veces.',
            })
        });
        window.addEventListener('higherValue', event => {
            Swal.fire({
                type: 'warning',
                title: 'Error',
                text: 'No se puede descontar menos que el subtotal.',
            })
        });
        window.addEventListener('higherValueBalance', event => {
            Swal.fire({
                type: 'warning',
                title: 'Error',
                text: 'El total de los conceptos agregados no puede superar el saldo disponible',
            })
        });
    </script>
@endpush
