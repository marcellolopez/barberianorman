<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB, Carbon\Carbon, Log;
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

        Log::info('Prueba '. $fecha);
        echo 'Prueba '. $fecha;
        return 'Registro en log';
    }
}
