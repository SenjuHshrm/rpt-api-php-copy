<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetMarketValues extends Controller
{
    public function getVal() {
			$q = DB::select("CALL get_land_unit_market_values()");
			return json_encode($q);
		}
}
