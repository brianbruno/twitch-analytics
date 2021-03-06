@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <chart-evulucaotopgames></chart-evulucaotopgames>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <a href="{{ route('previsao') }}">Previsao</a>
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
