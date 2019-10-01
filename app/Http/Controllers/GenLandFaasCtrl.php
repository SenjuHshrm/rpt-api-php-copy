<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Classes\pdf\tcpdf\TCPDF;
use App\Classes\pdf\tcpdi\TCPDI;

class GenLandFaasCtrl extends Controller
{
		public function genFile(Request $req) {
			$pdf = new TCPDI(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->setTitle('LandFaas_' . $req['pin'] . '_' . date('m-d-Y') . '.pdf');
			$pdf->SetDisplayMode(100);
			$count = $pdf->SetSourceFile(base_path().'\resources\assets\pdf\land_faas_template.pdf');
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			for($page = 1; $page <= $count; $page++) {
				// Page 1
				if($page == 1) {
					$tpl = $pdf->importPage($page);
					$size = $pdf->getTemplateSize($tpl);
					$orn = $size['h'] > $size['w'] ? 'P' : 'L';
					$pdf->addPage($orn);
					$pdf->useTemplate($tpl, null, null, 0, 0, TRUE);
					$pdf->SetFont('helvetica', '', 10);
					$pdf->Text(145, 32, $req['transaction_code']);
					$pdf->SetFont('helvetica', '', 9);
					$pdf->Text(28, 45.9, $req['arp_no']);
					$pdf->Text(116, 45.9, $req['pin']);
					$pdf->Text(45, 51.1, $req['oct_tct_no']);
					$pdf->Text(25, 57.3, $req['oct_tct_dated']);
					$pdf->Text(126, 51.1, $req['survey_no']);
					$pdf->Text(167, 51.1, $req['lot_no']);
					$pdf->Text(189, 51.1, $req['block']);
					if(strlen($req['owner_names']) > 160) {
						$pdf->SetFont('helvetica', '', 5);
					} else if(strlen($req['owner_names']) < 160 && strlen($req['owner_names']) > 320) {
						$pdf->SetFont('helvetica', '', 4);
					}
					$pdf->writeHTMLCell(112, 19, 15, 60, '<span>'.$req['owner_names'].'</span>', 0, 0, 0, true, 'J', true);
					$pdf->writeHTMLCell(105, 12, 22, 80, '<span>'.$req['owner_tins'].'</span>', 0, 0, 0, true, 'J', true);
					$pdf->writeHTMLCell(59, 12, 143, 80, '<span>'.$req['owner_contact_nos'].'</span>', 0, 0, 0, true, 'J', true);
					$pdf->SetFont('helvetica', '', 9);
					if(strlen($req['admin_names']) > 160) {
						$pdf->SetFont('helvetica', '', 5);
					} else if(strlen($req['admin_names']) < 160 && strlen($req['admin_names']) > 320) {
						$pdf->SetFont('helvetica', '', 4);
					}
					$pdf->writeHTMLCell(112, 19, 15, 102, '<span>'.$req['admin_names'].'</span>', 0, 0, 0, true, 'J', true);
					$pdf->writeHTMLCell(105, 12, 22, 122, '<span>'.$req['admin_tins'].'</span>', 0, 0, 0, true, 'J', true);
					$pdf->writeHTMLCell(59, 12, 143, 122, '<span>'.$req['admin_contact_nos'].'</span>', 0, 0, 0, true, 'J', true);
					$pdf->SetFont('helvetica', '', 9);
					$pdf->writeHTMLCell(72, 19, 130, 60, '<span>'.$req['owner_addresses'].'</span>', 0, 0, 0, true, 'J', true);
					$pdf->writeHTMLCell(72, 19, 130, 102, '<span>'.$req['admin_addresses'].'</span>', 0, 0, 0, true, 'J', true);
					$pdf->Text(31, 148, $req['street_no']);
					$pdf->Text(130, 148, $req['barangay_district']);
					$pdf->Text(34, 156, $req['municipality']);
					$pdf->Text(131, 156, $req['province_city']);
					$pdf->Text(25, 173, $req['north']);
					$pdf->Text(25, 182, $req['east']);
					$pdf->Text(25, 190, $req['south']);
					$pdf->Text(25, 199, $req['west']);
					$pdf->writeHTMLCell(37.9, 2, 13, 221, '<span>'.$req['class'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(37.9, 2, 51, 221, '<span>'.$req['sub_class'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(37.9, 2, 89, 221, '<span>'.$req['area'].' sqm</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(37.9, 2, 127, 221, '<span>P '.$req['unit_value'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(34, 2, 169, 221, '<span>'.$req['base_market_value'].'</span>', 0, 0, 0, true, 'J', true);
					$pdf->writeHTMLCell(37.9, 2, 89, 240, '<span>'.$req['area'].' sqm</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(37.9, 2, 169, 240, '<span>'.$req['total_base_market_value'].'</span>', 0, 0, 0, true, 'J', true);
					$pdf->SetFont('helvetica', '', 6);
					$pdf->StartTransform();
					$pdf->Rotate(90);
					$pdf->Text(200, 37, 'Date Printed: ' . $req['diag_date_printed']);
					$pdf->Text(200, 40, 'Printed By: ' . $req['diag_printed_by']);
					$pdf->StopTransform();
				}
				// Page 2
				else if($page == 2) {
					$tpl = $pdf->importPage($page);
					$size = $pdf->getTemplateSize($tpl);
					$orn = $size['h'] > $size['w'] ? 'P' : 'L';
					$pdf->addPage($orn);
					$pdf->useTemplate($tpl, null, null, 0, 0, TRUE);
					$pdf->SetFont('helvetica', '', 9);
					$pdf->writeHTMLCell(47, 2, 13, 58, '<span>'.$req['pa_actual_use'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(37.9, 2, 65, 58, '<span>'.$req['pa_market_value'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(47, 2, 108, 58, '<span>'.$req['pa_assessment_level'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(37.9, 2, 160, 58, '<span>'.$req['pa_assessed_value'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(37.9, 2, 65, 73, '<span>'.$req['pa_market_value'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(37.9, 2, 160, 73, '<span>'.$req['pa_total_assessed_value'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->SetFont('helvetica', 'B', 9);
					$pdf->Text(30.5, 81.5, $req['pa_tax']);
					$pdf->Text(55, 81.5, $req['pa_exp']);
					$pdf->SetFont('helvetica', '', 9);
					$pdf->Text(135, 81.5, $req['pa_effectivity_assess_quarter']);
					$pdf->Text(160, 81.5, $req['pa_effectivity_assess_year']);
					$pdf->SetFont('helvetica', '', 10);
					$pdf->writeHTMLCell(55, 2, 13, 114, '<span>'.$req['appraised_by'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(36, 2, 69, 114, '<span>'.$req['appraised_by_date'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(55, 2, 106, 114, '<span>'.$req['recommending'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(36, 2, 162, 114, '<span>'.$req['recommending_date'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(60, 2, 70, 131, '<span>'.$req['approved_by'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(42, 2, 148, 131, '<span>'.$req['approved_by_date'].'</span>', 0, 0, 0, true, 'C', true);
					$pdf->writeHTMLCell(190, 18, 13, 146.5, '<p style="text-indent: 75px">'.$req['memoranda'].'</p>', 0, 0, 0, true, 'J', true);
					$pdf->Text(101, 172, $req['date_created']);
					$pdf->writeHTMLCell(59, 1, 140, 171, '<p>'.$req['entry_by'].'</p>', 0, 0, 0, true, 'C', true);
					$pdf->Text(22, 186.3, $req['superseded_pin']);
					$pdf->Text(28, 191, $req['superseded_arp_no']);
					$pdf->Text(127, 191, $req['superseded_td_no']);
					$pdf->Text(48, 196, $req['superseded_total_assessed_value']);
					$pdf->Text(40, 201, $req['superseded_previous_owner']);
					$pdf->Text(54, 205.6, $req['superseded_effectivity_assess']);
					$pdf->Text(35, 210.6, $req['superseded_ar_page_no']);
					$pdf->Text(43, 215.6, $req['superseded_recording_personnel']);
					$pdf->Text(166, 215.6, $req['superseded_date']);
				}
			}
			$this->addToLog($req['username'], $req['id']);
			return $pdf->Output('LandFaas_' . $req['pin'] . '_' . date('m-d-Y') . '.pdf', 'E');
		}

		private function addToLog($username, $id) {
			$q = DB::select("CALL login_web('".$username."')");
			DB::select("CALL add_land_faas_log('PRINT LAND FAAS', ".$q[0]->user_id.", ".$id.")");
		}
}
