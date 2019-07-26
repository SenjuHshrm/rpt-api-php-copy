<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReassessmentCtrl extends Controller
{
    public function reassessLand(Request $req) {
			if($req) {
				return json_encode(['res'=>'add']);
			}
		}

		public function reassessBldg(Request $req) {
			if($req) {
				return json_encode(['res'=>'add']);
			}
		}
}
