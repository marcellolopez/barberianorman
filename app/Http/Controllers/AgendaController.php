<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Cliente;
use DB, Carbon\Carbon;
use App\Http\Controllers\IndexController;
use Auth;

class AgendaController extends Controller
{
    public function cargarAgenda(Request $request){

        $reservas= Reserva::select(
            'id',
            'barber_id',
            'cliente_id',
            'title',
            'start',
            'end',
            DB::raw("DATE_FORMAT(start,'%d-%m-%Y') as start_fecha"),
            DB::raw("TIME_FORMAT(start, '%H:%i %p') as start_hora"),
            DB::raw("DATE_FORMAT(end,'%d-%m-%Y') as end_fecha"),
            DB::raw("TIME_FORMAT(end, '%H:%i %p') as end_hora")
        )
        ->where('barber_id',$request->barber_id)
        ->where('start', '>', Carbon::now()->setTimezone('America/Santiago'))
        ->get();

        return response()->json($reservas);
    } 
    
    public function reservarHora(Request $request){
        $cliente = Cliente::where('celular',$request->celular)->first();

        $cantidad_reservas = Reserva::where('cliente_id', $cliente->id)
        ->where('start', '>', Carbon::now()->setTimezone('America/Santiago'))
        ->get()
        ->count();

        if($cantidad_reservas > 0){
            return response()->json(['status' => '500', 'mensaje' => 'Ya cuentas con una hora agendada.']); 
        }


        $reserva = Reserva::select(
            'id',
            'barber_id',
            'cliente_id',
            'title',
            'start',
            'end',
            DB::raw("DATE_FORMAT(start,'%d-%m-%Y') as start_fecha"),
            DB::raw("TIME_FORMAT(start, '%H:%i %p') as start_hora"),
            DB::raw("DATE_FORMAT(end,'%d-%m-%Y') as end_fecha"),
            DB::raw("TIME_FORMAT(end, '%H:%i %p') as end_hora")
        )
        ->where('id',$request->id)
        ->first();
        $reserva->title = 'Ocupado';
        $reserva->cliente_id = $cliente->id;
        $reserva->reserva_admin = (Auth::check() ? Auth::user()->id : '');
        if($reserva->save()){
            $array = array();
            $array['nombre'] = $cliente->nombres;
            $array['dia'] = $reserva->start_fecha;
            $array['hora'] = $reserva->start_hora;
            $array['celular'] = $request->celular;
            //$whatsapp = (IndexController::send($array));
            return response()->json(['status' => '200']); 
        }
        else{
            return response()->json(['status' => '500']); 
        }
            
    }
}
