<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Traits\FileUploader;
use App\Traits\ResponseApi;

class ImageController extends Controller
{
    use FileUploader;
    use ResponseApi;

    /**
     * Display a listing of the resource.
     */
    public function __invoke(ImageRequest $request)
    {
        $data = $request->validated();

        $this->uploadFile($request->file('image'), 'images/');

        return $this->respond('OK');
    }
}
