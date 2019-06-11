<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class GetClearance extends Controller
{
    public function getFile($file) {
        $cont = Storage::get('public/'.$file);
        return [ base64_encode($cont) ];
    }
}
