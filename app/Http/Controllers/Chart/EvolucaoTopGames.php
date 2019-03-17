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
        SELECT dl.value name, dt.id_run, dt.viewers
        FROM data_topgames dt, (SELECT data_runs.id FROM data_runs ORDER BY date DESC LIMIT 100) dr, data_labels dl
        WHERE dt.id_run = dr.id
        AND dl.id = dt.id_name
        ORDER BY dl.value, dt.id_run");

        $dataSets = [];
        $labels = [];

        $labelsSelect = array_reverse(DB::select("SELECT DATE_FORMAT(date, '%d/%m/%Y %H:%i:%s') data FROM data_runs ORDER BY date DESC LIMIT 100"));

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