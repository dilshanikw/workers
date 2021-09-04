<?php
include 'connect.php';
include 'session.php';
require_once('tcpdf_include.php');
error_reporting(0);
ob_start();

$cur_dte=date("Y-m-d");

if(isset($_POST['submit'])){
	$ss1=$_POST['sele_responsibleperson'];
	$ss2=$_POST['sele_projstatus'];
	
	$result2=mysqli_query($link,"SELECT * FROM staff WHERE empno='$ss1'");
	while($test2 = mysqli_fetch_array($result2)){
		$fistnme=$test2['firstname'];
		$lstnme=$test2['lastname'];
	}
	
class MYPDF extends TCPDF {

	public function Header() {
		
		$cur_dte=date("Y-m-d");
		$ss1=$_POST['sele_responsibleperson'];
		$ss2=$_POST['sele_projstatus'];
		
		include 'connect.php';
		$result2=mysqli_query($link,"SELECT * FROM staff WHERE empno='$ss1'");
		while($test2 = mysqli_fetch_array($result2)){
			$fistnme=$test2['firstname'];
			$lstnme=$test2['lastname'];
		}
					  // Get the current page break margin
					$bMargin = $this->getBreakMargin();

					// Get current auto-page-break mode
					$auto_page_break = $this->AutoPageBreak;

					// Disable auto-page-break
					$this->SetAutoPageBreak(false, 0);

					// Define the path to the image that you want to use as watermark.
				
					$this->SetAutoPageBreak($auto_page_break, $bMargin);
					
					// Set the starting point for the page content
					$this->setPageMark();
					
					$img_file1 = 'images/logo.png';
					$this->Image($img_file1, 5, 0, 40, 28, '', '', '', false, 300, '', false, false, 0);
						//$this->SetFont('helvetica', 'B', 20);
						
						
						$html ='<table border="0"  width="100%">
									<tr>
										<td width="100%" >
											<div style="font-size:15px;font-weight:bold;" align="center">WorkTracker</div>
											<div style="font-size:18px;font-weight:bold;" align="center">'.$ss2.' Projects Reports - '.$fistnme.' '.$lstnme.'</div>
											<div style="font-size:13px;" align="center">'.$cur_dte.'</div>
											
										</td>
									</tr>
							</table>
							';
						$this->writeHTML($html, true, false, true, false, '');
						// Title
		
	  
	}
	public function Footer() {
		include 'session.php';

			//$cur_dte_rtpgen=date("Y-m-d");
			date_default_timezone_set('Asia/Kolkata');
			$cur_dte_rtpgen = date('Y-m-d h:i:s');
			
			$ftext='<table border="0"  width="100%">
						<tr>
							<td width="40%" style="font-size:8px;">'.$ses_user.' &nbsp;&nbsp;&nbsp; '.$cur_dte_rtpgen.'</td>
							<td width="40%" style="font-size:8px;">Report Generated by WorkTracker</td>
							<td width="20%" align="right" style="font-size:8px;">Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages().'</td>
						</tr>
						
					</table>';
        // Position at 15 mm from bottom
        $this->SetY(-6);
        // Set font
        //$this->SetFont('helvetica', 'I', 12);
        // Page number
		$this->writeHTML($ftext, true, false, true, false, '');
    }
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);

$pdf->SetTitle('Project Reports - Responsible Person');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 32, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
//$pdf->SetFont('dejavusans', '', 15);

// add a page
$pdf->AddPage();
$pdf->SetFont('times', '', 12);
//$pdf->Image('images/image_demo.jpg', 90, 100, 60, 60, '', '', '', true, 72);
 

 

 
		$html='
			<table border="1" width="100%">
				<thead>
					<tr style="font-weight:bold;background-color:#f9f9fa;font-size:12px;">
						<th width="5%">  #</th>
						<th width="10%"> Project ID</th>
						<th width="20%"> Project Name</th>
						<th width="20%"> Project Description</th>
						<th width="15%"> Responsible Person</th>
						<th width="15%"> Client</th>
						<th width="15%"> Project Status</th>
					</tr>
				</thead>
				<tbody>';
				$no=0;
				
				if($ss2=="All"){
					$result=mysqli_query($link,"SELECT * FROM project INNER JOIN staff ON project.responsiblePerson=staff.empno
																							WHERE project.responsiblePerson='$ss1'");
				}
				if($ss2=="Pending"){
					$result=mysqli_query($link,"SELECT * FROM project INNER JOIN staff ON project.responsiblePerson=staff.empno
																							WHERE project.responsiblePerson='$ss1'
																							AND project.project_status=0");
				}
				if($ss2=="Complete"){
					$result=mysqli_query($link,"SELECT * FROM project INNER JOIN staff ON project.responsiblePerson=staff.empno
																							WHERE project.responsiblePerson='$ss1'
																							AND project.project_status=1");
				}
				if($ss2=="Cancel"){
					$result=mysqli_query($link,"SELECT * FROM project INNER JOIN staff ON project.responsiblePerson=staff.empno
																							WHERE project.responsiblePerson='$ss1'
																							AND project.project_status=2");
				}
				while($test = mysqli_fetch_array($result))
				{
					
					$no++;
					$html.='<tr style="font-size:10px;">';
						$html.='<td width="5%" align="center">'.$no.'</td>
						<td width="10%" align="center"> '.$test['projectID'].'</td>
						<td width="20%"> '.$test['projectName'].'</td>
						<td width="20%"> '.$test['projectDesc'].'</td>
						<td width="15%"> '.$test['firstname'].' '.$test['lastname'].'</td>
						<td width="15%"> '.$test['client'].'</td>';
						if($test['project_status']==0){	
							$html.='<td width="15%"> Pending</td>';
						}
						else if($test['project_status']==1){
							$html.='<td width="15%"> Complete</td>';
						}
						else{
							$html.='<td width="15%"> Cancelled</td>';
						}
					
					$html.='</tr>';
				}
					
			$html.='</tbody>
			 </table>';
		
 $pdf->writeHTML($html, true, false, true, false, '');


$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('projectresponsiblepersonwise_'.$fistnme.''.$lstnme.'_'.$cur_dte.'_'.$ss2.'Reports.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

}
?>