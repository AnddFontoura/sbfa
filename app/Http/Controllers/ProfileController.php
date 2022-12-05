<?php

namespace App\Http\Controllers;

use App\City;
use App\GamePosition;
use App\Http\Requests\ProfileRequest;
use App\User;
use App\UserProfile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function create()
    {
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();
        $cities = City::orderBy('name', 'asc')->get();
        $gamePositions = GamePosition::get();
        $selectedPositions = json_decode($user->profile->game_positions ?? null);

        return view('profile.form', compact('user', 'gamePositions', 'selectedPositions', 'cities'));
    }

    public function store(ProfileRequest $request)
    {
        $picturePath = null;

        $user = Auth::user();
        $data = $request->except('_token');

        if($data['userCity'] == 0) {
            $data['userCity'] = null;
        }

        if ($request->file('userPhoto')) {
            $picturePath = $this->uploadService->uploadFileToFolder('public', 'profiles_pictures', $data['userPhoto']);
        }

        if ($data['userName'] != "") {
            User::where('id', $user->id)
                ->update([
                    'name' => $data['userName']
                ]);
        }

        if (isset($data['userPositions']) && !empty($data['userPositions'])) {
            $data['userPositions'] = json_encode($data['userPositions']);
        }

        $hasProfile = UserProfile::where('user_id', $user->id)->first();

        if($hasProfile) {
            UserProfile::where('user_id', $user->id)->update([
                'is_player' => $data['userIsPlayer'] ?? 0,
                'city_id' => $data['userCity'] ?? null,
                'nickname' => $data['userNickName'] ?? null,
                'mobile_number' => $data['userCellphone'] ?? null,
                'weight' => $data['userWeight'] ?? null,
                'height' => $data['userHeight'] ?? null,
                'description' => $data['userDescription'] ?? null,
                'birthdate' => $data['userBirthdate'] ?? null,
                'game_positions' => $data['userPositions'] ?? null,
            ]);
        } else {
            UserProfile::create([
                'user_id' => $user->id,
                'is_player' => $data['userIsPlayer'] ?? 0,
                'city_id' => $data['userCity'] ?? null,
                'nickname' => $data['userNickName'] ?? null,
                'mobile_number' => $data['userCellphone'] ?? null,
                'weight' => $data['userWeight'] ?? null,
                'height' => $data['userHeight'] ?? null,
                'description' => $data['userDescription'] ?? null,
                'birthdate' => $data['userBirthdate'] ?? null,
                'game_positions' => $data['userPositions'] ?? null,
            ]);
        }

        $hasProfile = UserProfile::where('user_id', $user->id)->first();

        if($picturePath) {
            $hasProfile->photo = $picturePath;
            $hasProfile->save();
        }

        return redirect('/');
    }
}
