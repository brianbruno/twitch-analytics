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
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('resultado-previsao-api') }}">
                                    @csrf
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selectChannel">Selecione um canal</label>
                                            <select class="form-control" id="selectChannel" name="channel">
                                                @foreach($channels as $channel)
                                                    <option value="{{ $channel->id }}">{{$channel['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <button type="submit" class="btn btn-primary text-center">Buscar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#select').selectpicker();
        });

    </script>
@endsection