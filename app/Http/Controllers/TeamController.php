<?php

namespace App\Http\Controllers;

use App\City;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $teams = Team::paginate(20);

        return view('team.index', compact('teams'));
    }

    public function myTeams()
    {
        $userId = Auth::id();
        $teams = Team::where('owner_id', $userId)->paginate(20);

        return view('team.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $id = null)
    {
        $cities = City::get();

        $team = null;

        if ($id) {
            $team = $this->model::where('id', $id)->first();
        }

        return view('team.form', compact('team', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id = null)
    {
        if ($id) {
            $currentData = $this->model::where('id', $id)
                ->first();

            if ($currentData->owner_id != Auth::id()) {
                return back()->withErrors('Você não tem permissão para atualizar esse time');
            }
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
            $fileName = Storage::disk('public')->put('logos', $data['logo']);

            $team->logo = $fileName;
            $team->save();
        }

        if ($request->file('header')) {
            $fileName = Storage::disk('public')->put('headers', $data['header']);

            $team->header = $fileName;
            $team->save();
        }

        return redirect("teams/show/" . $team->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
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