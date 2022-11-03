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
        <form action="@if($match) {{ route('matches.update', [$team->id, $match->id]) }} @else {{ route('matches.save', $team->id) }} @endif" method='POST'>
            <div class="card">
                <div class="card-header">
                    <h1> Organizar Estatisticas </h1>
                </div>

                <div class="card-body">
                    @if(count($teamHasPlayers) > 0)

                    <table class="table table-bordered">
                        <tr>
                            <th class="table-vertical-text"> Jogador </th>
                            @foreach($statistics as $data)
                            <th>
                                <p class="table-vertical-text"> {{ $data->name }} </p>
                            </th>
                            @endforeach
                        </tr>

                        @foreach($teamHasPlayers as $player)
                        <tr>
                            <td> {{ $player->name }} </td>
                            @foreach($statistics as $data)
                            <th>
                                <input type="number" name="player[{{ $player->id }}][{{ $data->id }}]"class="w-100"> </input> </p>
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
                </div>

                <div class="card-footer">
                    <input type="submit" value="Cadastrar estatistícas" class="btn btn-success"></input>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection