<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Classes\genJWT;

class SearchRecord extends Controller
{
    public function search(Request $request) {
        $header = $request->header('Authorization');
        $proc = new genJWT();
        $tokenRes = $proc->authToken(str_replace('Bearer ', '', $header));
        if($tokenRes) {
            if($request['SearchIn'] == 'land') {
                return json_encode([
                    'success' => true,
                    'data' => $this->searchLand($request)
                ]);
            } else {
                $this->searchBldg($request);
            }
        } else {
            return json_encode([
                'success' => 'error',
                'res' => 'Invalid User'
            ]);
        }
    }

    private function searchLand(Request $request) {
        switch($request['SearchBy']){
            case 'pin':
                $q = "CALL searchLandByPIN('".$request['info']."')";
                $dbres = DB::select($q);
                $data = $dbres[0];
                $owner = DB::select("CALL get_land_faas_owners(".$data->land_faas_id.")");
                $admin = DB::select("CALL get_land_faas_administrators(".$data->land_faas_id.")");
                $strips = DB::select("CALL get_land_faas_strips(".$data->land_faas_id.")");
                return [
                    'landfaas' => $data,
                    'owner' => $owner,
                    'admin' => $admin,
                    'strips' => $strips
                ];
                break;
            case 'arpNo':

                break;
            case 'name':

                break;
        }
    }

    private function searchBldg(Request $request) {

    }
}
