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
    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
        <div class="card">
            <div class="card-body">
                @if(count($teamHasPlayers) == 0)
                <div class="alert alert-success m-3">
                    Ainda não existem jogadores adicionados. <a href="{{ route('team_has_player.create', $team->id) }}"> Que tal incluir um agora? </a>
                </div>
                @else
                <table class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th> Posição </th>
                            <th> Nome </th>
                            <th> Número </th>
                            <th> Opções </th>
                        </tr>
                    </thead>
                    @foreach($teamHasPlayers as $teamPlayer)
                    <tr>
                        <td> {!! $teamPlayer->position->icon !!} </td>
                        <td> {{ $teamPlayer->name }} <br> @if($teamPlayer->nickname) <p class='text-muted'> ({{ $teamPlayer->nickname}}) </p> @endif </td>
                        <td> {{ $teamPlayer->number }}</td>
                        <td>
                            <a href="{{ route('team_has_player', $team->id . '/' . $teamPlayer->id) }} " class="btn btn-xs btn-warning" title="Editar"> E </a>
                            <a href="" class="btn btn-xs btn-info" title="Ver Estatistícas"> G </a>
                            <a href="" class="btn btn-xs btn-danger" title="Deletar"> D </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12">
        <form action="@if($player) {{ route('team_has_player.update', [$team->id, $player->id]) }} @else {{ route('team_has_player.save', $team->id) }} @endif" method='POST'>
            @csrf
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Inserir novo jogador no time
                        </div>

                        <div class="card-body">
                            <div class="w-100 text-center">    
                                    <img src="{{ asset('img/mapa_posicao.jpg') }}" class='img w-50'></img>
                                    <p> <a href="https://pt.wikipedia.org/wiki/Posi%C3%A7%C3%B5es_no_futebol" target="_blank"> Saiba mais </a> </p>
                            </div>
                            <div class="form-group mt-3">
                                <label for="teamName">Nome do Jogador</label>
                                <input type="text" name="name" class="form-control" id="teamName" placeholder="Nome do jogador" value="@if($player){{ $player->name }}@else{{ old('name') }}@endif">
                            </div>

                            <div class="form-group mt-3">
                                <label for="teamNickName">Nome do Jogador</label>
                                <input type="text" name="nickname" class="form-control" id="teamNickName" placeholder="Apelido do jogador" value="@if($player){{ $player->nickname }}@else{{ old('nickname') }}@endif">
                            </div>

                            <div class="form-group mt-3">
                                <label for="teamNumber">Número do jogador</label>
                                <input type="number" name="number" class="form-control mb-3" id="teamNumber" placeholder="Número no time" value="@if($player){{ $player->number }}@else{{ old('number') }}@endif">
                            </div>

                            <div class="form-group mt-3">
                                <label for="teamPosition">Posição do jogador</label>
                                <select name="position_id" class="select2 w-100">
                                    @foreach($gamePositions as $position)
                                        <option value="{{ $position->id }}" @if($player && $player->position_id == $position->id) selected @endif> {{ $position->name }} ({{ $position->short }}) </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <input type="submit" class="btn btn-success" value="Cadastrar Jogador"></input>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection