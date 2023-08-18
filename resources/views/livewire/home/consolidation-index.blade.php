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
        <div class="card-header flex">

            <input wire:model="search" class="form-control" placeholder="Buscar consolidacion">

        </div>
        @if ($consolidations->count())
            <div class="card-body ">
                <div class="table-responsive rounded">

                    <table class="table align-middle table-striped table-bordered table-sm"
                        style="text-align: center; vertical-align: middle;">

                        <thead class="table-dark">
                            <tr>
                                <th role="button" wire:click="order('id')">N° Consolidación</th>
                                <th role="button" wire:click="order('crew_id')">N° Cuadrilla</th>
                                <th role="button" wire:click="order('crew_id')">Contratista</th>
                                <th role="button" wire:click="order('month')">Mes/Año</th>
                                <th role="button" wire:click="order('user_id')">Contador</th>
                                <th role="button" wire:click="order('created_at')">Fecha generada</th>
                                <th>Total consolidado (ARS)</th>
                                <th>Ordenes de compra</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($consolidations as $consolidation)
                                <tr>
                                    <td>{{ $consolidation->id }}</td>
                                    <td>{{ $consolidation->crew_id }}</td>
                                    <td>{{ \App\Models\Crew::find($consolidation->crew_id)->contractor->name }}</td>
                                    <td>{{ $consolidation->month . '/' . $consolidation->year }}</td>
                                    <td>{{ $consolidation->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($consolidation->created_at)->format('d/m/Y - H:i a') }}
                                    </td>
                                    <td>${{ number_format($consolidation->total(), 2, ',', '.') }}</td>
                                    {{-- <td style="text-align:right">${{ number_format($consolidation->total(), 2, ',', '.') }}</td> --}}
                                    <td width="150px">
                                        <a class="btn btn-outline-primary btn-sm btn-block"
                                            href="{{ route('home.purchaseOrders.show', $consolidation->id) }}">Detalle</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>

            <div class="card-footer">
                {{ $consolidations->links() }}
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
