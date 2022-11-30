<?php

namespace App\Http\Services;

use App\UserProfile;

class UserService
{
    public function selectProfilesByParameters(array $filter)
    {
        $profiles = UserProfile::where('is_player', true)
            ->join('users', 'users_profiles.user_id', '=', 'users.id');

        if (isset($filter['userName']) && $filter['userName'] != "") {
            $profiles->where('users.name', '%' . $filter['userName'] . '%');
        }

        if (isset($filter['userCity']) && $filter['userCity'] != 0) {
            $profiles->where('city_id', $filter['userCity']);
        }

        if (isset($filter['userState']) && $filter['userState'] != 0) {
            $profiles->join('cities', 'cities.id', '=', 'users_profiles.city_id')
                ->where('state_id', $filter['userState']);
        }

        return $profiles->paginate(20);
    }
}
