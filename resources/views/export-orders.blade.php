<table>
    <thead>
        <tr>
            <th>ID orden</th>
            <th>{{ env('APP_EVENTO') == 'pastelitos' ? 'Ventas de' : 'Rover encargado' }}</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Telefono</th>
            <th>Direccion</th>
            @if (env('APP_EVENTO') != 'pastelitos')
                <th>Cod. Postal</th>
                <th>Delivery</th>
            @endif
            <th>{{ env('APP_EVENTO') == 'pastelitos' ? '1/2 Membrillo' : 'QTY' }}</th>
            @if (env('APP_EVENTO') == 'pastelitos')
                <th>1/2 Batata</th>
            @endif
            <th>Importe</th>
            @if (env('APP_EVENTO') != 'pastelitos')
                <th>Salsas</th>
            @endif
            <th>Observaciones {{ $getCurrentYear->year }}</th>
            <th>{{ $getPrevioustYear ? 'Observaciones ' . $getPrevioustYear->year : 'No hay registros del año pasado' }}</th>
            <th>Dinero cobrado</th>
            <th>A cobrar</th>
            <th>Mercado pago SI/NO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user ? $order->user->name : '-' }}</td>
                <td>{{ $order->client->name }}</td>
                <td>{{ $order->client->last_name }}</td>
                <td>{{ $order->client->phone_number }}</td>
                <td>{{ $order->client->direction }}</td>

                @if (env('APP_EVENTO') != 'pastelitos')
                <td>{{ $order->client->postal_code }}</td>
                <td>{{ $order->take_away ? 'SI' : 'NO' }}</td>
                @endif

                <td>{{ $order->portions }}</td>

                @if (env('APP_EVENTO') == 'pastelitos')
                <td>{{ $order->batata }}</td>
                @endif

                <td>{{ $order->amount }}</td>

                @if (env('APP_EVENTO') != 'pastelitos')
                <td>{{ $order->sauces }}</td>
                @endif
                <td>
                    @foreach ($order->client->observations as $observation)
                        @if ( $observation->year_id == $getCurrentYear->id)
                            {{ $observation->observation }}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($order->client->observations as $observation)
                        @if ( $getPrevioustYear != null && $observation->year_id == $getPrevioustYear->id )
                            {{ $observation->observation }}
                        @endif
                    @endforeach
                </td>
                <td>{{ $order->money_collected }}</td>
                <td>{{ $order->to_collect }}</td>
                <td>{{ $order->mp ? 'SI' : 'NO' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>