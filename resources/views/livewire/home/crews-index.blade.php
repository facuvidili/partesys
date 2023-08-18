<div>
    
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
                                    <th role="button" wire:click="order('contractor_id')">Contratista</th>
                                    <th role="button" wire:click="order('amount_members')">
                                        Cantidad
                                        de integrantes</th>
                                    <th role="button" wire:click="order('hour_price')">Precio de la hora</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($crews as $crew)
                                    <tr>
                                        <td>{{ $crew->id }}</td>
                                        <td>{{ $crew->contractor->name }}</td>
                                        <td>{{ $crew->amount_members }}</td>

                                        <td>
                                            {{ $crew->hour_price ? '$' . number_format($crew->hour_price, 2, ',', '.') : 'Por contrato' }}
                                        </td>
                                        <td width="10px">
                                            @if ($crew->hour_price != 0)
                                                <a class="btn btn-outline-primary btn-sm"
                                                    href="{{ route('home.crews.edit', $crew) }}">Editar</a>
                                            @else
                                                <button wire:click="$emit('contract')" type="submit"
                                                    class="btn btn-outline-secondary btn-sm">Editar</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                              
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $crews->links() }}
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
    @push('js')
        <script>
            Livewire.on('contract', function() {
                Swal.fire({
                    type: 'warning',
                    title: 'Error',
                    text: 'Esta cuadrilla no puede ser modificada ya que posee un contrato activo.',
                    // footer: '<a href="">¿Por qué tengo este problema?</a>'
                })
            });
        </script>
    @endpush
</div>
