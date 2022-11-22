<div class="card card-widget widget-user">

    <div class="widget-user-header @if(!$team->header) bg-dark @endif " 
        style="background-image: url('{{ asset('storage/' . $team->header) }}'); 
                background-size: 100%;
                background-position: center;
        ">
        <h3 class="widget-user-username"></h3>
        <h5 class="widget-user-desc">  </h5>
    </div>
    @if($team->logo)
    <div class="widget-user-image">
        <img class="img-circle elevation-2" src="{{ asset('storage/' . $team->logo) }}" alt="Logo do Time">
    </div>
    @endif
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <h5 class="description-header">{{ $team->name }}</h5>
                </div>

            </div>

            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <h5 class="description-header">{{ $team->city->name }}</h5>
                </div>

            </div>

            <div class="col-sm-4">
                <div class="description-block">
                    <h5 class="description-header">{{ $team->city->state->short }}</h5>
                </div>
            </div>

        </div>

    </div>
</div>