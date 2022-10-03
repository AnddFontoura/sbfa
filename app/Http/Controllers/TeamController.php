<?php

namespace App\Http\Controllers;

use App\City;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    protected $model;
    protected $viewFolder;
    protected $multipleRecordName;
    protected $singleRecordName;

    function __construct()
    {
        $this->model = new Team();
        $this->viewFolder = "team";
        $this->singleRecordName = "team";
        $this->multipleRecordName = "teams";
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

        ${$this->singleRecordName} = null;

        if ($id) {
            ${$this->singleRecordName} = $this->model::where('id', $id)->first();
        }

        return view('team.form', compact($this->singleRecordName, 'cities'));
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

        $data = $request->all();

        if ($id) {
            unset($data['_token']);

            $this->model::where('id', $id)
                ->update($data);

            ${$this->singleRecordName} = $this->model::where('id', $id)
                ->first();
        } else {
            $data['owner_id'] = Auth::id();

            ${$this->singleRecordName} = $this->model::create($data);
        }

        if ($request->file('logo')) {
            $fileName = Storage::disk('public')->put('logos', $data['logo']);

            ${$this->singleRecordName}->logo = $fileName;
            ${$this->singleRecordName}->save();
        }

        if ($request->file('header')) {
            $fileName = Storage::disk('public')->put('headers', $data['header']);

            ${$this->singleRecordName}->header = $fileName;
            ${$this->singleRecordName}->save();
        }

        return redirect($this->multipleRecordName . "/show/" . ${$this->singleRecordName}->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        ${$this->singleRecordName} = $this->model::where('id', $id)
                ->first();

        return view($this->viewFolder . ".view",  compact($this->singleRecordName));
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
