@extends('layouts.adminlte')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Estatisticas do time </h1>
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
            <form action="{{ route('matches.statistics.save', [$team->id, $match->id]) }}" method='POST'>
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h1> Organizar Estatisticas </h1>
                    </div>

                    <div class="card-body">
                        @if(count($matchHasPlayer) > 0)
                                @foreach($matchHasPlayer as $player)
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h3>{{ $player->name }} (<span class="text-muted">{{ $player->nickname }}</span>)</h3>
                                                </div>

                                                <div class="col-6 text-right">
                                                    <i class="btn btn-sm btn-success"> # {{ $player->number }} </i>
                                                    <i class="btn btn-sm btn-success"> {{ $player->gamePosition->short }} </i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($statistics as $data)
                                                    <div class="form-group col-md-2 col-lg-2 col-sm-1 mt-lg-3">
                                                        <span> {{ $data->name }} </span>
                                                        <input class="form-control w-100" type="number" name="player[{{ $player->id }}][{{ $data->id }}]" value="@if(isset($player->statistics[$data->id])){{ $player->statistics[$data->id] }}@else{{ 0 }}@endif">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                        @else
                            <div class="alert alert-danger">
                                Não existem jogadores cadastrados, você deve ter algum para registrar estatisticas
                            </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <input type="submit" value="Cadastrar estatistícas" class="btn btn-success"></input>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
