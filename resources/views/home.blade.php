@extends('layouts.adminlte')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1> Painel Principal </h1>
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

    @if(!\Illuminate\Support\Facades\Auth::user()->name)
        <div class="col-md-6 col-lg-4 col-12">
            <div class="alert alert-danger"> Atualize seus dados cadastrais </div>
        </div>
    @endif

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
    @if(count($teamsYouJoin) > 0)
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header card-outline card-dark">
                <h1> Times que você participa </h1>
            </div>

            <div class="card-body">
                @foreach($teamsYouJoin as $teamInfo)
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
        </div>
    </div>
    @endif

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
