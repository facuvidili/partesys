<div>
    <div class="card">
        @if (session('info'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>
                    {{ session('info') }}
                </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>
                {{ session('danger') }}
            </strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
        <div class="card-header flex input-group">
            <input wire:model="search" class="form-control" placeholder="Buscar contrato">
            <div class="input-group-append">
                <a class="btn btn-outline-secondary mb-2 float-right" href="{{ route('home.contracts.create') }}">Crear
                    contrato</a>
            </div>
        </div>
        @if ($contracts->count())
            <div class="card-body">
                <div class="table-responsive rounded">

                    <table class="table align-middle table-striped table-bordered table-sm"
                        style="text-align: center; vertical-align: middle;">

                        <thead class="table-dark">
                            <tr>
                                <th role="button" style="text-align: center" role="button" wire:click="order('id')">Contratista
                                </th>
                                <th role="button" style="text-align: center" role="button" wire:click="order('crew_id')">N° Cuadrilla
                                </th>
                                <th role="button" style="text-align: center" role="button" wire:click="order('account_id')">Compañía
                                </th>
                                <th role="button" style="text-align: center" role="button" wire:click="order('account_id')">Cuenta</th>
                                <th role="button" style="text-align: center" role="button" wire:click="order('start_date')">Fecha de
                                    inicio</th>
                                <th role="button" style="text-align: center" role="button" wire:click="order('end_date')">Fecha de
                                    finalización</th>
                                <th role="button" style="text-align: center" role="button" wire:click="order('months_duration')">Cantidad de
                                    meses</th>
                                <th role="button" style="text-align: center" role="button" wire:click="order('total_price')">Valor</th>
                                <th role="button" style="text-align: center" role="button" wire:click="order('end_date')">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contracts as $contract)
                                <tr>
                                    <td role="button" style="text-align: center">
                                        {{ $contract->crew->contractor->name }}
                                    </td>
                                    <td role="button" style="text-align: center">{{ $contract->crew_id }}</td>
                                    <td role="button" style="text-align: center">
                                        {{ $contract->account->company->name }}
                                    </td>
                                    <td role="button" style="text-align: center">{{ $contract->account->name }}</td>
                                    <td role="button" style="text-align: center">
                                        {{ \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') }}</td>
                                    <td role="button" style="text-align: center">
                                        {{ \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') }}</td>
                                    <td role="button" style="text-align: center">{{ $contract->months_duration }}</td>
                                    <td role="button" style="text-align: center">AR$
                                        {{ number_format($contract->total_price, 2, ',', '.') }}</td>
                                        @if ( $contract->end_date >= \Carbon\Carbon::today() )
                                        <td role="button" style="text-align: center; color:green">Activo</td>
                                        @else 
                                        <td role="button" style="text-align: center; color:red">Inactivo</td>
                                        @endif
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $contracts->links() }}
            </div>
        @else
            <div class="card-footer">
                <div class="alert alert-secondary" role="alert">
                    No se encontraron resultados.
                </div>
            </div>
        @endif
    </div>
</div>
