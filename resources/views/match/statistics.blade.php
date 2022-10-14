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
        <form action="@if($match) {{ route('matches.update', [$team->id, $match->id]) }} @else {{ route('matches.save', $team->id) }} @endif" method='POST'>
            @if(count($teamHasPlayers) > 0)

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
                        <input type="number" class="w-100"> </input> </p>
                    </th>
                    @endforeach
                </tr>
                @endforeach

            </table>

            @else
            <div class="alert alert-danger">
                Não existem jogadores cadastrados, você deve ter algum para registrar estatisticas
            </div>
            @endif
        </form>
    </div>
</div>

@endsection