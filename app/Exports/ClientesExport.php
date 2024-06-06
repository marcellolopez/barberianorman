<?php

namespace App\Exports;

use App\Models\Reserva;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class ClientesExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    public function query()
    {
        return Reserva::query()
            ->from('clientes as c', 'r.cliente_id', '=', 'c.id')
            ->select(
                DB::raw('CONCAT(c.nombres, " ", c.apellido_paterno) as nombre_completo'),
                DB::raw("DATE_FORMAT(c.fecha_nacimiento, '%d-%m-%Y') as fecha_nacimiento"),
                'c.email',
                'c.celular',
                DB::raw('(SELECT COUNT(*) FROM reservas WHERE reservas.cliente_id = c.id) as reservas_count'),
                DB::raw('(SELECT DATE_FORMAT(MAX(start), "%d-%m-%Y %H:%i %p") FROM reservas WHERE reservas.cliente_id = c.id) as ultima_reserva')
            )
            ->orderBy('c.id');
    }

    public function headings(): array
    {
        return [
            'Nombre Completo',
            'Fecha de Nacimiento',
            'Email',
            'Celular',
            'Cantidad de Reservas',
            'Última Reserva'
        ];
    }
}
