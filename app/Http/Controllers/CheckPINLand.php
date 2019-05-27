<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\genJWT;
use Illuminate\Support\Facades\DB;

class CheckPINLand extends Controller
{
    public function check(Request $request) {
        $header = $request->header('Authorization');
        $q = "CALL check_pin_availability_land_faas('".$request['city']."','".$request['dist']."','".$request['brgy']."','".$request['sect']."','".$request['prcl']."')";
        $result = DB::select($q);
        $proc = new genJWT();
        $res = $proc->authToken(str_replace('Bearer ', '', $header));
        if($res) {
            if(count($result) == 0) {
                return json_encode([
                'success' => true,
                'res' => 'New']);
            } else {
               return json_encode([
                'success' => false,
                'res' => 'Exisiting']); 
            }
        } else {
            return json_encode([
                'success' => 'error',
                'res' => 'Invalid User'
            ]);
        }

    }
}
