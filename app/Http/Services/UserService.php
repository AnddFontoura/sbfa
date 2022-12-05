<?php

namespace App\Http\Services;

use App\GamePosition;
use App\UserProfile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use phpDocumentor\Reflection\Types\Integer;

class UserService
{
    public function selectProfilesByParameters(array $filter)
    {
        $profiles = UserProfile::select('*','users_profiles.id as profile_id')
            ->where('is_player', true)
            ->join('users', 'users_profiles.user_id', '=', 'users.id');

        if(isset($filter['id']) && $filter['id'] != 0) {
            $profiles->where('users_profiles.id', $filter['id']);
        }

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

        return $profiles;
    }

    public function getGamePositionsFromProfileInformation(string $gamePositions): ?Collection
    {
        $positions = json_decode($gamePositions);

        if ($positions) {
            return GamePosition::whereIn('id', $positions)->get();
        }

        return null;
    }

    public function getAgeFromBirthdate(string $birthDate): int
    {
        $now = Carbon::now();

        return $now->diffInYears($birthDate);
    }
}
