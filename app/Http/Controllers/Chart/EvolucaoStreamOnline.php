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

class EvolucaoStreamOnline extends Chart {

    public function find() {
//        $run =  Run::find(DB::table('data_runs')->max('id'));
//        $games = TopGame::limit(25)->get();

        $games = DB::select("
        SELECT dc.display_name, dl.value, dso.viewers, DATE_FORMAT(dso.created_at, '%d/%m/%Y %H:%i:%s') data
        FROM data_streamsonline dso, (SELECT data_runs.id FROM data_runs WHERE data_runs.task = 'twitch:streamsonline' ORDER BY date DESC LIMIT 50) dr,
             (SELECT * FROM data_labels) dl, (SELECT * FROM data_channels) dc
        WHERE dso.id_run = dr.id
        AND dl.id = dso.id_game
        AND dc.id = dso.id_channel");

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