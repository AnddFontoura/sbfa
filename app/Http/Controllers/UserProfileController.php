<?php

namespace App\Http\Controllers;

use App\City;
use App\GamePosition;
use App\State;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $data = $request->except('_token');
        $userProfiles = $this->userService->selectProfilesByParameters($data);
        $userProfiles = $userProfiles->paginate(20);

        foreach ($userProfiles as $profile) {
            if ($profile->game_positions) {
                $profile->positions = $this->userService->getGamePositionsFromProfileInformation($profile->game_positions);
            }
        }


        $cities = City::orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();

        return view('profile.index', compact('userProfiles','cities', 'states'));
    }

    /**
     * @param int $profileId
     * @return View
     */
    public function show(int $profileId): View
    {
        $filter = [
            'id' => $profileId,
        ];

        $profileInformation = $this->userService->selectProfilesByParameters($filter);
        $profileInformation = $profileInformation->first();

        if ($profileInformation) {
            if ($profileInformation->game_positions) {
                $profileInformation->positions = $this->userService->getGamePositionsFromProfileInformation($profileInformation->game_positions);
            }

            if ($profileInformation->birthdate) {
                $profileInformation->age = $this->userService->getAgeFromBirthdate($profileInformation->birthdate);
            }

            return view('profile.view', compact('profileInformation'));
        }

        return view('errors.404');
    }
}
