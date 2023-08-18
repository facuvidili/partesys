<div>

    <div class="card-header flex">

        <input wire:model="search" class="form-control" placeholder="Buscar cuadrilla">
    </div>
    @if ($crews->count())
    <div class="card-body">
        <div class="table-responsive rounded">

            <table class="table align-middle table-striped table-bordered table-sm"
                style="text-align: center; vertical-align: middle;">

                <thead class="table-dark">
                    <tr>
                        <th role="button" wire:click="order('id')">N° Cuadrilla</th>
                        <th role="button">Contratista propietaria</th>
                        <th role="button" wire:click="order('amount_members')">Cantidad de integrantes</th>
                        <th role="button" wire:click="order('hour_price')">Precio de la hora</th>
                        <th>Seleccionar</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($crews as $crew)
                        <tr>
                            <td>{{ $crew->id }}</td>
                            <td>{{ $crew->contractor->name }}</td>
                            <td>{{ $crew->amount_members }}</td>
                            <td>{{ $crew->hour_price ? '$' . number_format($crew->hour_price, 2, ',', '.') : 'Por contrato' }}
                            </td>
                            <td width="10px"><button wire:click="showCalendar({{ $crew->id }})"
                                class="btn btn-outline-primary btn-sm">Seleccionar</button></td>
                        </tr>
    
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-body">
            <div>
                {{ $crews->links() }}
            </div>
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