<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    public static function store($file, $folder)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '.' . $extension;
        $file->move(public_path($folder), $fileName);
        return $folder . $fileName;
    }

    public static function delete($file)
    {
        if ($file && File::exists(public_path($file))) {
            File::delete(public_path($file));
        }
    }
}
