@extends('layouts.auth')

@section('content')
<div class="login-box">
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg"> Esqueceu sua senha? Digite seu e-mail e se houver um cadastro com ele enviaremos por email um link para troca</p>
            <form action="{{ route('password.email') }}" method="post">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Requisitar troca de senha</button>
                    </div>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </form>
            <p class="mt-3 mb-1 mt-3">
                <a href="{{ route('login') }}">Login</a>
            </p>
            <p class="mb-0 mt-3">
                <a href="{{ route('register') }}" class="text-center">Cadastrar</a>
            </p>
        </div>

    </div>
</div>

@endsection