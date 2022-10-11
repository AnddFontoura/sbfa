@extends('layouts.adminlte')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1> Jogador do time </h1>
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
    
    <div class="col-md-5 col-12 mt-3">
        <h5> {{ $team->name}} </h5>
        <p> {{$team->city->name}} ({{$team->city->state->name}}/{{ $team->city->state->short }})
    </div>

    <div class="col-md-6 col-12 mt-3 text-center">
        <a href="{{ route('configuration.team', $team->id) }}" class="btn btn-success"> Configuração do time </a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                            <h6> Nome do Jogador</h6>
                            <h2> {{ $player->name }} </h2>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                            <h6>Apelido do Jogador</h6>
                            <h2>{{ $player->nickname ?? '' }} <h2>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                            <h6>Número do jogador</h6>
                            <h2> {{ $player->number }} </h2>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                            <h6>Idade</h6>
                            <h2> {{ $player->age }} </h2>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                            <h6>Peso (kg)</h6>
                            <h2> {{ $player->weight }} </h2>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                            <h6>Altura (cm)</h6>
                            <h2> {{ $player->height }} </h2>
                        </div>

                    </div>
                </div>
            </div>
    </div>
</div>

@endsection