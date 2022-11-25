
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Partida</h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                        <h5 class="description-header">{{ $match->homeTeam->name ?? $match->home_team_name }}</h5>
                        <span class="description-text">MANDANTE</span>
                    </div>

                </div>

                <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                        <h5 class="description-header">{{ $match->visitorTeam->name ?? $match->visitor_team_name }}</h5>
                        <span class="description-text">VISITANTE</span>
                    </div>

                </div>

                <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                        <h5 class="description-header">{{ $match->match_datetime->format('d/m/Y H:i:s') }}</h5>
                        <span class="description-text">DATA E HORA</span>
                    </div>

                </div>

                <div class="col-sm-3 col-6">
                    <div class="description-block">
                        <h5 class="description-header">{{ $match->home_score }} x {{ $match->visitor_score }}</h5>
                        <span class="description-text">PLACAR</span>
                    </div>

                </div>
            </div>

        </div>

    </div>
