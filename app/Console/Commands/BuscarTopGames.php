<?php

namespace App\Console\Commands;

use App\Models\Data\Label;
use App\Models\Data\Run;
use App\Models\Data\TopGame;
use App\Twitch;
use Illuminate\Console\Command;

class BuscarTopGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitch:topgames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca os maiores games atualmente na twitch.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
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

        $resultado = $twitch->getTopGames();

        $top = $resultado->top;

        foreach ($top as $row) {
            $topGame = new TopGame();
            $topGame->id_name = Label::getIdLabel('game_name', $row->game->name);
            $topGame->viewers = $row->viewers;
            $topGame->id_locale = Label::getIdLabel('game_locale', $row->game->locale);
            $topGame->id_run = $run->id;
            $topGame->save();
        }
    }
}
