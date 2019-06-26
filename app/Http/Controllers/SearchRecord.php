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
                $q = $this->searchLandByPIN($request['info'], $request['sysCaller']);
                $owner = $this->getLandOwner($q);
                $admin = $this->getAdmin($q);
                return [
                    'faas' => $q,
                    'owner' => $owner,
                    'admin' => $admin,
                ];
                break;
            case 'arpNo':
                $q = $this->searchLandByARP($request['info'], $request['sysCaller']);
                $owner = $this->getLandOwner($q);
                $admin = $this->getAdmin($q);
                return [
                    'faas' => $q,
                    'owner' => $owner,
                    'admin' => $admin,
                ];
                break;
            case 'name':
                $data = $this->searchLandByName($request['info'], $request['sysCaller']);
                $owner = $this->getLandOwner($data);
                $admin = $this->getAdmin($data);
                return [
                    'faas' => $data,
                    'owner' => $owner,
                    'admin' => $admin,
                ];
                break;
        }
    }

    public function getLandOwner($qr) {
        $res = array();
        for($x = 0; $x < count($qr); $x++) {
            $q = DB::select("CALL get_land_faas_owners(".$qr[$x]->id.")");
            array_push($res, $q);
        }
        return $res;
    }

    public function getAdmin($qr) {
        $res = array();
        for($x = 0; $x < count($qr); $x++) {
            $q = DB::select("CALL get_land_faas_administrators(".$qr[$x]->id.")");
            array_push($res, $q);
        }
        return $res;
    }

    private function getBldgOwner($qr) {
        $res = array();
        
    }

    private function getAdminBldg($qr) {

    }

    public function searchLandByPIN($id, $sysCaller) {
        return DB::select("CALL search_land_faas('".$id."', 'PIN', '".$sysCaller."')");
    }

    public function searchLandByARP($id, $sysCaller) {
        return DB::select("CALL search_land_faas('".$id."', 'ARP_NO', '".$sysCaller."')");
    }

    public function searchLandByName($id, $sysCaller) {
        $res = DB::select("CALL search_land_faas('".$id."', 'NAME', '".$sysCaller."')");
        return $res;
    }

    private function searchBldg(Request $request) {
        switch($request['SearchBy']){
            case 'pin':
                $q = $this->searchBldgByPIN($request['info'], $request['sysCaller']);
                $owner = '';
                $admin = '';
                return [
                    'faas' => $q,
                    'owner' => $owner,
                    'admin' => $admin
                ];
                break;
            case 'arpNo':

                break;
            case 'name':

                break;
        }
    }

    private function searchBldgByPIN($id, $sysCaller) {
        return DB::select("CALL search_building_faas('".$id."', 'PIN', '".$sysCaller."')");
    }

    private function searchBldgByARP($id, $sysCaller) {
        return DB::select("CALL search_building_faas('".$id."', 'ARP_NO', '".$sysCaller."')");
    }

    private function searchBldgByName($id, $sysCaller) {
        return DB::select("CALL search_building_faas('".$id."', 'NAME', '".$sysCaller."')");
    }
}
