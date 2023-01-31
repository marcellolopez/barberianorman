<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barbero;
use App\Models\Reserva;
use App\Models\Cliente;
use DB, Carbon\Carbon;
use DataTables;
use App\Exports\ClientesExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function viewLogin(){
        return view('administrador.login');
    }

    public function index(Request $request){
        $barberos  = Barbero::all();
        $barber_id = isset($request->barber_id) ? $request->barber_id : null;
        $barbero   = $barberos->where('id',$barber_id)->first();
        return view('administrador.index', compact('barberos', 'barber_id', 'barbero'));
    }    

    public function agendarCliente(){
      $barberos = Barbero::all();
      $barber_id = null;
      return view('administrador.reservar', compact('barberos', 'barber_id'));
    }    

    public function cargarAgendaBarbero(Request $request){
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
        $hora_inicio = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_inicio.' '.'12:00:00');
        $fecha_hora_inicio  = $hora_inicio->format('Y-m-d H:i:s');
        $fecha_hora_termino = $hora_inicio->addHours(1);
        for ($i=0; $i < 7 ; $i++) { 
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
    public function verRegistros(){
        return view('administrador.registros');
    }

    public function getClientesDatatables(){
        $clientes = new Cliente();
        $algo = DataTables::eloquent($clientes)->get();
        dd($algo);
    }

    public function exportarExcel(){
        return Excel::download(new ClientesExport, 'clientes.xlsx');
    }

    public function menu(Request $request){
        $request->session()->put('menu', $request->menu);
    }    
}
