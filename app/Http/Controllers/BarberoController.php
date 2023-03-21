<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barbero;
use App\Models\Reserva;
use DB, Carbon\Carbon;
use Validator, DateTime;

class BarberoController extends Controller
{
	public function actualizarBarbero(Request $request){

		$validator = $this->validarDatosBarbero($request);

		if ($validator->fails()) {
			return response()->json(['status' => '500', 'validate' => false, 'errors' => $validator->errors()->all()]);
        }
        else{
        	$barbero = Barbero::find($request->barber_id);
	        $barbero->nombres = $request->nombre;
	        $barbero->apellido_paterno = $request->apellido_paterno;
	        $barbero->email = $request->email;
	        $barbero->celular = $request->celular;
	        $barbero->fecha_nacimiento = $request->fecha_nacimiento;
	        $barbero->bloqueado = isset($request->bloqueado) ? 1 : 0;
	        if($barbero->save()){
	            
	            return response()->json(['status' => '200']); 
	        }
	        else{
	            return response()->json(['status' => '500', 'validate' => true, 'mensaje' => 'Hubo un error, pongase en contacto con soporte.']); 
	        }
        }
    }

    public function validarDatosBarbero($request){
		Validator::extend('olderThan', function($attribute, $value, $parameters)
		{
		    $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 13;
		    return (new DateTime)->diff(new DateTime($value))->y >= $minAge;

		    // or the same using Carbon:
		    // return Carbon\Carbon::now()->diff(new Carbon\Carbon($value))->y >= $minAge;
		});
    	return Validator::make($request->all(), [
            'barber_id' 		=> 'required',
            'celular'			=> 'required',
			'nombre'			=> 'required',
			'apellido_paterno'	=> 'required',
			'email'				=> 'required|email',
			'fecha_nacimiento'	=> 'required|date|before_or_equal:'.\Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
        ],
        [
        'fecha_nacimiento.before_or_equal' => 'Debe ser mayor de 18 años'
        ]);
    }
}
