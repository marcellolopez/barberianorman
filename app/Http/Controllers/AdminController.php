<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barbero;
use App\Models\Reserva;
use App\Models\Cliente;
use DB, Carbon\Carbon;
use DataTables;
use App\Exports\ClientesExport;
use App\Exports\ClientesReservasExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index(Request $request){
        $barberos  = Barbero::where('bloqueado',0)->get();
        $barber_id = isset($request->barber_id) ? $request->barber_id : null;
        $barbero   = $barberos->where('id',$barber_id)->first();
        return view('administrador.index', compact('barberos', 'barber_id', 'barbero'));
    }    

    public function agendarCliente(){
      $barberos = Barbero::where('bloqueado',0)->get();
      $barber_id = null;
      return view('administrador.reservar', compact('barberos', 'barber_id'));
    }    

    public function cargarAgendaBarbero(Request $request){
        $reservas= Reserva::from('reservas as r')->select(
            'r.id as reserva_id',
            'r.barber_id',
            'r.cliente_id',
            'r.title',
            'r.start',
            'r.end',
            'r.comentario',
            DB::raw("DATE_FORMAT(r.start,'%d-%m-%Y') as start_fecha"),
            DB::raw("TIME_FORMAT(r.start, '%H:%i %p') as start_hora"),
            DB::raw("DATE_FORMAT(r.end,'%d-%m-%Y') as end_fecha"),
            DB::raw("TIME_FORMAT(r.end, '%H:%i %p') as end_hora"),
            DB::raw("CONCAT(c.nombres, ' ', c.apellido_paterno) as nombre_completo"),
            'c.celular as telefono'
        )
        ->leftjoin('clientes as c','c.id','r.cliente_id')
        ->where('barber_id', $request->barber_id)
        //->where('start', '>=', Carbon::now('America/Santiago')->subDay()->format('Y-m-d'))
        ->get();
        return response()->json($reservas);
    }     

    public function cargarProgramacionBarbero(Request $request){
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
        ->where('barber_id', $request->barber_id)
        ->where('start', '>=', Carbon::now('America/Santiago')->format('Y-m-d h:i:s'))
        ->groupBy(DB::raw("DATE_FORMAT(start,'%d-%m-%Y')"))
        ->get();
        return response()->json($reservas);
    }  

    public function calendarioBarberoAjax(Request $request){
        $barber_id = $request->barber_id;
        $start = date('Y-m-d');

        $html = view('js.admin.calendario_barbero', compact('barber_id'))->render();
        return $html;
        if($html){
            return response()->json(['status' => '200', 'view' => $html]); 
        }
        else{
            return response()->json(['status' => '500']); 
        }
        
    }

    public function actualizarHora(Request $request){
        $reserva = Reserva::find($request->reserva_id);

        switch ($request->id) {
            case 1:
                // Liberar
                $reserva->cliente_id = null;
                $reserva->title = 'Libre';
                $reserva->save();
                break;
            case 2:
                // Eliminar
                $reserva->delete();
                break;
            case 3:
                // Bloquear
                $reserva->title = $reserva->title == 'Bloqueada' ? 'Libre' : 'Bloqueada';
                $reserva->save();
                break;
            case 4:
                // Asiste
                if($reserva->cliente_id == null){
                    $reserva = false;
                    break;
                }
                $reserva->title = 'Asiste';
                $reserva->save();
                break;
            case 5:
                // No asiste
                if($reserva->cliente_id == null){
                    $reserva = false;
                    break;
                }            
                $reserva->title = 'No Asiste';
                $reserva->save();
                break;                                
        }

        if($reserva){
            return response()->json(['status' => '200']); 
        }
        else{
            return response()->json(['status' => '500']); 
        }
        
    }

    public function guardarProgramacionBarbero(Request $request){
        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $request->info['startStr']);
        $fecha_termino = Carbon::createFromFormat('Y-m-d', $request->info['endStr']);

        $barber_id = $request->barber_id;
        $start = date('Y-m-d');

        do {
            $this->generarHoras($fecha_inicio->format('Y-m-d'), $fecha_termino->format('Y-m-d'), $barber_id);
            $fecha_inicio->addDay();
        } 
        while ($fecha_inicio != $fecha_termino);


        return response()->json(['status' => '200']); 
        
        
    }    

    public function generarHoras($fecha_inicio, $fecha_termino, $barber_id){
        $hora_inicio = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_inicio.' '.'11:00:00');
        $fecha_hora_inicio  = $hora_inicio->format('Y-m-d H:i:s');
        $fecha_hora_termino = $hora_inicio->addHours(1);
        for ($i=0; $i < 9 ; $i++) { 
            if(Reserva::where('start',$fecha_hora_inicio)->where('barber_id',$barber_id)->first() == null){
                $reserva            = new Reserva();
                $reserva->barber_id = $barber_id;
                $reserva->start     = $fecha_hora_inicio;
                $reserva->end       = $fecha_hora_termino->format('Y-m-d H:i:s'); 
                $reserva->title     = 'Libre';
                $reserva->save();
                $fecha_hora_inicio = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_hora_inicio);
                $fecha_hora_termino = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_hora_termino);
                $fecha_hora_inicio->addHours(1);
                $fecha_hora_termino->addHours(1);
            }
        }
    }  
    public function verClientes(){
        $url = 'admin/getClientes';
        return view('administrador.registros',compact('url'));
    }

    public function verBarberos(){
        $url = 'admin/getBarberos';
        return view('administrador.registros_barberos',compact('url'));
    }

    public function getClientesDatatables(){
        $query = DB::table('clientes')
            ->select(
                'id',
                DB::raw('CONCAT(nombres, " ", apellido_paterno) as nombre_completo'),
                DB::raw("DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') as fecha_nacimiento"),
                'email',
                'celular',
                DB::raw('(SELECT COUNT(*) FROM reservas WHERE reservas.cliente_id = clientes.id) as reservas_count'),
                DB::raw('(SELECT DATE_FORMAT(MAX(start), "%d-%m-%Y %H:%i %p") FROM reservas WHERE reservas.cliente_id = clientes.id) as ultima_reserva')
            )
            ->get();
    
        return DataTables::of($query)->toJson();
    }
    

    public function getBarberosDatatables(){
        $query = DB::table('barberos')
            ->select(
                DB::raw('CONCAT(nombres, " ", apellido_paterno) as nombre_completo'),
                DB::raw("DATE_FORMAT(fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento"),
                'email',
                'celular'
            )
            ->get();
     
        return DataTables::of($query)->toJson();
    }

    public function exportarExcel(){
        return Excel::download(new ClientesReservasExport, 'clientesReservas.xlsx');
    }

    public function exportarExcelClientes(){
        return Excel::download(new ClientesExport, 'clientes.xlsx');
    }

    public function menu(Request $request){
        $request->session()->put('menu', $request->menu);
    }    

    public function historial($id)
    {
        // Obtener el historial de reservas del cliente
        $reservas = Reserva::where('cliente_id', $id)
            ->join('barberos as b', 'reservas.barber_id', '=', 'b.id')
            ->select(
                'reservas.id',
                DB::raw("DATE_FORMAT(reservas.start, '%d-%m-%Y %H:%i %p') as fecha_inicio"),
                DB::raw("DATE_FORMAT(reservas.end, '%d-%m-%Y %H:%i %p') as fecha_termino"),
                'reservas.title as estatus',
                DB::raw("CONCAT(b.nombres, ' ', b.apellido_paterno) as nombre_barbero")
            )
            ->orderBy('reservas.start', 'desc')
            ->get();

        // Retornar la vista con el historial
        return view('administrador.cliente_historial', compact('reservas'));
    }

}
