@extends('layouts.auth')

@section('content')

<div class="login-box m-auto mt-3">

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <b>SBFA</b>
        </div>
        <div class="card-body">
            <form action="{{ route('login') }}" method="post">
                @csrf
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block"> Logar </button>
                    </div>

                    <div class="col-6">
                        <a class="btn btn-success btn-block" href="{{ route('register') }}"> Cadastrar </a>
                    </div>
                </div>
            </form>

            @if (Route::has('password.request'))
            <p class="mb-1 mt-3">
                <a href="{{ route('password.request') }}">Esqueci minha senha</a>
            </p>
            @endif
        </div>

    </div>

</div>

@endsection