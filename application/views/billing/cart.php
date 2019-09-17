<div class="wrapper wrapper-content">
    <?php
    $user_id = sess('user_id');
    $user_info = staff_info();
    $user_dept = $user_info['department'];
    $usertype = $user_info['type'];
    if (!empty($result)) {
        foreach ($result as $row) {
            $target_start_date = date("m/d/Y", strtotime($row->target_start_date));
            $target_complete_date = date("m/d/Y", strtotime($row->target_complete_date));
            $note_count = getNoteCount('company', $row->reference_id);
            $status = $row->status;
            if ($status == 0) {
                $tracking = 'Completed';
            } elseif ($status == 1) {
                $tracking = 'Started';
            } elseif ($status == 2) {
                $tracking = 'Not Started';
            } elseif ($status == 10) {
                $tracking = 'Not Sold';
            }
            $sql_query_result = get_office_name($row->reference, $row->reference_id);
            if (!empty($sql_query_result)) {
                $office_name = $sql_query_result->office_name;
            } else {
                $office_name = '-';
            }

            $late_status = $row->late_status;
            if ($late_status == '1' && $status == 1) {
                $late_class = $row->dept . '-late';
            } else {
                $late_class = '';
            }

            $order_date = strtotime($row->order_date);

            echo '<div class="panel panel-default service-panel category' . $row->category_id . ' filter-' . $row->dept . '-' . $status . ' ' . $late_class . '">
                <div class="panel-heading">';
//        if ($usertype == '3') {
//            if ($status == 2) {
//                if ($row->category_id == 1) {
//                    echo '<a href="' . base_url() . 'services/incorporation/edit_company/' . $row->id . '" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
//                } else {
//                    if ($row->service_id == 10 || $row->service_id == '41') {
//                        $res = getBookkeepingdata($row->reference_id);
//                        if (!empty($res)) {
//                            if ($res['sub_category'] == 2) {
//                                echo '<a href="' . base_url() . 'services/accounting_services/edit_bookkeeping_by_date/' . $row->id . '" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
//                            } else {
//                                echo '<a href="' . base_url() . 'services/accounting_services/edit_bookkeeping/' . $row->id . '" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
//                            }
//                        } else {
//                            echo '<a href="' . base_url() . 'services/accounting_services/edit_bookkeeping/' . $row->id . '" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
//                        }
//                    } elseif ($row->service_id == '11') {
//                        echo '<a href="' . base_url() . 'services/accounting_services/edit_payroll/' . $row->id . '" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
//                    }
//                }
//            } //status checking
//        } else {
//            if ($row->category_id == 1) {
//                echo '<a href="' . base_url() . 'services/incorporation/edit_company/' . $row->id . '" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
//            } else {
//                if ($row->service_id == 10 || $row->service_id == '41') {
//                    $res = getBookkeepingdata($row->reference_id);
//                    if (!empty($res)) {
//                        if ($res['sub_category'] == 2) {
//                            echo '<a href="' . base_url() . 'services/accounting_services/edit_bookkeeping_by_date/' . $row->id . '" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
//                        } else {
//                            echo '<a href="' . base_url() . 'services/accounting_services/edit_bookkeeping/' . $row->id . '" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
//                        }
//                    } else {
//                        echo '<a href="' . base_url() . 'services/accounting_services/edit_bookkeeping/' . $row->id . '" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
//                    }
//                } elseif ($row->service_id == '11') {
//                    echo '<a href="' . base_url() . 'services/accounting_services/edit_payroll/' . $row->id . '" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
//                }
//            }
//        }
//        echo '<a href="' . base_url() . 'services/home/download_pdf/' . $row->id . '/' . $row->category_id . '/' . $row->reference_id . '/' . $row->service_id . '" class="btn btn-primary btn-xs btn-service-pdf bookkeepingbydate"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download Pdf</a>';
            // echo '<a href="#" class="btn btn-primary btn-xs btn-service-pdf bookkeepingbydate"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download Pdf</a>';
            echo '<h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $row->id . '" aria-expanded="false" class="collapsed">
                        <div class="table-responsive">
                            <table class="table table-borderless" style="margin-bottom: 0px;">
                                <tr>
                                    <th>Order#</th>
                                    <th style="width:120px;">Client Name</th>
                                    <th>Tracking</th>
                                    <th>Requested</th>
                                    <th>Office</th>
                                    <th>' . (($row->status == "2" || $row->status == "3") ? "Target Start" : "Target Start<br>" . $target_start_date . "<br>Start Date") . '</th>
                                    <th>' . (($row->status == "2" || $row->status == "3") ? "Target Complete" : "Target Complete<br>" . $target_complete_date . "<br>Complete Date") . '</th>
                                    <th>Amount$$$</th>
                                    <th>Requested by</th>
                                    <th>Notes</th>
                                    <th>Services</th>
                                </tr>
                                <tr>
                                    <td title="ID">#' . $row->id . '</td>
                                    <td title="Client Name" style="word-break: break-all;">' . $row->client_name . '</td>
                                    <td title="Tracking"><span class="label label-primary">' . $tracking . '</span></td>
                                    <td title="Order Date">' . date('m/d/Y', $order_date) . '</td>
                                    <td title="Office">' . $office_name . '</td>';
            if ($row->start_date != '') {
                echo '<td align="left" title="Start Date">' . date("m/d/Y", strtotime($row->start_date)) . '</td>';
            } else {
                echo '<td align="left" title="Start Date">-</td>';
            }
            if ($row->complete_date != '') {
                echo '<td align="left" title="Complete Date">' . date("m/d/Y", strtotime($row->complete_date)) . '</td>';
            } else {
                echo '<td align="left" title="Complete Date">-</td>';
            }
            if ($row->total_of_order != '' && isset($row->total_of_order)) {
                $total = '$' . $row->total_of_order;
            } else {
                $total = '-';
            }

            echo '<td title="Amount">' . $total . '</td>
                                    <td title="Requested by">' . $row->requested_staff . '</td>
                                    <td title="Notes"><span>' . (($note_count > 0) ? '<a class="label label-warning" href="javascript:void(0)"><b>' . $note_count . '</b></a>' : '<b class="label label-warning">' . $note_count . '</b>') . '</span></td>
                                    <td title="Services"><span class="label label-warning">' . get_services_count($row->id) . '</span></td>
                                </tr>
                            </table>
                        </div>
                    </h5>
                </div>';
            //if($row->service_id!='11'){
            echo '<div id="collapse' . $row->id . '" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    <div class="table-responsive">
                <table class="table table-borderless">';

            $services_list = listServicesOrderajaxdashboard($row->id, $status, $row->reference_id, $row->service_id);
            //print_r($services_list);
            echo "<tr><th style='width:11%;'>Name</th><th style='width:11%;'>Retail Price</th><th style='width:11%;'>Override Price</th><th style='width:11%;'>Responsible Dept</th><th style='width:11%;'>Tracking Description</th><th style='width:11%;'>Target Start</th><th>Target Complete</th><th style='width:11%;'>Actual Complete</th><th style='width:11%;'>Notes</th></tr>";
            $service_id = $row->service_id;
            $order_id = $row->id;
            $ref_id = $row->reference_id;
            if (!empty($services_list)) {
                foreach ($services_list as $row_inner) {
                    $note_count_inner = 0;

                    if ($service_id == '11') {
                        if ($row_inner->id == '11') {
                            $note_count_inner = getNoteCountforpayrollform('Note', 'n', 4, 'reference_id', $ref_id);
                        } elseif ($row_inner->id == '42') {
                            $note_count_inner = getNoteCountforpayrollform('Rt6 Note', 'n', 5, 'reference_id', $ref_id);
                        } else {
                            $note_count_inner = getNoteCount('service', $row_inner->service_req_id);
                        }
                    } else {
                        $note_count_inner = getNoteCount('service', $row_inner->service_req_id);
                    }

                    if ($row_inner->service_name == 'Create New Company')
                        $row_inner->service_name = "New Corporation";
                    $start_date = date('m/d/Y', strtotime($row_inner->date_started));
                    $end_date = date('m/d/Y', strtotime($row_inner->date_completed));
                    if ($row_inner->status == 0) {
                        $tracking = 'Completed';
                        $actual_complete = $end_date;
                    } elseif ($row_inner->status == 1) {
                        $tracking = 'Started';
                        $actual_complete = '-';
                    } elseif ($row_inner->status == 2) {
                        $tracking = 'Not Started';
                        $actual_complete = '-';
                    }

                    if ($row_inner->id == '10' || $row_inner->id == '41') {
                        $query_result = get_sum_of_amount_from_financial_acc($ref_id, 'grand_total');
                        if ($query_result[0]['total'] != '0') {
                            $sub_tot = $query_result[0]['total'];
                            $query_corp_result = get_bookkeeping_by_order_id($row_inner->id);
                            $corp_tax = $query_corp_result[0]['corporate_tax_return'];
                            if ($corp_tax == 'y') {
                                $tot = $sub_tot + 35;
                            } else {
                                $tot = $sub_tot;
                            }
                        } else {
                            $query_sub_result = get_sum_of_amount_from_financial_acc($ref_id, 'total_amount');
                            $tot = $query_sub_result[0]['total'];
                        }
                    }
                    $requested_staff_id = $row->staff_requested_service;
                    $resp_dept = staff_department_name($requested_staff_id);

                    echo "<tr " . (($row_inner->status == 1 && $row->late_status == 1) ? "class='text-danger'" : "") . ">
                    <td title=\"Service Name\">{$row_inner->service_name}</td>";
                    if ($row_inner->id == '10' || $row_inner->id == '41') {
                        echo "<td title=\"Retail Price\">\${$tot}</td>";
                    } else {
                        echo "<td title=\"Retail Price\">\${$row_inner->retail_price}</td>";
                    }

                    echo "<td title=\"Override Price\">\${$row_inner->price_charged}</td>    
                    <td title=\"Responsible Dept\">{$resp_dept}</td>";
                    if ($usertype == "3") {
                        echo"<td align='left' title=\"Tracking Description\"><span class='label label-primary label-block'>" . $tracking . "</span></td> ";
                    } else {
                        ?>   
                        <td align='left' title="Tracking Description"><a href='javascript:void(0);' onclick='change_status_inner(<?php echo $row_inner->rowid; ?>,<?php echo $row_inner->status; ?>, <?= $row_inner->rowid ?>)'><span class='label label-primary label-block'><?php echo $tracking; ?></span></a></td>
                    <?php } ?>
                    <?php
                    echo" <td align='left' title=\"Start Date\">{$start_date}</td>
                    <td align='left' title=\"Complete Date\">{$end_date}</td>
                    <td align='left' title=\"Actual Complete\">{$actual_complete}</td>";
                    if ($service_id == '11') {
                        if ($row_inner->id == '11') {
                            echo "<td title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a class="label label-warning" href="javascript:void(0)"><b>' . $note_count_inner . '</b></a>' : '<b class="label label-warning">' . $note_count_inner . '</b>') . "</span></td>";
                        } else {
                            echo "<td title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a class="label label-warning" href="javascript:void(0)"><b>' . $note_count_inner . '</b></a>' : '<b class="label label-warning">' . $note_count_inner . '</b>') . "</span></td>";
                        }
                    } else {
                        echo "<td title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a class="label label-warning" href="javascript:void(0)"><b>' . $note_count_inner . '</b></a>' : '<b class="label label-warning">' . $note_count_inner . '</b>') . "</span></td>";
                    }
                    echo "</tr>";
                }
            }
            echo '</div>';
            echo '</table></div></div></div>';
            //}
            echo '</div>';
            //echo '<td><a href="javascript:void(0);" class="start_process" id="'.$row->id.'">Start Process</a></td>';
        } ?>
        <div class="text-right m-b-md">
            <button class="btn btn-primary btn-lg" type="button" onclick="buyService();">Place Order Now</button>
        </div>
    <?php } else {
        echo 'No data found';
    }
    ?>
</div>