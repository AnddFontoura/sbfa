@extends('layouts.adminlte')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1> Jogadores do time </h1>
            </div>
        </div>
    </div>
</section>

<div class="row mt-3 text-left">
    <div class="col-md-1 col-12 mt-3 text-center">
        @if($team->logo)
        <img src="{{ asset('storage/' . $team->logo) }}" class="img w-50"></img>
        @endif
    </div>
    <div class="col-md-10 col-12 mt-3">
        <h5> {{ $team->name}} </h5>
        <p> {{$team->city->name}} ({{$team->city->state->name}}/{{ $team->city->state->short }})
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">

        @if(count($teamHasPlayers) == 0)

        <div class="alert alert-danger">
            Não existem jogadores cadastrados, você deve ter algum para registrar estatisticas
        </div>
        @else
        <form action="@if($match) {{ route('statistics.update', [$team->id, $match->id]) }} @else {{ route('statistics.save', [$team->id, $match->id]) }} @endif" method='POST'>
            <div class="card">
                <div class="card-header">
                    Jogadores a serem avaliados
                </div>

                <div class="card-body">
                    @csrf

                    <table class="table table-stripped">
                        <tr>
                            <th style="writing-mode: vertical-rl; font-size: 10px;"> Jogador </th>
                            <th style="writing-mode: vertical-rl; font-size: 10px;"> Nº Camisa </th>
                            <th style="writing-mode: vertical-rl; font-size: 10px;"> Pago </th>
                            @foreach($statistics as $data)
                            <th>
                                <p style="writing-mode: vertical-rl; font-size: 10px;"> {{ $data->name }} </p>
                            </th>
                            @endforeach
                        </tr>

                        @foreach($teamHasPlayers as $player)
                        <tr>
                            <td> {{ $player->name }} </td>
                            <th>
                                <input type="number" class="w-100"> </input> </p>
                            </th>
                            <th>
                                <input type="number" class="w-100"> </input> </p>
                            </th>
                            @foreach($statistics as $data)
                            <th>
                                <input type="number" class="w-100" name="playerStatistic[{{ $player->id }}][{{ $data->id }}]" value="0"> </input> </p>
                            </th>
                            @endforeach
                        </tr>
                        @endforeach

                    </table>

                </div>

                <div class="card-footer">
                    <input type="submit" value="Cadastrar Estatisticas"></input>
                </div>
                @endif
        </form>
    </div>
</div>

@endsection