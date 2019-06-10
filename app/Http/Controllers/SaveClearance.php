<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaveClearance extends Controller
{
    public function save(Request $request) {
        try {
            Storage::put('public/'.$request['filename'], $request['file']);
            return [ 'res' => true ];
        } catch (Exception $e) {
            return [ 'res' => false ];
        }
    }
}
