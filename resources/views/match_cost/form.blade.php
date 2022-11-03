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
            <form action="{{ route('team_has_player.update', [$team->id, $match->id]) }}" method='POST'>
                @csrf
                <div class="card">
                    <div class="card-header">
                        Custos da partida
                    </div>

                    <!--
                        'match_total_cost',
                        'match_field_cost',
                        'match_referees_cost',
                        'extra_costs',
                        'extra_costs_description',
                    -->

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                                <label for="fieldCost">Custo do Campo</label>
                                <input type="number" step="any" name="match_field_cost" class="form-control is-warning" id="teamName" placeholder="Custo do campo" value="@if($matchCost){{ $matchCost->match_field_cost }}@else{{ old('match_field_cost') }}@endif" required>
                            </div>

                            <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                                <label for="fieldCost">Custo dos Árbitros</label>
                                <input type="number" step="any" name="match_referees_cost" class="form-control is-warning" id="teamName" placeholder="Custo do campo" value="@if($matchCost){{ $matchCost->match_field_cost }}@else{{ old('match_field_cost') }}@endif" required>
                            </div>

                            <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                                <label for="fieldCost">Custos Extra</label>
                                <input type="number" step="any" name="extra_costs_description" class="form-control is-warning" id="teamName" placeholder="Custo do campo" value="@if($matchCost){{ $matchCost->match_field_cost }}@else{{ old('match_field_cost') }}@endif" required>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <input type="submit" class="btn btn-success" value="@if($matchCost) Atualizar @else Cadastrar @endif Custos da Partida"></input>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
