<?php

namespace App\Console\Commands;

use App\Models\Data\StreamOnline;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GerarDataset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gerar:dataset';

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
     * @return mixed
     */
    public function handle() {
        $streams = StreamOnline::all();
        $arquivoString = "";

//        Storage::disk('local')->delete('dataset.txt');

        foreach ($streams as $stream) {
            $date = \DateTime::createFromFormat('Y-m-d H:i:s', $stream->created_at);
            $hora = $date->format('G'); // hora sem 0
            $diaSemana = $date->format('w'); // de 0 (domingo) a 6 (sábado)

            $string = $stream->id_game.";".$stream->id_channel.";".$diaSemana.";".$hora.";".$stream->viewers.";".PHP_EOL;
            $arquivoString .= $string;

        }
        
        Storage::disk('local')->put('dataset.txt', $arquivoString);
    }
}
