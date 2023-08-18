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
        <div class="card-header flex input-group">
            <input wire:model="search" class="form-control" placeholder="Buscar cuenta">
            <div class="input-group-append">
                <a class="btn btn-outline-secondary mb-2 float-right" href="{{ route('home.accounts.create') }}">Crear
                    cuenta</a>
            </div>
        </div>

        @if ($accounts->count())

            <div class="card-body">
                <div class="table-responsive rounded">

                    <table class="table align-middle table-striped table-bordered table-sm"
                        style="text-align: center; vertical-align: middle;">

                        <thead class="table-dark">
                            <tr>
                                <th role="button" wire:click="order('id')">N° Cuenta</th>
                                <th role="button" wire:click="order('id')">Compañia</th>
                                <th role="button" wire:click="order('name')">Nombre</th>
                                <th role="button" wire:click="order('budget')">Presupuesto (ARS)</th>
                                <th role="button" wire:click="order('balance')">Saldo (ARS)</th>
                                <th>Reservado (ARS)</th>
                                <th>Deficitaria</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($accounts as $account)
                                <tr>
                                    <td>{{ $account->id }}</td>
                                    <td>{{ $account->company->name }}</td>
                                    <td>{{ $account->name }}</td>
                                    <td>${{ number_format($account->budget, 2, ',', '.') }}</td>
                                    <td>${{ number_format($account->balance, 2, ',', '.') }}</td>
                                    <td>
                                        ${{ number_format($account->totalReserved(), 2, ',', '.') }}</td>
                                    <td>{{ $account->is_deficitary ? 'SI' : 'NO' }}</td>

                                    <td width="10px">
                                        <div class="btn-group">
                                            <a class="btn btn-outline-primary btn-sm"
                                                href="{{ route('home.accounts.edit', $account) }}">Editar</a>
                                            @if ($account->totalReserved())
                                                <button wire:click="$emit('reserved')" type="submit"
                                                    class="btn btn-outline-secondary btn-sm">Eliminar</button>
                                            @else
                                                <button wire:click="$emit('deleteAccount',{{ $account->id }})"
                                                    type="submit"
                                                    class="btn btn-outline-danger btn-sm">Eliminar</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
            <div class="card-footer">
                {{ $accounts->links() }}
            </div>
        @else
            <div class="card-footer">
                <div class="alert alert-secondary" role="alert">
                    No se encontraron resultados.
                </div>
            </div>
        @endif
    </div>
    @push('js')
        <script>
            Livewire.on('deleteAccount', accountId => {
                Swal.fire({
                    title: '¿Está seguro que desea eliminar la cuenta?',
                    text: "No podrá deshacer esta operación.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar.',
                    cancelButtonText: 'Cancelar.'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire(
                            'Eliminada.',
                            'La cuenta ha sido eliminada.',
                            'success'
                        )
                        Livewire.emit('delete', accountId);
                    }
                })
            });
            Livewire.on('reserved', function() {
                Swal.fire({
                    type: 'warning',
                    title: 'Error',
                    text: 'Esta cuenta no puede ser borrada ya que posee consolidaciones pendientes.',
                })
            });
        </script>
    @endpush
</div>
