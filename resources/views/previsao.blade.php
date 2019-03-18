@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Previsao</div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        <a href="{{ route('home') }}">Voltar</a>
                    </div>

                    <div class="row justify-content-center">
                        <table>
                            <thead>
                            <tr>
                                <th> Channel</th>
                                <th> Select</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($channels as $channel)
                                <tr>
                                    <td> {{$channel['name']}} </td>
                                    <td> <a href="{{ route('resultado-previsao', ['id' => $channel->id]) }}">Selecionar</a></td>
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
