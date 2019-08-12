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
					$pdf->Text(28, 45, $req['arp_no']);
					$pdf->Text(116, 45, $req['pin']);
					$pdf->Text(45, 52.5, $req['oct_tct_no']);
					$pdf->Text(25, 57.3, $req['oct_tct_dated']);
					$pdf->Text(126, 50, $req['survey_no']);
					$pdf->Text(121, 54.9, $req['lot_no']);
					$pdf->Text(115, 59.7, $req['block']);
					$pdf->Text(26, 64.5, $req['owner_names']);
					$pdf->Text(116, 64, $req['owner_tins']);
					$pdf->Text(28, 74, $req['owner_addresses']);
					$pdf->Text(27, 83.3, $req['owner_contact_nos']);
					$pdf->Text(14, 94.3, $req['admin_names']);
					$pdf->Text(14, 103.3, $req['admin_addresses']);
					$pdf->Text(116, 89.8, $req['admin_tins']);
					$pdf->Text(26, 108.5, $req['admin_contact_nos']);
					$pdf->Text(31, 128.3, $req['street_no']);
					$pdf->Text(130, 128.3, $req['barangay_district']);
					$pdf->Text(34, 137, $req['municipality']);
					$pdf->Text(131, 136.7, $req['province_city']);
					$pdf->Text(25, 156, $req['north']);
					$pdf->Text(25, 164, $req['east']);
					$pdf->Text(25, 172, $req['south']);
					$pdf->Text(25, 181, $req['west']);
					$pdf->Text(21, 203, $req['class']);
					$pdf->Text(66, 203, $req['sub_class']);
					$pdf->Text(101, 203, $req['area'] . ' sqm');
					$pdf->Text(137, 203, 'P ' . $req['unit_value']);
					$pdf->Text(170, 203, $req['base_market_value']);
					$pdf->Text(101, 223, $req['area'] . ' sqm');
					$pdf->Text(170, 223, $req['total_base_market_value']);
				}
				// Page 2
				else if($page == 2) {
					$tpl = $pdf->importPage($page);
					$size = $pdf->getTemplateSize($tpl);
					$orn = $size['h'] > $size['w'] ? 'P' : 'L';
					$pdf->addPage($orn);
					$pdf->useTemplate($tpl, null, null, 0, 0, TRUE);
					$pdf->SetFont('helvetica', '', 9);
					$pdf->Text(22, 58, $req['pa_actual_use']);
					$pdf->Text(68, 58, $req['pa_market_value']);
					$pdf->Text(129, 58, $req['pa_assessment_level']);
					$pdf->Text(163, 58, $req['pa_assessed_value']);
					$pdf->Text(68, 73, $req['pa_market_value']);
					$pdf->Text(163, 73, $req['pa_total_assessed_value']);
					$pdf->SetFont('helvetica', 'B', 9);
					$pdf->Text(27.6, 81.5, $req['pa_tax']);
					$pdf->Text(46.5, 81.5, $req['pa_exp']);
					$pdf->SetFont('helvetica', '', 9);
					$pdf->Text(129, 81.5, 'Quarter: ' . $req['pa_effectivity_assess_quarter'] . "\t\t\t\t\t\t\tYear: " . $req['pa_effectivity_assess_year']);
					$pdf->SetFont('helvetica', '', 10);
					$pdf->Text(25, 108, $req['appraised_by']);
					$pdf->Text(71, 108, $req['appraised_by_date']);
					$pdf->Text(121, 108, $req['recommending']);
					$pdf->Text(165, 108, $req['recommending_date']);
					$pdf->Text(77, 116.5, $req['approved_by']);
					$pdf->Text(160, 116.5, $req['approved_by_date']);
					$pdf->Text(39, 132, $req['memoranda']);
					$pdf->Text(87, 143, $req['date_created']);
					$pdf->Text(153, 143, $req['entry_by']);
					$pdf->Text(22, 159.6, $req['superseded_pin']);
					$pdf->Text(27, 164.5, $req['superseded_arp_no']);
					$pdf->Text(118, 164.5, $req['superseded_td_no']);
					$pdf->Text(48, 169.4, $req['superseded_total_assessed_value']);
					$pdf->Text(40, 174, $req['superseded_previous_owner']);
					$pdf->Text(54, 179, $req['superseded_effectivity_assess']);
					$pdf->Text(35, 184, $req['superseded_ar_page_no']);
					$pdf->Text(43, 188.8, $req['superseded_recording_personnel']);
					$pdf->Text(162, 188.8, $req['superseded_date']);
				}
			}
			return $pdf->Output('TD_' . $req['pin'] . '_' . $req['diag_date_printed'] . '.pdf', 'E');
		}
}
