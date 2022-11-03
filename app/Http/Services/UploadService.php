<?php

namespace App\Http\Services;

use App\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadService {

    /**
     * @param string $disk
     * @param string $folderPath
     * @param object $file
     * @return bool
     */
    public function uploadFileToFolder(string $disk = 'public', string $folderPath, object $file)
    {
        return Storage::disk($disk)->put($folderPath, $file);
    }
}
