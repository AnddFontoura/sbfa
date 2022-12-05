@extends('layouts.adminlte')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-3 col-lg-3 col-sm-12 mt-3">
                            @if ($profileInformation->photo)
                                <img src="{{ asset('storage/' . $profileInformation->photo) }}" class="card-img-top">
                            @else
                                <img src="{{ asset('img/no-profile-photo.png') }}" class="card-img-top">
                            @endif

                            @if(isset($profileInformation->age)) <h6 class="alert alert-secondary text-center mt-1"> {{ $profileInformation->age }} anos </h6> @endif
                            @if(isset($profileInformation->height)) <h6 class="alert alert-secondary text-center mt-1"> {{ $profileInformation->height }} cm </h6> @endif
                            @if(isset($profileInformation->weight)) <h6 class="alert alert-secondary text-center mt-1"> {{ $profileInformation->weight }} Kg </h6> @endif

                        </div>

                        <div class="col-md-9 col-lg-9 col-sm-12 mt-3">
                            <h4> {{ $profileInformation->user->name }} </h4>

                            @if($profileInformation->nickname)
                                <p class="text-muted mt-3"> Apelido </p>
                                <h5> {{ $profileInformation->nickname }} </h5>
                            @endif

                            @if($profileInformation->city)
                                <p class="text-muted mt-3"> Cidade / Estado </p>
                                <h5> {{ $profileInformation->city->name }} ({{$profileInformation->city->state->short}}) </h5>
                            @endif

                            @if($profileInformation->positions)
                                <p class="text-muted mt-3"> Posições que joga </p>
                                @foreach($profileInformation->positions as $position)
                                    {!! $position->icon !!}
                                @endforeach
                            @endif

                            @if($profileInformation->description)
                                <p class="text-muted mt-3"> Descrição </p>
                                {!! $profileInformation->description !!}
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
