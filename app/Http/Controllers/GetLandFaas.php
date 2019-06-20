<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetLandFaas extends Controller
{
    public function getInfo(Request $request) {
        $res = DB::select("CALL get_land_faas(".$request['id'].")");
        $obj = $res[0];
        $obj->encoder_id = $this->getEncoder($obj->encoder_id);
        return json_encode($obj);
    }

    private function getEncoder($id) {
        $q = DB::select("CALL get_user_credentials(".$id.")");
        if($q[0]->middle_name == '') {
            $res = $q[0]->first_name . ' ' .$q[0]->last_name;
        } else {
            $res = $q[0]->first_name . ' ' . substr($q[0]->middle_name, 0) . '. ' .$q[0]->last_name;
        }
        return $res;
    }
}
