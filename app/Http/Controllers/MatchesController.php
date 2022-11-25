<?php

namespace App\Http\Controllers;

use App\City;
use App\Matches;
use App\State;
use App\Statistic;
use App\Team;
use App\TeamHasPlayers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MatchesController extends Controller
{
    /**
     * Lista as partidas que foram cadastradas na plataforma
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filter = $request->except('_token');
        $cities = City::orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();
        $teams = Team::select('id', 'name')->get();

        $matches = Matches::orderBy('match_datetime', 'desc')->paginate(20);

        return view('match.index', compact('matches', 'cities', 'states', 'teams'));
    }

    public function statistics(int $teamId, int $matchId)
    {
        $match = Matches::where('id', $matchId)->first();
        $team = Team::where('id', $teamId)->first();
        $teamHasPlayers = TeamHasPlayers::where('team_id', $teamId)->get();
        $statistics = Statistic::get();

        //Fazer uma lista com todos os jogadores, as estatisticas
        // e possibilitar salvamento posterior, mesmo deslogado
        // utilizando localstorage
        // precisa de laço p/campos salvos

        return view('match.statistics', compact('team', 'match', 'teamHasPlayers', 'statistics'));
    }

    /**
     * @param int $teamId
     * @param int|null $matchId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(int $teamId, int $matchId = null)
    {
        $match = null;
        $cities = City::get();
        $team = Team::where('id', $teamId)->first();

        if($matchId) {
            $match = Matches::where('id', $matchId)->first();

            if ($match->home_team_id == $teamId) {
                $match->homeOrVisitor = 'home';
                $match->myTeamScore = $match->home_score;
                $match->enemyTeamName = $match->visitor_team_name;
                $match->enemyTeamScore = $match->visitor_score;
            }

            if ($match->visitor_team_id == $teamId) {
                $match->homeOrVisitor = 'visitor';
                $match->myTeamScore = $match->visitor_score;
                $match->enemyTeamName = $match->home_team_name;
                $match->enemyTeamScore = $match->home_score;
            }
        }

        return view('match.form', compact('cities', 'match', 'team'));
    }

    /**
     * @param Request $request
     * @param int $teamId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, int $teamId)
    {
        $this->validate($request, [
            'homeOrVisitor' => 'required|', Rule::in(['home','visitor']),
            'enemyTeamName' => 'required|string|min:1|max:200',
            'myTeamScore' => 'nullable|int',
            'enemyTeamScore' => 'nullable|int',
            'city_id' => 'required|int',
            'match_address' => 'required|string|min:1|max:5000',
            'match_datetime' => 'required|date_format:Y-m-d\TH:i'
        ]);

        $data = $request->except('_token');
        $homeTeamId = null;
        $homeTeamName = null;
        $homeTeamScore = null;
        $visitorTeamName = null;
        $visitorTeamId = null;
        $visitorTeamScore = null;


        if ($data['homeOrVisitor'] == 'home') {
            $homeTeamId = $teamId;
            $homeTeamScore = $data['myTeamScore'];
            $visitorTeamName = $data['enemyTeamName'];
            $visitorTeamScore = $data['enemyTeamScore'];
        }

        if ($data['homeOrVisitor'] == 'visitor') {
            $visitorTeamId = $teamId;
            $visitorTeamScore = $data['myTeamScore'];
            $homeTeamName = $data['enemyTeamName'];
            $homeTeamScore = $data['enemyTeamScore'];
        }

        $createData = [
            'home_team_id' => $homeTeamId,
            'visitor_team_id' => $visitorTeamId,
            'home_team_name' => $homeTeamName,
            'visitor_team_name' => $visitorTeamName,
            'home_score' =>  $homeTeamScore,
            'visitor_score' => $visitorTeamScore,
            'city_id' => $data['city_id'] ?? null,
            'match_address' => $data['match_address'] ?? null,
            'match_datetime' => $data['match_datetime'] ?? null,
            'created_by_team_id' => $teamId
        ];

        $match = Matches::create($createData);

        return redirect('configuration/team/' . $teamId);
    }

    /**
     * @param Request $request
     * @param int $teamId
     * @param int $matchId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $teamId, int $matchId)
    {
        $this->validate($request, [
            'homeOrVisitor' => 'required|', Rule::in(['home','visitor']),
            'enemyTeamName' => 'required|string|min:1|max:200',
            'myTeamScore' => 'nullable|int',
            'enemyTeamScore' => 'nullable|int',
            'city_id' => 'required|int',
            'match_address' => 'required|string|min:1|max:5000',
            'match_datetime' => 'required|date_format:Y-m-d\TH:i'
        ]);

        $data = $request->except('_token');
        $homeTeamId = null;
        $homeTeamName = null;
        $homeTeamScore = null;
        $visitorTeamName = null;
        $visitorTeamId = null;
        $visitorTeamScore = null;


        if ($data['homeOrVisitor'] == 'home') {
            $homeTeamId = $teamId;
            $homeTeamScore = $data['myTeamScore'];
            $visitorTeamName = $data['enemyTeamName'];
            $visitorTeamScore = $data['enemyTeamScore'];
        }

        if ($data['homeOrVisitor'] == 'visitor') {
            $visitorTeamId = $teamId;
            $visitorTeamScore = $data['myTeamScore'];
            $homeTeamName = $data['enemyTeamName'];
            $homeTeamScore = $data['enemyTeamScore'];
        }

        $createData = [
            'home_team_id' => $homeTeamId,
            'visitor_team_id' => $visitorTeamId,
            'home_team_name' => $homeTeamName,
            'visitor_team_name' => $visitorTeamName,
            'home_score' =>  $homeTeamScore,
            'visitor_score' => $visitorTeamScore,
            'city_id' => $data['city_id'] ?? null,
            'match_address' => $data['match_address'] ?? null,
            'match_datetime' => $data['match_datetime'] ?? null
        ];

        $match = Matches::where('id', $matchId)->update($createData);

        return redirect('configuration/team/' . $teamId);
    }

    /**
     * @param int $matchId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $matchId)
    {
        $match = Matches::where('id', $matchId)->first();

        return view('match.view', compact('match'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matches $match)
    {
        //
    }
}
