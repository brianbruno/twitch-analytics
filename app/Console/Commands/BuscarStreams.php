<?php

namespace App\Console\Commands;

use App\Models\Data\Channel;
use App\Models\Data\Label;
use App\Models\Data\Run;
use App\Models\Data\StreamOnline;
use App\Twitch;
use Illuminate\Console\Command;

class BuscarStreams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitch:streamsonline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Streams online';

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
        $run = new Run();
        $run->note = "Twitch Analytics";
        $run->task = $this->signature;
        $run->save();

        $twitch = new Twitch();

        $resultado = $twitch->getStreams();
        $streams = $resultado->streams;

        foreach ($streams as $stream) {
            $transmissao = new StreamOnline();
            $transmissao->_id = $stream->_id;
            $transmissao->id_game = Label::getIdLabel('game_name', $stream->game);
            $idcanal = Channel::getIdChannel($stream->channel, $run);
            $transmissao->id_channel = $idcanal;
            $transmissao->status = $stream->channel->status;
            $transmissao->description = $stream->channel->description;
            $transmissao->viewers = $stream->viewers;
            $transmissao->id_run = $run->id;
            $transmissao->save();
        }
    }
}
