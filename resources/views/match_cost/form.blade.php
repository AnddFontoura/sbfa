@extends('layouts.adminlte')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Custos da Partida </h1>
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
            <form action="{{ route('matches.cost.save', [$team->id, $match->id]) }}" method='POST'>
                @csrf
                <div class="card">
                    <div class="card-header">
                        Custos da partida
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12 mt-3">
                                <label for="fieldCost">Custo do Campo</label>
                                <input type="number" step="any" name="match_field_cost" class="form-control is-warning" id="fieldCost" placeholder="Custo do campo" value="@if($matchCost){{ $matchCost->match_field_cost }}@else{{ old('match_field_cost') }}@endif" required>
                            </div>

                            <div class="form-group col-12 mt-3">
                                <label for="refereesCost">Custo dos Árbitros</label>
                                <input type="number" step="any" name="match_referees_cost" class="form-control" id="refereesCost" placeholder="Custo do Juíz" value="@if($matchCost){{ $matchCost->match_referees_cost }}@else{{ old('match_referees_cost') }}@endif">
                            </div>

                            <div class="form-group col-12 mt-3">
                                <label for="ExtraCosts">Custos Extra</label>
                                <input type="number" step="any" name="extra_costs" class="form-control" id="ExtraCosts" placeholder="Custo extra" value="@if($matchCost){{ $matchCost->extra_costs }}@else{{ old('extra_costs') }}@endif">
                            </div>

                            <div class="form-group col-12 mt-3">
                                <label for="extraCostDescription">Custos Extra Descrição</label>
                                <textarea name="extra_costs_description" class="form-control" id="extraCostDescription">@if($matchCost){{ $matchCost->extra_costs_description }}@else{{ old('extra_costs_description') }}@endif</textarea>
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
