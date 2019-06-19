<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetLandFaas extends Controller
{
    public function getInfo(Request $request) {
        $res = "CALL get_land_faas(".$request['id'].")";
        return json_encode($res);
    }
}
