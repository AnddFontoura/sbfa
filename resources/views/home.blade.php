@extends('layouts.adminlte')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1> Dashboard - Página principal </h1>
            </div>
        </div>
    </div>
</section>

<div class="row mt-3">
    @if(!$userHasValidEmail)
    <div class="col-12">
        <div class="alert alert-danger">
            Verifique seu e-mail para ter acesso completo ao sistema.

            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-primary"> Clique aqui para verificar </button>.
            </form>
        </div>
    </div>
    @endif
    <div class="col-md-6 col-lg-4 col-12">
        <div class="alert alert-danger"> Atualize seus dados cadastrais </div>
    </div>

    <div class="col-md-6 col-lg-4 col-12">
        @if(count($playerInvitedToAnyTeam) > 0)
            @foreach($playerInvitedToAnyTeam as $invite)
                <div class="alert alert-warning mt-3">
                    <p class="text-white"> O time <b>{{ $invite->teamHasPlayer->team->name }}</b> de <b> {{ $invite->teamHasPlayer->team->city->name }}/{{ $invite->teamHasPlayer->team->city->state->short}} </b> convidou você para ser parte do elenco, deseja participar? </p>
                    <div href="{{ route('players_invited.yes', $invite->id) }}" class="btn btn-lg btn-success mt-3 mr-3 btnAcceptInvite" data-inviteid="{{ $invite->id }}"> <i class="fas fa-check-square"></i> Sim </div>
                    <div href="{{ route('players_invited.no', $invite->id) }}" class="btn btn-lg btn-danger mt-3 mr-3 btnRefuseInvite" data-inviteid="{{ $invite->id }}"> <i class="fas fa-window-close"></i> Não </div>
                    <a href="{{ route('teams.view', $invite->teamHasPlayer->id) }}" class="btn btn-lg btn-info mt-3"> <i class="fas fa-eye"></i> Ver time </a>
                </div>
            @endforeach
        @else
            <div class="alert alert-secondary"> Nenhum convite para times no momento </div>
        @endif
    </div>

    <div class="col-md-6 col-lg-4 col-12">
        <div class="alert alert-secondary"> Nenhum convite para jogos no momento </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $countPlayers }}</h3>
                <p>Jogadores Cadastrados</p>
            </div>

            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>

            <a href="#" class="small-box-footer">Ver lista <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $countTeams }}</h3>
                <p>Times Cadastrados</p>
            </div>

            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>

            <a href="#" class="small-box-footer">Ver lista <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $countMatches }}</h3>
                <p>Partidas que acontecerão</p>
            </div>

            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>

            <a href="#" class="small-box-footer">Ver lista <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!--div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <b> Últimos Jogos </b>
            </div>

            <div class="card-body">
                <table class="table stripped">
                    <thead>
                        <tr>
                            <th> Mandante </th>
                            <th> </th>
                            <th> X </th>
                            <th> </th>
                            <th> Visitante </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td> Ibis </td>
                            <td> 5 </td>
                            <td> X </td>
                            <td> 3 </td>
                            <td> <b> Tabajara </b> </td>
                        </tr>

                        <tr>
                            <td> Mandaguaçu </td>
                            <td> 2 </td>
                            <td> X </td>
                            <td> 5 </td>
                            <td> <b> Tabajara </b> </td>
                        </tr>

                        <tr>
                            <td> <b> Tabajara </b> </td>
                            <td> 6 </td>
                            <td> X </td>
                            <td> 0 </td>
                            <td> Sua Mãe </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <b> Próximos Jogos </b>
            </div>

            <div class="card-body">
                <table class="table stripped">
                <thead>
                    <tr>
                        <th> Mandante </th>
                        <th> X </th>
                        <th> Visitante </th>
                        <th> Data </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td> Ibis </td>
                        <td> X </td>
                        <td> <b> Tabajara </b> </td>
                        <td> 22/02/2022 </td>
                    </tr>

                    <tr>
                        <td> Mandaguaçu </td>
                        <td> X </td>
                        <td> <b> Tabajara </b> </td>
                        <td> 09/10/2023 </td>
                    </tr>

                    <tr>
                        <td> <b> Tabajara </b> </td>
                        <td> X </td>
                        <td> Sua Mãe </td>
                        <td> 07/11/2023 </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div-->
@endsection

@section('page_js')
<script>
    $('.btnAcceptInvite').on('click', function() {
        var inviteId = $(this).data('inviteid');

        Swal.fire({
            title: 'Atenção!',
            text: 'Você está prestes a aceitar um convite. Você terá acesso a algumas informações desse time ao aceitar. Deseja continuar?',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, aceitar',
            cancelButtonText: 'Não, cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var request = $.ajax({
                    url: "{{ url('players-invited/yes') }}",
                    method: "POST",
                    data: {
                        id: inviteId,
                    },
                    dataType: "json"
                });
                request.done(function() {
                    Swal.fire({
                            title: 'Pronto!',
                            text: 'Você aprovou o convite',
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
                        'Algo deu errado ao aprovar esse convite, tente novamente mais tarde.',
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

    $('.btnRefuseInvite').on('click', function() {
        var inviteId = $(this).data('inviteid');

        Swal.fire({
            title: 'Atenção!',
            text: 'Você está prestes a recusar um convite. Você não terá acesso a algumas informações desse time ao recusar. Deseja continuar?',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, recusar',
            cancelButtonText: 'Não, cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var request = $.ajax({
                    url: "{{ url('players-invited/no') }}",
                    method: "POST",
                    data: {
                        id: inviteId,
                    },
                    dataType: "json"
                });
                request.done(function() {
                    Swal.fire({
                            title: 'Pronto!',
                            text: 'Você recusou o convite',
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
                        'Algo deu errado ao recusar esse convite, tente novamente mais tarde.',
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
