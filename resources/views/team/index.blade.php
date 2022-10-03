@extends('layouts.adminlte')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1> Times </h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('teams.create') }}" class="btn btn-info"> Criar Time </a>
            </div>
        </div>
    </div>
</section>

<div class="col-12">
    @if(count($teams) == 0)
    <div class="alert alert-success m-3">
        Ainda não existem times criados. <a href="{{ route('teams.create') }}"> Que tal criar um agora? </a>
    </div>
    @else
    <div class="row mt-3 text-left">
        @foreach($teams as $team)
        <div class="col-md-3 col-lg-2 col-sm-12 d-flex">
            <div class="card shadow  w-100">
                <div class="card-body text-center flex-fill">
                    <a href="{{ route('teams.view', $team->id) }}">
                        <h5> {{ $team->name }} </h5>
                        @if($team->logo)
                            <img src="{{ asset('storage/' . $team->logo) }}" class="img w-100"></img>
                        @endif
                    </a>
                </div>

                @if($team->owner_id == Auth::id())
                <div class="card-footer text-center bg-secondary">
                    <a href="#" title="Partidas" class="btn btn-warning"> P </a>
                    <a href="#" title="Jogadores" class="btn btn-info"> J </a>
                    <a href="#" title="Financeiro" class="btn btn-success"> F </a>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if(count($teams) > 20)
    {{ $teams->links() }}
    @endif
</div>

</div>
@endsection