<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends BaseController
{
    private $imageModel;
    public function __construct()
    {
        $this->imageModel = new Image();
    }
}
