@extends('layouts.adminlte')

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('matches') }}" method="GET">
                <section class="card">
                    <div class="card-header">
                        Filtrar partidas
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="teamName"> Nome parcial de um time </label>
                                    <input class="form-control" type="text" min="1" max="200" placeholder="Nome do time" name="teamName" value="{{ Request::get('teamName') ?? old('teamName') }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="matchCity">Cidades</label>
                                    <select name="matchCity" class='select2 w-100' id="matchCity">
                                        <option value="0"> --- Escolha uma cidade ---</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if(Request::get('teamCity') == $city->id) selected @endif>
                                                {{ $city->name }} ({{ $city->state->name }}/{{ $city->state->short }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="matchState">Estados</label>
                                    <select name="matchState" class='select2 w-100' id="matchState">
                                        <option value="0"> --- Escolha um estado ---</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" @if(Request::get('teamState') == $state->id) selected @endif>
                                                {{ $state->name }} ({{ $state->short }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="matchStatus">Exibir Partidas</label>
                                    <select name="matchStatus" class='select2 w-100' id="matchStatus">
                                        <option value="0"> --- Todas ---</option>
                                        <option value="-1"> Encerradas </option>
                                        <option value="1"> Futuras </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="teamName"> Times que eu participo? </label>
                                    <input class="form-control" type="checkbox" name="myTeams" value="1" @if(Request::get('myTeams') == 1) checked @endif>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <input type="submit" class="btn btn-success" value="Filtrar partidas">
                    </div>
                </section>
            </form>
        </div>

        @if(count($matches) > 0)
            @foreach($matches as $matchInfo)
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 text-center" style="height: 100px;">
                                    @if(!empty($matchInfo->homeTeam->logo))
                                        <img class="img h-100 border-1" src="{{ asset('storage/' . $matchInfo->homeTeam->logo) }}" alt="Logo do Time">
                                    @endif
                                </div>

                                <div class="col-2 text-center">
                                    <h1>  </h1>
                                </div>

                                <div class="col-5 text-center"  style="height: 100px;">
                                    @if(!empty($matchInfo->visitorTeam->logo))
                                        <img class="img h-100 border-1" src="{{ asset('storage/' . $matchInfo->visitorTeam->logo) }}" alt="Logo do Time">
                                    @endif
                                </div>

                                <div class="col-5 text-center">
                                    <p> {{ $matchInfo->homeTeam->name ?? $matchInfo->home_team_name }} </p>
                                </div>

                                <div class="col-2 text-center">
                                    <h1>  </h1>
                                </div>

                                <div class="col-5 text-center">
                                    <p> {{ $matchInfo->visitorTeam->name ?? $matchInfo->visitor_team_name }} </p>
                                </div>

                                <div class="col-5 text-center">
                                     <h2> {{ $matchInfo->home_score }} </h2>
                                </div>

                                <div class="col-2 text-center">
                                    <h1> X </h1>
                                </div>

                                <div class="col-5 text-center">
                                    <h2> {{ $matchInfo->visitor_score }} </h2>
                                </div>

                                <div class="col-12 text-center">
                                    {{ $matchInfo->match_datetime->format('d/m/Y H:i') }}
                                </div>

                                <div class="col-12 text-center">
                                    {{ $matchInfo->city->name }} ({{  $matchInfo->city->state->short }})
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <a href="{{ route('matches.view', $matchInfo->id) }}" class="btn btn-lg btn-secondary mt-1" title="Visualizar dados gerais da partida"> <i class="fas fa-eye"></i> </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        <div class="col-12">
            <div class="alert alert-danger w-100"> Nenhum jogo cadastrado no momento </div>
        </div>
        @endif
    </div>
@endsection
