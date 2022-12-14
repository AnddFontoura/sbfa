<?php

namespace App\Http\Controllers;

use App\Http\Services\MatchService;
use App\Http\Services\PermissionService;
use App\Http\Services\PlayerInvitedService;
use App\Http\Services\TeamService;
use App\Http\Services\UploadService;
use App\Http\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $permissionService;
    protected $uploadService;
    protected $playerInvitedService;
    protected $matchService;
    protected $teamService;
    protected $userService;

    public function __construct()
    {
        $this->permissionService = new PermissionService();
        $this->uploadService = new UploadService();
        $this->playerInvitedService = new PlayerInvitedService();
        $this->matchService = new MatchService();
        $this->teamService = new TeamService();
        $this->userService = new UserService();
    }
}
