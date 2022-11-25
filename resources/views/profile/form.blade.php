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
                    <h3 class="card-title"> Editar Dados </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                            <label for="userName">Nome completo</label>
                            <input type="text" name="userName" class="form-control" id="userName" placeholder="Seu nome" value="@if(isset($user)) {{ $user->name }}@else{{ old('name') }}@endif">
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
