<div>

    <div class="card">

        <div class="card-body">

            <div class="table-responsive rounded">

                <table class="table align-middle table-striped table-bordered table-sm"
                    style="text-align: center; vertical-align: middle;">

                    <thead class="table-dark">
                        <tr>
                            <th role="button" wire:click="order('id')">N° Cuenta</th>
                            <th>Horas normales(ARS)</th>
                            <th>Horas al 50 (ARS)</th>
                            <th>Horas al 100 (ARS)</th>
                            <th>Viandas (ARS)</th>
                            <th>Conceptos extraordinarios (ARS)</th>
                            <th>Descuentos (ARS)</th>
                            <th>Total (ARS)</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($purchaseOrder->costs as $cost)
                            @php
                                
                                $totalExtraordinaryConcepts = $cost->totalExtraordinaryCosts('normal');
                                
                                $totalDiscount = $cost->totalExtraordinaryCosts('descuento');
                                
                                $total = $cost->normal_hour + $cost->fifty_hour + $cost->hundred_hour + $cost->food + $totalExtraordinaryConcepts - $totalDiscount;
                                
                            @endphp

                            <tr>
                                <td>{{ $cost->account->id }}</td>
                                <td>${{ number_format($cost->normal_hour, 2) }}</td>
                                <td>${{ number_format($cost->fifty_hour, 2) }}</td>
                                <td>${{ number_format($cost->hundred_hour, 2) }}</td>
                                <td>${{ number_format($cost->food, 2) }}</td>
                                <td>${{ number_format($totalExtraordinaryConcepts, 2) }}</td>
                                <td>$-{{ number_format($totalDiscount, 2) }}</td>
                                <td>${{ number_format($total, 2) }}</td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>

        {{-- <div class="card-footer">
            {{ $purchaseOrder->links() }}
        </div> --}}

    </div>

</div>
