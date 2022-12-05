@extends('layouts.adminlte')

@section('content')


<div class="row">
    <div class="col-md-6 col-12 text-center mt-3">
        <div class="card bg-danger text-center">
            <div class="card-header">
                Caixa do time
            </div>

            <div class="card-body">
                <h1 id='financesField'> R$ 0,00 </h1>
            </div>

            <div class="card-footer">
                <a href="#" class="btn btn-danger w-100"> Acessar financeiro </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-12 mt-3">
        <a href="{{ route('teams.edit', [$team->id]) }}" class="btn btn-lg bg-primary w-100"> Editar time </a>
        <div class="row">

            <div class="col-md-6 col-12 mt-6 mt-3">
                <a class="btn btn-success w-100" href="{{ route('matches.create', $team->id) }}"> Adicionar partida </a>
            </div>

            <div class="col-md-6 col-12 mt-6 mt-3">
                <a class="btn btn-success w-100" href="{{ route('team_has_player.create', $team->id) }}"> Adicionar Jogador </a>
            </div>

            <div class="col-md-6 col-12 mt-6 mt-3">
                <a class="btn btn-warning w-100" href="#"> Lista de partidas </a>
            </div>

            <div class="col-md-6 col-12 mt-6 mt-3">
                <a class="btn btn-warning w-100" href="#"> Lista de jogadores </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card card-dark card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="teamInformation" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="teamPlayerList-tab" data-toggle="pill" href="#teamPlayerList" role="tab" aria-controls="teamPlayerList" aria-selected="true">Lista de Jogadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="teamMatchesList-tab" data-toggle="pill" href="#teamMatchesList" role="tab" aria-controls="teamMatchesList" aria-selected="false">Últimas Partidas</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="teamInformationContent">
                    <div class="tab-pane active" id="teamPlayerList" role="tabpanel" aria-labelledby="teamPlayerList-tab">
                        @if(count($teamHasPlayers) == 0)
                        <div class="alert alert-success m-3">
                            Ainda não existem jogadores adicionados. Adicione um jogador <a href="{{ route('team_has_player.create', $team->id) }}"> clicando aqui </a>
                        </div>
                        @else
                        <div class="row">
                            @foreach($teamHasPlayers as $teamPlayer)
                                <div class="col-md-4 col-lg-4 col-sm-12 mt-3 d-flex align-items-stretch">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                @if($teamPlayer->profile_picture)
                                                    <img src="{{ asset('storage/' . $teamPlayer->profile_picture) }}" class="card-img-top">
                                                @else
                                                    <img src="{{ asset('img/no-profile-photo.png') }}" class="card-img-top">
                                                @endif
                                                <div class="col-6">
                                                    <h3> Posição </h3>
                                                    <p>{!! $teamPlayer->position->icon !!} </p>
                                                </div>

                                            <div class="col-6">
                                                <h3> Número </h3>
                                                <p> {{ $teamPlayer->number }} </p>
                                            </div>

                                            <div class="col-12">
                                                <h3> Nome </h3>
                                                <p> {{ $teamPlayer->name }} </p> @if($teamPlayer->nickname) <p class='text-muted'> ({{ $teamPlayer->nickname}}) </p> @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-center">
                                        <a href="{{ route('team_has_player.view', [$team->id, $teamPlayer->id]) }} " class="btn btn-lg btn-secondary mt-1" title="Visualizar"> <i class="fas fa-search-plus"></i> </a>
                                        <a href="{{ route('team_has_player.edit', [$team->id, $teamPlayer->id]) }} " class="btn btn-lg btn-warning mt-1" title="Editar"> <i class="fas fa-edit"></i> </a>
                                        <div class="btn btn-lg btn-success btnInvitePlayer mt-1" data-playerid="{{ $teamPlayer->id }}" title="Convidar Jogador por e-mail"> <i class="fas fa-envelope"></i> </div>
                                        <div class="btn btn-lg btn-danger btnDelete mt-1" data-playerid="{{ $teamPlayer->id }}" title="Deletar"> <i class="fas fa-user-times"></i> </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="teamMatchesList" role="tabpanel" aria-labelledby="teamMatchesList-tab">
                        @if(count($lastMatches) > 0)
                            <div class="row">
                                @foreach($lastMatches as $matchInfo)
                                    <div class="col-md-6 col-lg-6 col-sm-12 d-flex align-items-stretch">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-5 text-center">
                                                        <p> {{ $matchInfo->homeTeam->name ?? $matchInfo->home_team_name }} </p>
                                                        <h2> {{ $matchInfo->home_score }} </h2>
                                                    </div>
                        <div class="row">
                            @foreach($lastMatches as $matchInfo)
                            <div class="col-md-6 col-lg-6 col-sm-12 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-5 text-center">
                                                <p> {{ $matchInfo->homeTeam->name ?? $matchInfo->home_team_name }} </p>
                                                <h2> {{ $matchInfo->home_score }} </h2>
                                            </div>

                                            <div class="col-2 text-center">
                                                <h1> X </h1>
                                            </div>

                                            <div class="col-5 text-center">
                                                <p> {{ $matchInfo->visitorTeam->name ?? $matchInfo->visitor_team_name }} </p>
                                                <h2> {{ $matchInfo->visitor_score }} </h2>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-center">
                                        <a href="{{ route('matches.view', $matchInfo->id) }}" class="btn btn-lg btn-secondary mt-1" title="Visualizar dados gerais da partida"> <i class="fas fa-eye"></i> </a>
                                        <a href="{{ route('matches.edit', [$team->id, $matchInfo->id]) }}" class="btn btn-lg btn-warning mt-1" title="Editar Informações da Partida"> <i class="fas fa-edit"></i> </a>
                                        <a href="{{ route('matches.player-at.create', [$team->id, $matchInfo->id]) }}" class="btn btn-lg btn-success mt-1" title="Vincular Jogadores"> <i class="fas fa-users"></i> </a>
                                        <a href="{{ route('matches.statistics.create', [$team->id, $matchInfo->id]) }}" class="btn btn-lg btn-primary mt-1" title="Editar Estatisticas dos jogadores"> <i class="fas fa-chart-bar"></i> </a>
                                        <a href="{{ route('matches.cost.create', [$team->id, $matchInfo->id]) }}" class="btn btn-lg bg-indigo text-white mt-1" title="Editar financeiro da partida"> <i class="fas fa-coins"></i> </a>
                                        <div class="btn btn-lg btn-danger btnDeleteMatch mt-1" data-matchid="{{ $matchInfo->id }}" title="Deletar partida"> <i class="fas fa-minus-circle"></i> </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="alert alert-danger"> Nenhum jogo cadastrado, <a href="{{ route('matches.create', $team->id) }}"> clique aqui para cadastrar um </a> </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    @endsection

    @section('page_js')
    <script>
        $(document).ready(function() {
            getFinances({$team->id}}, "{{ config('app.url') }}")
        });

        $('.btnInvitePlayer').on('click', function() {
            var playerId = $(this).data('playerid');

            Swal.fire({
                title: 'Indique o e-mail do jogador',
                input: 'email',
                inputLabel: 'Email do Jogador',
                inputPlaceholder: 'aaaa@aaaa.a.a',
                showCancelButton: true,
                cancelButtonText: 'Não, cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var request = $.ajax({
                        url: "{{ url('players-invited/invite') }}",
                        method: "POST",
                        data: {
                            team_has_player_id: playerId,
                            email: result.value
                        },
                        dataType: "json"
                    });
                    request.done(function() {
                        Swal.fire({
                                title: 'Pronto!',
                                text: 'Convidamos esse jogador',
                                type: 'success',
                                buttons: true,
                            })
                            .then((buttonClick) => {
                                if (buttonClick) {
                                    location.reload();
                                }
                            });
                    });
                    request.fail(function() {
                        Swal.fire(
                            'Erro',
                            'Algo deu errado ao convidar esse jogador, tente novamente mais tarde.',
                            'error'
                        )
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire(
                        'Cancelado!',
                        'Nenhuma alteração realizada.',
                        'error'
                    )
                }
            });
        });

        $('.btnDelete').on('click', function() {
            var playerId = $(this).data('playerid');

            Swal.fire({
                title: 'Atenção!',
                text: 'Você está prestes a apagar um jogador. O jogador apagado não pode ser reativado. Ele continuará nas estatisticas e saldo como Jogador Deletado',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, apagar',
                cancelButtonText: 'Não, cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var request = $.ajax({
                        url: "{{ url('teams-has-players/delete') }}",
                        method: "DELETE",
                        data: {
                            id: playerId
                        },
                        dataType: "json"
                    });
                    request.done(function() {
                        Swal.fire({
                                title: 'Pronto!',
                                text: 'Apagamos esse jogador',
                                type: 'success',
                                buttons: true,
                            })
                            .then((buttonClick) => {
                                if (buttonClick) {
                                    location.reload();
                                }
                            });
                    });
                    request.fail(function() {
                        Swal.fire(
                            'Erro',
                            'Algo deu errado ao excluir esse jogador, tente novamente mais tarde.',
                            'error'
                        )
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire(
                        'Cancelado!',
                        'Nenhuma alteração realizada.',
                        'error'
                    )
                }
            });
        });
    </script>
    @endsection
