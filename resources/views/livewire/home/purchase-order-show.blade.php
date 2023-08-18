<div>

    <div class="card">
        @if ($purchaseOrders->count())
            <div class="card-body ">

                <div class="table-responsive rounded">

                    <table class="table align-middle table-striped table-bordered table-sm"
                        style="text-align: center; vertical-align: middle;">

                        <thead class="table-dark">
                            <tr>
                                <th role="button" wire:click="order('id')">Número de orden</th>
                                <th>Compañía</th>
                                <th>Horas normales(ARS)</th>
                                <th>Horas al 50 (ARS)</th>
                                <th>Horas al 100 (ARS)</th>
                                <th>Viandas (ARS)</th>
                                <th>Conceptos extraordinarios (ARS)</th>
                                <th>Descuentos (ARS)</th>
                                <th>Total (ARS)</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($purchaseOrders as $purchaseOrder)
                                <?php
                                
                                $totalNormalHour = $purchaseOrder->costs->sum('normal_hour');
                                
                                $totalFiftyHour = $purchaseOrder->costs->sum('fifty_hour');
                                
                                $totalHundredHour = $purchaseOrder->costs->sum('hundred_hour');
                                
                                $totalFood = $purchaseOrder->costs->sum('food');
                                
                                $totalExtraordinaryConcepts = $purchaseOrder->totalExtraordinaryConcepts('normal');
                                
                                $totalDiscount = $purchaseOrder->totalExtraordinaryConcepts('descuento');
                                
                                $total = $totalNormalHour + $totalFiftyHour + $totalHundredHour + $totalFood + $totalExtraordinaryConcepts - $totalDiscount;
                                ?>
                                <tr>
                                    <td>{{ $purchaseOrder->id }}</td>

                                    <td>{{ $purchaseOrder->companyName() }}</td>

                                    <td>${{ number_format($totalNormalHour, 2) }}</td>

                                    <td>${{ number_format($totalFiftyHour, 2) }}</td>

                                    <td>${{ number_format($totalHundredHour, 2) }}</td>

                                    <td>${{ number_format($totalFood, 2) }}</td>

                                    <td>${{ number_format($totalExtraordinaryConcepts, 2) }}</td>

                                    <td>$-{{ number_format($totalDiscount, 2) }}</td>

                                    <td>${{ number_format($total, 2) }}</td>


                                    <td width="10px">
                                        <div class="btn-group">
                                            <a class="btn btn-outline-primary btn-sm"
                                                href="{{ route('home.purchaseOrderDetails.show', $purchaseOrder->id) }}">Detalle</a>
                                                <button class="btn btn-outline-primary btn-sm"
                                                wire:click='downloadPdf({{ $purchaseOrder ? $purchaseOrder->id : null }})'>
                                                Descargar</button>

                                        </div>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                </div>

            </div>
            {{-- <div class="card-footer">
                {{ $purchaseOrders->links() }}
            </div> --}}
        @else
            <div class="card-footer">
                <div class="alert alert-danger" role="alert">
                    No se encontraron resultados.
                </div>
            </div>
        @endif
    </div>

</div>
