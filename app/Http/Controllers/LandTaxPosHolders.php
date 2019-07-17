<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CheckRequestAuth;

class LandTaxPosHolders extends Controller
{
    function getHolders(Request $req) {
				$header = $req->header('Authorization');
				$test = new CheckRequestAuth();
				if($test->testToken($header)) {
					$q = DB::select("CALL get_position_holder_links('TAX CLEARANCE')");
	        return json_encode($q);
				} else {
					return json_encode([]);
				}
    }
}
