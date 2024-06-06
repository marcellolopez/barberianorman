<?php

namespace App\Exports;
use App\Models\Cliente;
use App\Models\Reserva;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class ClientesReservasExport implements FromQuery, WithHeadings, ShouldAutoSize
{

    public function query()
    {
        return Reserva::query()->from('reservas as r')
            ->leftJoin('clientes as c', 'r.cliente_id', 'c.id')
            ->join('barberos as b', 'r.barber_id', 'b.id')
            ->select(
                DB::raw("DATE_FORMAT(r.start, '%d') as dia"),
                DB::raw("DATE_FORMAT(r.start, '%m') as mes"),
                DB::raw("DATE_FORMAT(r.start, '%Y') as ano"),
                DB::raw("CONCAT(c.nombres, ' ', c.apellido_paterno) AS nombre_cliente"),
                'c.email',
                'c.celular',
                //DB::raw("(SELECT COUNT(*) FROM reservas WHERE reservas.cliente_id = c.id) as cantidad_de_reservas"),
                DB::raw("CONCAT(b.nombres, ' ', b.apellido_paterno) AS nombre_barbero"),
                DB::raw("'Sin servicio' AS tipo_servicio"),
                DB::raw("'Sin categoría' AS categoria"),
                DB::raw("DATE_FORMAT(r.start, '%H:%i %p') as hora_inicio"),
                DB::raw("DATE_FORMAT(r.end, '%H:%i %p') as hora_termino"),
                DB::raw("'1 hora' as duracion"),
                DB::raw("r.title as estatus_final"),
                DB::raw("'0' as valor_final")
            )
            ->orderBy('r.id');
    }

    public function headings(): array
    {
        return [
            'DIA',
            'MES',
            'AÑO',
            'NOMBRE_CLIENTE',
            'EMAIL_CLIENTE',
            'CELULAR_CLIENTE',
            //'CANTIDAD_DE_RESERVAS',
            'NOMBRE_BARBERO',
            'TIPO_SERVICIO',
            'CATEGORIA',
            'HORA_INICIO_RESERVA',
            'HORA_TERMINO',
            'DURACION_SERVICIO',
            'ESTATUS_FINAL',
            'VALOR_SERVICIO'
        ];
    }
}
