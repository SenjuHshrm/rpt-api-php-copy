<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssessLand extends Controller
{
    public function addLand(Request $req) {
			if($req) {
				return json_encode(['res'=>'add']);
			}
		}

		public function updateLand(Request $req) {
			if($req) {
				return json_encode(['res'=>'update']);
			}
		}
}
