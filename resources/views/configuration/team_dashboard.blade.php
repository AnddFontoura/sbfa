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
    <div class="col-md-3 col-12 mt-3">
        <h5> {{ $team->name}} </h5>
        <p> {{$team->city->name}} ({{$team->city->state->name}}/{{ $team->city->state->short }})
    </div>
    <div class="col-md-8 col-12 text-center mt-3">
        <div class="btn-group">
            <a href="{{ route('team_has_player.create', $team->id) }}" class="btn btn-success">Incluir jogador</a>
            <a href="#" class="btn btn-primary">Incluir Partida</a>
            <a href="#" class="btn btn-warning">Incluir Fluxo de Caixa</a>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
        <div class="card">
            <div class="card-header">
                Lista de Jogadores
            </div>

            <div class="card-body  p-0 m-0">
                @if(count($teamHasPlayers) == 0)
                <div class="alert alert-success m-3">
                    Ainda não existem jogadores adicionados. Adicione um jogador <a href="{{ route('team_has_player.create', $team->id) }}"> clicando aqui </a>
                </div>
                @else
                <table class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th> Posição </th>
                            <th> Nome </th>
                            <th> Número </th>
                            <th class='text-right'> Opções </th>
                        </tr>
                    </thead>
                    @foreach($teamHasPlayers as $teamPlayer)
                    <tr>
                        <td> {!! $teamPlayer->position->icon !!} </td>
                        <td> {{ $teamPlayer->name }} <br> @if($teamPlayer->nickname) <p class='text-muted'> ({{ $teamPlayer->nickname}}) </p> @endif </td>
                        <td> {{ $teamPlayer->number }}</td>
                        <td class='text-right'>
                            <div class="btn-group">
                                <a href="{{ route('team_has_player.view', [$team->id, $teamPlayer->id]) }} " class="btn btn-lg btn-secondary" title="Visualizar"> <i class="fas fa-search-plus"></i> </a>
                                <a href="{{ route('team_has_player.edit', [$team->id, $teamPlayer->id]) }} " class="btn btn-lg btn-warning" title="Editar"> <i class="fas fa-edit"></i> </a>
                                <div class="btn btn-lg btn-success btnInvitePlayer" data-playerid="{{ $teamPlayer->id }}" title="Convidar Jogador por e-mail"> <i class="fas fa-envelope"></i> </div>
                                <div class="btn btn-lg btn-danger btnDelete" data-playerid="{{ $teamPlayer->id }}" title="Deletar"> <i class="fas fa-user-times"></i> </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
        <div class="card  bg-danger text-center">
            <div class="card-header">
                Caixa do time
            </div>

            <div class="card-body">
                <h1> R$ 0,00 </h1>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                Últimos jogos
            </div>

            <div class="card-body">
                @if(!$lastMatches)
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th> Time Mandante </th>
                            <th> </th>
                            <th> X </th>
                            <th> </th>
                            <th> Time Visitante </th>
                            <th> Opções </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($lastMatches as $match)
                        <tr>
                            <td> {{ $match->homeTeam->name ?? $match->home_team_name }}</td>
                            <td> {{ $match->home_score }}</td>
                            <td> x </td>
                            <td> {{ $match->visitor_score }}</td>
                            <td> {{ $match->visitorTeam->name ?? $match->visitor_team_name }} </td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-danger"> Nenhum jogo cadastrado, <a href="{{ route('matches.create', $team->id) }}"> clique aqui para cadastrar um </a> </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('page_js')
<script>
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