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
        $arquivoArray = [];

//        Storage::disk('local')->delete('dataset.txt');

        foreach ($streams as $stream) {
            $date = \DateTime::createFromFormat('Y-m-d H:i:s', $stream->created_at);
            $tempo = $date->format('A');

            if ($tempo == 'AM') {
                $hora = 0;
            } else {
                $hora = 1;
            }
            $string = $stream->id_game.";".$stream->id_channel.";".$hora.";".$stream->viewers.";".PHP_EOL;
            $arquivoArray[] = $string;
//            Storage::disk('local')->append('dataset.txt', $string);

        }
        
        Storage::disk('local')->put('dataset.txt', $arquivoArray);
    }
}
