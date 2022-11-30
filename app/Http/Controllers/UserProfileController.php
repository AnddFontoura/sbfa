<?php

namespace App\Http\Controllers;

use App\City;
use App\State;
use App\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $request->except('_token');
        $userProfiles = $this->userService->selectProfilesByParameters($data);

        $cities = City::orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();

        return view('profile.index', compact('userProfiles','cities', 'states'));
    }
}
