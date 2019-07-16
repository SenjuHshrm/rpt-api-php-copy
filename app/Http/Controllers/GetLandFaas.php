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
        return json_encode([
					'faas' => $obj,
					'owners' => DB::select("CALL get_land_faas_owners(".$request['id'].")"),
					'admins' => DB::select("CALL get_land_faas_administrators(".$request['id'].")"),
					'strips' => DB::select("CALL get_land_faas_strips(".$request['id'].")"),
					'marketval' => DB::select("CALL get_land_faas_adjustment_factors(".$request['id'].")")
				]);
    }

    private function getEncoder($id) {
        $q = DB::select("CALL get_user_credentials(".$id.")");
        if($q[0]->middle_name == '') {
            $res = $q[0]->first_name . ' ' .$q[0]->last_name;
        } else {
            $res = $q[0]->first_name . ' ' . substr($q[0]->middle_name, 0, 1) . '. ' .$q[0]->last_name;
        }
        return $res;
    }
}
