<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB, Carbon\Carbon, Log;
use App\Http\Controllers\IndexController;

class PruebaLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PruebaLog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $fecha = Carbon::now('America/Santiago')
                    ->format('Y-m-d H:i:s');    
        /*/    
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($fecha);
        $mes = $meses[($fecha->format('n')) - 1];
        $inputs = $fecha->locale('es_ES')->dayName  . ', ' . $fecha->format('d') . ' de ' . $mes ;
        dd($inputs);

        /*/
        $request = array();
        $request['nombre']      =   'Marcello';
        $request['telefono']    =   '56974163322';
        $request['hora']        =   '14:00';
        IndexController::send($request);

        Log::info('Prueba '. $fecha);
        echo 'Prueba '. $fecha;
        return 'Registro en log';
        
    }
}
