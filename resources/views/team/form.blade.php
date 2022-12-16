@extends('layouts.adminlte')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1> Times </h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('teams') }}" class="btn btn-info"> Listar Times </a>
            </div>
        </div>
    </div>
</section>

<div class="col-12">
    <form action="@if($team) {{ route('teams.update', $team->id) }} @else {{ route('teams.save') }} @endif" method="POST" enctype="multipart/form-data">
        @if($errors->any())
        {{ $errors }}
        @endif

        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> Cadastrar novo time </h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-3">
                        <label for="teamName">Nome do time</label>
                        <input type="text" name="name" class="form-control" id="teamName" placeholder="Nome do time" value="@if($team){{ $team->name }}@else{{ old('name') }}@endif">
                    </div>

                    <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-3">
                        <label for="teamCity">Cidade</label>
                        <select name='city_id' class='select2 w-100' id="teamCity">
                            @foreach($cities as $city)
                            <option value="{{$city->id}}" @if($team && $team->city_id == $city->id) selected @endif>
                                {{ $city->name }} ({{ $city->state->name }}/{{ $city->state->short }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group col-12 mt-3">
                        <label>Jogadores podem pedir para participar? (Você poderá aprovar/rejeitar a solicitação)</label>    
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="can_player_join" value="1" @if(isset($team->can_player_join) && $team->can_player_join == 1) checked @endif>
                            <label class="form-check-label"> Sim </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="can_player_join" value="0" @if(isset($team->can_player_join) && $team->can_player_join == 0) checked @endif>
                            <label class="form-check-label"> Não </label>
                        </div>
                    </div>

                    <div class="form-group col-12 mt-3">
                        <label for="teamDescription">Descrição do time</label>
                        <textarea name="description" class="summernote" id="teamDescription" placeholder="Cidade do time">@if($team){{ $team->description }}@else{{ old('description') }}@endif</textarea>
                    </div>

                    <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-3">
                        <label for="teamDescription">Logo do time</label> <br>
                        <input type="file" name="logo" id="teamLogo">
                    </div>

                    <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-3">
                        <label for="teamBanner">Banner do time</label> <br>
                        <input type="file" name="header" id="teamBanner">
                    </div>

                    @if($team && $team->logo)
                    <div class="form-group col-sm-12 col-md-6 col-lg-6 text-center mt-3">
                        <img src="{{ asset('storage/' . $team->logo) }}" class="img w-50"></img>
                    </div>
                    @endif

                    @if($team && $team->header)
                    <div class="form-group col-sm-12 col-md-6 col-lg-6 text-center mt-3">
                        <img src="{{ asset('storage/' . $team->header) }}" class="img w-50"></img>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class='btn btn-success'> @if($team) Atualizar @else Cadastrar @endif time </button>
            </div>
        </div>
    </form>
</div>

@endsection