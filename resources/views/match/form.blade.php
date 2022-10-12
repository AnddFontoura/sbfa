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
            @csrf
            <div class="card">
                <div class="card-header">
                    Dados da partida
                </div>

                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    @endif

                    <div class="row">

                        <div class="col-12">
                            <h1> Informações dos Times </h1>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <label for="homeOrVisitorLabel">Seu time é o mandante ou visitante?</label> <br>
                            <div class="custom-control custom-radio ">
                                <input type="radio" name="homeOrVisitor" value="home" class="custom-control-input" id="customRadioHome" checked> <label for="customRadioHome" class="custom-control-label"> Mandante </label> </input>
                            </div>

                            <div class="custom-control custom-radio ">
                                <input type="radio" name="homeOrVisitor" value="visitor" class="custom-control-input" id="customRadioVisitor"> <label for="customRadioVisitor" class="custom-control-label"> Visitante </label> </input>
                            </div>
                        </div>

                        <div class="form-group col-lg-6 col-md-3 col-sm-12 mt-3">
                            <label for="matchEnemyName">Nome do adversário</label>
                            <input type="text" name="enemyTeamName" class="form-control is-warning" id="matchEnemyName" placeholder="Nome do Time Adversario" value="@if($match){{ $match->nickname }}@else{{ old('enemyTeamName') }}@endif" required>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-12 mt-3">
                            <label for="myTeamScore">Placar do seu time</label>
                            <input type="number" name="myTeamScore" class="form-control mb-3" id="myTeamScore" placeholder="Placar do seu time" value="@if($match){{ $match->number }}@else{{ old('myTeamScore') }}@endif">
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-12 mt-3">
                            <label for="myTeamScore">Placar do time Adversário</label>
                            <input type="number" name="enemyTeamScore" class="form-control mb-3" id="enemyTeamScore" placeholder="Placar do time adversário" value="@if($match){{ $match->number }}@else{{ old('enemyTeamScore') }}@endif">
                        </div>

                        <div class="col-12">
                            <h1> Informações do Confronto </h1>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-12 mt-3">
                            <label for="matchCity">Cidade do confronto</label>
                            <select name="city_id" class="select2 w-100">
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}" @if($match && $match->city_id == $city->id) selected @endif> {{ $city->name }} ({{ $city->state->short }}) </option>
                                @endforeach
                            </select>

                            <label for="matchDateTime" class="mt-3">Data e horário do confronto</label>
                            <input type="datetime-local" name="match_datetime" class="form-control" id="matchDateTime" placeholder="dd/mm/yyyy h:i:s" value="@if($match){{ $match->match_datetime }}@else{{ old('match_datetime') }}@endif"> </textarea>

                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-12 mt-3">
                            <label for="matchAddress">Endereço do Confronto</label>
                            <textarea style="height: 125px" name="match_address" class="form-control" id="matchAddress" value="@if($match){{ $match->match_address }}@else{{ old('match_address') }}@endif"> </textarea>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <input type="submit" class="btn btn-success" value="@if($match) Atualizar @else Cadastrar @endif Partida"></input>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection