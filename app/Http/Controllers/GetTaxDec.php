<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Classes\pdf\tcpdf\TCPDF;
use App\Classes\pdf\tcpdi\TCPDI;
use App\Http\Controllers\ChekRequestAuth;

class GetTaxDec extends Controller
{
    public function getFile(Request $req) {
			$header = $req->header('Authorization');
			$token = new CheckRequestAuth();
			if($token->testToken($header)) {
				return json_encode([ 'res' => $this->makeFile($req) ]);
			} else {
				return json_encode([ 'res' => false ]);
			}
			//return view('samplepdf')->with([ 'data' => $this->makeFile($req) ]);
    }

		private function makeFile(Request $req) {
			$pdf = new TCPDI(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetTitle('TD_' . $req['pin'] . '_' . $req['diag_date_printed'] . '.pdf');
			$pdf->SetDisplayMode(100);
			$count = $pdf->setSourceFile(base_path().'\resources\assets\pdf\tax_declaration_template.pdf');
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			$tpl = $pdf->importPage(1);
			$size = $pdf->getTemplateSize($tpl);
			$orn = $size['h'] > $size['w'] ? 'P' : 'L';
			$pdf->addPage($orn);
			$pdf->useTemplate($tpl, null, null, 0, 0, TRUE);
			// reference number
			$pdf->SetFont('helvetica', '', 8);
			$pdf->Text(27, 13, $req['reference_number']);
			$pdf->SetFont('helvetica', '', 10);
			//TD
			$pdf->Text(30, 27, $req['td_no']);
			//PIN
			$pdf->Text(142, 27, $req['pin']);
			//Owner
			$pdf->Text(30, 32, $req['owner_names']);
			//$pdf->Text(30, 35, "Sample Text");
			//Owner TIN
			$pdf->Text(148, 32, $req['owner_tins']);
			//$pdf->Text(148, 35, "Sample Text");
			//Owner Address
			$pdf->Text(30, 42, $req['owner_addresses']);
			//$pdf->Text(30, 45, "Sample Text");
			//Owner Num.
			$pdf->Text(163, 42, $req['owner_contact_nos']);
			//$pdf->Text(163, 45, "Sample Text");
			//Admin
			$pdf->Text(63, 52, $req['admin_names']);
			//$pdf->Text(63, 55, "Sample Text");
			//Admin TIN
			$pdf->Text(148, 52, $req['admin_tins']);
			//$pdf->Text(148, 55, "Sample Text");
			//Admin Address
			$pdf->Text(30, 63, $req['admin_addresses']);
			//$pdf->Text(30, 66, "Sample Text");
			//Admin Num.
			$pdf->Text(163, 63, $req['admin_contact_nos']);
			//$pdf->Text(163, 66, "Sample Text");
			//Number and street
			$pdf->Text(50, 73, $req['street_no']);
			//Brgy
			$pdf->Text(112, 73, $req['brgy_district']);
			//City
			//$pdf->Text(150, 73, "Sample Text");
			//CLOA
			$pdf->Text(48, 84, $req['oct_tct_no']);
			//SurveyNo
			$pdf->Text(128, 84, $req['survey_no']);
			//CCT
			$pdf->Text(27, 89, $req['condo_cert']);
			//LotNo
			$pdf->Text(128, 89, $req['lot_no']);
			//Dated
			$pdf->Text(27, 94, $req['dated']);
			//BlkNo
			$pdf->Text(128, 94, $req['block_no']);
			//north
			$pdf->Text(40, 103, $req['north']);
			//south
			$pdf->Text(122, 103, $req['south']);
			//east
			$pdf->Text(40, 108, $req['east']);
			//pcntl_west
			$pdf->Text(121, 108, $req['west']);
			//prop asmt
			$pdf->SetFont('helvetica', 'B', 12);
			$pdf->Text(16, 120, $req['s1']);
			$pdf->Text(59, 120, $req['s2']);
			$pdf->Text(132, 120, $req['s3']);
			$pdf->Text(16, 136, $req['s4']);
			$pdf->Text(32, 191, $req['tax']);
			$pdf->Text(60, 191, $req['exp']);
			$pdf->SetFont('helvetica', '', 10);
			//storeys
			$pdf->Text(82, 127, $req['no_of_storey']);
			//bldg desc
			$pdf->Text(82, 132, $req['desc_bldg']);
			//mch
			$pdf->Text(155, 127, $req['desc_mchn']);
			//spcfy
			$pdf->Text(26, 143, $req['others_specify']);


			$pdf->SetFont('helvetica', '', 9);
			//class
			$pdf->Text(17, 156, $req['class']);
			//area
			$pdf->Text(45, 156, $req['area']);
			//mark val
			$pdf->Text(75, 156, $req['market_val']);
			//actual use
			$pdf->Text(105, 156, $req['actual_use']);
			//lvl
			$pdf->Text(135, 156, $req['assess_level']);
			//assessed val
			$pdf->Text(175, 156, $req['assessed_val']);
			//total mark val
			$pdf->Text(75, 172, $req['total_market_val']);
			//total assessed val
			$pdf->Text(175, 172, $req['total_assessed_val']);


			$pdf->SetFont('helvetica', '', 10);
			// amount in words
			$pdf->Text(45, 181, $req['total_assessed_value_in_words'] . ' Only');
			//Qtr
			$pdf->Text(135, 193, $req['pa_effectivity_assess_quarter']);
			// yr
			$pdf->Text(170, 193, $req['pa_effectivity_assess_year']);
			//approved by1
			$pdf->Text(45, 205, $req['approved_by1']);
			// approved by2
			$pdf->Text(109, 205, $req['approved_by2']);
			// date
			$pdf->Text(170, 205, $req['approved_by_date']);

			$pdf->SetFont('times', 'I', 9);
			// pos1
			$pdf->Text(63, 209, $req['approver_title1']);
			// pos2
			$pdf->Text(125, 209, $req['approver_title2']);

			$pdf->SetFont('helvetica', '', 9);

			//Cancel TD
			$pdf->Text(55, 219, $req['previous_td_no']);
			// prev owner
			$pdf->Text(95, 219, $req['previous_owner']);
			// prev av
			$pdf->Text(178, 219, $req['previous_assessed_value']);

			$pdf->SetFont('helvetica', '', 10);
			// memoranda
			$pdf->Text(37, 227, $req['memoranda']);

			return $pdf->Output('TD_' . $req['pin'] . '_' . $req['diag_date_printed'] . '.pdf', 'E');
		}
}
