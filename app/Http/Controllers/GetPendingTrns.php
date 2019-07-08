<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetPendingTrns extends Controller
{
    public function getPendingSegregation(Request $req) {
			return json_encode(DB::select("CALL get_pending_segregated_lands('".$req['name']."')"));
		}

		public function getPendingConsolidation(Request $req) {
			return json_encode(DB::select("CALL get_pending_consolidated_lands('".$req['name']."')"));
		}

		public function getPendingSubdivision(Request $req) {
			return json_encode(DB::select("CALL get_pending_subdivided_lands('".$req['name']."')"));
		}
}
