<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CheckRequestAuth;

class AssessLand extends Controller
{
    public function addLand(Request $req) {
			// if($req) {
			// 	return json_encode(['res'=>'add']);
			// }
			try {
				$header = $req->header('Authorization');
				$test = new CheckRequestAuth();
				if($test->testToken($header)) {
					return json_encode([ 'res' => $this->procAdd($req) ]);
				} else {
					return json_encode([ 'res' => false ]);
				}
			} catch (Exception $e) {
				return json_encode([ 'res' => $e]);
			}

		}

		public function updateLand(Request $req) {
			if($req) {
				return json_encode(['res'=>'update']);
			}
		}

		private function procAdd($obj) {
			try {
				$query = "CALL assess_land_faas('".$obj['trnsCode']."', '".$obj['arpNo']."',".
								"'".$obj['pin']['city']."', '".$obj['pin']['district']."', '".$obj['pin']['barangay']."',".
								"'".$obj['pin']['section']."', '".$obj['pin']['parcel']."',".
								"'".$obj['OCT_TCT']."', '".$obj['surveyNo']."', '".$obj['lotNo']."', '".$obj['blockNo']."',".
								"'".$obj['propLoc']['streetNo']."', '".$obj['propLoc']['brgy']."', '".$obj['propLoc']['subd']."', '".$obj['propLoc']['city']."',".
								"'".$obj['propLoc']['province']."',".
								"'".$obj['propLoc']['north']."', '".$obj['propLoc']['south']."', '".$obj['propLoc']['west']."', '".$obj['propLoc']['east']."',".
								"'".$obj['landAppraisal']['class']."', '".$obj['landAppraisal']['subCls']."', '".$obj['landAppraisal']['interiorLot']."', '".$obj['landAppraisal']['cornerLot']."',".
								"'".$obj['landAppraisal']['area']."', '".$obj['landAppraisal']['unitVal']."', '".$obj['landAppraisal']['baseMarketVal']."',".
								"'".$obj['landAppraisal']['baseMarketVal']."',".
								"'".$obj['landAppraisal']['stripping']."',".
								"'".$obj['propAsmt']['actualUse']."', '".$obj['propAsmt']['marketVal']."', '".$obj['propAsmt']['assessmentLvl']."',".
								"'".$obj['propAsmt']['assessedVal']."', '".$obj['propAsmt']['specialClass']."', '".$obj['propAsmt']['total']."',".
								"'".$obj['propAsmt']['status']."',".
								"'".$obj['propAsmt']['effty']."', '".$obj['propAsmt']['efftQ']."',".
								"'".$obj['propAsmt']['appraisedName']."', '".$obj['propAsmt']['appraisedDate']."',".
								"'".$obj['propAsmt']['recommendName']."', '".$obj['propAsmt']['recommendDate']."',".
								"'".$obj['propAsmt']['approvedName']."', '".$obj['propAsmt']['approvedDate']."',".
								"'".$obj['propAsmt']['memoranda']."',".
								"'".$obj['supersededRec']['supPin']."', '".$obj['supersededRec']['supArpNo']."',".
								"'".$obj['supersededRec']['supTotalAssessedVal']."', '".$obj['supersededRec']['supPrevOwner']."',".
								"'".$obj['supersededRec']['supEff']."', '".$obj['supersededRec']['supARPageNo']."',".
								"'".$obj['supersededRec']['supRecPersonnel']."', '".$obj['supersededRec']['supTDNo']."',".
								"'".$obj['supersededRec']['supDate']."',".
								"'".$obj['status']."', ".$this->getEncoderId($obj['encoder']).",".
								"'".$obj['attachment']."')";
				$res = DB::select($query);
				return true;
			} catch (Exception $e) {
				return $e;
			}
		}

		private function getEncoderId($username) {
			$q = DB::select("CALL login('".$username."')");
			return $q[0]->user_id;
		}
}
