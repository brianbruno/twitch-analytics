<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 16/03/2019
 * Time: 22:34
 */

namespace App;

use App\Helpers\Requisicao;

class Twitch {

    public function getTopGames() {
        $url = "https://api.twitch.tv/kraken/games/top";

        $requisicao = new Requisicao();
        $resultado = $requisicao->get($url);

        return $resultado;
    }

    public function getStreams() {
        $url = "https://api.twitch.tv/kraken/streams?language=pt-br&stream_type=live";

        $requisicao = new Requisicao();
        $resultado = $requisicao->get($url);

        return $resultado;
    }
}