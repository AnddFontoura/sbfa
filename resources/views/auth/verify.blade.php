@extends('layouts.auth')

@section('content')

    <div class="register-page">
        <div class="register-box">
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="login-box-msg"> Verificar E-mail </p>

                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Um novo e-mail de verificação foi enviado, por favor, confirme-o para continuar.
                        </div>
                    @endif
                    <p> Algumas ferramentas do sistema estão disponíveis apenas para usuários com o e-mail
                    verificado. Por favor, confirme seu e-mail e clique em 'verificar'.</p>

                    <p> Caso você não tenha recebido o e-mail: </p>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline"> Clique aqui para reenviar </button>.
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
