<div
    style="/* background-color: ivory; */ font-family: 'Helvetica Neue', 'Helvetica', sans-serif, Verdana; padding-bottom: 80px; text-align: center">
    <div>
        <img style="height: 120px; min-width: 120px;"
            src="C:\xampp\htdocs\partesys\public\vendor\adminlte\dist\img\ParteSys.png">
    </div>
    <h2 class="text-center  text-green-600">Informe estadístico de compañía {{$compania}}</h2>
        <h3>{{substr($desde,5,6).'/'.substr($desde,0,4).' hasta '.substr($hasta,5,6).'/'.substr($hasta,0,4)}}</h3>
        {{-- DESCOMENTAR ESTO PARA QE FUNCIONE --}}
</div>
<div>
    <table style="width:100%; margin:auto; border: 1.5px solid slategray; border-collapse: collapse; text-align: left">
        <thead style="background-color: #e0e0e0">
            <tr>
                <th style="border: 1.5px solid slategray;" scope="col">N° de cuenta</th>
                <th style="border: 1.5px solid slategray;" scope="col">Nombre</th>
                <th style="border: 1.5px solid slategray;" scope="col">Deficitaria</th>
                <th style="border: 1.5px solid slategray;" scope="col">Presupuesto</th>
                <th style="border: 1.5px solid slategray;" scope="col">Saldo disponible</th>
                <th style="border: 1.5px solid slategray;" scope="col">Total hora normal</th>
                <th style="border: 1.5px solid slategray;" scope="col">Total hora 50%</th>
                <th style="border: 1.5px solid slategray;" scope="col">Total hora 100%</th>
                <th style="border: 1.5px solid slategray;" scope="col">Total viandas</th>
                <th style="border: 1.5px solid slategray;" scope="col">Total conceptos extraordinarios</th>
                <th style="border: 1.5px solid slategray;" scope="col">Total descuentos</th>
                <th style="border: 1.5px solid slategray;" scope="col">Sumatoria de totales</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consulta as $c)
                <tr>
                    <th style="border: 1.5px solid slategray;" scope="row">{{ $c['account_id'] }}</th>
                    <td style="text-align: left; border: 1.5px solid slategray;">{{ $c['name'] }}</td>
                    <td style="text-align: center; border: 1.5px solid slategray;">
                        {{ $deficitary = $c['is_deficitary'] ? 'Si' : 'No' }}</td>
                    <td style="text-align: right; border: 1.5px solid slategray;">
                        ${{ number_format($c['budget'], 2, ',', '.') }}</td>
                    <td style="text-align: right; border: 1.5px solid slategray;">
                        ${{ number_format($c['balance'], 2, ',', '.') }}</td>
                    <td style="text-align: right; border: 1.5px solid slategray;">
                        ${{ number_format($c['total_normal_hour'], 2, ',', '.') }}</td>
                    <td style="text-align: right; border: 1.5px solid slategray;">
                        ${{ number_format($c['total_fifty_hour'], 2, ',', '.') }}</td>
                    <td style="text-align: right; border: 1.5px solid slategray;">
                        ${{ number_format($c['total_hundred_hour'], 2, ',', '.') }}</td>
                    <td style="text-align: right; border: 1.5px solid slategray;">
                        ${{ number_format($c['total_food'], 2, ',', '.') }}</td>
                    <td style="text-align: right; border: 1.5px solid slategray;">
                        ${{ number_format($c['total_concepts']['total_extraordinary_concepts'], 2, ',', '.') }}</td>
                    <td style="text-align: right; border: 1.5px solid slategray;">
                        ${{ number_format($c['total_concepts']['total_discount'], 2, ',', '.') }}</td>
                    <td style="text-align: right; border: 1.5px solid slategray;">
                        ${{ number_format($c['total_normal_hour'] + $c['total_fifty_hour'] + $c['total_hundred_hour'] + $c['total_food'] + $c['total_concepts']['total_extraordinary_concepts'] + $c['total_concepts']['total_discount'], 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
