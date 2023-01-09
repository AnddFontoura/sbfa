@extends('layouts.adminlte')

@section('content')

<form action="{{ route('profile.save') }}" method="POST" enctype="multipart/form-data">

    @csrf
    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-12 mt-3">
            <div class="card">
                <div class="card-header">
                    Pedido de ingresso de: <b> {{ $playerJoinTeam->user->name ?? 'Nome não preenchido' }} </b>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-lg-6 mt-3">
                            @if ($playerJoinTeam->user->profile->photo)
                            <img src="{{ asset('storage/' . $playerJoinTeam->user->profile->photo) }}" class="card-img-top">
                            @else
                            <img src="{{ asset('img/no-profile-photo.png') }}" class="card-img-top">
                            @endif
                        </div>

                        <div class="col-md-6 col-sm-12 col-lg-6 mt-3">
                            <p class="text-muted"> Nome do Jogador </p>
                            <h3> {{ $playerJoinTeam->user->name ?? 'Nome não preenchido' }}</h3>

                            <p class="text-muted"> E-mail do jogador </p>
                            <h3> {{ $playerJoinTeam->user->email }}</h3>

                            <p class="text-muted"> Cidade/Estado do Jogador </p>
                            <h3> {{ $playerJoinTeam->user->profile->city->name ?? "Nd"}}/{{ $playerJoinTeam->user->profile->city->state->name ?? "Nd" }}</h3>

                            <p class="text-muted"> Peso e Altura </p>
                            <h3> {{ $playerJoinTeam->user->profile->weight ?? "Nd" }} kg / {{ $playerJoinTeam->user->profile->height ?? "Nd" }} cm</h3>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-center">
                    @if (isset($playerJoinTeam->user->profile->id) && $playerJoinTeam->user->profile->is_player))
                    <a href="{{ route('players.view', [$playerJoinTeam->user->profile->id]) }}" class="btn btn-primary" target="_blank"> Acessar perfil do Jogador </a>
                    @else
                    <button type="button" class="btn btn-secondary disabled"> Esse usuário não preencheu o perfil básico </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6 col-sm-12 mt-3">
            <form action="{{ route('players_joins_teams.save_changes', $playerJoinTeam->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <b> Formulário de aprovação </b>
                    </div>

                    <div class="card-body">
                        <div id="accordion">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
                                            #1 - Aprovar ou rejeitar pedido
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="collapse show" data-parent="#accordion" style="">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <span> Deseja aprovar o pedido de ingresso? </span>
                                            <select name="approveOrReject" id="approveOrReject" class="form-control">
                                                <option value="1"> Aprovar </option>
                                                <option value="-1"> Rejeitar </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <span> Caso deseje, aproveite esse espaço para explicar a razão da sua escolha </span>
                                            <textarea name="aproveOrRejectDescription" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(count($teamHasPlayer) > 0)
                            <div class="card card-primary" id="card2">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" id="accordion2">
                                            #2 - Adicionar esse usuário a algum jogador criado no time?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
                                    <div class="card-body">
                                        <div class="custom-control custom-radio mt-3">
                                            <input class="custom-control-input" type="radio" id="customRadio" name="teamHasPlayerId" value="0">
                                            <label for="customRadio" class="custom-control-label"> Não usar um jogador que existe já</label>
                                        </div>
                                        @foreach($teamHasPlayer as $key => $player)
                                        <div class="custom-control custom-radio mt-3">
                                            <input class="custom-control-input" type="radio" id="customRadio{{ $key }}" name="teamHasPlayerId" value="{{ $player->id }}" onChange="changeAccordion3()">
                                            <label for="customRadio{{ $key }}" class="custom-control-label">{!! $player->position->icon !!} [{{ $player->number ?? 00 }}] {{ $player->name }} </label>
                                        </div>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="card card-primary" id="card3">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100"data-toggle="collapse" href="#collapseThree" id="accordion3" disabled>
                                            #3 - Criar um novo perfil para esse jogador no time.
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h1> Informações de Camiseta </h1>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                                                <label for="teamName">Nome do Jogador</label>
                                                <input type="text" name="name" class="form-control is-warning" id="teamName" placeholder="Nome do jogador" value="@if($player){{ $player->name }}@else{{ old('name') }}@endif" required>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                                                <label for="teamNickName">Apelido do Jogador</label>
                                                <input type="text" name="nickname" class="form-control is-warning" id="teamNickName" placeholder="Apelido do jogador" value="@if($player){{ $player->nickname }}@else{{ old('nickname') }}@endif" required>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                                                <label for="teamNumber">Número do jogador</label>
                                                <input type="number" name="number" class="form-control mb-3" id="teamNumber" placeholder="Número no time" value="@if($player){{ $player->number }}@else{{ old('number') }}@endif">
                                            </div>

                                            <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                                                <label for="teamPosition">Posição do jogador</label>
                                                <select name="position_id" class="select2 w-100  is-warning">
                                                    @foreach($gamePositions as $position)
                                                    <option value="{{ $position->id }}" @if($player && $player->position_id == $position->id) selected @endif> {{ $position->name }} ({{ $position->short }}) </option>
                                                    @endforeach
                                                </select>
                                                <p class="m-1"> <a href="https://pt.wikipedia.org/wiki/Posi%C3%A7%C3%B5es_no_futebol" target="_blank"> Saiba mais </a> </p>
                                            </div>

                                            <div class="col-12">
                                                <h1> Informações Técnicas do Jogador </h1>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                                                <label for="playerBirthDate">Data de Nascimento</label>
                                                <input type="date" name="birthday" class="form-control" id="playerBirthDate" placeholder="xx/xx/xxxx" value="@if($player){{ $player->birthday }}@else{{ old('birthday') }}@endif">
                                            </div>

                                            <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                                                <label for="playerWeight">Peso (kg)</label>
                                                <input type="number" name="weight" class="form-control" id="playerWeight" placeholder="xxxx" value="@if($player){{ $player->weight }}@else{{ old('weight') }}@endif">
                                            </div>

                                            <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-3">
                                                <label for="playerHeight">Altura (cm)</label>
                                                <input type="number" name="height" class="form-control" id="playerHeight" placeholder="xxx" value="@if($player){{ $player->height }}@else{{ old('height') }}@endif">
                                            </div>

                                            <div class="col-12">
                                                <h1> Sobre o Jogador </h1>
                                            </div>

                                            <div class="form-group col-12">
                                                <label for="profilePicture"></label>
                                                <input type="file" name="profilePicture" class="form-control" id="profilePicture">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-success" disabled id="formSubmit">Atualizar status de ingresso</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</form>

@endsection

@section('page_js')
<script>
    $(document).ready(function() {
        $("#approveOrReject").on('change', function() {
            let selectValue = this.value;

            if (selectValue < 0) {
                /* Disable user from being created */
                $("#accordion3").prop( "disabled", true);
                $("#accordion2").prop( "disabled", true);
                $("#card2").removeClass("disabled card-primary").addClass("disable card-secondary");
                $("#card3").removeClass("disabled card-primary").addClass("disable card-secondary");
            } else {
                $("#accordion3").prop( "disabled", false);
                $("#accordion2").prop( "disabled", false);
                $("#card2").removeClass("disable card-secondary").addClass("disabled card-primary");
                $("#card3").removeClass("disable card-secondary").addClass("disabled card-primary");
            }
        });

        $("#customRadio").on('change', function() {
                $("#accordion3").prop( "disabled", false);
                $("#card3").removeClass("disable card-secondary").addClass("disabled card-primary");
                $("#formSubmit").prop("disabled", false);
        });

    })

    function changeAccordion3() {
        $("#accordion3").prop( "disabled", true);
        $("#card3").removeClass("disabled card-primary").addClass("disable card-secondary");
        $("#formSubmit").prop("disabled", false);
    }
</script>
@endsection
