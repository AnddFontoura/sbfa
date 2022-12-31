<?php

namespace App\Http\Controllers;

use App\PlayerJoinTeam;
use App\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PlayerJoinTeamController extends Controller
{
    /**
     * @param int $teamId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(Request $request, int $teamId)
    {
        $this->validate($request, [
            'status' => 'nullable|int'
        ]);

        $filter = $request->all();

        $team = Team::where('id', $teamId)
            ->first();

        $playersRequests = PlayerJoinTeam::where('team_id', $teamId)
            ->orderBy('status', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('player_join_team.index', compact(
            'team',
            'playersRequests'
        ));
    }

    /**
     * @param Request $request
     * @param int $teamId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, int $teamId): RedirectResponse
    {
        $this->validate($request, [
            'ask_description' => 'nullable|string|max:1000'
        ]);

        $data = $request->except('_token');
        $askDescription = $data['ask_description'] ?? '';

        $canJoin = $this->teamService->checkIfTeamAllowNewPlayers($teamId);

        if($canJoin) {
            $userId = Auth::user()->id;

            $askedToJoin = $this->teamService->checkIfPlayerAlreadyAskToJoin($teamId, $userId);

            if (!$askedToJoin)
            {
                $this->teamService->registerInterestInTeam($teamId, $userId, $askDescription);
            } else {
                return back()->withErrors(['error' => 'Você já pediu para participar desse time.']);
            }
        }

        return back()->withErrors(['error' => 'O time não aceita novos jogadores no momento']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PlayerJoinTeam  $playerJoinTeam
     * @return \Illuminate\Http\Response
     */
    public function show(PlayerJoinTeam $playerJoinTeam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PlayerJoinTeam  $playerJoinTeam
     * @return \Illuminate\Http\Response
     */
    public function edit(PlayerJoinTeam $playerJoinTeam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PlayerJoinTeam  $playerJoinTeam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlayerJoinTeam $playerJoinTeam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PlayerJoinTeam  $playerJoinTeam
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlayerJoinTeam $playerJoinTeam)
    {
        //
    }
}
