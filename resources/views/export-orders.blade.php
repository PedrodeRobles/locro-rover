<table>
    <thead>
        <tr>
            <th>ID orden</th>
            <th>Rover encargado</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Cod. Postal</th>
            <th>Retira? SI/NO</th>
            <th>QTY</th>
            <th>Importe</th>
            <th>Salsas</th>
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
                <td>{{ $order->client->postal_code }}</td>
                <td>{{ $order->take_away ? 'SI' : 'NO' }}</td>
                <td>{{ $order->portions }}</td>
                <td>{{ $order->amount }}</td>
                <td>{{ $order->sauces }}</td>
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