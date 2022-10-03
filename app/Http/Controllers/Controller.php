<?php

namespace App\Http\Controllers;

use App\Http\Enums\ConfigurationEnum;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected $model;
    protected $viewFolder;
    protected $multipleRecordName;
    protected $singleRecordName;
    protected $paginate;

    function __construct()
    {
        parent::__construct();
        $this->paginate = ConfigurationEnum::PAGINATE_VALUE;
    }

    public function index(Request $request)
    {
        ${$this->multipleRecordName} = $this->model::paginate($this->paginate);

        return view($this->viewFolder . '.index', compact($this->multipleRecordName));
    }

    public function uploadImage($fileInformation)
    {
        
    }
}
