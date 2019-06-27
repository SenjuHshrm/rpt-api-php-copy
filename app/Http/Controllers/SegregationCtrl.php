<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Classes\genJWT;

class SegregationCtrl extends Controller
{
    public function searchRecord(Request $req) {
        $header = $req->header('Authorization');
        if($header) {
            $proc = new genJWT();
            $token = $proc->authToken(str_replace('Bearer ', '', $header));
            if($token) {
                $res = DB::select("CALL search_land_faas('".$req['info']."', '".$req['SearchBy']."', '".$req['SysCaller']."')");
                return [
                    'success' => true ,
                    'err' => null,
                    'data' => $res
                ];
            } else {
                return [
                    'success' => false ,
                    'err' => 'Invalid Token',
                    'data' => null
                ];
            }
        } else {
            return [
                'success' => false ,
                'err' => 'Unauthorize',
                'data' => null
            ];
        }
    }
}
