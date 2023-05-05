<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\IndexController;
use App\Models\Reserva;
use DB, Carbon\Carbon;

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
        $fecha    = Carbon::now('America/Santiago')
                    ->addDay() //RECORDAR QUITAR CUANDO SE HABILITE CRON
                    ->format('Y-m-d');

        $reservas = Reserva::with('cliente')
                    ->where(DB::raw("(DATE_FORMAT(RESERVAS.start,'%Y-%m-%d'))"),$fecha)
                    ->where('title','Ocupado')
                    ->get();

        if($reservas == null){
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
                }
                else{
                    echo 'Cliente sin recordatorio número '. $r->cliente->celular ;
                }
            }
        }
    }
      
}
