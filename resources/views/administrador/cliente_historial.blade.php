<!-- resources/views/admin/cliente/historial.blade.php -->
<table class="table table-sm table-striped">
    <thead>
        <tr class="table-secondary">
            <th scope="col">Fecha de Inicio</th>
            <th scope="col">Fecha de Término</th>
            <th scope="col">Estatus</th>
            <th scope="col">Barbero</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($reservas as $reserva)
            <tr>
                <td>{{ $reserva->fecha_inicio }}</td>
                <td>{{ $reserva->fecha_termino }}</td>
                <td>{{ $reserva->estatus }}</td>
                <td>{{ $reserva->nombre_barbero }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No hay reservas para este cliente.</td>
            </tr>
        @endforelse
    </tbody>
</table>
