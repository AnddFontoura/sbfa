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
        <form action="{{ route('matches.player-at.save', [$team->id, $match->id]) }}" method='POST'>
            @csrf
            <div class="card">
                <div class="card-header">
                    <h1> Organizar Estatisticas </h1>
                </div>

                <div class="card-body">
                    @if(count($teamHasPlayers) > 0)

                    <table class="table table-bordered">
                        <tr>
                            <th class=""> Jogador </th>
                            <th class=""> Posição </th>
                            <th Class=""> Número </th>
                            <th class=""> Presente? </th>
                            <th class=""> Pagou </th>
                            <th class=""> Anotações da partida </th>
                        </tr>

                        @foreach($teamHasPlayers as $player)
                        <tr>
                            <td> {{ $player->name }} </td>
                            @php
                                $positionId = null;

                                isset($player->matchHasPlayer->game_position_id)
                                ? $positionId = $player->matchHasPlayer->game_position_id
                                : $positionId = $player->position_id;
                            @endphp
                            <td>
                                <select class="select2 w-100" name="player[{{ $player->id }}][position_id]">
                                @foreach($gamePositions as $position)
                                    <option value="{{ $position->id }}" @if($positionId == $position->id) selected @endif> {{ $position->name }} ({{ $position->short }}) </option>
                                @endforeach
                                </select>
                            </td>

                            <td>
                                <input  class="form-control" type="number" name="player[{{ $player->id }}][number]" class="w-100" value="@if($player->matchHasPlayer){{ $player->matchHasPlayer->number_used }}@else{{ $player->number }}@endif"> </input> </p>
                            </td>

                            <td>
                                <input class="form-control" type="checkbox" name="player[{{ $player->id }}][present]" value="1" @if($player->matchHasPlayer && $player->matchHasPlayer->present == 0) @else checked @endif></input>
                            </td>

                            <td>
                                <input class="form-control" type="number" name="player[{{ $player->id }}][payed]" value="@if($player->matchHasPlayer){{ $player->matchHasPlayer->payed }}@endif"></input>
                            </td>

                            <td>
                                <textarea class="form-control" name="player[{{ $player->id }}][match_notes]">@if($player->matchHasPlayer){{ $player->matchHasPlayer->match_notes }}@endif</textarea>
                            </td>
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
                    <input type="submit" value="Cadastrar Jogadores" class="btn btn-success"></input>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
