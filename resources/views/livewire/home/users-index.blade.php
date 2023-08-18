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
            <input wire:model="search" class="form-control" placeholder="Buscar usuario">
            <div class="input-group-append">
                <a class="btn btn-outline-secondary mb-2 float-right" href="{{ route('home.users.create') }}">Crear
                    usuario</a>
            </div>
        </div>

        @if ($users->count())

            <div class="card-body">
                <div class="table-responsive rounded">

                    <table class="table align-middle table-striped table-bordered table-sm"
                        style="text-align: center; vertical-align: middle;">

                        <thead class="table-dark">
                            <tr>
                                <th role="button" wire:click="order('name')">Nombre</th>
                                <th role="button" wire:click="order('dni')">DNI</th>
                                <th role="button" wire:click="order('email')">Correo
                                    electronico
                                </th>
                                <th role="button" wire:click="order('phone_number')">
                                    Teléfono
                                </th>
                                <th>Rol</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @if (Auth::user()->id == $user->id || !($user->getRoleNames()[0] == 'Administrador'))
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->dni }}</td>
                                        <td>{{ $user->email }}</td>
                                        @if ($user->phone_number == 0)
                                            <td role="button">-</td>
                                        @else
                                            <td>{{ $user->phone_number }}</td>
                                        @endif
                                        <td>{{ $user->getRoleNames()[0] }}</td>

                                        <td width="10px">
                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                <a class="btn btn-outline-primary btn-sm btn-block"
                                                    href="{{ route('home.users.edit', $user) }}">Editar</a>
                                                @if (Auth::user()->id == $user->id)
                                                    <button wire:click="$emit('admin')" type="submit"
                                                        class="btn btn-outline-secondary btn-sm ">Eliminar</button>
                                                @else
                                                    <button wire:click="$emit('deleteUser',{{ $user->id }})"
                                                        type="submit"
                                                        class="btn btn-outline-danger btn-sm">Eliminar</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $users->links() }}
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
        Livewire.on('deleteUser', userId => {
            Swal.fire({
                title: '¿Está seguro que desea eliminar el usuario?',
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
                        'Eliminado.',
                        'El usuario ha sido eliminado.',
                        'success'
                    )
                    Livewire.emit('delete', userId);
                }
            })
        });
        Livewire.on('admin', function() {
            Swal.fire({
                type: 'warning',
                title: 'Error',
                text: 'No puede eliminar su propio usuario.',
            })
        });
    </script>
@endpush
