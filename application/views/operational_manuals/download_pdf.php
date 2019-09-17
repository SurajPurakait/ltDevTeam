<?php
tcpdf();
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$title = "PDF Report";
$obj_pdf->SetTitle('Operational Manuals');
//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// $obj_pdf->SetDefaultMonospacedFont('helvetica');
//$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//$obj_pdf->SetFont('helvetica', '', 9);
//$obj_pdf->setFontSubsetting(false);
$obj_pdf->AddPage();
ob_start();
    // we can have any view part here like HTML, PHP etc
    $content  = '';
    
    // Repeat this section for Section Title 
    if(!empty($main_title)){ 
        foreach($main_title as $mt){                            
    $content .= '<table style="width:100%;" cellpadding="0" cellspacing="0" border="0">';
    $content .= '<tbody>';
    $content .= '<tr>';
    $content .= '<td style="padding-top:15px;">';
    $content .= '<h1>'.$mt['name'].'</h1><hr style="margin-bottom: 15px;"/>';
    $content .= '</td>';
    $content .= '</tr>';
    $content .= '<tr>';
    $content .= '<td>';
    $title_content = get_content('main',$mt['id']);
    $content .= '<p>'.$title_content['description'].'</p>';
    $content .= '</td>';
    $content .= '</tr>';
    $content .= '<tr>';
    $content .= '<td>';

    $subtitle = get_operational_sub_titles_by_id($mt['id']);
    if(!empty($subtitle)){
     foreach($subtitle as $st){
    
    // Subtitle Section (Repeat for Multiple Subtitle)
    $content .= '<br/><br/><table style="width:100%;" cellpadding="0" cellspacing="0" border="0">';
    $content .= '<thead>';
    $content .= '<tr>';
    $content .= '<th><h3>'.$st['name'].'</h3></th>';
    $content .= '</tr>';
    $content .= '</thead>';
    $content .= '<tbody>';
    $content .= '<tr>';
    $content .= '<td>';
    $sub_title_content = get_content('sub',$st['id']);
    $content .= '<p>'.$sub_title_content['description'].'</p>';
    $content .= '</td>';
    $content .= '</tr>';
    $content .= '</tbody>';
    $content .= '</table>';
    // Subtitle Section End
    } }
    $content .= '</td>';
    $content .= '</tr>';
    $content .= '</tbody>';
    $content .= '</table>';
    } }
        

//$content .= 'I, , certify that all information above is true and correct. I authorize OFFICE NAME to move forward with the following service.
//
//Sign Here ________________________
//Name:_________________________
//Date: ______________________';



ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');

$obj_pdf->Output("Taxleaf_" . date('dmY') . ".pdf", 'D');

//echo $rowid;
//echo $catid;
//echo $reference_id;
//echo $service_id;1