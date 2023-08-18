<div style="/* background-color: ivory; */ font-family: 'Helvetica Neue', 'Helvetica', sans-serif, Verdana; padding-bottom: 80px; text-align: center">

    <div>

        <div>
            <table style="margin: auto">
                <tr>
                    <td>
                        <div>
                            <img style="height: 120px; min-width: 120px;"
                                src="C:\xampp\htdocs\partesys\public\vendor\adminlte\dist\img\ParteSys.png">

                        </div>
                    </td>
                    <td>
                        <div>
                            @if ($dailyReportShow)
                                <h2 class="text-center  text-green-600">Parte de trabajo N°: {{ $dailyReportShow->id }}
                                </h2>
                            @endif
                        </div>
                    </td>

                </tr>


            </table>
        </div>
        <hr>




        <div style="font-size: 16px">
            <table style="margin: auto; width: 580px">
                <tr>
                    <td style="padding: 0px 14px 0px 14px">
                        <div><strong>Compañía: </strong> {{ $company->name }}</div>
                        <div><strong>Cuenta N°:</strong> {{ $dailyReportShow->account->id }}</div>
                        <div><strong>Supervisor:</strong> {{ $supervisor->name }}</div>
                    </td>
                    <td style="padding: 0px 14px 0px 14px">
                        <div><strong>Cuadrilla N°:</strong> {{ $dailyReportShow->crew->id }}</div>
                        <div><strong>Cantidad de miembros:</strong> {{ $dailyReportShow->crew->amount_members }}</div>
                        <div><strong>Fecha:</strong> {{\Carbon\Carbon::now()->format('d/m/Y H:i') }} hs</div>
                    </td>
                </tr>
            </table>




        </div>
    </div>


    <hr>

    <div style="font-size: 16px">
        @if ($dailyReportShow)
            <table
                style="margin: auto; border: 1.5px solid slategray; border-collapse: collapse; text-align: left; width: 600px">
                <tr>
                    <td style="border: 1px solid slategray; padding: 0px 24px 0px 24px">
                        <div>

                            <strong>Fecha de inicio</strong>

                        </div>
                    </td>
                    <td style="border: 1px solid slategray; padding: 0px 24px 0px 24px; text-align: right">
                        {{ date('d/m/Y', strtotime($dailyReportShow->work_start_date)) }}
                    </td>
                    <td style="border: 1px solid slategray; padding: 0px 24px 0px 24px">
                        <div>

                            <strong>Hora de inicio</strong>

                        </div>
                    </td>
                    <td style="border: 1px solid slategray; padding: 0px 24px 0px 24px; text-align: right">
                        {{ $dailyReportShow->work_start_time }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid slategray; padding: 0px 24px 0px 24px">
                        <div>

                            <strong>Fecha de finalización</strong>
                        </div>
                    </td>
                    <td style="border: 1px solid slategray; padding: 0px 24px 0px 24px; text-align: right">
                        {{ date('d/m/Y', strtotime($dailyReportShow->work_end_date)) }}

                    </td>
                    <td style="border: 1px solid slategray; padding: 0px 24px 0px 24px">
                        <div>

                            <strong>Hora de fin</strong>
                        </div>
                    </td>
                    <td style="border: 1px solid slategray; padding: 0px 24px 0px 24px; text-align: right">
                        {{ $dailyReportShow->work_end_time }}

                    </td>
                </tr>
            </table>

            <hr>




            <div>
                <label>
                    <h3>Tareas</h3>

                    @foreach ($dailyReportShow->tasks as $key => $task)
                        <strong> {{ $key + 1 }} -</strong>
                        <strong>Descripción:</strong> {{ $task->description }} -
                        <strong>Duración:</strong> {{ $task->time }} hs<br>
                    @endforeach
                </label>
            </div>
            <br>
            <hr>
            <div>
                <h3>Conceptos</h3>
                <table style="margin: auto; border: 1.5px solid slategray; border-collapse: collapse; text-align: left; width: 580px">
                    <tr>
                        <th style="border: 1px solid slategray; text-align: center; padding: 0px 24px 0px 24px">Nombre
                        </th>
                        <th style="border: 1px solid slategray; text-align: center; padding: 0px 24px 0px 24px">Cantidad
                        </th>
                        <th style="border: 1px solid slategray; text-align: center; padding: 0px 24px 0px 24px">Subtotal
                        </th>
                    </tr>
                    @foreach ($dailyReportShow->concepts as $concept)
                    @if ($concept->name=='Viandas')
                    <tr>
                        <th style="border: 1px solid slategray; text-align: left; padding: 0px 24px 0px 24px">
                            {{ $concept->name }}</th>
                        <td style="border: 1px solid slategray; text-align: right; padding: 0px 24px 0px 24px">
                            {{ $concept->pivot->amount }}</td>
                        <td style="border: 1px solid slategray; text-align: right; padding: 0px 24px 0px 24px"> <label style="text-align: left">AR$</label>
                            {{ number_format($concept->pivot->sub_total, 2, ',', '.') }}</td>
                    </tr>
                        @else
                        <tr>
                            <th style="border: 1px solid slategray; text-align: left; padding: 0px 24px 0px 24px">
                                {{ $concept->name }}</th>
                            <td style="border: 1px solid slategray; text-align: right; padding: 0px 24px 0px 24px">
                                {{ sprintf('%02d:%02d', (int) $concept->pivot->amount, round(fmod(floatval($concept->pivot->amount), 1) * 60)) }}
                                {{-- {{ $concept->pivot->amount }}</td> --}}
                            <td style="border: 1px solid slategray; text-align: right; padding: 0px 24px 0px 24px"> <label style="text-align: left">AR$</label>
                                {{ number_format($concept->pivot->sub_total, 2, ',', '.') }}</td>
                        </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td style="padding: 0px 24px 0px 24px"><strong style="font-size: 18px">Total:</strong></td>
                        <td style="padding: 0px 24px 0px 24px"></td>
                        <td style="padding: 0px 24px 0px 24px; text-align: right"><strong>AR$
                                {{ number_format($dailyReportShow->total, 2, ',', '.') }}</strong></td>
                    </tr>
                </table>

            </div>
            <br>
            <hr>


            <div style="font-size: 18px; text-align: left; margin-left: 60px ">
                <label>
                    <strong>Observación:</strong> {{ $dailyReportShow->observation }}
                </label>
            </div>
            <br>
            {{-- <hr> --}}
            <hr>
        @endif

    </div><br><br><br>
    <div style="font-size: 16px;">
        <table style="margin: auto">
            <tr>
                <th style="padding: 0px 14px 40px 14px">Firma del supervisor</th>

                <th style="padding: 0px 14px 40px 14px">Firma de la contratista</th>
            </tr>
            <tr>
                <td style="padding: 0px 14px 0px 14px">----------------------------------</td>
                <td style="padding: 0px 14px 0px 14px">----------------------------------</td>
            </tr>
        </table>
    </div>
    <hr>

</div>
