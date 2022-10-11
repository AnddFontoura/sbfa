<?php

namespace App\Http\Controllers;

use App\Http\Services\PermissionService;
use App\Http\Services\PlayerInvitedService;
use App\Http\Services\UploadService;
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

    public function __construct()
    {   
        $this->permissionService = new PermissionService();
        $this->uploadService = new UploadService();
        $this->playerInvitedService = new PlayerInvitedService();
    }
}
