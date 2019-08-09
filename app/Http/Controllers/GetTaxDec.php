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
			$pdf->Text(30, 42, "Sample Text");
			//$pdf->Text(30, 45, "Sample Text");
			//Owner Num.
			$pdf->Text(163, 42, "Sample Text");
			//$pdf->Text(163, 45, "Sample Text");
			//Admin
			$pdf->Text(63, 52, "Sample Text");
			$pdf->Text(63, 55, "Sample Text");
			//Admin TIN
			$pdf->Text(148, 52, "Sample Text");
			$pdf->Text(148, 55, "Sample Text");
			//Admin Address
			$pdf->Text(30, 63, "Sample Text");
			$pdf->Text(30, 66, "Sample Text");
			//Admin Num.
			$pdf->Text(163, 63, "Sample Text");
			$pdf->Text(163, 66, "Sample Text");
			//Number and street
			$pdf->Text(50, 73, "Sample Text");
			//Brgy
			$pdf->Text(100, 73, "Sample Text");
			//City
			$pdf->Text(150, 73, "Sample Text");
			//CLOA
			$pdf->Text(48, 84, "Sample Text");
			//SurveyNo
			$pdf->Text(128, 84, "Sample Text");
			//CCT
			$pdf->Text(27, 89, "Sample Text");
			//LotNo
			$pdf->Text(128, 89, "Sample Text");
			//Dated
			$pdf->Text(27, 94, "Sample Text");
			//BlkNo
			$pdf->Text(128, 94, "Sample Text");
			//north
			$pdf->Text(40, 103, "Sample Text");
			//south
			$pdf->Text(122, 103, "Sample Text");
			//east
			$pdf->Text(40, 108, "Sample Text");
			//pcntl_west
			$pdf->Text(121, 108, "Sample Text");
			//prop asmt
			$pdf->SetFont('helvetica', 'B', 12);
			$pdf->Text(16, 120, "x");
			$pdf->Text(59, 120, "x");
			$pdf->Text(132, 120, "x");
			$pdf->Text(16, 136, "x");
			$pdf->Text(32, 191, "x");
			$pdf->Text(60, 191, "x");
			$pdf->SetFont('helvetica', '', 10);
			//storeys
			$pdf->Text(82, 127, "Sample Text");
			//bldg desc
			$pdf->Text(82, 132, "Sample Text");
			//mch
			$pdf->Text(155, 127, "Sample Text");
			//spcfy
			$pdf->Text(26, 143, "Sample Text");


			$pdf->SetFont('helvetica', '', 9);
			//class
			$pdf->Text(17, 156, "Sample Text");
			//area
			$pdf->Text(45, 156, "Sample Text");
			//mark val
			$pdf->Text(75, 156, "Sample Text");
			//actual use
			$pdf->Text(105, 156, "Sample Text");
			//lvl
			$pdf->Text(135, 156, "Sample Text");
			//assessed val
			$pdf->Text(175, 156, "Sample Text");
			//total mark val
			$pdf->Text(75, 172, "Sample Text");
			//total assessed val
			$pdf->Text(175, 172, "Sample Text");


			$pdf->SetFont('helvetica', '', 10);
			// amount in words
			$pdf->Text(45, 181, "Sample Text");
			//Qtr
			$pdf->Text(135, 193, "Sample Text");
			// yr
			$pdf->Text(170, 193, "Sample Text");
			//approved by1
			$pdf->Text(45, 205, "Sample Text");
			// approved by2
			$pdf->Text(109, 205, "Sample Text");
			// date
			$pdf->Text(170, 205, "Sample Text");

			$pdf->SetFont('times', 'I', 9);
			// pos1
			$pdf->Text(63, 209, "Sample Text");
			// pos2
			$pdf->Text(125, 209, "Sample Text");

			$pdf->SetFont('helvetica', '', 9);

			//Cancel TD
			$pdf->Text(55, 219, "Sample Text");
			// prev owner
			$pdf->Text(95, 219, "Sample Text");
			// prev av
			$pdf->Text(178, 219, "Sample Text");

			$pdf->SetFont('helvetica', '', 10);
			// memoranda
			$pdf->Text(37, 227, "Sample Text");

			return 'data:pdf;base64,' . $pdf->Output('taxdec.pdf', 'E');
		}
}
