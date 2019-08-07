<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\pdf\tcpdf\TCPDF;
use App\Classes\pdf\tcpdi\TCPDI;

class LandFaasGenFile extends Controller
{


    public function genFile(Request $request) {
			//require_once(base_path()."\\app\\Classes\pdf\\tcpdf\\tcpdf.php");
			// require_once base_path()."\\pdf\\tcpdi\\tcpdi.php";
			// $pdf =new TCPDI();
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetTitle('Sample PDF');
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('times', 'BI', 20);
			$txt = "<p>TCPDF Example 002</p>
			<p>Default page header and footer are disabled using setPrintHeader() and setPrintFooter() methods.</p>";
			$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
			$pdf->Output('SamplePDF.pdf', 'I');
		}
}
