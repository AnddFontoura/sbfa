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

<div class="row mt-3">
    <div class="col-12">
        <form action="@if($player) {{ route('team_has_player.update', [$team->id, $player->id]) }} @else {{ route('team_has_player.save', $team->id) }} @endif" method='POST'>
            @csrf
            <div class="card">
                <div class="card-header">
                    Dados do Jogador
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h1> Informações de Camiseta </h1>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                            <label for="teamName">Nome do Jogador</label>
                            <input type="text" name="name" class="form-control is-warning" id="teamName" placeholder="Nome do jogador" value="@if($player){{ $player->name }}@else{{ old('name') }}@endif" required>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                            <label for="teamNickName">Apelido do Jogador</label>
                            <input type="text" name="nickname" class="form-control is-warning" id="teamNickName" placeholder="Apelido do jogador" value="@if($player){{ $player->nickname }}@else{{ old('nickname') }}@endif" required>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                            <label for="teamNumber">Número do jogador</label>
                            <input type="number" name="number" class="form-control mb-3" id="teamNumber" placeholder="Número no time" value="@if($player){{ $player->number }}@else{{ old('number') }}@endif">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                            <label for="teamPosition">Posição do jogador</label>
                            <select name="position_id" class="select2 w-100  is-warning">
                                @foreach($gamePositions as $position)
                                <option value="{{ $position->id }}" @if($player && $player->position_id == $position->id) selected @endif> {{ $position->name }} ({{ $position->short }}) </option>
                                @endforeach
                            </select>
                            <p class="m-1"> <a href="https://pt.wikipedia.org/wiki/Posi%C3%A7%C3%B5es_no_futebol" target="_blank"> Saiba mais </a> </p>
                        </div>

                        <div class="col-12">
                            <h1> Informações Técnicas do Jogador </h1>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                            <label for="playerBirthDate">Data de Nascimento</label>
                            <input type="date" name="birthday" class="form-control" id="playerBirthDate" placeholder="xx/xx/xxxx" value="@if($player){{ $player->birthday }}@else{{ old('birthday') }}@endif">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                            <label for="playerWeight">Peso (kg)</label>
                            <input type="number" name="weight" class="form-control" id="playerWeight" placeholder="xxxx" value="@if($player){{ $player->weight }}@else{{ old('weight') }}@endif">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                            <label for="playerHeight">Altura (cm)</label>
                            <input type="number" name="height" class="form-control" id="playerHeight" placeholder="xxx" value="@if($player){{ $player->height }}@else{{ old('height') }}@endif">
                        </div>

                    </div>
                </div>

                <div class="card-footer text-right">
                    <input type="submit" class="btn btn-success" value="@if($player) Atualizar @else Cadastrar @endif Jogador"></input>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection