<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use Twilio\Rest\Client; 
use App\Models\Barbero;

class IndexController extends Controller
{ 
    public function index(){
      $barberos = Barbero::all();
      $barber_id = null;
      return view('usuario.index', compact('barberos', 'barber_id'));
    }    
    static function send($array){
        $sid    = "ACb2ce8de99339dccaba9cde2eb64bcdda"; 
        $token  = "20ee335550eeb5dbb93d5cd9695bfad4"; 
        $twilio = new Client($sid, $token); 
        $body = "¡Hola,". $array['nombre'] ."! Ya agendamos tu solicitud de reserva para el día ".$array['dia']." a las ".$array['hora'].". 
        Te recordaremos por este medio el día de tu cita... ¡Te esperamos!";
        $message = $twilio->messages 
                          ->create("whatsapp:+56".$array['celular'] , // to 
                                   array( 
                                       "from" => "whatsapp:+14155238886",       
                                       "body" => $body
                                   ) 
                          ); 
         
        return $message;
    }  
}
