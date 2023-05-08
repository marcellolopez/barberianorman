<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use Twilio\Rest\Client; 
use App\Models\Barbero;
use App\Models\Reserva;
use DB, Log, Carbon\Carbon;

class IndexController extends Controller
{ 
    public function index(){
      $barberos = Barbero::where('bloqueado', 0)->get();
      $barber_id = null;
      return view('usuario.index', compact('barberos', 'barber_id'));
    }    
    static function send($request = null){
        //TOKEN QUE NOS DA FACEBOOK
        $token = env('TOKEN_WSP');
        //NUESTRO TELEFONO
        $telefono = $request['telefono'];
        //URL A DONDE SE MANDARA EL MENSAJE
        $url = env('URL_WSP');
        Log::info('Nombre: '. $request['nombre']);
        Log::info('Celular: '. $request['telefono']);
        Log::info('Hora: '. $request['hora']);
        //CONFIGURACION DEL MENSAJE
        $mensaje = ''
                . '{'
                . '"messaging_product": "whatsapp", '
                . '"to": "'.$telefono.'", '
                . '"type": "template", '
                . '"template": '
                . '{'
                . '     "name": "recordatorio",'
                . '     "language":{ "code": "es_ES" },'
                .'      "components": [
                            {
                                "type": "body",
                                "parameters": [
                                    {
                                        "type": "text",
                                        "text": "'.$request['nombre'].'"
                                    },
                                    {
                                        "type": "text",
                                        "text": "'.$request['hora'].'"
                                    },
                                ]
                            }
                        ],'
                . '} '
                . '}';

        //DECLARAMOS LAS CABECERAS
        $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
        //INICIAMOS EL CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
        $response = json_decode(curl_exec($curl), true);
        //IMPRIMIMOS LA RESPUESTA 
        print_r($response);
        Log::info($response);
        //OBTENEMOS EL CODIGO DE LA RESPUESTA
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //CERRAMOS EL CURL
        curl_close($curl);
    }
}
