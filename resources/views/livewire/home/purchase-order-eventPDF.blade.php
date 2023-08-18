<div
    style="/* background-color: ivory; */ font-family: 'Helvetica Neue', 'Helvetica', sans-serif, Verdana; padding-bottom: 80px; text-align: center">

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
                            @if ($purchaseOrder)
                                <h2 class="text-center  text-green-600">Orden de compra N° {{ $purchaseOrder->id }}
                                </h2>
                            @endif
                        </div>
                    </td>

                </tr>


            </table>
        </div>
        <hr>
        <div style="font-size: 16px">
            <table style="/* margin: auto; */ width: 580px; ">
                <tr>
                    <td style="padding: 0px 14px 0px 14px">
                        <div><strong>Compañía: </strong> {{ $purchaseOrder->companyName() }}</div>
                        <div><strong>Administrador contable:</strong> {{ $contador->name }}</div>
                    </td>
                    <td style="padding: 0px 14px 0px 14px">
                        <div><strong>Cuadrilla N°:</strong> {{ $purchaseOrder->consolidation->crew->id }}</div>
                        <div><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 0px 14px 0px 14px">
                        <div><strong>Contratista:</strong> {{ $purchaseOrder->consolidation->crew->contractor->name }}
                        </div>
                    </td>
                    <td style="padding: 0px 14px 0px 14px">
                        <div><strong>Mes: </strong>
                            {{ $purchaseOrder->consolidation->month . '/' . $purchaseOrder->consolidation->year }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <hr>

    <div style="font-size: 16px">
        @if ($purchaseOrder)
            <?php $total = 0; ?>
            @foreach ($purchaseOrder->costs as $cost)
                <h3>Cuenta N° {{ $cost->account->id }}</h3>
                <table
                    style="margin: auto; /* border: 1.5px solid slategray; */ border-collapse: collapse; text-align: left; width: 580px">
                    <tr>
                        <th
                            style="border-top: solid 1.5px slategray;
                        border-bottom: 1.5px solid slategray; text-align: left; padding: 3px 24px 3px 24px">
                            Concepto
                        </th>
                        <!-- <th style="/* border: 1px solid slategray; */ text-align: left; padding: 0px 24px 0px 24px">Cantidad
                    </th> -->
                        <th
                            style="border-top: solid 1.5px slategray;
                        border-bottom: 1.5px solid slategray; text-align: right; padding: 3px 24px 3px 24px">
                            Subtotal
                        </th>
                    </tr>


                    <?php
                    $totalExtraordinaryConcepts = $cost->totalExtraordinaryCosts('normal');
                    
                    $totalDiscount = $cost->totalExtraordinaryCosts('descuento');
                    
                    $subtotal = $cost->normal_hour + $cost->fifty_hour + $cost->hundred_hour + $cost->food + $totalExtraordinaryConcepts - $totalDiscount;
                    
                    $total += $subtotal;
                    ?>

                    <tr>
                        <th style="/* border: 1px solid slategray; */ text-align: left; padding: 3px 24px 3px 24px">
                            Horas normales
                        </th>
                        <td style="/* border: 1px solid slategray; */ text-align: right; padding: 3px 24px 3px 24px">
                            ${{ number_format($cost->normal_hour, 2) }}
                        </td>

                    </tr>
                    <tr>
                        <th style="/* border: 1px solid slategray; */ text-align: left; padding: 3px 24px 3px 24px">
                            Horas al 50%
                        </th>
                        <td style="/* border: 1px solid slategray; */ text-align: right; padding: 3px 24px 3px 24px">
                            ${{ number_format($cost->fifty_hour, 2) }}
                        </td>

                    </tr>
                    <tr>
                        <th style="/* border: 1px solid slategray; */ text-align: left; padding: 3px 24px 3px 24px">
                            Horas al 100%
                        </th>
                        <td style="/* border: 1px solid slategray; */ text-align: right; padding: 3px 24px 3px 24px">
                            ${{ number_format($cost->hundred_hour, 2) }}
                        </td>

                    </tr>
                    <tr>
                        <th style="/* border: 1px solid slategray; */ text-align: left; padding: 3px 24px 3px 24px">
                            Viandas
                        </th>
                        <td style="/* border: 1px solid slategray; */ text-align: right; padding: 3px 24px 3px 24px">
                            ${{ number_format($cost->food, 2) }}
                        </td>

                    </tr>
                    <tr>
                        <th style="/* border: 1px solid slategray; */ text-align: left; padding: 3px 24px 3px 24px">
                            Conceptos extraordinarios
                        </th>
                        <td style="/* border: 1px solid slategray; */ text-align: right; padding: 3px 24px 3px 24px">
                            ${{ number_format($totalExtraordinaryConcepts, 2) }}
                        </td>

                    </tr>
                    <tr>
                        <th style="/* border: 1px solid slategray; */ text-align: left; padding: 3px 24px 3px 24px">
                            Descuentos
                        </th>
                        <td style="/* border: 1px solid slategray; */ text-align: right; padding: 3px 24px 3px 24px">
                            $-{{ number_format($totalDiscount, 2) }}
                        </td>

                    </tr>
                    {{-- <tr>
                        <th style="/* border: 1px solid slategray; */ text-align: left; padding: 3px 24px 3px 24px">
                            Subtotal
                        </th>
                        <td style="/* border: 1px solid slategray; */ text-align: right; padding: 3px 24px 3px 24px">
                            ${{ number_format($subtotal, 2) }}
                        </td>
                    </tr> --}}
                </table>
            @endforeach

            <br>
            <hr>

            <table style="margin: auto; width: 580px;">
                <tr style="text-align: right;">
                    <td style="text-align: right;"><strong>Total: </strong>AR${{ number_format($total, 2, '.', ',') }}</td>
                </tr>
            </table>


    </div>
    <br>
    <hr>



    @endif



</div>
