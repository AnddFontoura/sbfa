@extends('layouts.adminlte')

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('players') }}" method="GET">
                <section class="card">
                    <div class="card-header">
                        Filtrar Jogadores
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="userName"> Nome parcial de um jogador</label>
                                    <input class="form-control" type="text" min="1" max="200" placeholder="Nome do time" name="userName" value="{{ Request::get('userName') ?? old('userName') }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="userCity">Cidades</label>
                                    <select name="userCity" class='select2 w-100' id="userCity">
                                        <option value="0"> --- Escolha uma cidade ---</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if(Request::get('userCity') == $city->id) selected @endif>
                                                {{ $city->name }} ({{ $city->state->name }}/{{ $city->state->short }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="userState">Estados</label>
                                    <select name="userState" class='select2 w-100' id="userState">
                                        <option value="0"> --- Escolha um estado ---</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" @if(Request::get('userState') == $state->id) selected @endif>
                                                {{ $state->name }} ({{ $state->short }})
                                            </option>
                                        @endforeach
                                    </select>
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

        @if(count($userProfiles) > 0)
            @foreach($userProfiles as $profile)
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{ asset('storage/' . $profile->photo) }}" class="card-img-top">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h4> {{ $profile->user->name }} </h4>
                                    @if($profile->nickname)
                                        <h6>{{ $profile->nickname }}</h6>
                                    @endif
                                </div>

                                @if($profile->city)
                                    <div class="col-12 mt-3">
                                        <h6>{{ $profile->city->name }} ({{$profile->city->state->short}})</h6>
                                    </div>
                                @endif

                                @if($profile->positions)
                                    <div class="col-12 mt-3 text-center">
                                        @foreach($profile->positions as $position)
                                            {!! $position->icon !!}
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <a href="{{ route('players.view', $profile->id) }}" class="btn btn-lg btn-secondary mt-1" title="Visualizar perfil"> <i class="fas fa-eye"></i> </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-danger"> Nenhum jogador cadastrado com esses parâmetros </div>
            </div>
        @endif
    </div>
@endsection
