<?php

namespace App\Http\Controllers;

use App\Models\Data\Channel;
use App\Models\MachineLearning\StreamGames;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

        try {
            $previsoes = $this->getPrevisoes();
        } catch (\Exception $e) {
            $previsoes = [];
        }

        return view('home', ['previsoes' => $previsoes]);
    }

    public function getPrevisoes() {
        $retorno = [];

        $resultados = DB::select("
            SELECT data_labels.id IDGAME, value name, data_channels.id IDCHANNEL, data_channels.display_name NMCHANNEL, 1 as IDTIME
            FROM data_labels, data_channels
            WHERE data_labels.name = 'game_name'
            AND value IS NOT NULL
            AND value <> ''
            ORDER BY RAND()
            LIMIT 10");

        foreach ($resultados as $resultado) {

            $IDGAME = $resultado->IDGAME;
            $IDCHANNEL = $resultado->IDCHANNEL;
            $IDHORA = date('G');
            $NMCHANNEL = $resultado->NMCHANNEL;
            $IDDIASEMANA = date('w');

            $valor = $this->mlChannelFindRequest($IDGAME, $IDCHANNEL, $IDHORA, $IDDIASEMANA);

            $retorno[] = array(
                'game' => $resultado->name,
                'streamer' => $NMCHANNEL,
                'visualizacoes' => $valor
            );
        }

        return $retorno;

    }

    public function mlChannel() {
        return view('previsao', ['channels' => Channel::all()]);
    }

    public function mlChannelFind($id) {
        set_time_limit(300);

        $retorno = [];

        $resultados = DB::select("
            SELECT data_labels.id IDGAME, value name, data_channels.id IDCHANNEL, data_channels.display_name NMCHANNEL
            FROM data_labels, data_channels
            WHERE data_labels.name = 'game_name'
            AND value IS NOT NULL
            AND value <> ''
            AND data_channels.id = ".$id);

        $tInicial = time();
        foreach ($resultados as $resultado) {
            $IDGAME = $resultado->IDGAME;
            $IDCHANNEL = $resultado->IDCHANNEL;
            $IDHORA = date('G');
            $NMCHANNEL = $resultado->NMCHANNEL;
            $IDDIASEMANA = date('w');

            $valor = $this->mlChannelFindRequest($IDGAME, $IDCHANNEL, $IDHORA, $IDDIASEMANA);

            $retorno[] = array(
                'game' => $resultado->name,
                'streamer' => $NMCHANNEL,
                'visualizacoes' => $valor
            );
        }

        $tFinal = time();
        return view('resultado', ['previsoes' => $retorno, 'tempo' => $tFinal-$tInicial]);
    }

    public function mlChannelFindApi(Request $request) {
        $idChannel = $request->channel;
        /*$status = true;
        $resultado = StreamGames::where('idChannel', '=', $idChannel)->get();

        if (empty($resultado))
            $status = false;

        return response()->json([
            'resultado' => $resultado,
            'status'  => $status,
        ], 200);*/

        return redirect()->route('resultado-previsao', ['id' => $idChannel]);

    }
    
    public function mlChannelFindRequest($IDGAME, $IDCHANNEL, $IDHORA, $IDDIASEMANA) {
        $url = "http://127.0.0.1:5000/dataset?IDGAME=".$IDGAME."&IDCHANNEL=".$IDCHANNEL."&IDHORA=".$IDHORA."&IDDIASEMANA=".$IDDIASEMANA;

        $client = new Client();
        $response = $client->request('GET', $url);
        $valor = $response->getBody()->getContents();
        
        return $valor;
    }
}
