<div>

    <div class="card">

        <div class="card-header flex">

            <input wire:model="search" class="form-control" placeholder="Buscar consolidación pendiente">

        </div>
        @if ($unresolved_consolidations->count())
            <div class="card-body ">


                <div class="table-responsive rounded">

                    <table class="table align-middle table-striped table-bordered table-sm"
                        style="text-align: center; vertical-align: middle;">

                        <thead class="table-dark">
                            <tr>
                                <th role="button" wire:click="order('crew_id')">N° Cuadrilla</th>
                                <th role="button" wire:click="order('crew_id')">Contratista</th>
                                <th role="button" wire:click="order('monthYear')">Mes-Año</th>
                                <th role="button" wire:click="order('total')">Total (ARS)</th>
                                <th role="button" wire:click="order('crew_id')">Precio Cuadrilla</th>
                                <th>Acción</th>
                    </tr>
                        </thead>

                <tbody>
                    @foreach ($unresolved_consolidations as $unresolved_consolidation)
                    <?php
                    $crew=\App\Models\Crew::find($unresolved_consolidation->crew_id);
                    ?>
                        <tr>
                            <td>{{ $unresolved_consolidation->crew_id }}</td>
                            <td>{{ $crew->contractor->name }}</td>
                            <td>{{ $unresolved_consolidation->monthYear }}</td>
                            <td>${{ number_format($unresolved_consolidation->total, 2, ',', '.') }}</td>
                            <td> {{ $crew->hour_price ? '$' . number_format($crew->hour_price, 2, ',', '.') : 'Por contrato' }} </td>

                            <td width="18%">
                                {{-- <a class="btn btn-outline-primary btn-block"
                                    href="{{ route('consolidations.new',['crewId' => $unresolved_consolidation->crew_id,'monthYear' => $unresolved_consolidation->monthYear]) }}">Generar
                                    consolidación</a> --}}
                                    <a class="btn btn-outline-primary btn-block"
                                   wire:click='alertContract({{ $unresolved_consolidation->crew_id }}, "{{ $unresolved_consolidation->monthYear }}")'>Generar
                                    consolidación</a>
                                </td>
                            </tr>
                            @endforeach
                          
                </tbody>

                    </table>
                </div>
            </div>

            <div class="card-footer">
                {{ $unresolved_consolidations->links() }}
            </div>
        @else
            <div class="card-footer">
                <div class="alert alert-secondary" role="alert">
                    No se encontraron resultados.
                </div>
            </div>
        @endif
    </div>
    <script>
            window.addEventListener('alertContract', event => {
                Swal.fire({
                    title: '¿Está seguro que quiere continuar?',
                    text: "Existen días del mes en los que no se cargaron partes",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, continuar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        
                        Livewire.emit('continue');
                    }
                })
            });
    </script>

</div>
