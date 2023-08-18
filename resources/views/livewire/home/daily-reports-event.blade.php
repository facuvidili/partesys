<div>
    <x-jet-dialog-modal wire:model="openEvent" maxWidth="4xl">
        <x-slot name="title" wire:model='dailyReportShow'>
            <div class="mt-2">
                <div class="my-6">
               

                    <x-jet-button wire:click="$set('openEvent', false)" class="my-0 flex">
                        << Atrás </x-jet-button>

                        @if ($dailyReportShow)
                        <h2 class="text-center  text-green-600">Parte N°: {{ $dailyReportShow->id }}</h2>
                    @endif

                </div>

            </div>

        </x-slot>
        <x-slot name="content">


            <div wire:model='dailyReportShow'>
                @if ($dailyReportShow)
                    <div>
                        <label>
                            Fecha Inicio: {{ date('d-m-y', strtotime($dailyReportShow->work_start_date)) }}
                        </label>
                        ||
                        <label>
                            Hora Inicio: {{ $dailyReportShow->work_start_time }}
                        </label>
                    </div>
                    <div>
                        <label>
                            Fecha Fin: {{ date('d-m-y', strtotime($dailyReportShow->work_end_date)) }}
                        </label>
                        ||
                        <label>
                            Hora Fin: {{ $dailyReportShow->work_end_time }}
                        </label>
                    </div>
                    <div>
                        <label>
                            Tareas: <br>

                            @foreach ($dailyReportShow->tasks as $key => $task)
                                {{ $key + 1 }} -
                                Descripcion: {{ $task->description }} || 
                                Duración: {{ $task->time }} hs <br>
                            @endforeach
                        </label>
                    </div>
                    <div>
                        <label>
                            Total: AR$ {{ number_format($dailyReportShow->total, 2, '.', ',') }}
                        </label>
                    </div>
                    <div>
                        <label>
                            Observación: {{ $dailyReportShow->observation }}
                        </label>
                    </div>

                @endif

            </div>

        </x-slot>
        <x-slot name="footer">
            <div>
                <x-jet-button class="max-w-fit" wire:click='downloadPdf({{ $dailyReportShow?$dailyReportShow->id:null }})'>Generar PDF</x-jet-button>
            </div>
            
        </x-slot>
    </x-jet-dialog-modal>

</div>
