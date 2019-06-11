<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SaveClearance extends Controller
{
    public function save(Request $request) {
        try {
            Storage::put('public/'.$request['filename'].'.docx', base64_decode($request['file']));
            $target = Storage::get('public/'.$request['filename'].'.docx');
            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            $renderer = \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;
            $path = base_path().'\tcpdf';
            \PhpOffice\PhpWord\Settings::setPdfRenderer($renderer, $path);
            $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
            $writer->save($request['filename'].'.pdf');
            File::copy(base_path().'\public\\'.$request['filename'].'.pdf', storage_path().'\app\\public\\'.$request['filename'].'.pdf');
            File::delete(base_path().'\public\\'.$request['filename'].'.pdf');
            File::delete(storage_path().'\app\\public\\'.$request['filename'].'.docx');
            return [ 'res' => true ];
        } catch (Exception $e) {
            return [ 'res' => false ];
        }
    }
}
