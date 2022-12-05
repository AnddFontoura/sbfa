@extends('layouts.adminlte')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Times </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('teams.create') }}" class="btn btn-info"> Criar Time </a>
                </div>
            </div>
        </div>
    </section>

    <form action="{{ route('teams') }}" method="GET">
        <section class="card">
            <div class="card-header">
                Filtrar times
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-lg-3">
                        <div class="form-group">
                            <label for="teamName"> Nome do Time </label>
                            <input class="form-control" type="text" min="1" max="200" placeholder="Nome do time" name="teamName" value="{{ Request::get('teamName') ?? old('teamName') }}">
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-lg-3">
                        <div class="form-group">
                            <label for="teamCity">Cidades</label>
                            <select name="teamCity" class='select2 w-100' id="teamCity">
                                <option value="0"> --- Escolha uma cidade ---</option>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}" @if(Request::get('teamCity') == $city->id) selected @endif>
                                        {{ $city->name }} ({{ $city->state->name }}/{{ $city->state->short }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-lg-3">
                        <div class="form-group">
                            <label for="teamState">Estados</label>
                            <select name="teamState" class='select2 w-100' id="teamState">
                                <option value="0"> --- Escolha um estado ---</option>
                                @foreach($states as $state)
                                    <option value="{{$state->id}}" @if(Request::get('teamState') == $state->id) selected @endif>
                                        {{ $state->name }} ({{ $state->short }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-lg-3">
                        <div class="form-group">
                            <label for="teamName"> Times que eu participo? </label>
                            <input class="form-control" type="checkbox" name="myTeams" value="1" @if(Request::get('myTeams') == 1) checked @endif>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <input type="submit" class="btn btn-success" value="Filtrar times">
            </div>
        </section>
    </form>

    @if(count($teams) == 0)
    <div class="alert alert-success m-3">
        Ainda não existem times criados. <a href="{{ route('teams.create') }}"> Que tal criar um agora? </a>
    </div>
    @else
    <div class="row mt-3 text-left">
        @foreach($teams as $teamInfo)
        <div class="col-md-3 col-lg-3 col-sm-12 d-flex align-items-stretch">
            <div class="card shadow w-100">
                <div class="card-body text-center flex-fill">
                    <a href="{{ route('teams.view', $teamInfo->id) }}">
                        <h5> {{ $teamInfo->name }} </h5>
                        @if($teamInfo->logo)
                            <img src="{{ asset('storage/' . $teamInfo->logo) }}" class="img w-100"></img>
                        @endif
                    </a>
                </div>

                @if($teamInfo->owner_id == Auth::id())
                <div class="card-footer text-center bg-secondary">
                    <a href="{{ route('configuration.team', $teamInfo->id) }}" title="Configurações" class="btn btn-lg btn-warning"> <i class="fas fa-cogs"></i> </a>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="card">
        <div class="card-footer">
            {{ $teams->appends(request()->query())->links() }}
        </div>
    </div>

@endsection
