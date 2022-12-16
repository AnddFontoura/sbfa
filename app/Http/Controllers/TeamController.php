<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\FilterTeamRequest;
use App\State;
use App\Team;
use App\TeamHasPlayers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * @param FilterTeamRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(FilterTeamRequest $request)
    {
        $filter = $request->except('_token');
        $cities = City::orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();

        $teams = $this->teamService->selectTeamsWithFilters($filter);

        return view('team.index', compact('teams', 'cities', 'states'));
    }

    /**
     * @param int|null $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(int $id = null)
    {
        $cities = City::get();

        $team = null;

        if ($id) {
            $this->permissionService->checkIfLoggedUserCanManageTeam($id);

            $team = Team::where('id', $id)->first();
        }

        return view('team.form', compact('team', 'cities'));
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, int $id = null)
    {
        if ($id) {
            $this->permissionService->checkIfLoggedUserCanManageTeam($id);
        }

        $this->validate($request, [
            'name' => 'required|string|min:1|max:254',
            'description' => 'nullable|string|max:10000',
            'can_player_join' => 'nullable|boolean',
            'city_id' => 'nullable|int',
            'logo' => 'nullable',
            'header' => 'nullable',
        ]);

        $data = $request->except('_token');

        if ($id) {
            Team::where('id', $id)
                ->update($data);

            $team = Team::where('id', $id)
                ->first();
        } else {
            $data['owner_id'] = Auth::id();

            $team = Team::create($data);
        }

        if ($request->file('logo')) {
            $team->logo = $this->uploadService->uploadFileToFolder('public', 'logos', $data['logo']);
            $team->save();
        }

        if ($request->file('header')) {
            $team->header = $this->uploadService->uploadFileToFolder('public', 'headers', $data['header']);
            $team->save();
        }

        return redirect("teams/show/" . $team->id);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id)
    {
        $userInTeam = TeamHasPlayers::where('user_id', Auth::user()->id)
            ->where('team_id', $id)
            ->first();

        $teamInfo = Team::where('id', $id)
            ->first();

        $countPlayersInTeam = TeamHasPlayers::where('team_id', $id)
            ->where('active', 1)
            ->count('id');

        $countMatches = $this->matchService->getMatchOfTeam($id)->count('id');

        return view(
            "team.view",
            compact(
                'teamInfo',
                'userInTeam',
                'countPlayersInTeam',
                'countMatches'
            )
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }
}
