<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Reserva;
use DB, Carbon\Carbon;
use Validator, DateTime;

class ClienteController extends Controller
{
    public function consultarCliente(Request $request){
        $cliente = Cliente::where('celular',$request->celular)->first();
        if($cliente){
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
            ->where('cliente_id',$cliente->id)
            ->where('start', '>', Carbon::now()->setTimezone('America/Santiago'))
            ->first();

            return response()->json(['status' => '200', 'cliente' => (object) $cliente->toArray(), 'reserva' => $reserva]); 
        }
        else{
            return response()->json(['status' => '500']); 
        }
    } 
    public function registrarCliente(Request $request){
        $validator = $this->validarDatosCliente($request);

        if ($validator->fails()) {
            return response()->json(['status' => '500', 'validate' => false, 'errors' => $validator->errors()->all()]);
        }
        else{
            $cliente = new Cliente();
            $cliente->nombres = $request->nombre;
            $cliente->apellido_paterno = $request->apellido;
            $cliente->email = $request->email;
            $cliente->celular = $request->celular;
            $cliente->fecha_nacimiento = $request->fecha_nacimiento;
            $cliente->recordatorio = $request->recordatorio;
            if($cliente->save()){

                return response()->json(['status' => '200', 'cliente' => (object) $cliente]); 
            }
            else{
                return response()->json(['status' => '500', 'validate' => true, 'mensaje' => 'Hubo un error, pongase en contacto con soporte.']); 
            }
        }
    }   

    public function validarDatosCliente($request){
        Validator::extend('olderThan', function($attribute, $value, $parameters)
        {
            $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 13;
            return (new DateTime)->diff(new DateTime($value))->y >= $minAge;

            // or the same using Carbon:
            // return Carbon\Carbon::now()->diff(new Carbon\Carbon($value))->y >= $minAge;
        });
        return Validator::make($request->all(), [
            'celular'           => 'required',
            'nombre'            => 'required',
            'apellido'          => 'required',
            'email'             => 'required|email|unique:clientes',
            'fecha_nacimiento'  => 'required|date|before_or_equal:'.\Carbon\Carbon::now()->subYears(1)->format('Y-m-d'),
        ],
        [
        'fecha_nacimiento.before_or_equal' => 'Debe ser mayor de 1 años',
        'email.unique' => 'El correo se encuentra registrado con otra cuenta'
        ]);
    }
}
