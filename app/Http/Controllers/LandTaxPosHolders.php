<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandTaxPosHolders extends Controller
{
    function getHolders() {
        $q = DB::select("CALL get_position_holder_links('TAX CLEARANCE')");
        return json_encode($q);
    }
}
