<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CheckRequestAuth;

class GetPendingTrns extends Controller
{
    public function getPendingSegregation(Request $req, $name) {
			$header = $req->header('Authorization');
			$test = new CheckRequestAuth();
			if($test->testToken($header)) {
				return json_encode(DB::select("CALL get_pending_segregated_lands('".$name."')"));
			} else {
				return json_encode([ 'res' => false ]);
			}
		}

		public function getPendingConsolidation(Request $req, $name) {
			$header = $req->header('Authorization');
			$test = new CheckRequestAuth();
			if($test->testToken($header)) {
				return json_encode(DB::select("CALL get_pending_consolidated_lands('".$name."')"));
			} else {
				return json_encode([ 'res' => false ]);
			}
		}

		public function getPendingSubdivision(Request $req, $name) {
			$header = $req->header('Authorization');
			$test = new CheckRequestAuth();
			if($test->testToken($header)) {
				return json_encode(DB::select("CALL get_pending_subdivided_lands('".$name."')"));
			} else {
				return json_encode([ 'res' => false ]);
			}
		}
}
