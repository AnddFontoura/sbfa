@extends('layouts.adminlte')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1> Time </h1>
            </div>
            <div class="col-sm-6 text-right">
                @if($team->owner_id == Auth::id())<a href="{{ route('teams.edit', $team->id) }}" class="btn btn-warning"> Editar Time </a>@endif
                <a href="{{ route('teams.create') }}" class="btn btn-success"> Criar Time </a>
                <a href="{{ route('teams') }}" class="btn btn-info"> Listar Time </a>
            </div>
        </div>
    </div>
</section>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"> <b> {{ $team->name }} </b> </h3>
        </div>

        <div class="card-body">
            <div class="row">
                @if($team->header)
                <div class="col-12">
                    <img src="{{ asset('storage/' . $team->header) }}" class="img w-100"></img>
                </div>
                @endif

                <div class="col-md-6 col-12">
                    @if($team->logo)
                    <img src="{{ asset('storage/' . $team->logo) }}" class="img w-100"></img>
                    @else 
                        <div class='alert alert-danger'> Esse time não cadastrou uma logo </div>
                    @endif
                </div>

                <div class="col-md-6 col-12">
                    <div class="callout callout-info mt-3">
                        <h5> Criado por </h5>
                        <p> {{ $team->owner->name ?? ''}} </p>
                    </div>
                    
                    <div class="callout callout-info">
                        <h5> Cidade </h5>
                        <p> {{ $team->city->name }} / {{ $team->city->state->short ?? '' }} </p>
                    </div>
                    
                    <div class="callout callout-info">
                        <h5> Descrição </h5>
                        <p> {!! $team->description !!} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection