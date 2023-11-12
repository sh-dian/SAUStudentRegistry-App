<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileAccessController extends Controller
{
    public function uploadServe($fileName)
    {
        $filepath = Storage::disk("uploads")->path($fileName);
        return response()->file($filepath);
    }
}
