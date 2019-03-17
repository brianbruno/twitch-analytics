<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 17/03/2019
 * Time: 08:58
 */

namespace App\Http\Controllers\Chart;

use App\Models\Data\Run;
use App\Models\Data\TopGame;
use Illuminate\Support\Facades\DB;

class EvolucaoTopGames extends Chart {


    /**
     * EvolucaoTopGames constructor.
     */
    public function __construct() {

        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

    }

    public function find() {
//        $run =  Run::find(DB::table('data_runs')->max('id'));
//        $games = TopGame::limit(25)->get();

        $games = DB::select("
        SELECT X.id, X.name, DATE_FORMAT(X.date, '%d/%m/%Y %H:%i:%s') data, X.viewers viewers
        FROM (SELECT dr.id, value name, dr.date, dt.viewers viewers
               FROM data_labels dl, (SELECT data_runs.id, data_runs.date FROM data_runs WHERE task = 'twitch:topgames' ORDER BY date DESC LIMIT 100) dr
                                      LEFT JOIN data_topgames dt
                                                on dt.id_run = dr.id
               WHERE dl.name = 'game_name'
                 AND dl.value <> ''
                 AND dt.id_name = dl.id
                 AND (SELECT COUNT(id) FROM data_topgames WHERE dl.id = data_topgames.id_name) 
        
               UNION ALL
        
               SELECT dr.id, value name, dr.date, null viewers
               FROM data_labels dl, (SELECT data_runs.id, data_runs.date FROM data_runs WHERE task = 'twitch:topgames' ORDER BY date DESC LIMIT 100) dr
               WHERE dl.name = 'game_name'
                 AND dl.value <> ''
                 AND (SELECT COUNT(id) FROM data_topgames WHERE dl.id = data_topgames.id_name)
                 AND NOT EXISTS(SELECT id FROM data_topgames WHERE data_topgames.id_run = dr.id AND data_topgames.id_name = dl.id)) X
        ORDER BY X.date");

        $dataSets = [];
        $labels = [];

        $labelsSelect = array_reverse(DB::select("SELECT DATE_FORMAT(date, '%d/%m/%Y %H:%i:%s') data FROM data_runs WHERE task = 'twitch:topgames' ORDER BY date DESC LIMIT 100"));

        foreach ($games as $jogo) {
            $this->addNovoDataSet($dataSets, $jogo);
        }

        foreach ($labelsSelect as $label) {
            $date = \DateTime::createFromFormat('d/m/Y H:i:s', $label->data);
            $labels[] = $date->format('D H:i');
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => $dataSets
        ]);

    }

    public function addNovoDataSet(&$dataSets, $jogo) {
        $nomeJogo = $jogo->name;
        $viewers = $jogo->viewers;
        $criarNovo = true;

        foreach ($dataSets as &$dataSet) {
            if ($dataSet['label'] == $nomeJogo) {
                $dataSet['data'][] = $viewers;
                $criarNovo = false;
            }
        }

        if ($criarNovo) {
            $dataSets[] = array(
                'label' => $jogo->name,
                'borderColor' => parent::getBackgroundColor($jogo->name),
                'hidden' => false,
                'data'  => array($viewers)
            );
        }
    }
}