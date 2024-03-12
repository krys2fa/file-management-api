<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\File;
use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, File $file)
    {
        $file->is_uploaded = $request->is_uploaded;
        $file->save();

        return FileResource::make($file);
    }
}
