<?php
//echo $rowid;
//echo $catid;
//echo $reference_id;
//echo $service_id;
$ci = &get_instance();
$ci->load->model('Service');
$ci->load->model('Pdf');
$ci->load->model('Staff');
$ci->load->model('Contacts');
$ci->load->model('Company');
$ci->load->model('Documents');
$ci->load->model('Notes');
$ci->load->model('System');
$ci->load->model('Service');
$ci->load->model('payroll');
$ci->load->model('employee');
$edit_data = $ci->Service->get_edit_data($rowid);
//print_r($edit_data);
if ($catid == 1) { //for newcompany
    $service = $ci->Service->getService(1);
    $all_notes_main_service = $ci->Notes->getmainServiceNotesContent($edit_data[0]['id'], 1);
    ?>
    <div class="table-responsive">
        <table class="table table-striped" style="width:100%;">
            <tbody>
                <tr>
                    <td colspan="2"
                        style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <h3>New Corporation</h3></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State of
                        Incorporation:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        $getstatename = $ci->Pdf->getstatename($edit_data[0]['state_opened']);
                        echo $getstatename['state_name'];
                        ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                        Business:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
    <?php echo $edit_data[0]['name']; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Tracking:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        $status = $edit_data[0]['status'];
                        if ($status == 0) {
                            $tracking = 'Completed';
                        } elseif ($status == 1) {
                            $tracking = 'Started';
                        } elseif ($status == 2) {
                            $tracking = 'Not Started';
                        }
                        echo $tracking;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Date
                        Requested:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        echo $ci->System->normalizeDate($edit_data[0]['order_date']);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Office:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        $sql_query = "select idata.*,(select name from office where id=idata.office) as office_name from internal_data idata where idata.reference='" . $edit_data[0]['reference'] . "' and idata.reference_id='" . $edit_data[0]['reference_id'] . "'";

                        $conn = $this->db;
                        $sql_query_result = $conn->query($sql_query)->row();
                        echo $sql_query_result->office_name;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Start
                        Date:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        echo date("m/d/Y", strtotime($edit_data[0]['start_date']));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Completed
                        Date:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        echo date("m/d/Y", strtotime($edit_data[0]['complete_date']));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Amount:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        echo $edit_data[0]['total_of_order'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Requested
                        By:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        $staff_id = $edit_data[0]['staff_requested_service'];
                        $rq_by = $ci->Staff->get_staff_name($staff_id);
                        echo $rq_by[0]['first_name'] . ' ' . $rq_by[0]['last_name'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                        Company:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php $gettypename = $ci->Pdf->gettypename($edit_data[0]['company_type']);
                        echo $gettypename['type'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Fiscal Year
                        End:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php $i = $edit_data[0]['fye'];
                        echo date("F", strtotime("2000-$i-01"));
                        ?>
                    </td>
                </tr>
    <?php if ($edit_data[0]['business_description'] != "") { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            Business Description:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <?php echo urldecode($edit_data[0]['business_description']); ?>
                        </td>
                    </tr>
    <?php } ?>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                        Info:
                    </td>

                    <?php
                    $contactlist = $ci->Contacts->loadContactListpdf("company", $edit_data[0]['reference_id']);
                    if ($contactlist) {
                        echo "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                        foreach ($contactlist as $contact) {
                            echo "<div class='media-body'>
                            <label class='label label-primary'>{$contact->type}</label>
                            <h4 class='media-heading'>Contact Name: {$contact->first_name}" . " {$contact->middle_name}" . " {$contact->last_name} </h4>
                                <p>
                                   
                                    Phones 1: {$contact->phone1} ({$contact->phone1_country_name}) <br>
                                    Email: {$contact->email1} <br>
                                    {$contact->address1}, {$contact->city}, {$contact->state}, ZIP: {$contact->zip}, {$contact->country_name}
                                </p></div>";
                        }
                        echo "</td>";
                    }
                    ?>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Owners:
                    </td>

                    <?php
                    $ownerlist = $ci->Company->loadCompanyTitlepdf($edit_data[0]['reference_id']);
                    if ($ownerlist) {
                        echo "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                        foreach ($ownerlist as $title) {
                            echo "<div class='media-body'><label class='label label-primary'>{$title->title}</label>
                                    <h4 class='media-heading'>Name: {$title->name} </h4>
                                    <p>
                                    Date of birth: {$ci->System->normalizeDate($title->birth_date)}<br>
                                    Percentage: {$title->percentage}%<br>
                                    Language: {$title->language}<br>
                                    Country of Residence: {$title->country_residence_name}<br>
                                    Country of Citizenship: {$title->country_citizenship_name}<br>
                                </p></div>";
                        }
                        echo "</td>";
                    }
                    ?>

                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Office:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                <?php echo $ci->Pdf->getOffice($edit_data[0]['office'])['name']; ?>
                    </td>
                </tr>
    <?php if ($edit_data[0]['partner'] != "") { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            Partner:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <?php $staff_name = $ci->Pdf->getOfficeStaff($edit_data[0]['partner']);
                    echo $staff_name['first_name'] . " " . $staff_name['last_name'];
                    ?>
                        </td>
                    </tr>
    <?php } ?>
    <?php if ($edit_data[0]['manager'] != "") { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            Manager:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <?php $staff_name = $ci->Pdf->getOfficeStaff($edit_data[0]['manager']);
                    echo $staff_name['first_name'] . " " . $staff_name['last_name'];
                    ?>
                        </td>
                    </tr>
    <?php } ?>
                        <?php if ($edit_data[0]['client_association'] != "") { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Client
                            Association:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $edit_data[0]['client_association']; ?>
                        </td>
                    </tr>
                        <?php } ?>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Referred By
                        Source:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
    <?php echo $ci->Pdf->getReferredBySource($edit_data[0]['referred_by_source'])['source']; ?>
                    </td>
                </tr>
                        <?php if ($edit_data[0]['referred_by_name'] != "") { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            Referred By Name:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $edit_data[0]['referred_by_name']; ?>
                        </td>
                    </tr>
                        <?php } ?>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Language:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
    <?php echo $ci->Pdf->getLanguages($edit_data[0]['language'])['language']; ?>
                    </td>
                </tr>
                        <?php if ($edit_data[0]['price_charged'] != "") { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">New
                            Corporation Price:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <?php echo $edit_data[0]['price_charged']; ?>
                        </td>
                    </tr>
    <?php } ?>
    <?php
    if (!empty($all_notes_main_service)) {
        $i = 0;
        foreach ($all_notes_main_service as $n) {
            if ($i != 0) {
                ?>
                            <tr>
                                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                    New Corporation Note:
                                </td>
                                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            <?php echo $n->note; ?>
                                </td>
                            </tr>
                        <?php
                        }
                        $i++;
                    }
                }
                ?>

                        <?php
                        $related_services = $ci->Service->get_related_service_newcorp_pdf($edit_data[0]['id']);
                        if (!empty($related_services)) {
                            ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Related
                            Services:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"><?php
                            foreach ($related_services as $rs) {
                                if ($rs->services_id != '1') {
                                    $all_notes_service = $ci->Notes->getmainServiceNotesContent($edit_data[0]['id'], $rs->services_id);

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


                                    echo "<label><b>{$rs->service_name}</b></label>
                                <p> 
                                    <b>Retail Price: </b>";
                                    if ($rs->services_id == '10' || $rs->services_id == '41') {
                                        echo ${$tot};
                                    } else {
                                        $get_service_details = $ci->Service->get_service_details($rs->services_id);
                                        echo $get_service_details[0]['retail_price'];
                                    }
                                    echo "</p>";
                                    echo "<p>
                                    <b>Override Price: </b> {$rs->price_charged} 
                                </p>";
                                    echo "<p>
                                    <b>Responsible Department: </b> ";
                                    $resp_dept = $ci->Service->get_resp_dept($rs->services_id);
                                    echo $resp_dept[0]['dept_name'];
                                    echo "</p>";
                                    echo "<p>
                                    <b>Tracking Description: </b> ";
                                    $tracking_desc = $ci->Service->get_tracking($rs->services_id);
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
                                    echo $tracking;
                                    echo "</p>";
                                    echo "<p>
                                    <b>Target Start: </b> {$start_date}  
                                </p>";
                                    echo "<p>
                                    <b>Target Complete: </b> {$end_date}  
                                </p>";
                                    echo "<p>
                                    <b>Actual Complete: </b> {$actual_complete}  
                                </p>";
                                    if (!empty($all_notes_service)) {
                                        foreach ($all_notes_service as $k => $n) {
                                            if ($n->note != "")
                                                echo $k == 0 ? 'Service Notes: ' : "";
                                            echo $n->note . '<br>';
                                        }
                                    }
                                }
                            }
                            ?></td>
                    </tr>
    <?php } ?>
    <?php
    $all_notes_company = $ci->Notes->getNotesContent('company', $reference_id);
    if (!empty($all_notes_company)) {
        echo '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Order Notes: </td>';
        echo '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
        foreach ($all_notes_company as $n) {
            echo $n->note . '<br>';
        }
        echo '</td></tr>';
    }
    ?>
            </tbody>
        </table>
    </div>
<?php
} elseif ($catid == 2) { //for bookkeeping
    if ($service_id == '10' || $service_id == '41') {

        $sub_query = $ci->Pdf->getsubcat($reference_id);
        $subcat = $sub_query['sub_category'];
        if ($subcat == 1) {
            $service = $ci->Service->getService(10);
            $all_notes_main_service = $ci->Notes->getmainServiceNotesContent($edit_data[0]['id'], 10);
            $get_bookkeeping = $ci->Documents->get_bookkeeping_data($reference_id);
        } else {
            $service = $ci->Service->getService(41);
            $all_notes_main_service = $ci->Notes->getmainServiceNotesContent($edit_data[0]['id'], 41);
            $get_bookkeeping = $ci->Documents->get_bookkeeping_data($reference_id);
        }
        ?>
        <table class="table table-striped" style="width:100%;">
            <tbody>
        <?php if ($subcat == 1) { ?>
                    <tr>
                        <td colspan="2"
                            style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            <h3>Recurring Bookkeeping</h3></td>
                    </tr>
        <?php } else { ?>
                    <tr>
                        <td colspan="2"
                            style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            <h3>Bookkeeping By Date</h3></td>
                    </tr>
        <?php } ?>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                        Business:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $edit_data[0]['name']; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">State
                        of Incorporation:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php $getstatename = $ci->Pdf->getstatename($edit_data[0]['state_opened']);
                        echo $getstatename['state_name'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Tracking:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        $status = $edit_data[0]['status'];
                        if ($status == 0) {
                            $tracking = 'Completed';
                        } elseif ($status == 1) {
                            $tracking = 'Started';
                        } elseif ($status == 2) {
                            $tracking = 'Not Started';
                        }
                        echo $tracking;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Date
                        Requested:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        echo $ci->System->normalizeDate($edit_data[0]['order_date']);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Office:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php
        $sql_query = "select idata.*,(select name from office where id=idata.office) as office_name from internal_data idata where idata.reference='" . $edit_data[0]['reference'] . "' and idata.reference_id='" . $edit_data[0]['reference_id'] . "'";

        $conn = $this->db;
        $sql_query_result = $conn->query($sql_query)->row();
        echo $sql_query_result->office_name;
        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Start
                        Date:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        echo date("m/d/Y", strtotime($edit_data[0]['start_date']));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Completed Date:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        echo date("m/d/Y", strtotime($edit_data[0]['complete_date']));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Amount:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        echo $edit_data[0]['total_of_order'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Requested By:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php
        $staff_id = $edit_data[0]['staff_requested_service'];
        $rq_by = $ci->Staff->get_staff_name($staff_id);
        echo $rq_by[0]['first_name'] . ' ' . $rq_by[0]['last_name'];
        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                        Company:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php $gettypename = $ci->Pdf->gettypename($edit_data[0]['company_type']);
                        echo $gettypename['type'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Fiscal
                        Year End:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php $i = $edit_data[0]['fye'];
        echo date("F", strtotime("2000-$i-01"));
        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Business Description:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <?php echo urldecode($edit_data[0]['business_description']); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                        Info:
                    </td>

                    <?php
                    $contactlistbookkeeping = $ci->Contacts->loadContactListbookkeepingpdf("company", $edit_data[0]['reference_id']);
                    if ($contactlistbookkeeping) {
                        echo "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                        foreach ($contactlistbookkeeping as $contact) {
                            echo "<div class='media-body'>
                            <label class='label label-primary'>{$contact->type}</label>
                            <h4 class='media-heading'>Contact Name: {$contact->first_name}" . " {$contact->middle_name}" . " {$contact->last_name} </h4>
                                <p>
                                    Phones 1: {$contact->phone1} ({$contact->phone1_country_name}) <br>
                                    Email: {$contact->email1} <br>
                                    {$contact->address1}, {$contact->city}, {$contact->state}, ZIP: {$contact->zip}, {$contact->country_name}
                                </p></div>";
                        }
                        echo "</td>";
                    }
                    ?>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Owners:
                    </td>

                    <?php
                    $ownerlist = $ci->Company->loadCompanyTitlepdf($edit_data[0]['reference_id']);
                    if ($ownerlist) {
                        echo "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                        foreach ($ownerlist as $title) {
                            echo "<div class='media-body'><label class='label label-primary'>{$title->title}</label>
                                 <h4 class='media-heading'>Name: {$title->name} </h4>   
                                <p>
                                    Date of birth: {$ci->System->normalizeDate($title->birth_date)}<br>
                                    Percentage: {$title->percentage}%<br>
                                    Language: {$title->language}<br>
                                    Country of Residence: {$title->country_residence_name}<br>
                                    Country of Citizenship: {$title->country_citizenship_name}<br>
                                </p></div>";
                        }
                        echo "</td>";
                    }
                    ?>

                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Office:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                <?php echo $ci->Pdf->getOffice($edit_data[0]['office'])['name']; ?>
                    </td>
                </tr>
        <?php if ($edit_data[0]['partner'] != "") { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            Partner:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
            <?php $staff_name = $ci->Pdf->getOfficeStaff($edit_data[0]['partner']);
            echo $staff_name['first_name'] . " " . $staff_name['last_name'];
            ?>
                        </td>
                    </tr>
        <?php } ?>
        <?php if ($edit_data[0]['manager'] != "") { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            Manager:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <?php $staff_name = $ci->Pdf->getOfficeStaff($edit_data[0]['manager']);
                    echo $staff_name['first_name'] . " " . $staff_name['last_name'];
                    ?>
                        </td>
                    </tr>
                        <?php } ?>
                        <?php if ($edit_data[0]['client_association'] != "") { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            Client Association:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
            <?php echo $edit_data[0]['client_association']; ?>
                        </td>
                    </tr>
                        <?php } ?>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Referred By Source:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $ci->Pdf->getReferredBySource($edit_data[0]['referred_by_source'])['source']; ?>
                    </td>
                </tr>
                        <?php if ($edit_data[0]['referred_by_name'] != "") { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            Referred By Name:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
            <?php echo $edit_data[0]['referred_by_name']; ?>
                        </td>
                    </tr>
                        <?php } ?>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Language:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $ci->Pdf->getLanguages($edit_data[0]['language'])['language']; ?>
                    </td>
                </tr>

                        <?php if ($get_bookkeeping[0]['existing_practice_id'] != '') { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            Existing Practise Id:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <?php echo $get_bookkeeping[0]['existing_practice_id']; ?>
                        </td>
                    </tr>
        <?php } ?>
        <?php if ($edit_data[0]['price_charged'] != "") { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            Bookkeeping Price:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <?php echo $edit_data[0]['price_charged']; ?>
                        </td>
                    </tr>
                <?php } ?>
                <?php
                if (!empty($all_notes_main_service)) {
                    $i = 0;
                    foreach ($all_notes_main_service as $n) {
                        if ($i != 0) {
                            ?>
                            <tr>
                                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                    Bookkeeping Note:
                                </td>
                                <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                    <?php echo $n->note; ?>
                                </td>
                            </tr>
                                <?php
                                }
                                $i++;
                            }
                        }
                        ?>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Financial Accounts:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php
                        if ($subcat == 1) {
                            $acc_list = $ci->Documents->loadAccountsListpdf($reference_id);
                            if ($acc_list) {
                                foreach ($acc_list as $title) {
                                    $type = $title->type_of_account;
                                    if (strpos($type, 'Account') !== false) {
                                        $short_type = str_replace('Account', '', $type);
                                    } else {
                                        $short_type = $type;
                                    }

                                    echo "<div class='media-body'><label class='label label-primary'>{$short_type}</label>
                              <h4 class='media-heading'> {$title->bank_name} </h4>
                                <p>
                                    Total Amount: " . "$" . "{$title->total_amount} <br>
                                    # Of Transactions: {$title->number_of_transactions}
                                </p></div>";
                                }
                            }
                        } else {
                            $acc_list = $ci->Documents->loadAccountsListbydatepdf($reference_id);
                            if ($acc_list) {
                                foreach ($acc_list as $title) {
                                    $type = $title->type_of_account;
                                    if (strpos($type, 'Account') !== false) {
                                        $short_type = str_replace('Account', '', $type);
                                    } else {
                                        $short_type = $type;
                                    }

                                    echo "<div class='media-body'><label class='label label-primary'>{$short_type}</label>
                                            <h4 class='media-heading'> {$title->bank_name} </h4>
                                            <p>
                                                Grand Total Amount: " . "$" . "{$title->grand_total} <br>
                                                # Of Transactions: {$title->number_of_transactions}
                                            </p></div>";
                                }
                            }
                        }
                        ?>
                    </td>
                </tr>
                        <?php
                        if ($subcat == 1) {
                            $related_services = $ci->Service->get_related_service_newcorp_pdf($edit_data[0]['id']);
                            if (!empty($related_services)) {
                                ?>
                        <tr>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                                Related Services:
                            </td>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"><?php
                                foreach ($related_services as $rs) {
                                    if ($rs->services_id != '10') {
                                        $all_notes_service = $ci->Notes->getmainServiceNotesContent($edit_data[0]['id'], $rs->services_id);
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


                                        echo "<label>{$rs->service_name}</label>
                                <p> 
                                    <b>Retail Price: </b>";
                                        if ($rs->services_id == '10' || $rs->services_id == '41') {
                                            echo ${$tot};
                                        } else {
                                            $get_service_details = $ci->Service->get_service_details($rs->services_id);
                                            echo $get_service_details[0]['retail_price'];
                                        }
                                        echo "</p>";
                                        echo "<p>
                                    <b>Override Price: </b> {$rs->price_charged} 
                                </p>";
                                        echo "<p>
                                    <b>Responsible Department: </b>";
                                        $resp_dept = $ci->Service->get_resp_dept($rs->services_id);
                                        echo $resp_dept[0]['dept_name'];
                                        echo "</p>";
                                        echo "<p>
                                    <b>Tracking Description: </b>";
                                        $tracking_desc = $ci->Service->get_tracking($rs->services_id);
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
                                        echo $tracking;
                                        echo "</p>";
                                        echo "<p>
                                    <b>Target Start: </b> {$start_date}  
                                </p>";
                                        echo "<p>
                                    <b>Target Complete: </b> {$end_date}  
                                </p>";
                                        echo "<p>
                                    <b>Actual Complete: </b> {$actual_complete}  
                                </p>";
                                        if (!empty($all_notes_service)) {
                                            foreach ($all_notes_service as $k => $n) {
                                                if ($n->note != "")
                                                    echo $k == 0 ? 'Service Notes: ' : "";
                                                echo $n->note . '<br>';
                                            }
                                        }
                                    }
                                }
                                ?></td>
                        </tr>
                        <?php }
                    }
                    ?>
                <?php
                $all_notes_bookkeeping = $ci->Notes->getNotesContent('company', $reference_id);
                if (!empty($all_notes_bookkeeping)) {
                    echo '<tr><td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Order Notes: </td>';
                    echo '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">';
                    foreach ($all_notes_bookkeeping as $n) {
                        echo $n->note . '<br>';
                    }
                    echo '</td></tr>';
                }
                ?>
        <?php if ($subcat == 1) { ?>
                    <tr>
                        <td>Frequency Of Bookkeeping:</td>
            <?php
            if ($get_bookkeeping[0]['frequency'] == 'm') {
                echo '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Monthly</td>';
            } elseif ($get_bookkeeping[0]['frequency'] == 'q') {
                echo '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Quarterly</td>';
            } elseif ($get_bookkeeping[0]['frequency'] == 'y') {
                echo '<td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Yearly</td>';
            }
            ?>
                    </tr>
        <?php } ?>
            </tbody>
        </table>
                    <?php
                    } //end bookkeeping
                    elseif ($service_id == '11') { //start payroll
//    echo $reference_id;
                        $payroll_company_data = $ci->payroll->payroll_company_data($reference_id);
                        $payroll_account_numbers = $ci->payroll->payroll_account_numbers($reference_id);
                        $payroll_data = $ci->payroll->payroll_data($reference_id);
                        $company_data = $ci->payroll->get_company_by_id($reference_id);
                        $notes_data = $ci->payroll->get_note_by_reference_id($reference_id);
                        $payroll_approver = $ci->payroll->get_payroll_approver_by_reference_id($reference_id);
                        $company_principal = $ci->payroll->get_company_principal_by_reference_id($reference_id);
                        $employee_list = $ci->employee->loadEmployeeList($reference_id);
                        $signer_data = $ci->payroll->get_signer_data($reference_id);
                        ?>
        <table class="table table-striped" style="width:100%;">
            <tbody>
                <tr>
                    <td colspan="2"
                        style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <h3>Payroll</h3></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Name Of
                        Company:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php
        echo $company_data['name'];
        ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">DBA (if
                        any):
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $company_data['dba']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                        Address:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_company_data['company_address']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">City:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_company_data['city']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        State:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_company_data['state']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Zip:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $payroll_company_data['zip']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">FEIN:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $company_data['fein']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Type of
                        Company:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php $gettypename = $ci->Pdf->gettypename($company_data['type']);
        echo $gettypename['type'];
        ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">FYE:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $company_data['fye']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                        Started:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_company_data['company_started']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Phone
                        Number:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_company_data['phone_number']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Fax:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $company_data['fax']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Email:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $company_data['email']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Website:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $company_data['website']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Notes:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo urldecode($notes_data['note']); ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Business Description:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo urldecode($company_data['business_description']); ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                        Name:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $payroll_account_numbers['bank_name']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                        Account #:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $payroll_account_numbers['ban_account_number']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Bank
                        Routing #:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $payroll_account_numbers['bank_routing_number']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Do you
                        have a RT-6 #?:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $payroll_account_numbers['rt6_availability']; ?></td>
                </tr>
        <?php if ($payroll_account_numbers['rt6_availability'] == "Yes") { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            RT-6 Number:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
            <?php echo $payroll_account_numbers['rt6_number']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            State:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
            <?php echo $payroll_account_numbers['state']; ?></td>
                    </tr>
        <?php } else { ?>
                    <tr>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            Resident or Non-resident:
                        </td>
                        <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
            <?php echo $payroll_account_numbers['resident_type']; ?></td>
                    </tr>
                    <?php } ?>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                        Frequency:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <?php echo $payroll_data['payroll_frequency']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Payday:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <?php echo $payroll_data['payday']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Pay
                        Period Ending:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo 'Month'; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Contact
                        Info:
                    </td>

                    <?php
                    $contactlist = $ci->Contacts->loadContactListpdf("company", $reference_id);
                    if ($contactlist) {
                        echo "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                        foreach ($contactlist as $contact) {
                            echo "<div class='media-body'>
                            <label class='label label-primary'>{$contact->type}</label>
                            <h4 class='media-heading'>Contact Name: {$contact->first_name}" . " {$contact->middle_name}" . " {$contact->last_name} </h4>
                                <p>
                                   
                                    Phones 1: {$contact->phone1} ({$contact->phone1_country_name}) <br>
                                    Email: {$contact->email1} <br>
                                    {$contact->address1}, {$contact->city}, {$contact->state}, ZIP: {$contact->zip}, {$contact->country_name}
                                </p></div>";
                        }
                        echo "</td>";
                    }
                    ?>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Owners:
                    </td>

        <?php
        $ownerlist = $ci->Company->loadCompanyTitlepdf($reference_id);
        if ($ownerlist) {
            echo "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
            foreach ($ownerlist as $title) {
                echo "<div class='media-body'><label class='label label-primary'>{$title->title}</label>
                                    <h4 class='media-heading'>Name: {$title->name} </h4>
                                    <p>
                                    Date of birth: {$ci->System->normalizeDate($title->birth_date)}<br>
                                    Percentage: {$title->percentage}%<br>
                                    Language: {$title->language}<br>
                                    Country of Residence: {$title->country_residence_name}<br>
                                    Country of Citizenship: {$title->country_citizenship_name}<br>
                                </p></div>";
            }
            echo "</td>";
        }
        ?>

                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                        Approver First Name:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_approver['fname']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                        Approver Last Name:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_approver['lname']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                        Approver Title:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_approver['title']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                        Approver Social Security #:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_approver['social_security']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                        Approver Phone Number:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_approver['phone']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                        Approver Ext:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_approver['ext']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                        Approver Fax:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_approver['fax']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Payroll
                        Approver Email:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $payroll_approver['email']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                        Principal First Name:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $company_principal['fname']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                        Principal Last Name:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $company_principal['lname']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                        Principal Title:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $company_principal['title']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                        Principal Social Security #:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $company_principal['social_security']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                        Principal Phone Number:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $company_principal['phone']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                        Principal Ext:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $company_principal['ext']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                        Principal Fax:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $company_principal['fax']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Company
                        Principal Email:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                    <?php echo $company_principal['email']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Signer
                        Data First Name:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $signer_data['fname']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Signer
                        Data Last Name:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $signer_data['lname']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Signer
                        Data Social Security #:
                    </td>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
        <?php echo $signer_data['social_security']; ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                        Employee Data:
                    </td>

                    <?php
                    if ($employee_list) {
                        echo "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;'>";
                        foreach ($employee_list as $el) {
                            ?>
                    <div class='media-body'><label
                            class='label label-primary'><?php echo $el['employee_type']; ?></label>
                        <h4 class='media-heading'>Employee
                            Name: <?php echo $el['first_name'] . " " . $el['last_name']; ?> </h4>
                        <p>
                            Phones: <?php echo $el['phone_number']; ?><br>
                            Email: <?php echo $el['email']; ?><br>
                            Address: <?php echo $el['address']; ?><br>
                            City: <?php echo $el['city']; ?><br>
                            State: <?php echo $el['state']; ?><br>
                            Zip: <?php echo $el['zip']; ?><br>
                            Home Phone: <?php echo $el['phone_number']; ?><br>
                            SS #: <?php echo $el['ss']; ?><br>
                            Gender: <?php echo $el['gender']; ?><br>
                            Email: <?php echo $el['email']; ?><br>
                            Pay Type: <?php echo $el['is_paid']; ?><br>
                            Date Of Birth: <?php echo date('m/d/Y', strtotime($el['date_of_birth'])); ?><br>
                            Date Of Hire: <?php echo date('m/d/Y', strtotime($el['date_of_hire'])); ?><br>
                            Payroll Check Receive Type: <?php echo $el['payroll_check']; ?><br>
                <?php if ($el['payroll_check'] == 'Direct Deposit') { ?>
                                Bank Account Type: <?php echo $el['zip']; ?><br>
                                Bank Account #: <?php echo $el['zip']; ?><br>
                                Bank Routing #: <?php echo $el['zip']; ?><br>
                <?php } ?>
                            Hourly Rate or Salary Per Pay Period: <?php echo $el['hourly_rate']; ?><br>
                            Filing Status: <?php echo $el['filing_status']; ?><br>
                            # of Allowances from IRS Form W-4: <?php echo $el['irs_form']; ?>
                        </p></div>
            <?php
            }
            echo "</td>";
        }
        ?>

        </tr>
        </tbody>
        </table>
    <?php } //end payroll
}
?>