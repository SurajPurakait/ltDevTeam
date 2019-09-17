<div class="wrapper wrapper-content">
    <div class="ibox-content m-b-md">
        <?php
        $content = '';
        if ($catid == 1) { //for incorporation 
            if($service_id == 1){
            $content .= '<table class="table table-striped" style="width:100%;">
        <tbody>
        <tr>
            <td colspan="2"
                style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                <h3>New Corporation #' . $edit_data[0]['id'] . '</h3></td>
        </tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State of
                Incorporation:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $getstatename['state_name'] . '</td>
        </tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                Business:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['name'] . (isset($name2) ? "<br>" . $name2 : "") . (isset($name3) ? "<br>" . $name3 : "") . '</td>
        </tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Tracking:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';

            $status = $edit_data[0]['main_order_status'];
            if ($status == 0) {
                $tracking = 'Completed';
            } elseif ($status == 1) {
                $tracking = 'Started';
            } elseif ($status == 2) {
                $tracking = 'Not Started';
            }
            $content .= $tracking . '</td>
        </tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Date
                Requested:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . normalizeDatehelper($edit_data[0]['order_date']) . '
            </td>
        </tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Office:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';

            $sql_query = "select idata.*,(select name from office where id=idata.office) as office_name from internal_data idata where idata.reference='" . $edit_data[0]['reference'] . "' and idata.reference_id='" . $edit_data[0]['reference_id'] . "'";

            $conn = $this->db;
            $sql_query_result = $conn->query($sql_query)->row();
            $content .= $sql_query_result->office_name . '
            </td>
        </tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Start
                Date:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . date("m/d/Y", strtotime($edit_data[0]['start_date'])) . '
            </td>
        </tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Completed
                Date:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . date("m/d/Y", strtotime($edit_data[0]['complete_date'])) . '
            </td>
        </tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Amount:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['total_of_order'] . '
            </td>
        </tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Requested
                By:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $rq_by[0]['first_name'] . ' ' . $rq_by[0]['last_name'] . '
            </td>
        </tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                Company:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '
            </td>
        </tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Fiscal Year
                End:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
            $i = $edit_data[0]['fye'];
            $content .= date("F", strtotime("2000-$i-01")) . '</td>
        </tr>';
             if ($edit_data[0]['dba'] != "") {
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                   DBA:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . ($edit_data[0]['dba']) . '
                </td>
            </tr>';
            }else{
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                   DBA:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . 'N/A' . '
                </td>
            </tr>';
            }
            if ($edit_data[0]['business_description'] != "") {
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($edit_data[0]['business_description']) . '
                </td>
            </tr>';
            }

            $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                Info:
            </td>';

            if ($contactlist) {
                $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                foreach ($contactlist as $contact) {
                    $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                   <b> Phones : </b>" . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                   <b> Email:</b> " . $contact->email1 . "<br>" .
                            "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                }
                $content .= "</td>";
            }
            $content .= '</tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owners:
            </td>';
            if (isset($ownerlist) && !empty($ownerlist)) {
                $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                foreach ($ownerlist as $title) {
                    $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                    <b>Date of birth:</b> " . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage:</b> " . $title->percentage . "%<br>
                                   <b> Language:</b> " . $title->language . "<br>
                                   <b> Country of Residence:</b> " . $title->country_residence_name . "<br>
                                    <b>Country of Citizenship:</b> " . $title->country_citizenship_name . "<br>
                                   <b> SSN_ITIN:</b>" . $title->ssn_itin . "<br>    
                                </p></div>";
                }
                $content .= "</td>";
            }
            $content .= '</tr>';
            $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
            if (isset($owner_list) && !empty($owner_list)) {
                $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                foreach ($owner_list as $contact) {
                    $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones</b>: " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email</b>: " . $contact->email1 . "<br>" .
                            "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                }
                $content .= "</td>";
            }
            $content .= '    
        </tr>
        <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Office:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $office_details['name'] . '
            </td>
        </tr>';
            if ($edit_data[0]['partner'] != "") {
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Partner:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $partner_name['first_name'] . " " . $partner_name['last_name'] . '
                </td>
            </tr>';
            }
            if ($edit_data[0]['manager'] != "") {
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Manager:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $manager_name['first_name'] . ' ' . $manager_name['last_name'] . '
                </td>
            </tr>';
            }
            if ($edit_data[0]['client_association'] != "") {
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                    Association:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['client_association'] . '
                </td>
            </tr>';
            }
            $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                Source:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $ref_by_src['source'] . '
            </td>
        </tr>';

            if ($edit_data[0]['referred_by_name'] != "") {
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Referred By Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['referred_by_name'] . '
                </td>
            </tr>';
            }
            $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $lang['language'] . '
            </td>
        </tr>';
            if ($edit_data[0]['price_charged'] != "") {
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">New
                    Corporation Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['price_charged'] . '
                </td>
            </tr>';
            }
            $content .= '</tbody></table><tbody><table>';
            if (!empty($all_notes_main_service)) {
                $content .= '<tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            New Corporation Note:
                        </td>';
                foreach ($all_notes_main_service as $n) {
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $n->note . '
                        </td>';
                }
                $content .= '</tr>';
            }

            if (!empty($related_services)) {

                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Related
                    Services:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                foreach ($related_services as $rs) {
                    if ($rs->services_id != '1') {
                        $all_notes_service = getmainServiceNotesContent($edit_data[0]['id'], $rs->services_id);

                        if ($rs->services_id == '10' || $rs->services_id == '41') {
                            $query = 'select sum(grand_total) as total from financial_accounts where company_id="' . $edit_data[0]['reference_id'] . '"';
                            $query_result = $this->db->query($query)->result_array();
                            if ($query_result[0]['total'] != '0') {
                                $sub_tot = $query_result[0]['total'];
                                $query_corp = 'select * from bookkeeping where company_id="' . $ref_id . '"';
                                $query_corp_result = $this->db->query($query_corp)->result_array();
                                $corp_tax = $query_corp_result[0]['corporate_tax_return'];
                                if ($corp_tax == 'y') {
                                    $tot = $sub_tot + 35;
                                } else {
                                    $tot = $sub_tot;
                                }
                            } else {
                                $query_sub = 'select sum(total_amount) as total from financial_accounts where company_id="' . $ref_id . '"';
                                $query_sub_result = $this->db->query($query_sub)->result_array();
                                $tot = $query_sub_result[0]['total'];
                            }
                        }


                        $content .= "<label><b>" . $rs->service_name . "</b></label>
                                <p> 
                                    <b>Retail Price: </b>";
                        if ($rs->services_id == '10' || $rs->services_id == '41') {
                            $content .= '$' . $tot;
                        } else {
                            $get_service_details = get_service_details($rs->services_id);
                            $content .= $get_service_details[0]['retail_price'];
                        }
                        $content .= "</p>";
                        $content .= "<p>
                                    <b>Override Price: </b> " . $rs->price_charged . " 
                                </p>";
                        $content .= "<p>
                                    <b>Responsible Department: </b> ";
                        $resp_dept = get_resp_dept($rs->services_id);
                        $content .= $resp_dept[0]['dept_name'];
                        $content .= "</p>";
                        $content .= "<p>
                                    <b>Tracking Description: </b> ";
                        $tracking_desc = get_tracking_srv($rs->services_id);
                        $status = $tracking_desc[0]['status'];
                        $start_date = date('m/d/Y', strtotime($rs->date_started));
                        $end_date = date('m/d/Y', strtotime($rs->date_completed));
                        if ($status == 0) {
                            $tracking = 'Completed';
                            $actual_complete = $end_date;
                        } elseif ($status == 1) {
                            $tracking = 'Started';
                            $actual_complete = 'N/A';
                        } elseif ($status == 2) {
                            $tracking = 'Not Started';
                            $actual_complete = 'N/A';
                        }
                        $content .= $tracking;
                        $content .= "</p>";
                        $content .= "<p>
                                    <b>Target Start: </b> " . $start_date . "  
                                </p>";
                        $content .= "<p>
                                    <b>Target Complete: </b> " . $end_date . "  
                                </p>";
                        $content .= "<p>
                                    <b>Actual Complete: </b> " . $actual_complete . "  
                                </p>";
                        if (!empty($all_notes_service)) {
                            foreach ($all_notes_service as $k => $n) {
                                if ($n->note != "")
                                    $content .= $k == 0 ? 'Service Notes: ' : "";
                                $content .= $n->note . '<br>';
                            }
                        }
                    }
                }
                $content .= '</td>
            </tr>';
            }

            if (!empty($all_notes_company)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Order Notes: </td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                foreach ($all_notes_company as $n) {
                    $content .= $n->note . '<br>';
                }
                $content .= '</td></tr>';
            }
             $content .= '<tr>';
                
                $content .='<td><h3>Files:
                </h3>';
            if (!empty($documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($documents);
                foreach ($documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                    if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                }
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                $content .='</td></tr>';
                
                if (!empty($owner_documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($owner_documents);
                foreach ($owner_documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                 if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                    
                }
                
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                $content .='</td></tr>';
            $content .= '</tbody>
        </table>';
            }elseif($service_id == 3 || $service_id == 39 || $service_id == 48){
//                echo 1;exit;
                $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>
            <tr>
                <td colspan="2"
                    style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <h3>Annual Report #' . $edit_data[0]['id'] . '</h3></td>
            </tr>
           
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['name'] . '</td>
            </tr>
            
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State
                    of Incorporation:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $getstatename['state_name'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Month & Year To Start:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['start_month_year'] . '</td>
            </tr>
           
        <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Federal ID:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['fein'] . '</td>
            </tr>
        
            
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($edit_data[0]['business_description']) . '</td>
            </tr>';

                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                    Info:
                </td>';

//echo 1;exit;
                if ($contactlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($contactlist as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email: </b>" . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owners:
            </td>';
                if ($ownerlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($ownerlist as $title) {

                        $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                    <b>Date of birth:</b> " . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage:</b> " . $title->percentage . "%<br>
                                    <b>Language:</b> " . $title->language . "<br>
                                   <b> Country of Residence:</b> " . $title->country_residence_name . "<br>
                                    <b>Country of Citizenship:</b> " . $title->country_citizenship_name . "<br>
                                    <b>SSN_ITIN:</b>" . $title->ssn_itin . "<br>
                                </p></div>";
                    }
                    $content .= "</td>";
                }

                $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
                if ($owner_list) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($owner_list as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones :</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }



                $content .= '<tr>
                  
                 <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Total Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['total_of_order'] . '</td>
                </tr>';
//                $content .= '<tr>
//            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
//           Frequency Of Salestax:
//            </td>
//            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $freq_of_salesrax . '
//            </td>
//        </tr>';

                $content .= '<tr>
                    
               
                
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Office:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $office_details['name'] . '</td>
            </tr>';

                if ($edit_data[0]['partner'] != "") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Partner:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $partner_name['first_name'] . " " . $partner_name['last_name'] . '
                    </td>
                </tr>';
                }
                if ($edit_data[0]['manager'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Manager:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $manager_name['first_name'] . ' ' . $manager_name['last_name'] . '
                </td>
            </tr>';
                }
                if ($edit_data[0]['client_association'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                    Association:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['client_association'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                Source:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $ref_by_src['source'] . '
            </td>
        </tr>';
                if ($edit_data[0]['referred_by_name'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Referred By Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['referred_by_name'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $lang['language'] . '
            </td>
        </tr>';

                

                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($documents);

                foreach ($documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
               if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                    }
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';

                if (!empty($owner_documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($owner_documents);
                foreach ($owner_documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                 if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                    
                }
               
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                
                $content .= '</tbody></table>';
        }elseif($service_id == 4){
                
                $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>
            <tr>
                <td colspan="2"
                    style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <h3>FEIN Application #' . $edit_data[0]['id'] . '</h3></td>
            </tr>
           
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['name'] . '</td>
            </tr>
            
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State
                    of Incorporation:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $getstatename['state_name'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Month & Year 
                to Start:

                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['start_month_year'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Federal ID:

                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fein'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">DBA:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['dba'] . '</td>
            </tr>
            
           
     
        
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($edit_data[0]['business_description']) . '</td>
            </tr>';

                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                    Info:
                </td>';

//echo 1;exit;
                if ($contactlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($contactlist as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email: </b>" . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owners:
            </td>';
                if (!empty($ownerlist)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($ownerlist as $title) {

                        $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                    <b>Date of birth:</b> " . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage:</b> " . $title->percentage . "%<br>
                                    <b>Language:</b> " . $title->language . "<br>
                                   <b> Country of Residence:</b> " . $title->country_residence_name . "<br>
                                    <b>Country of Citizenship:</b> " . $title->country_citizenship_name . "<br>
                                    <b>SSN_ITIN:</b>" . $title->ssn_itin . "<br>
                                </p></div>";
                    }
                    $content .= "</td>";
                }

                $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
                if (!empty($owner_list)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($owner_list as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones :</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                   
                }
                $content .= "</td>";
                $content .= '<tr>
                  
                 <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Total Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['total_of_order'] . '</td>
                </tr>';

                $content .= '<tr>
                    
               
                
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Office:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $office_details['name'] . '</td>
            </tr>';

                if ($edit_data[0]['partner'] != "") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Partner:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $partner_name['first_name'] . " " . $partner_name['last_name'] . '
                    </td>
                </tr>';
                }
                if ($edit_data[0]['manager'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Manager:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $manager_name['first_name'] . ' ' . $manager_name['last_name'] . '
                </td>
            </tr>';
                }
                if ($edit_data[0]['client_association'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                    Association:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['client_association'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                Source:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $ref_by_src['source'] . '
            </td>
        </tr>';
                if ($edit_data[0]['referred_by_name'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Referred By Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['referred_by_name'] . '
                </td>
            </tr>';
                }
                 if ($edit_data[0]['practice_id'] != "") { 
               $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                   Existing Practice Id:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">'.$edit_data[0]['practice_id'].'
                </td>
            </tr>';
         } 
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $lang['language'] . '
            </td>
        </tr>';
               if (!empty($all_notes_company)) {
                    $content .= '<tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                 Note:
                            </td>';
                    foreach ($all_notes_company as $n) {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $n->note . '</td>';
                    }
                    $content .= '</tr>';
                }
                $content .= '</tbody></table>';
                
            }elseif($service_id == 2 ){
                
                $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>
            <tr>
                <td colspan="2"
                    style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <h3>Corporate Amendment#' . $edit_data[0]['id'] . '</h3></td>
            </tr>
           
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['name'] . '</td>
            </tr>
            
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State
                    of Incorporation:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $getstatename['state_name'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Month & Year 
                to Start:

                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['start_month_year'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Federal ID:

                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fein'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">DBA:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['dba'] . '</td>
            </tr>
            
           
     
        
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($edit_data[0]['business_description']) . '</td>
            </tr>';

                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                    Info:
                </td>';

//echo 1;exit;
                if ($contactlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($contactlist as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email: </b>" . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owners:
            </td>';
                if (!empty($ownerlist)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($ownerlist as $title) {

                        $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                    <b>Date of birth:</b> " . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage:</b> " . $title->percentage . "%<br>
                                    <b>Language:</b> " . $title->language . "<br>
                                   <b> Country of Residence:</b> " . $title->country_residence_name . "<br>
                                    <b>Country of Citizenship:</b> " . $title->country_citizenship_name . "<br>
                                    <b>SSN_ITIN:</b>" . $title->ssn_itin . "<br>
                                </p></div>";
                    }
                    $content .= "</td>";
                }

                $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
                if (!empty($owner_list)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($owner_list as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones :</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                   
                }
                $content .= "</td>";
                $content .= '<tr>
                  
                 <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Total Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['total_of_order'] . '</td>
                </tr>';

                $content .= '<tr>
                    
               
                
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Office:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $office_details['name'] . '</td>
            </tr>';

                if ($edit_data[0]['partner'] != "") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Partner:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $partner_name['first_name'] . " " . $partner_name['last_name'] . '
                    </td>
                </tr>';
                }
                if ($edit_data[0]['manager'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Manager:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $manager_name['first_name'] . ' ' . $manager_name['last_name'] . '
                </td>
            </tr>';
                }
                if ($edit_data[0]['client_association'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                    Association:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['client_association'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                Source:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $ref_by_src['source'] . '
            </td>
        </tr>';
                if ($edit_data[0]['referred_by_name'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Referred By Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['referred_by_name'] . '
                </td>
            </tr>';
                }
                  if ($edit_data[0]['practice_id'] != "") { 
            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Existing Practice Id:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">'.$edit_data[0]['practice_id'].'
                </td>
            </tr>';
         } 
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $lang['language'] . '
            </td>
        </tr>';
               if (!empty($all_notes_company)) {
                    $content .= '<tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                 Note:
                            </td>';
                    foreach ($all_notes_company as $n) {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $n->note . '</td>';
                    }
                    $content .= '</tr>';
                }
                $content .= '</tbody></table>';
                
            
            }elseif($service_id == '5'){ //operating agreement
                
                
                $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>
            <tr>
                <td colspan="2"
                    style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <h3>Operating Agreement #' . $edit_data[0]['id'] . '</h3></td>
            </tr>
           
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['name'] . '</td>
            </tr>
            
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State
                    of Incorporation:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $getstatename['state_name'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Month & Year 
                to Start:

                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['start_month_year'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Federal ID:

                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fein'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">DBA:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['dba'] . '</td>
            </tr>
            
           
     
        
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($edit_data[0]['business_description']) . '</td>
            </tr>';

                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                    Info:
                </td>';

//echo 1;exit;
                if ($contactlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($contactlist as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email: </b>" . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owners:
            </td>';
                if (!empty($ownerlist)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($ownerlist as $title) {

                        $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                    <b>Date of birth:</b> " . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage:</b> " . $title->percentage . "%<br>
                                    <b>Language:</b> " . $title->language . "<br>
                                   <b> Country of Residence:</b> " . $title->country_residence_name . "<br>
                                    <b>Country of Citizenship:</b> " . $title->country_citizenship_name . "<br>
                                    <b>SSN_ITIN:</b>" . $title->ssn_itin . "<br>
                                </p></div>";
                    }
                    $content .= "</td>";
                }

                $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
                if (!empty($owner_list)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($owner_list as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones :</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                   
                }
                $content .= "</td>";
                $content .= '<tr>
                  
                 <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Total Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['total_of_order'] . '</td>
                </tr>';

                $content .= '<tr>
                    
               
                
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Office:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $office_details['name'] . '</td>
            </tr>';

                if ($edit_data[0]['partner'] != "") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Partner:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $partner_name['first_name'] . " " . $partner_name['last_name'] . '
                    </td>
                </tr>';
                }
                if ($edit_data[0]['manager'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Manager:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $manager_name['first_name'] . ' ' . $manager_name['last_name'] . '
                </td>
            </tr>';
                }
                if ($edit_data[0]['client_association'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                    Association:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['client_association'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                Source:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $ref_by_src['source'] . '
            </td>
        </tr>';
                if ($edit_data[0]['referred_by_name'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Referred By Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['referred_by_name'] . '
                </td>
            </tr>';
                }
                  if ($edit_data[0]['practice_id'] != "") { 
            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Existing Practice Id:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">'.$edit_data[0]['practice_id'].'
                </td>
            </tr>';
         } 
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $lang['language'] . '
            </td>
        </tr>';
               if (!empty($all_notes_company)) {
                    $content .= '<tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                 Note:
                            </td>';
                    foreach ($all_notes_company as $n) {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $n->note . '</td>';
                    }
                    $content .= '</tr>';
                }
                $content .= '</tbody></table>';
                
            
            }elseif($service_id == '6' || $service_id == '53'){
                
                
                $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>
            <tr>
                <td colspan="2"
                    style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <h3>Certificate Of Good Standing #' . $edit_data[0]['id'] . '</h3></td>
            </tr>
           
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['name'] . '</td>
            </tr>
            
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State
                    of Incorporation:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $getstatename['state_name'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Month & Year 
                to Start:

                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['start_month_year'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Federal ID:

                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fein'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">DBA:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['dba'] . '</td>
            </tr>
            
           
     
        
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($edit_data[0]['business_description']) . '</td>
            </tr>';

                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                    Info:
                </td>';

//echo 1;exit;
                if ($contactlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($contactlist as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email: </b>" . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owners:
            </td>';
                if (!empty($ownerlist)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($ownerlist as $title) {

                        $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                    <b>Date of birth:</b> " . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage:</b> " . $title->percentage . "%<br>
                                    <b>Language:</b> " . $title->language . "<br>
                                   <b> Country of Residence:</b> " . $title->country_residence_name . "<br>
                                    <b>Country of Citizenship:</b> " . $title->country_citizenship_name . "<br>
                                    <b>SSN_ITIN:</b>" . $title->ssn_itin . "<br>
                                </p></div>";
                    }
                    $content .= "</td>";
                }

                $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
                if (!empty($owner_list)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($owner_list as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones :</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                   
                }
                $content .= "</td>";
                $content .= '<tr>
                  
                 <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Total Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['total_of_order'] . '</td>
                </tr>';

                $content .= '<tr>
                    
               
                
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Office:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $office_details['name'] . '</td>
            </tr>';

                if ($edit_data[0]['partner'] != "") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Partner:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $partner_name['first_name'] . " " . $partner_name['last_name'] . '
                    </td>
                </tr>';
                }
                if ($edit_data[0]['manager'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Manager:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $manager_name['first_name'] . ' ' . $manager_name['last_name'] . '
                </td>
            </tr>';
                }
                if ($edit_data[0]['client_association'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                    Association:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['client_association'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                Source:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $ref_by_src['source'] . '
            </td>
        </tr>';
                if ($edit_data[0]['referred_by_name'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Referred By Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['referred_by_name'] . '
                </td>
            </tr>';
                }
                  if ($edit_data[0]['practice_id'] != "") { 
            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Existing Practice Id:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">'.$edit_data[0]['practice_id'].'
                </td>
            </tr>';
         } 
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $lang['language'] . '
            </td>
        </tr>';
               if (!empty($all_notes_company)) {
                    $content .= '<tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                 Note:
                            </td>';
                    foreach ($all_notes_company as $n) {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $n->note . '</td>';
                    }
                    $content .= '</tr>';
                }
                $content .= '</tbody></table>';
                
            
            }elseif($service_id == '7'){ //    Certificate Shares 
                
                
                $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>
            <tr>
                <td colspan="2"
                    style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <h3>    Certificate Shares #' . $edit_data[0]['id'] . '</h3></td>
            </tr>
           
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['name'] . '</td>
            </tr>
            
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State
                    of Incorporation:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $getstatename['state_name'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Month & Year 
                to Start:

                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['start_month_year'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Federal ID:

                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fein'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">DBA:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['dba'] . '</td>
            </tr>
            
           
     
        
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($edit_data[0]['business_description']) . '</td>
            </tr>';

                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                    Info:
                </td>';

//echo 1;exit;
                if ($contactlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($contactlist as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email: </b>" . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owners:
            </td>';
                if (!empty($ownerlist)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($ownerlist as $title) {

                        $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                    <b>Date of birth:</b> " . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage:</b> " . $title->percentage . "%<br>
                                    <b>Language:</b> " . $title->language . "<br>
                                   <b> Country of Residence:</b> " . $title->country_residence_name . "<br>
                                    <b>Country of Citizenship:</b> " . $title->country_citizenship_name . "<br>
                                    <b>SSN_ITIN:</b>" . $title->ssn_itin . "<br>
                                </p></div>";
                    }
                    $content .= "</td>";
                }

                $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
                if (!empty($owner_list)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($owner_list as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones :</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                   
                }
                $content .= "</td>";
                $content .= '<tr>
                  
                 <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Total Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['total_of_order'] . '</td>
                </tr>';

                $content .= '<tr>
                    
               
                
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Office:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $office_details['name'] . '</td>
            </tr>';

                if ($edit_data[0]['partner'] != "") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Partner:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $partner_name['first_name'] . " " . $partner_name['last_name'] . '
                    </td>
                </tr>';
                }
                if ($edit_data[0]['manager'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Manager:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $manager_name['first_name'] . ' ' . $manager_name['last_name'] . '
                </td>
            </tr>';
                }
                if ($edit_data[0]['client_association'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                    Association:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['client_association'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                Source:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $ref_by_src['source'] . '
            </td>
        </tr>';
                if ($edit_data[0]['referred_by_name'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Referred By Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['referred_by_name'] . '
                </td>
            </tr>';
                }
                  if ($edit_data[0]['practice_id'] != "") { 
            $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Existing Practice Id:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">'.$edit_data[0]['practice_id'].'
                </td>
            </tr>';
         } 
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $lang['language'] . '
            </td>
        </tr>';
               if (!empty($all_notes_company)) {
                    $content .= '<tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                 Note:
                            </td>';
                    foreach ($all_notes_company as $n) {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $n->note . '</td>';
                    }
                    $content .= '</tr>';
                }
                $content .= '</tbody></table>';
                
            
            }
        } elseif ($catid == 2) { //for accounting
            if ($service_id == '10' || $service_id == '41') {
                $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>';
                if ($subcat == 1) {
                    $content .= '<tr>
                    <td colspan="2"
                        style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <h3>Recurring Bookkeeping #' . $edit_data[0]['id'] . '</h3></td>
                </tr>';
                } else {
                    $content .= '<tr>
                    <td colspan="2"
                        style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <h3>Bookkeeping By Date #' . $edit_data[0]['id'] . '</h3></td>
                </tr>';
                }
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                    Business:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['name'] . '
                </td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State
                    of Incorporation:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $getstatename['state_name'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Tracking:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';

                $status = $edit_data[0]['main_order_status'];
                if ($status == 0) {
                    $tracking = 'Completed';
                } elseif ($status == 1) {
                    $tracking = 'Started';
                } elseif ($status == 2) {
                    $tracking = 'Not Started';
                }
                $content .= $tracking . '
                </td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Date
                    Requested:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' .
                        normalizeDatehelper($edit_data[0]['order_date']) . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Office:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';

                $sql_query = "select idata.*,(select name from office where id=idata.office) as office_name from internal_data idata where idata.reference='" . $edit_data[0]['reference'] . "' and idata.reference_id='" . $edit_data[0]['reference_id'] . "'";

                $conn = $this->db;
                $sql_query_result = $conn->query($sql_query)->row();
                $content .= $sql_query_result->office_name . '
                    
                </td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Start
                    Date:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . date("m/d/Y", strtotime($edit_data[0]['start_date'])) . '
                </td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Completed Date:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . date("m/d/Y", strtotime($edit_data[0]['complete_date'])) . '
                </td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Amount:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['total_of_order'] . '
                </td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Requested By:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $rq_by[0]['first_name'] . ' ' . $rq_by[0]['last_name'] . '
                </td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '
                </td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Fiscal
                    Year End:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $i = $edit_data[0]['fye'];
                $content .= date("F", strtotime("2000-$i-01")) . ' 
                </td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    DBA:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . ($edit_data[0]['dba']) . '</td>
            </tr>
            
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($edit_data[0]['business_description']) . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                    Info:
                </td>';

                if ($contactlistbookkeeping) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($contactlistbookkeeping as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b>" . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }

                $content .= '</tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Owners:
                </td>';
                if (isset($ownerlist) && !empty($ownerlist)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($ownerlist as $title) {
                        $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                    <b>Date of birth:</b> " . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage:</b> " . $title->percentage . "%<br>
                                    <b>Language:</b> " . $title->language . "<br>
                                    <b>Country of Residence:</b> " . $title->country_residence_name . "<br>
                                    <b>Country of Citizenship:</b> " . $title->country_citizenship_name . "<br>
                                    <b>SSN_ITIN:</b>" . $title->ssn_itin . "<br>    
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
                if (isset($owner_list) && !empty($owner_list)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($owner_list as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }

                $content .= '</tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Office:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $office_details['name'] . '</td>
            </tr>';
                if ($edit_data[0]['partner'] != "") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Partner:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $partner_name['first_name'] . " " . $partner_name['last_name'] . '
                    </td>
                </tr>';
                }
                if ($edit_data[0]['manager'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Manager:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $manager_name['first_name'] . ' ' . $manager_name['last_name'] . '
                </td>
            </tr>';
                }
                if ($edit_data[0]['client_association'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                    Association:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['client_association'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                Source:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $ref_by_src['source'] . '
            </td>
        </tr>';
                if (isset($edit_data[0]['referred_by_name']) && $edit_data[0]['referred_by_name'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Referred By Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['referred_by_name'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $lang['language'] . '
            </td>
        </tr>';

                if (isset($get_bookkeeping[0]['existing_practice_id']) && $get_bookkeeping[0]['existing_practice_id'] != '') {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Existing Practise Id:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $get_bookkeeping[0]['existing_practice_id'] . '</td>
                </tr>';
                }
                if ($edit_data[0]['price_charged'] != "") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Bookkeeping Price:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['price_charged'] . '</td>
                </tr>';
                }
                $content .= '</tbody></table><tbody><table>';
                if (!empty($all_notes_main_service)) {
                    $content .= '<tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                Bookkeeping Note:
                            </td>';
                    foreach ($all_notes_main_service as $n) {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $n->note . '</td>';
                    }
                    $content .= '</tr>';
                }
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Financial Accounts:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';

                if ($subcat == 1) {
                    if ($acc_list) {
                        foreach ($acc_list as $title) {
                            $type = $title->type_of_account;
                            if (strpos($type, 'Account') !== false) {
                                $short_type = str_replace('Account', '', $type);
                            } else {
                                $short_type = $type;
                            }

                            $content .= "<div class='media-body'><label class='label label-primary'>" . $short_type . "</label>
                              <h4 class='media-heading'> " . $title->bank_name . " </h4>
                                <p>
                                    Total Amount: " . "$" . $title->total_amount . " <br>
                                    # Of Transactions: " . $title->number_of_transactions . "
                                </p></div>";
                        }
                    }
                } else {
                    if ($acc_list) {
                        foreach ($acc_list as $title) {
                            $type = $title->type_of_account;
                            if (strpos($type, 'Account') !== false) {
                                $short_type = str_replace('Account', '', $type);
                            } else {
                                $short_type = $type;
                            }

                            $content .= "<div class='media-body'><label class='label label-primary'>" . $short_type . "</label>
                                            <h4 class='media-heading'> " . $title->bank_name . " </h4>
                                            <p>
                                                Grand Total Amount: " . "$" . $title->grand_total . " <br>
                                                # Of Transactions: " . $title->number_of_transactions . "
                                            </p></div>";
                        }
                    }
                }
                $content .= '</td>
            </tr>';
                if ($subcat == 1) {
                    if (!empty($related_services)) {
                        $content .= '<tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            Related Services:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                        foreach ($related_services as $rs) {
                            if ($rs->services_id != '10') {
                                $all_notes_service = getmainServiceNotesContent($edit_data[0]['id'], $rs->services_id);
                                if ($rs->services_id == '10' || $rs->services_id == '41') {
                                    $query = 'select sum(grand_total) as total from financial_accounts where company_id="' . $edit_data[0]['reference_id'] . '"';
                                    $query_result = $this->db->query($query)->result_array();
                                    if ($query_result[0]['total'] != '0') {
                                        $sub_tot = $query_result[0]['total'];
                                        $query_corp = 'select * from bookkeeping where company_id="' . $ref_id . '"';
                                        $query_corp_result = $this->db->query($query_corp)->result_array();
                                        $corp_tax = $query_corp_result[0]['corporate_tax_return'];
                                        if ($corp_tax == 'y') {
                                            $tot = $sub_tot + 35;
                                        } else {
                                            $tot = $sub_tot;
                                        }
                                    } else {
                                        $query_sub = 'select sum(total_amount) as total from financial_accounts where company_id="' . $ref_id . '"';
                                        $query_sub_result = $this->db->query($query_sub)->result_array();
                                        $tot = $query_sub_result[0]['total'];
                                    }
                                }


                                $content .= "<label>" . $rs->service_name . "</label>
                                <p> 
                                    <b>Retail Price: </b>";
                                if ($rs->services_id == '10' || $rs->services_id == '41') {
                                    $content .= '$' . $tot;
                                } else {
                                    $get_service_details = get_service_details($rs->services_id);
                                    $content .= $get_service_details[0]['retail_price'];
                                }
                                $content .= "</p>";
                                $content .= "<p>
                                    <b>Override Price: </b> " . $rs->price_charged . " 
                                </p>";
                                $content .= "<p>
                                    <b>Responsible Department: </b>";
                                $resp_dept = get_resp_dept($rs->services_id);
                                $content .= $resp_dept[0]['dept_name'];
                                $content .= "</p>";
                                $content .= "<p>
                                    <b>Tracking Description: </b>";
                                $tracking_desc = get_tracking_srv($rs->services_id);
                                $status = $tracking_desc[0]['status'];
                                $start_date = date('m/d/Y', strtotime($rs->date_started));
                                $end_date = date('m/d/Y', strtotime($rs->date_completed));
                                if ($status == 0) {
                                    $tracking = 'Completed';
                                    $actual_complete = $end_date;
                                } elseif ($status == 1) {
                                    $tracking = 'Started';
                                    $actual_complete = 'N/A';
                                } elseif ($status == 2) {
                                    $tracking = 'Not Started';
                                    $actual_complete = 'N/A';
                                }
                                $content .= $tracking;
                                $content .= "</p>";
                                $content .= "<p>
                                    <b>Target Start: </b> " . $start_date . "  
                                </p><p>
                                    <b>Target Complete: </b> " . $end_date . "  
                                </p><p>
                                    <b>Actual Complete: </b> " . $actual_complete . "  
                                </p>";
                                if (!empty($all_notes_service)) {
                                    foreach ($all_notes_service as $k => $n) {
                                        if ($n->note != "")
                                            $content .= $k == 0 ? 'Service Notes: ' : "";
                                        $content .= $n->note . '<br>';
                                    }
                                }
                            }
                        }
                        $content .= '</td>
                    </tr>';
                    }
                }

                if (!empty($all_notes_bookkeeping)) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Order Notes: </td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                    foreach ($all_notes_bookkeeping as $n) {
                        $content .= $n->note . '<br>';
                    }
                    $content .= '</td></tr>';
                }

                if ($subcat == 1) {
                    $content .= '<tr>
                    <td>Frequency Of Bookkeeping:</td>';
                    if (isset($get_bookkeeping[0]['frequency']) && $get_bookkeeping[0]['frequency'] == 'm') {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Monthly</td>';
                    } elseif (isset($get_bookkeeping[0]['frequency']) && $get_bookkeeping[0]['frequency'] == 'q') {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Quarterly</td>';
                    } elseif (isset($get_bookkeeping[0]['frequency']) && $get_bookkeeping[0]['frequency'] == 'y') {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Yearly</td>';
                    }
                    $content .= '</tr>';
                }
                 $content .= '<tr>';
                
                $content .='<td><h3>Files:
                </h3>';
                if (!empty($documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($documents);
                foreach ($documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                    if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                }
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                $content.='</td></tr>';
                 if (!empty($owner_documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($owner_documents);
                foreach ($owner_documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                 if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                    
                }
                
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                $content .='</td></tr>';
                $content .= '</tbody>
        </table>';
            } //end bookkeeping
            elseif ($service_id == '11') { //start payroll 
                $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>
            <tr>
                <td colspan="2"
                    style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <h3>Payroll #' . $edit_data[0]['id'] . '</h3></td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['name'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">DBA (if
                    any):
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['dba'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Address:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_company_data['company_address'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">City:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_company_data['city'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    State:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_company_data['state'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Zip:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_company_data['zip'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">FEIN:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fein'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">FYE:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fye'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Started:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_company_data['company_started'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Phone
                    Number:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_company_data['phone_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Fax:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fax'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Email:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['email'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Website:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['website'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Notes:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($notes_data['note']) . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($company_data['business_description']) . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['bank_name'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Account #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['ban_account_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Routing #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['bank_routing_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Do you
                    have a RT-6 #?:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['rt6_availability'] . '</td>
            </tr>';
                if ($payroll_account_numbers['rt6_availability'] == "Yes") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        RT-6 Number:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['rt6_number'] . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        State:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['state'] . '</td>
                </tr>';
                } else {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Resident or Non-resident:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_account_numbers['resident_type'] . '</td>
                </tr>';
                }
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Frequency:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_data['payroll_frequency'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Payday:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_data['payday'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Pay
                    Period Ending:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Month</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                    Info:
                </td>';

                if ($contactlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($contactlist as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                   <b> Phones : </b>" . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Owners:
                </td>';

                if (isset($ownerlist) && !empty($ownerlist)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($ownerlist as $title) {
                        $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                    <b>Date of birth:</b> " . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage: </b>" . $title->percentage . "%<br>
                                   <b> Language: </b>" . $title->language . "<br>
                                    <b>Country of Residence: </b>" . $title->country_residence_name . "<br>
                                   <b> Country of Citizenship: </b>" . $title->country_citizenship_name . "<br>
                                   <b> SSN_ITIN:</b>" . $title->ssn_itin . "<br>
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
                if (isset($owner_list) && !empty($owner_list)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($owner_list as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email: </b>" . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver First Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['fname'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Last Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['lname'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Title:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['title'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Social Security #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['social_security'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Phone Number:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['phone'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Ext:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['ext'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Fax:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['fax'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                    Approver Email:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $payroll_approver['email'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal First Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['fname'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Last Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['lname'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Title:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['title'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Social Security #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['social_security'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Phone Number:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['phone'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Ext:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['ext'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Fax:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['fax'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                    Principal Email:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_principal['email'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Signer
                    Data First Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $signer_data['fname'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Signer
                    Data Last Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $signer_data['lname'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Signer
                    Data Social Security #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $signer_data['social_security'] . '</td>
            </tr>';
                $content .= '</tbody></table><tbody><table>';
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Employee Data:
                </td>';

                if ($employee_list) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($employee_list as $el) {
                        $content .= "<div class='media-body'><label
                                    class='label label-primary'>" . $el['employee_type'] . "</label>
                            <h4 class='media-heading'>Employee
                                Name: " . $el['first_name'] . " " . $el['last_name'] . " </h4>
                            <p>
                                Phones: " . $el['phone_number'] . "<br>
                                Email: " . $el['email'] . "<br>
                                Address: " . $el['address'] . "<br>
                                City: " . $el['city'] . "<br>
                                State: " . $el['state'] . "<br>
                                Zip: " . $el['zip'] . "<br>
                                Home Phone: " . $el['phone_number'] . "<br>
                                SS #: " . $el['ss'] . "<br>
                                Gender: " . $el['gender'] . "<br>
                                Email: " . $el['email'] . "<br>
                                Pay Type: " . $el['is_paid'] . "<br>
                                Date Of Birth: " . date('m/d/Y', strtotime($el['date_of_birth'])) . "<br>
                                Date Of Hire: " . date('m/d/Y', strtotime($el['date_of_hire'])) . "<br>
                                Payroll Check Receive Type: " . $el['payroll_check'] . "<br>";
                        if ($el['payroll_check'] == 'Direct Deposit') {
                            $content .= "Bank Account Type: " . $el['zip'] . "<br>
                                    Bank Account #: " . $el['zip'] . "<br>
                                    Bank Routing #: " . $el['zip'] . "<br>";
                        }
                        $content .= "Hourly Rate or Salary Per Pay Period: " . $el['hourly_rate'] . "<br>
                                Filing Status: " . $el['filing_status'] . "<br>
                                # of Allowances from IRS Form W-4: " . $el['irs_form'] . "
                            </p></div>";
                    }
                    $content .= "</td>";
                }

                $content .= '</tr>
                <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">How many people are on payroll:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $employee_details['payroll_people_total'] . '</td>
                </tr>
                <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Retail Price ($ Per Month):
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $employee_details['retail_price'] . '</td>
                </tr>
                <tr>    
                 <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Override Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $employee_details['override_price'] . '</td>
                </tr>';
                if (!empty($payroll_employee_notes)) {
                    $content .= '<tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                Payroll Employee Note:
                            </td>';
                    foreach ($payroll_employee_notes as $n) {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $n['note'] . '</td>';
                    }
                    $content .= '</tr>';
                }
                 $content .= '<tr>';
                
                $content .='<td><h3>Files:
                </h3>';
                if (!empty($documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($documents);
                foreach ($documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                    if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                }
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                 if (!empty($owner_documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($owner_documents);
                foreach ($owner_documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                 if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                    
                }
                
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                
                if (!empty($payroll_wage_files)) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Wage Files:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                    $filesval = '';
                    $i = 0;
                    $len = count($payroll_wage_files);
                    foreach ($payroll_wage_files as $wage_files) {
                        $content .= '<a href=' . base_url() . '/uploads/' . $wage_files['file_name'] . ' ;>' . $wage_files['file_name'] . '</a><br>';
                        if ($i == $len - 1) {
                          $filesval .= $wage_files['file_name'];
                        }else{
                          $filesval .= $wage_files['file_name'].', ';
                        }
                        $i++;
                    }
                    $content .= '</td></tr>';
                    $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                    $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                    $content .= '<button type="submit">Download All</button></form></td>';
                }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Wage Files:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                    $content.='N/A';
                    $content .= '</td></tr>';
                }
                
                if (!empty($payroll_account_numbers)) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">RT6 Unemployment App Void Cheque:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= '<a href=' . base_url() . '/uploads/' . $payroll_account_numbers['void_cheque'] . ' ;>' . $payroll_account_numbers['void_cheque'] . '</a><br>';

                    $content .= '</td></tr>';
                }else{
                     $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">RT6 Unemployment App Void Cheque:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content.='N/A';

                    $content .= '</td></tr>';
                }
                if ($payroll_account_numbers['passport'] != "") {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Passport:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= '<a href=' . base_url() . '/uploads/' . $payroll_account_numbers['passport'] . ' ;>' . $payroll_account_numbers['passport'] . '</a><br>';

                    $content .= '</td></tr>';
                }else{
                    
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Passport:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                    $content .= 'N/A';
                    $content .= '</td></tr>';
                }
                
                if ($payroll_account_numbers['lease'] != "" && file_exists($payroll_account_numbers['lease'])) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Lease:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= '<a href=' . base_url() . '/uploads/' . $payroll_account_numbers['lease'] . ' ;>' . $payroll_account_numbers['lease'] . '</a><br>';

                    $content .= '</td></tr>';
                }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Lease:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                    $content .= 'N/A';
                    $content .= '</td></tr>';
                }
                if ($payroll_company_data['fein_filename'] != "" && file_exists($payroll_company_data['fein_filename'])) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">FEIN File:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= '<a href=' . base_url() . '/uploads/' . $payroll_company_data['fein_filename'] . ' ;>' . $$payroll_company_data['fein_filename'] . '</a><br>';

                    $content .= '</td></tr>';
                }else{
                     $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">FEIN File:</td>';
                     $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                     $content .= 'N/A';
                     $content .= '</td></tr>';
                }

                if (!empty($payroll_driver_license_data)) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll Driver License File:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';

                    foreach ($payroll_driver_license_data as $license_data) {
                        $content .= '<a href=' . base_url() . '/uploads/' . $license_data['file_name'] . ' ;>' . $license_data['file_name'] . '</a><br>';
                    }
                    $content .= '</td></tr>';
                }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll Driver License File:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                    $content.='N/A';
                    $content .= '</td></tr>';
                    
                }
                $content .='</td></tr>';
                $content .= '</tbody></table>';
            } //end payroll 
            elseif ($service_id == '12') { //start salestax 
                $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>
            <tr>
                <td colspan="2"
                    style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <h3>Sales Tax Application #' . $edit_data[0]['id'] . '</h3></td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['name'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State
                    of Incorporation:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $getstatename['state_name'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Month & Year To Start:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['start_month_year'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">FYE:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fye'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Federal ID:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fein'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">DBA:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['dba'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($company_data['business_description']) . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['bank_name'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Account #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['bank_account_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Routing #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['bank_routing_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Do you
                    have a RT-6 #?:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['rt6_availability'] . '</td>
            </tr>';
                if ($sales_tax_data['rt6_availability'] == "Yes") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        RT-6 Number:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['rt6_number'] . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        State:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['state'] . '</td>
                </tr>';
                } else {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Resident or Non-resident:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['resident_type'] . '</td>
                </tr>';
                }
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                    Info:
                </td>';

                if ($contactlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($contactlist as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones: </b>" . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email: </b>" . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Owners:
                </td>';

                if (isset($ownerlist) && !empty($ownerlist)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($ownerlist as $title) {
                        $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                    <b>Date of birth:</b> " . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage:</b> " . $title->percentage . "%<br>
                                    <b>Language:</b> " . $title->language . "<br>
                                    <b>Country of Residence:</b> " . $title->country_residence_name . "<br>
                                    <b>Country of Citizenship:</b> " . $title->country_citizenship_name . "<br>
                                     <b>SSN_ITIN:</b>" . $title->ssn_itin . "<br>
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
                if (isset($owner_list) && !empty($owner_list)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($owner_list as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                   <b> Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State of Sales Tax:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . ($sales_tax_data['state_recurring'] != 0 ? state_info($sales_tax_data['state_recurring'])['state_name'] : 'N/A') . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">County of Sales Tax:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . ($sales_tax_data['country_recurring'] != 0 ? county_info($sales_tax_data['country_recurring'])['name'] : 'N/A') . '</td>
            </tr>';

                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Office:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $office_details['name'] . '</td>
            </tr>';
                if ($edit_data[0]['partner'] != "") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Partner:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $partner_name['first_name'] . " " . $partner_name['last_name'] . '
                    </td>
                </tr>';
                }
                if ($edit_data[0]['manager'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Manager:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $manager_name['first_name'] . ' ' . $manager_name['last_name'] . '
                </td>
            </tr>';
                }
                if ($edit_data[0]['client_association'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                    Association:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['client_association'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                Source:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $ref_by_src['source'] . '
            </td>
        </tr>';
                if ($edit_data[0]['referred_by_name'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Referred By Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['referred_by_name'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $lang['language'] . '
            </td>
        </tr>';
                if ($sales_tax_data['existing_practice_id'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Existing Practise Id:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['existing_practice_id'] . '
                </td>
            </tr>';
                }

                if (!empty($salestax_employee_notes)) {
                    $content .= '<tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                Payroll Employee Note:
                            </td>';
                    foreach ($salestax_employee_notes as $n) {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $n['note'] . '</td>';
                    }
                    $content .= '</tr>';
                }
                 $content .= '<tr>';
                
                $content .='<td><h3>Files:
                </h3>';
                if (!empty($documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($documents);
                foreach ($documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                    if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                }
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                 if (!empty($owner_documents)) {
               $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($owner_documents);
                foreach ($owner_documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                 if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                    
                }
               
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                
                if ($sales_tax_data['void_cheque'] != "" ) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">RT6 Unemployment App Void Cheque:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= '<a href=' . base_url() . '/uploads/' . $sales_tax_data['void_cheque'] . ' ;>' . $sales_tax_data['void_cheque'] . '</a><br>';

                    $content .= '</td></tr>';
                } else {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">RT6 Unemployment App Void Cheque:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }

                if ($sales_tax_data['passport'] != "" ) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Passport:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= '<a href=' . base_url() . '/uploads/' . $sales_tax_data['passport'] . ' ;>' . $sales_tax_data['passport'] . '</a><br>';

                    $content .= '</td></tr>';
                } else {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Passport:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                if ($sales_tax_data['lease'] != "" ) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Lease:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= '<a href=' . base_url() . '/uploads/' . $sales_tax_data['lease'] . ' ;>' . $sales_tax_data['lease'] . '</a><br>';

                    $content .= '</td></tr>';
                } else {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Lease:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                    $content .= 'N/A';
                    $content .= '</td></tr>';
                }
                if (!empty($salestax_driver_license_data)) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Salestax Driver License File:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';

                    foreach ($salestax_driver_license_data as $license_data) {
                        $content .= '<a href=' . base_url() . '/uploads/' . $license_data['file_name'] . ' ;>' . $license_data['file_name'] . '</a><br>';
                    }
                    $content .= '</td></tr>';
                } else {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Salestax Driver License File:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                $content.='</td></tr>';
                $content .= '</tbody></table>';
            } elseif ($service_id == '14') { //start rt6 
                $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>
            <tr>
                <td colspan="2"
                    style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <h3>Rt6 Unemployment App #' . $edit_data[0]['id'] . '</h3></td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['name'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State
                    of Incorporation:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $getstatename['state_name'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Month & Year To Start:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['start_month_year'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">FYE:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fye'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Federal ID:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fein'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">DBA:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['dba'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($company_data['business_description']) . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['bank_name'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Account #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['bank_account_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                    Routing #:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['bank_routing_number'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Will the company need Sales Tax Application as well?:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['salestax_availability'] . '</td>
            </tr>';
                if ($sales_tax_data['salestax_availability'] == "Yes") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Sales Tax Number:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['salestax_number'] . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        State:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['state'] . '</td>
                </tr>';
                } else {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Resident or Non-resident:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['resident_type'] . '</td>
                </tr>';
                }
                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                    Info:
                </td>';

                if ($contactlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($contactlist as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                   <b> Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Owners:
                </td>';

                if (isset($ownerlist) && !empty($ownerlist)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($ownerlist as $title) {
                        $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                   <b> Date of birth: </b>" . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage:</b> " . $title->percentage . "%<br>
                                   <b> Language: </b>" . $title->language . "<br>
                                    <b>Country of Residence: </b>" . $title->country_residence_name . "<br>
                                    <b>Country of Citizenship:</b> " . $title->country_citizenship_name . "<br>
                                    <b>SSN_ITIN:</b>" . $title->ssn_itin . "<br>
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
                if (isset($owner_list) && !empty($owner_list)) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($owner_list as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';


                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Office:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $office_details['name'] . '</td>
            </tr>';
                if ($edit_data[0]['partner'] != "") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Partner:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $partner_name['first_name'] . " " . $partner_name['last_name'] . '
                    </td>
                </tr>';
                }
                if ($edit_data[0]['manager'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Manager:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $manager_name['first_name'] . ' ' . $manager_name['last_name'] . '
                </td>
            </tr>';
                }
                if ($edit_data[0]['client_association'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                    Association:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['client_association'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                Source:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $ref_by_src['source'] . '
            </td>
        </tr>';
                if ($edit_data[0]['referred_by_name'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Referred By Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['referred_by_name'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $lang['language'] . '
            </td>
        </tr>';
                if ($sales_tax_data['existing_practice_id'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Existing Practise Id:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $sales_tax_data['existing_practice_id'] . '
                </td>
            </tr>';
                }

                if (!empty($salestax_employee_notes)) {
                    $content .= '<tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                Payroll Employee Note:
                            </td>';
                    foreach ($salestax_employee_notes as $n) {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $n['note'] . '</td>';
                    }
                    $content .= '</tr>';
                }
                
                $content .= '<tr>';
                
                $content .='<td><h3>Files:
                </h3>';
               
                if (!empty($documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($documents);
                foreach ($documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                    if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                }
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                 if (!empty($owner_documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($owner_documents);
                foreach ($owner_documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                 if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                    
                }
               
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                
                if ($sales_tax_data['void_cheque'] != "" && file_exists($sales_tax_data['void_cheque'])) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">RT6 Unemployment App Void Cheque:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= '<a href=' . base_url() . '/uploads/' . $sales_tax_data['void_cheque'] . ' ;>' . $sales_tax_data['void_cheque'] . '</a><br>';

                    $content .= '</td></tr>';
                } else {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">RT6 Unemployment App Void Cheque:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                 if (!empty($salestax_driver_license_data)) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Salestax Driver License File:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';

                    foreach ($salestax_driver_license_data as $license_data) {
                        $content .= '<a href=' . base_url() . '/uploads/' . $license_data['file_name'] . ' ;>' . $license_data['file_name'] . '</a><br>';
                    }
                    $content .= '</td></tr>';
                } else {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Salestax Driver License File:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                 if ($sales_tax_data['passport'] != "") {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Passport:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= '<a href=' . base_url() . '/uploads/' . $sales_tax_data['passport'] . ' ;>' . $sales_tax_data['passport'] . '</a><br>';

                    $content .= '</td></tr>';
                } else {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Passport:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                 if ($sales_tax_data['lease'] != "" && file_exists($sales_tax_data['lease'])) {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Lease:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= '<a href=' . base_url() . '/uploads/' . $sales_tax_data['lease'] . ' ;>' . $sales_tax_data['lease'] . '</a><br>';

                    $content .= '</td></tr>';
                } else {
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Lease:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
             
                $content.='</td></tr>';
                $content .= '</tbody></table>';
                
                



                $content .= '</tbody></table>';
            } elseif ($service_id == 47) {
//                print_r($documents);die;
                //start salea tax recurring
                if ($recurring_data->freq_of_salestax == 'm') {
                    $freq_of_salesrax = 'Monthly';
                } else if ($recurring_data->freq_of_salestax == 'q') {
                    $freq_of_salesrax = 'Quarterly';
                } else if ($recurring_data->freq_of_salestax == 'b') {
                    $freq_of_salesrax = 'BI-ANNUAL';
                } else if ($recurring_data->freq_of_salestax == 'y') {
                    $freq_of_salesrax = 'Yearly';
                }
                $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>
            <tr>
                <td colspan="2"
                    style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <h3>Recurring Salestax #' . $edit_data[0]['id'] . '</h3></td>
            </tr>
           
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['name'] . '</td>
            </tr>
            
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State
                    of Incorporation:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $getstatename['state_name'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Month & Year To Start:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $recurring_data->start_month_year . '</td>
            </tr>
           <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Fiscal Year
                End:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $i = $edit_data[0]['fye'];
                $content .= date("F", strtotime("2000-$i-01")) . '</td>
        </tr>
        <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Federal ID:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fein'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">DBA:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['dba'] . '</td>
            </tr>
        
            
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($company_data['business_description']) . '</td>
            </tr>';

                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                    Info:
                </td>';


                if ($contactlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($contactlist as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email: </b>" . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owners:
            </td>';
                if ($ownerlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($ownerlist as $title) {

                        $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                    <b>Date of birth:</b> " . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage:</b> " . $title->percentage . "%<br>
                                    <b>Language:</b> " . $title->language . "<br>
                                   <b> Country of Residence:</b> " . $title->country_residence_name . "<br>
                                    <b>Country of Citizenship:</b> " . $title->country_citizenship_name . "<br>
                                    <b>SSN_ITIN:</b>" . $title->ssn_itin . "<br>
                                </p></div>";
                    }
                    $content .= "</td>";
                }

                $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
                if ($owner_list) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($owner_list as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones :</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }

                $content .= '</tr>';

                $content .= '<tr>
                  
                 <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Total Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['total_of_order'] . '</td>
                </tr>';
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
           Frequency Of Salestax:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $freq_of_salesrax . '
            </td>
        </tr>';

                $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        State of Salestax:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $state_name->state_name . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        County of Salestax:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $county->name . '</td>
                </tr>
                <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Office:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $office_details['name'] . '</td>
            </tr>';

                if ($edit_data[0]['partner'] != "") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Partner:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $partner_name['first_name'] . " " . $partner_name['last_name'] . '
                    </td>
                </tr>';
                }
                if ($edit_data[0]['manager'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Manager:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $manager_name['first_name'] . ' ' . $manager_name['last_name'] . '
                </td>
            </tr>';
                }
                if ($edit_data[0]['client_association'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                    Association:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['client_association'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                Source:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $ref_by_src['source'] . '
            </td>
        </tr>';
                if ($edit_data[0]['referred_by_name'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Referred By Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['referred_by_name'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $lang['language'] . '
            </td>
        </tr>';
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Sales Tax Id:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $recurring_data->sales_tax_id . '
            </td>
        </tr>';
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
            Website:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $recurring_data->website . '
            </td>
        </tr>';
                if ($recurring_data->existing_practice_id != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Existing Practise Id:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $recurring_data->existing_practice_id . '
                </td>
            </tr>';
                }

                if (!empty($salestax_employee_notes)) {
                    $content .= '<tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                Payroll Employee Note:
                            </td>';
                    foreach ($salestax_employee_notes as $n) {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $n['note'] . '</td>';
                    }
                    $content .= '</tr>';
                }
                 $content .= '<tr>';
                
                $content .='<td><h3>Files:
                </h3>';
                if (!empty($documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($documents);
                foreach ($documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                    if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                }
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                 if (!empty($owner_documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($owner_documents);
                foreach ($owner_documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                 if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                    
                }
                
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
               
                $content.='</td></tr>';
                $content .= '</tbody></table>';
            } elseif ($service_id == 13) {
                //start salea tax processing
                if ($recurring_data->frequeny_of_salestax == 'm') {
                    $freq_of_salesrax = 'Monthly';
                } else if ($recurring_data->frequeny_of_salestax == 'q') {
                    $freq_of_salesrax = 'Quarterly';
                } else if ($recurring_data->frequeny_of_salestax == 'y') {
                    $freq_of_salesrax = 'Yearly';
                }
                $content .= '<table class="table table-striped" style="width:100%;">
            <tbody>
            <tr>
                <td colspan="2"
                    style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <h3>Salestax Processing #' . $edit_data[0]['id'] . '</h3></td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['name'] . '</td>
            </tr>
            
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State
                    of Incorporation:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $getstatename['state_name'] . '</td>
            </tr>
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                    Company:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $gettypename['type'] . '</td>
            </tr>
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Month & Year To Start:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $recurring_data->start_year . '</td>
            </tr>
           <tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Fiscal Year
                End:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $i = $edit_data[0]['fye'];
                $content .= date("F", strtotime("2000-$i-01")) . '</td>
        </tr>
        <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Federal ID:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['fein'] . '</td>
            </tr>
        
             <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">DBA:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $company_data['dba'] . '</td>
            </tr> 
            
            <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Business Description:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . urldecode($company_data['business_description']) . '</td>
            </tr>';

                $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                    Info:
                </td>';


                if ($contactlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($contactlist as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones:</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email: </b>" . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }
                $content .= '</tr>';
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owners:
            </td>';
                if ($ownerlist) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($ownerlist as $title) {

                        $content .= "<div class='media-body'><label class='label label-primary'>" . $title->title . "</label>
                                    <h4 class='media-heading'>Name: " . $title->name . " </h4>
                                    <p>
                                    <b>Date of birth:</b> " . normalizeDatehelper($title->birth_date) . "<br>
                                    <b>Percentage:</b> " . $title->percentage . "%<br>
                                    <b>Language:</b> " . $title->language . "<br>
                                   <b> Country of Residence:</b> " . $title->country_residence_name . "<br>
                                    <b>Country of Citizenship:</b> " . $title->country_citizenship_name . "<br>
                                    <b>SSN_ITIN:</b>" . $title->ssn_itin . "<br>
                                </p></div>";
                    }
                    $content .= "</td>";
                }

                $content .= '<tr>
                <td>Owner Contact Info:
                </td>';
                if ($owner_list) {
                    $content .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                    foreach ($owner_list as $contact) {
                        $content .= "<div class='media-body'>
                            <label class='label label-primary'>" . $contact->type . "</label>
                            <h4 class='media-heading'>Contact Name: " . $contact->first_name . " " . $contact->middle_name . " " . $contact->last_name . " </h4>
                                <p>
                                   
                                    <b>Phones :</b> " . $contact->phone1 . ($contact->phone1_country_name) . "<br>
                                    <b>Email:</b> " . $contact->email1 . "<br>" .
                                "<b> Address:</b> " . $contact->address1 . "," . $contact->city . "," . $contact->state . "," . "ZIP:" . $contact->zip . "," . $contact->country_name . "
                                </p></div>";
                    }
                    $content .= "</td>";
                }



                $content .= '<tr>
                  
                 <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Total Price:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['total_of_order'] . '</td>
                </tr>';
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
           Frequency Of Salestax:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $freq_of_salesrax . '
            </td>
        </tr>';

                $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        State of Recurring:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $state_name->state_name . '</td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        County of Recurring:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $county->name . '</td>
                </tr>
                <tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Office:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $office_details['name'] . '</td>
            </tr>';

                if ($edit_data[0]['partner'] != "") {
                    $content .= '<tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Partner:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $partner_name['first_name'] . " " . $partner_name['last_name'] . '
                    </td>
                </tr>';
                }
                if ($edit_data[0]['manager'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Manager:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $manager_name['first_name'] . ' ' . $manager_name['last_name'] . '
                </td>
            </tr>';
                }
                if ($edit_data[0]['client_association'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                    Association:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['client_association'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                Source:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $ref_by_src['source'] . '
            </td>
        </tr>';
                if ($edit_data[0]['referred_by_name'] != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Referred By Name:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $edit_data[0]['referred_by_name'] . '
                </td>
            </tr>';
                }
                $content .= '<tr>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
            </td>
            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $lang['language'] . '
            </td>
        </tr>';

                if ($recurring_data->existing_practice_id != "") {
                    $content .= '<tr>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    Existing Practise Id:
                </td>
                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $recurring_data->existing_practice_id . '
                </td>
            </tr>';
                }

                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                foreach ($documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                }
                $content .= '</td></tr>';

                if (!empty($owner_documents)) {
                $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                $filesval = '';
                $i = 0;
                $len = count($owner_documents);
                foreach ($owner_documents as $d) {
                    $content .= '<a href=' . base_url() . '/uploads/' . $d['document'] . ' ;>' . $d['document'] . '</a><br>';
                 if ($i == $len - 1) {
                      $filesval .= $d['document'];
                    }else{
                      $filesval .= $d['document'].', ';
                    }
                    $i++;
                    
                }
               
                $content .= '</td></tr>';
                $content .= '<td><form name="download_form" method="POST" action="'.base_url().'services/home/download_zip">';
                $content .= '<input type="hidden" id="filesarray" name="filesarray" value="'.$filesval.'">';
                $content .= '<button type="submit">Download All</button></form></td>';
            }else{
                    $content .= '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owner Document:</td>';
                    $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';


                    $content .= 'N/A';

                    $content .= '</td></tr>';
                }
                

                if (!empty($salestax_employee_notes)) {
                    $content .= '<tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                Payroll Employee Note:
                            </td>';
                    foreach ($salestax_employee_notes as $n) {
                        $content .= '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">' . $n['note'] . '</td>';
                    }
                    $content .= '</tr>';
                }
                $content .= '</tbody></table>';
            }
        }
        echo $content;
        ?>
        <div class="text-right">
            <button class="btn btn-danger" type="button" onclick="go('services/home');">Back to dashboard</button>
        </div>
    </div>
</div>
