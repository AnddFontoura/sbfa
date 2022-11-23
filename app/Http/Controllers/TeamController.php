<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\FilterTeamRequest;
use App\State;
use App\Team;
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

        return view('team.index', compact('teams','cities', 'states'));
    }

    /**
     * @param FilterTeamRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myTeams(FilterTeamRequest $request)
    {
        $filter = $request->except('_token');
        $cities = City::orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();
        $userId = Auth::id();
        $filter['ownerId'] = $userId;

        $teams = $this->teamService->selectTeamsWithFilters($filter);

        return view('team.index', compact('teams'));
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
        $team = Team::where('id', $id)
                ->first();

        return view("team.view",  compact('team'));
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
