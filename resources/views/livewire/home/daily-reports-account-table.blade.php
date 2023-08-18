<div>
    <div class="card-header flex">
        <input wire:model="search" class="form-control" placeholder="Buscar cuenta">
    </div>
    @if ($accounts)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th role="button" wire:click="order('id')">N° Cuenta</th>
                    <th role="button" wire:click="order('name')">Nombre</th>
                    <th role="button">Es deficitaria</th>
                    <th role="button">Presupuesto</th>
                    <th role="button">Saldo actual</th>
                    <th role="button">Total reservado</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <td>{{ $account->id }}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->is_deficitary == 0 ? 'No' : 'Si' }}</td>
                        <td>AR$ {{ number_format($account->budget, 2, ',', '.') }}</td>
                        <td>AR$ {{ number_format($account->balance, 2, ',', '.') }}</td>
                        <td>AR$ {{ number_format($account->totalReserved(), 2, ',', '.') }}</td>
                        @if ($this->total > $account->balance - $account->totalReserved() && $account->is_deficitary == '0')
                            <td><button class="btn btn-outline-secondary btn-sm"
                                    wire:click="$emit('mayor')">Seleccionar</button></td>
                        @else
                            <td><button class="btn btn-outline-primary btn-sm"
                                    wire:click="selectAccount({{ $account }})">Seleccionar</button></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $accounts->links() }}
        </div>
        @else
        <div class="card-footer">
            <div class="alert alert-danger" role="alert">
                No hay cuentas disponibles para seleccionar.
            </div>
        </div>
    @endif
</div>
@push('js')
    <script>
        Livewire.on('mayor', function() {
            Swal.fire({
                type: 'warning',
                title: 'Error',
                text: 'El total del parte supera el saldo disponible y la cuenta no permite sobrepasar el presupuesto.',
            })
        });
    </script>
@endpush
