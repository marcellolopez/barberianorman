<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use Twilio\Rest\Client; 
use App\Models\Barbero;

class IndexController extends Controller
{ 
    public function index(){
      $barberos = Barbero::where('bloqueado', 0)->get();
      $barber_id = null;
      return view('usuario.index', compact('barberos', 'barber_id'));
    }    
    static function send(){
        $sid    = "ACdfe1f06ed553ab8425c0904d2f661948"; 
        $token  = "8e1318c41b9df4f6e2f24b988eeda6d1"; 
        $twilio = new Client($sid, $token); 
        $body = 'Hola hola';/*"¡Hola,". $array['nombre'] ."! Ya agendamos tu solicitud de reserva para el día ".$array['dia']." a las ".$array['hora'].". 
        Te recordaremos por este medio el día de tu cita... ¡Te esperamos!";*/
        $message = $twilio->messages 
                    ->create("whatsapp:+56974163322" , // to 
                        array( 
                            "from" => "whatsapp:+56949722564",       
                            "body" => $body
                        ) 
                    ); 
         
        return $message;
    }  
}
