@extends('layouts.adminlte')

@section('content')

    <div class="col-12">
        <form action="{{ route('profile.save') }}" method="POST" enctype="multipart/form-data">
            @if($errors->any())
                {{ $errors }}
            @endif

            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> Dados do Perfil </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-3">
                            <label for="userIsPlayer">Jogador? (Exibe na lista de jogadores)</label>
                            <input type="checkbox" name="userIsPlayer" class="form-control" id="userIsPlayer" value="1" @if(isset($user->profile) && $user->profile->is_player) checked @endif>
                        </div>

                        <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-3">
                            <label for="userPhoto">Foto de Perfil</label>
                            <input type="file" name="userPhoto" class="form-control" id="userPhoto">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-3">
                            <label for="userName">Nome completo</label>
                            <input type="text" name="userName" class="form-control" id="userName" placeholder="Nome completo" value="@if(isset($user)) {{ $user->name }}@else{{ old('name') }}@endif">
                        </div>

                        <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-3">
                            <label for="userNickName">Apelido</label>
                            <input type="text" name="userNickName" class="form-control" id="userNickName" placeholder="Apelido (caso queira)" value="@if(isset($user->profile)) {{ $user->profile->nickname }}@else{{ old('userNickName') }}@endif">
                        </div>

                        <div class="form-group col-sm-12 col-md-4 col-lg-4 mt-3">
                            <label for="userWeight">Peso (kg)</label>
                            <input type="number" name="userWeight" class="form-control" id="userWeightName" value="@if(isset($user->profile)){{ $user->profile->weight }}@else{{ old('userWeightName') }}@endif">
                        </div>

                        <div class="form-group col-sm-12 col-md-4 col-lg-4 mt-3">
                            <label for="userHeight">Altura (cm)</label>
                            <input type="number" name="userHeight" class="form-control" id="userHeight"  value="@if(isset($user->profile)){{ $user->profile->height }}@else{{ old('userHeight') }}@endif">
                        </div>

                        <div class="form-group col-sm-12 col-md-4 col-lg-4 mt-3">
                            <label for="userCellphone">Celular</label>
                            <input type="text" name="userCellphone" pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" class="form-control" id="userCellphone" placeholder="(xx) 12345-1234" value="@if(isset($user->profile)){{ $user->profile->mobile_number }}@else{{ old('userCellphone') }}@endif">
                        </div>

                        <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-3">
                            <label for="userBirthdate">Nascimento</label>
                            <input type="date" name="userBirthdate" class="form-control" id="userBirthdate" value="@if(isset($user->profile)){{ $user->profile->birthdate }}@else{{ old('userBirthday') }}@endif">
                        </div>

                        <div class="col-md-6 col-sm-12 col-lg-6 mt-3">
                            <div class="form-group">
                                <label for="userCity">Cidades</label>
                                <select name="userCity" class='select2 w-100' id="userCity">
                                    <option value="0"> --- Escolha uma cidade ---</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}" @if(isset($user->profile) && $user->profile->city_id == $city->id) selected @endif>
                                            {{ $city->name }} ({{ $city->state->name }}/{{ $city->state->short }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-12 mt-3">
                            <label for="userDescription">Sobre você</label>
                            <textarea name="userDescription" class="form-control summernote" id="userDescription">@if(isset($user->profile)) {{ $user->profile->description }}@else{{ old('userDescription') }}@endif</textarea>
                        </div>

                        <div class="form-group col-12">
                            <label for="userPositions">Posições que joga</label>
                            <div class="row">
                                @foreach($gamePositions as $key => $position)
                                    <div class=" col-md-3 col-lg-3 col-sm-12">
                                        <div class="custom-control custom-checkbox">
                                            <input name="userPositions[]" class="custom-control-input" type="checkbox" id="customCheckbox{{ $key }}" value="{{ $position->id }}" @if(!empty($selectedPositions) && in_array($position->id, $selectedPositions)) checked @endif>
                                            <label for="customCheckbox{{ $key }}" class="custom-control-label">{{ $position->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <input type="submit" class='btn btn-success' value="Atualizar perfil">
                </div>
            </div>
        </form>
    </div>

@endsection
