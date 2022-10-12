<?php

namespace App\Http\Controllers;

use App\City;
use App\Matches;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function teamMatches()
    {
        Matches::where('home_team_id', $teamId)
            ->orWhere('visitor_team_id', $teamId)
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $teamId, int $matchId = null)
    {
        $match = null;
        $cities = City::get();
        $team = Team::where('id', $teamId)->first();

        if($matchId) {
            $match = Matches::where('id', $matchId)->first();
        }

        return view('match.form', compact('cities', 'match', 'team'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
            'match_datetime' => $data['match_datetime'] ?? null
        ];

        $match = Matches::create($createData);

        return redirect('configuration/team/' . $teamId);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show(Matches $match)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function edit(Matches $match)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matches $match)
    {
        //
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
