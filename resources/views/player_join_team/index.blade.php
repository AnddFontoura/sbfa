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

    <form action="{{ route('players_joins_teams', [$team->id]) }}" method="GET">
        <section class="card">
            <div class="card-header">
                Filtrar Jogadores
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-lg-3">
                        <div class="form-group">
                            <label for="playerName"> Nome do Jogador </label>
                            <input class="form-control" type="text" min="1" max="200" placeholder="Nome do time" name="teamName" value="{{ Request::get('teamName') ?? old('teamName') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <input type="submit" class="btn btn-success" value="Filtrar times">
            </div>
        </section>
    </form>

    @if(count($playersRequests) == 0)
        <div class="alert alert-success m-3">
            Nenhum jogador pediu registro em seu time.
        </div>
    @else
        <div class="card">
            <div class="card-body pr-0 pl-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome do Jogador</th>
                            <th>Status do Pedido</th>
                            <th>Opções</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($playersRequests as $player)
                        <tr>
                            <td>
                                <p> {{ $player->user->name }} </p>
                                <h6 class="text-muted"> {{ $player->user->profile->nickname ?? '' }} </h6>
                            </td>

                            <td>
                                @switch($player->status)
                                    @case(0)
                                        <span class="badge badge-primary"> Aguardando </span>
                                        @break

                                    @case(1)
                                        <span class="badge badge-success"> Aprovado </span>
                                        @break

                                    @case(-1)
                                        <span class="badge badge-danger"> Recusado </span>
                                        @break
                                @endswitch
                            </td>

                            <td>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <div class="card-footer">
                {{ $playersRequests->appends(request()->query())->links() }}
            </div>
        </div>
@endsection
