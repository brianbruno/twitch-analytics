@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Resultado</div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        <a href="{{ route('previsao') }}">Voltar</a>
                    </div>

                    <div class="row justify-content-center">
                        <table>
                            <thead>
                            <tr>
                                <th> Game</th>
                                <th> Channel</th>
                                <th> Viewers  </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($previsoes as $previsao)
                                <tr>
                                    <td> {{$previsao['game']}} </td>
                                    <td> {{ empty($previsao['streamer']) ? '' : $previsao['streamer']}} </td>
                                    <td> {{$previsao['visualizacoes']}} </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
