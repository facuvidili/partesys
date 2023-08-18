<div>
    <script src="//unpkg.com/alpinejs" defer></script>
    <div class="card">
        <div class="card-header input-group">
            <label class="text-lg" style="font-weight: 400">Seleccione una compañía:</label>
            <select id="comp" class="form-control mx-2 rounded" style="max-width: 20%;" wire:model="filters.compania"
                name="compania">
                <option value="-1" selected>---</option>
                @foreach ($companias as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="card">
        <div class="card-body input-group">
            <label class="text-lg" style="font-weight: 400">Seleccione intervalo de fecha
                desde</label>
            <x-jet-input class="form-control mx-2 rounded" style="max-width: 20%;" wire:model="filters.fromDate"
                type="number" min="1990" max="2023" value="1990" onkeydown="return false" />
            <label class="text-lg" style="font-weight: 400"> hasta</label>
            <x-jet-input class="form-control mx-2 rounded" style="max-width: 20%" wire:model="filters.toDate"
                type="number" min="1990" max="2023" onkeydown="return false" />
        </div>
    </div>

    <div id="charts" style="display:flex; height: 350px" class="mb-0">
        <div class="chart-container ml-6 mr-0" style="position: relative; height:16rem; width:28%">
            <canvas id="myChart2"></canvas>
        </div>



        <div class="chart-container ml-0 mr-6" style="position: relative; height:40rem;  width:39%">
            <canvas id="myChart3"></canvas>
        </div>

        <div class="chart-container ml-6" style="text-align: center; position: relative; height:16rem;  width:33%">
            <canvas id="myChart"></canvas>

        </div>
    </div>

    <div>
        @php
            $a = '';
            $b = '';
            if ($filters['fromDate'] == '' || $filters['toDate'] == '') {
                $v = 'invisible';
                $a = 'visible';
                $b = 'invisible';
            } else {
                $from = strtotime(date($filters['fromDate']));
                $to = strtotime(date($filters['toDate']));
            
                if ($from <= $to) {
                    $v = 'visible';
                    $a = 'invisible';
                    $b = 'invisible';
                } else {
                    $v = 'invisible';
                    $b = 'visible';
                    $a = 'invisible';
                }
            }
            $y = 'invisible';
            if ($filters['fromDate'] != '' || $filters['toDate'] != '') {
                if (empty($consulta[0])) {
                    $v = 'invisible';
                    $y = 'visible';
                } else {
                    $v = 'visible';
                    $y = 'invisible';
                }
            }
            $i = 0;
        @endphp

        <div class="table-responsive rounded {{ $v }} mt-0">
            <table class="table align-middle table-striped table-bordered table-sm">
                <thead class="table-dark">
                    <tr>
                        <th style="font-size:13px" scope="col">N° de cuenta</th>
                        <th style="font-size:13px" scope="col">Nombre</th>
                        <th style="font-size:13px" scope="col">Deficitaria</th>
                        <th style="font-size:13px" scope="col">Presupuesto</th>
                        <th style="font-size:13px" scope="col">Saldo disponible</th>
                        <th style="font-size:13px" scope="col">Total horas normal ($ARS)</th>
                        <th style="font-size:13px" scope="col">Total horas al 50% ($ARS)</th>
                        <th style="font-size:13px" scope="col">Total horas al 100% ($ARS)</th>
                        <th style="font-size:13px" scope="col">Total viandas ($ARS)</th>
                        <th style="font-size:13px" scope="col">Total conceptos extraordinarios ($ARS)</th>
                        <th style="font-size:13px" scope="col">Total descuentos ($ARS)</th>
                        <th style="font-size:13px" scope="col">Sumatoria de totales</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($consulta as $c)
                        <tr>
                            <th scope="row">{{ $c->account_id }}</th>
                            <td style="text-align: left">{{ $c->name }}</td>
                            <td>{{ $deficitary = $c->is_deficitary ? 'SI' : 'NO' }}</td>
                            <td style="text-align: right">${{ number_format($c->budget, 2, ',', '.') }}</td>
                            <td style="text-align: right">${{ number_format($c->balance, 2, ',', '.') }}</td>
                            <td style="text-align: right">${{ number_format($c->total_normal_hour, 2, ',', '.') }}
                            </td>
                            <td style="text-align: right">${{ number_format($c->total_fifty_hour, 2, ',', '.') }}
                            </td>
                            <td style="text-align: right">${{ number_format($c->total_hundred_hour, 2, ',', '.') }}
                            </td>
                            <td style="text-align: right">${{ number_format($c->total_food, 2, ',', '.') }}</td>
                            <td style="text-align: right">
                                ${{ number_format($c->total_concepts->total_extraordinary_concepts, 2, ',', '.') }}
                            </td>
                            <td style="text-align: right">
                                ${{ number_format($c->total_concepts->total_discount, 2, ',', '.') }}</td>
                            <td style="text-align: right">

                                ${{ number_format($c->total_normal_hour + $c->total_fifty_hour + $c->total_hundred_hour + $c->total_food + $c->total_concepts->total_extraordinary_concepts + $c->total_concepts->total_discount, 2, ',', '.') }}
                            </td>



                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="py-2 {{ $v }}">
            <x-jet-button type="button" class="btn btn-dark" wire:click="generateReport" style="width:10%">Generar
                reporte
                Excel</x-jet-button>
            <x-jet-button type="button" class="btn btn-dark" wire:click="downloadPdf" style="width:10%">Generar reporte
                PDF</x-jet-button>
        </div>
        <div class="{{ $y }} alert alert-secondary" role="alert">
            Entre esas fechas no hay registros de gastos, intente con otro rango.
        </div>
        <div class="{{ $a }} alert alert-secondary" role="alert">
            No hay intervalo de fechas seleccionado, no puede generarse el archivo Excel o PDF.
        </div>
        <div class="{{ $b }} alert alert-secondary" role="alert">
            La fecha de comienzo no puede ser mayor que la de fin, no puede generarse el archivo Excel o PDF.
        </div>

        </body>

    </div>
