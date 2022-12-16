@extends('layouts.adminlte')

@section('content')

    <div class="card">
        <div class="card-header">
            <h1 class="text-center"> {{ $teamInfo->name }} </h1>
        </div>

        <div class="card-body">
            <div class="row">
                @if($teamInfo->header)
                <div class="col-12">
                    <img src="{{ asset('storage/' . $teamInfo->header) }}" class="img w-100"></img>
                </div>
                @endif

                <div class="col-md-6 col-12 mt-3">
                    @if($teamInfo->logo)
                    <img src="{{ asset('storage/' . $teamInfo->logo) }}" class="img w-100"></img>
                    @else
                        <div class='alert alert-danger'> Esse time não cadastrou uma logo </div>
                    @endif

                    <div class="small-box bg-primary mt-3">
                        <div class="inner">
                            <h3>{{ $countPlayersInTeam }}</h3>
                            <p>Jogadores ativos</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $countMatches }}</h3>
                            <p>Partidas registradas</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="btn btn-success text-center w-100"> Ver Partidas </a>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    @if(!$userInTeam)
                        <a href="#" class="btn btn-success w-100"> + Entrar no time </a> 
                    @endif
                    <div class="callout callout-info mt-3 shadow">
                        <h5> Criado por </h5>
                        <p> {{ $teamInfo->owner->name ?? 'Nome não cadastrado'}} </p>
                    </div>

                    <div class="callout callout-info shadow">
                        <h5> Cidade / Estado </h5>
                        <p> {{ $teamInfo->city->name }} / {{ $teamInfo->city->state->short ?? '' }} </p>
                    </div>

                    <div class="callout callout-info shadow">
                        <h5> Descrição </h5>
                        <p> {!! $teamInfo->description !!} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
