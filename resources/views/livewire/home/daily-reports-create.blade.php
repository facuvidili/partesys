<div>
    
    <div>
        <h2 class="text-2xl text-center">Seleccionar cuadrilla</h2>
    </div>

    <div class="card">

        {{-- TABLA DE CUADRILLAS --}}

        @livewire('home.daily-reports-crew-table')


        {{-- MODAL PARA CALENDARIO --}}
        <x-jet-dialog-modal wire:model="openFir" maxWidth="7xl">

            <x-slot name="title">

                <div class="mr-4 mb-4 flex-inline">
                    <h2 class="text-2xl mt-3 text-center">Seleccionar Día</h2>
                    <h2 class="text-l mt-3 text-center text-green-600">Cuadrilla N°:
                        {{ $this->crew ? $this->crew->id : '' }} -
                        Precio
                        de hora:
                        {{ $this->crew ? ($this->crew->hour_price ? ' AR$ ' . number_format($this->crew->hour_price,2, ',', '.') : 'Por contrato') : '' }}
                    </h2>
                    <x-jet-button wire:click="$set('openFir', false)" class=" mx-4 my-0 flex">
                        << Atrás </x-jet-button>
                </div>




            </x-slot>
            <x-slot name="content">
                <div class="ml-4 my-3">
                    @livewire('home.daily-reports-calendar')
                </div>

            </x-slot>
            <x-slot name="footer">

            </x-slot>

        </x-jet-dialog-modal>


        {{-- MODAL PARA EVENTOS --}}
        @livewire('home.daily-reports-event', compact('dailyReportShow'))


        {{-- MODAL PARA HORARIOS --}}
        <x-jet-dialog-modal wire:model="openHours" maxWidth="4xl">
            <x-slot name="title">
                <div>
                    <h2 class="text-2xl mt-3 text-center">Seleccionar horarios</h2>
                    <h2 class="text-l mt-3 text-center text-green-600">Cuadrilla N°:
                        {{ $this->crew ? $this->crew->id : '' }} -
                        Precio
                        de hora:
                        {{ $this->crew ? ($this->crew->hour_price ? ' AR$ ' . number_format($this->crew->hour_price,2, ',', '.') : 'Por contrato') : '' }}
                        - Cantidad de empleados: {{ $this->crew ? $this->crew->amount_members : '' }}
                    </h2>
                </div>

            </x-slot>
            <x-slot name="content">
                
                <div class="form-group">
                    <label>Día Inicio</label>
                    <x-jet-input wire:model='startDate' type="date" readonly class="form-control" required></x-jet-input>
                    
                    <h2 class="text-lg ml-2 text-green-600">
                        @switch(date('D', strtotime($startDate)))
                            @case('Sun')
                                {{ 'Domingo' }}
                            @break

                            @case('Mon')
                                {{ 'Lunes' }}
                            @break

                            @case('Tue')
                                {{ 'Martes' }}
                            @break

                            @case('Wed')
                                {{ 'Miércoles' }}
                            @break

                            @case('Thu')
                                {{ 'Jueves' }}
                            @break

                            @case('Fri')
                                {{ 'Viernes' }}
                            @break

                            @case('Sat')
                                {{ 'Sábado' }}
                            @break

                            @default
                        @endswitch
                    </h2>

                </div>
                <div class="form-group">
                    <label>Hora Inicio</label>
                    <x-jet-input wire:model='startTime' min="{{ $startTimeMin }}" type="time" class="form-control"
                        required>
                    </x-jet-input>
                    <x-jet-input-error for="startTime" />
                </div>
                <div class="form-group">
                    <label>Día Fin</label>
                    <x-jet-input wire:model.defer='endDate' type="date" min="{{ $startDate }}"
                        max="{{ date('Y-m-d', strtotime('+1 day', strtotime($startDate))) }}" class="form-control"
                        onkeypress="return false" required></x-jet-input>
                    <x-jet-input-error for="endDate" />
                </div>
                <div class="form-group">
                    <label>Hora Fin</label>
                    <x-jet-input wire:model='endTime' max="{{ $endTimeMax }}" type="time" class="form-control" required></x-jet-input>
                    <x-jet-input-error for="endTime" />
                </div>
                <x-jet-button wire:click="reportCalculate()" type="button" class='mb-4'>
                    Calcular</x-jet-button>
                    
                <table class="table table-striped">
                    <tbody>
                        
                        <tr>
                            <td>Horas normales</td>
                            <td>{{ sprintf('%02d:%02d', (int) $normalHours, fmod($normalHours, 1) * 60) }} HS
                            </td>
                            <td class="float-right">AR$
                                {{ number_format($normalHoursPrice, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Horas al 50%</td>
                            <td>{{ sprintf('%02d:%02d', (int) ($fiftHours / 1.5), fmod($fiftHours / 1.5, 1) * 60) }}
                                HS</td>
                            <td class="float-right">AR$
                                {{ number_format($fiftHoursPrice, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Horas al 100%</td>
                            <td>{{ sprintf('%02d:%02d', (int) ($hundHours / 2), fmod($hundHours / 2, 1) * 60) }} HS
                            </td>
                            <td class="float-right">AR$
                                {{ number_format($hundHoursPrice, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Viandas</td>
                            <td>{{ $foodQuan }}</td>
                            <td class="float-right">AR$ {{ number_format($food, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Total Parte</td>
                            <td class="float-right font-bold">AR$ {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>

                    </tbody>
                </table>
                <x-jet-input-error for="total" />
            </x-slot>
            <x-slot name="footer">
                <x-jet-button wire:click="modalToggle('calendar')" type="button" class="mr-2">
                    << Atrás</x-jet-button>
                        <x-jet-button wire:click="modalToggle('accounts')" type="button">Siguiente >></x-jet-button>
            </x-slot>

        </x-jet-dialog-modal>

        {{-- MODAL PARA CUENTAS --}}
        <x-jet-dialog-modal wire:model='openAccounts' maxWidth="4xl">
            <x-slot name="title">
                <div>
                    <h2 class="text-2xl mt-3 text-center">Seleccionar cuenta</h2>
                    <h2 class="text-l mt-3 text-center text-green-600">Cuenta seleccionada:
                        {{ $this->account ? 'N° ' . $this->account->id . ' - ' . $this->account->name : '' }} -

                        Total Parte: AR$
                        {{ number_format($this->total, 2, ',', '.') }}</h2>

                </div>

            </x-slot>
            <x-slot name="content">
                @livewire('home.daily-reports-account-table')
            </x-slot>
            <x-slot name="footer">

                <x-jet-button wire:click="modalToggle('hours')" type="button" class="mr-2">
                    << Atrás</x-jet-button>

            </x-slot>

        </x-jet-dialog-modal>


        {{-- MODAL PARA TAREAS --}}
        <x-jet-dialog-modal wire:model='openTasks'>
            <x-slot name="title">
                <div>
                    <h2 class="text-2xl mt-3 text-center">Agregar tareas</h2>
                </div>
                <h2 class="text-l mt-3 text-center text-green-600">Total de Horas:
                    {{ $this->totalHours ? sprintf('%02d:%02d',(int)$this->totalHours, round(fmod($this->totalHours, 1) * 60),2) : 0 }} -
                    Horas Cargadas:
                    {{ $this->totalTasksHrs ? sprintf('%02d:%02d',(int)$this->totalTasksHrs,round(fmod($this->totalTasksHrs, 1) * 60),2) : 0}}
                    {{-- @dump($this->totalTasksHrs, $this->totalHours); --}}
                </h2>
            </x-slot>
            <x-slot name="content">
                <div class="form-group">
                    <label>Descripción</label>
                    <x-jet-input wire:model='taskDescription' type="text" class="form-control" required
                        id='taskDescription'></x-jet-input>
                    <x-jet-input-error for="taskDescription" />
                </div>
                <div class="form-group">
                    <label>Duración</label>
                    <x-jet-input wire:model='taskDuration' min="1" type="time" class="form-control" required
                        id='taskDuration'></x-jet-input>
                    <x-jet-input-error for="taskDuration" />
                </div>
                <div x-data="{ tasks: @entangle('tasks') }">
                    <x-jet-button wire:click="addTask" type="button" class='mb-4'>
                        Agregar tarea</x-jet-button>

                    <template x-for="(task, index) in tasks" :key="index">
                        <div x-show="tasks">
                            <div class="input-group">
                                <label type="text" class="form-control rounded-md" x-text="'Tarea: '+task.description+' - Duración: '+task.time+' hs'"></label>
                                <div class="input-group-append"><button type="button" @click="window.livewire.emit('removeTask', index );"
                                    class="btn btn-outline-danger">X</button></div>
                            </div>

                        </div>
                    </template>

                    <x-jet-input-error for="tasks" />
                    <x-jet-input-error for="totalTasksHrs" />

                </div>
            </x-slot>
            <x-slot name="footer">
                {{-- <x-jet-button wire:click="mostrarTareas" type="button" class="mr-2">
                    Mostrar Tareas</x-jet-button> --}}
                <x-jet-button wire:click="modalToggle('accounts')" type="button" class="mr-2">
                    << Atrás</x-jet-button>
                        <x-jet-button wire:click="modalToggle('obs')" type="button">Siguiente >></x-jet-button>

            </x-slot>
            
        </x-jet-dialog-modal>


        {{-- MODAL PARA OBSERVACION --}}
        <x-jet-dialog-modal wire:model='openObs'>
            <x-slot name="title">
                <div>
                    <h2 class="text-2xl mt-3 text-center">Agregar observación</h2>
                </div>
            </x-slot>
            <x-slot name="content">
                <div class="form-group">
                    <label>Observación</label>
                    <textarea wire:model='observation' class="form-control" rows="10" cols="50" required
                        id='taskDescription'></textarea>

                </div>
                <x-jet-input-error for="observation" />

            </x-slot>
            <x-slot name="footer">

                <x-jet-button wire:click="modalToggle('tasks')" type="button" class="mr-2">
                    << Atrás</x-jet-button>
                        <x-jet-button wire:click="cancelReport" class="bg-red mr-2" type="button">
                            Cancelar parte</x-jet-button>
                        <x-jet-button wire:click="store" class="bg-green" type="button">
                            Confirmar parte</x-jet-button>

            </x-slot>

        </x-jet-dialog-modal>

        <script>
            window.addEventListener('alertReport', event => {
                Swal.fire({
                    title: event.detail.message,
                    type: 'warning',
                })
            });
            window.addEventListener('createdReport', event => {
                Swal.fire({
                    title: event.detail.message,
                    type: 'success',
                    timer: 5000,
                })
            });
        </script>



    </div>
</div>
