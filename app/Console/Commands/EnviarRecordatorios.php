<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\IndexController;
use App\Models\Reserva;
use DB, Carbon\Carbon, Log;

class EnviarRecordatorios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:EnviarRecordatorios';

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
        Log::info('Envío de recordatorios');

        $fecha    = Carbon::now('America/Santiago')
                    //->addDay() //RECORDAR QUITAR CUANDO SE HABILITE CRON
                    ->format('Y-m-d');
        Log::info($fecha);
        $reservas = Reserva::with('cliente')
                    ->where(DB::raw("(DATE_FORMAT(reservas.start,'%Y-%m-%d'))"),$fecha)
                    ->where('title','Ocupado')
                    ->get();
        $enviados=0;
        $noEnviados=0;
        if($reservas == null){
            Log::info('Sin reservas');
            echo 'Sin reservas';
        }
        else{
            foreach ($reservas as $r) {
                if($r->cliente->recordatorio == 1){
                    $request = array();
                    $request['nombre']      =   $r->cliente->nombres;
                    $request['telefono']    =   '56'.$r->cliente->celular;
                    $request['hora']    =   Carbon::parse($r->start)->format('H:i');
                    IndexController::send($request);
                    $enviados++;
                }
                else{
                    $noEnviados++;
                    Log::info('Cliente sin recordatorio número '. $r->cliente->celular);
                    echo 'Cliente sin recordatorio número '. $r->cliente->celular ;
                }
            }
        }
        Log::info('-----------------------');
        Log::info('Total enviados: '.$enviados);
        Log::info('-----------------------');
        Log::info('Total sin recordatorio: '.$noEnviados);
        Log::info('-----------------------');
        Log::info('Fin envío recordatorios');
        Log::info('-----------------------');
        Log::info('-----------------------');
        Log::info('-----------------------');

        $request = array();
        $request['nombre']      =   'Marcello';
        $request['telefono']    =   '56974163322';
        $request['hora']        =   'Enviados: '.$enviados;
        //IndexController::send($request);
    }
      
}
