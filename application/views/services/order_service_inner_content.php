<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-borderless">
            <tr>
                <th style='width:11%;  text-align: center;'>Service ID</th>
                <th style='width:11%;  text-align: center;'>Assign</th>
                <th style='width:11%;  text-align: center;'>Name</th>
                <th style='width:11%; text-align: center;'>Retail Price</th>
                <th style='width:11%; text-align: center;'>Override Price</th>
                <th style='width:11%; text-align: center;'>Responsible Dept</th>
                <th style='width:11%; text-align: center;'>Tracking</th>
                <th style='width:11%; text-align: center;'>Start</th>
                <th style='width:11%; text-align: center;'>Complete</th>
                <th style='width:5%; text-align: center;'>Notes</th>
                <th style='width:5%; text-align: center;'>SOS</th>
                <th style='width:11%; text-align: center; white-space: nowrap;'>Input Form</th>
            </tr>
            <?php
            $user_id = sess('user_id');
            $user_info = staff_info();
            $user_dept = $user_info['department'];
            $usertype = $user_info['type'];
            $role = $user_info['role'];
            if (!empty($services_list)) {
                foreach ($services_list as $keys => $row_inner) {
                    $keysval = $keys+1;
                    /* check if rt6 yes or no */
                    if (trim($row_inner->service_name) == 'Rt6') {
                        $check_rt6_status = check_rt6_status($row_inner->order_id);
                        if ($check_rt6_status['rt6_availability'] == 'No') {
                            $status_rt6_val = 'Yes';
                        } else {
                            $status_rt6_val = 'No';
                        }
                    } else {
                        $status_rt6_val = 'Yes';
                    }
                    /* check if rt6 yes or no */
                    $note_count_inner = 0;
                    if ($service_id == '11') {
                        if ($row_inner->service_id == '11') {
                            $note_count_inner = getNoteCountforpayrollform('Note', 'n', 4, 'reference_id', $reference_id);
                        } elseif ($row_inner->service_id == '42') {
                            $note_count_inner = getNoteCountforpayrollform('Rt6 Note', 'n', 5, 'reference_id', $reference_id);
                        } else {
                            $note_count_inner = getNoteCount('service', $row_inner->service_request_id);
                        }
                    } else {
                        $note_count_inner = getNoteCount('service', $row_inner->service_request_id);
                    }

                    if ($row_inner->service_name == 'Create New Company'):
                        $row_inner->service_name = "New Corporation";
                    endif;
                    $start_date = date('m/d/Y', strtotime($row_inner->date_started));
                    $end_date = date('m/d/Y', strtotime($row_inner->date_completed));

                    if ($row_inner->date_start_actual != '') {
                        $actual_start = date('m/d/Y', strtotime($row_inner->date_start_actual));
                    } else {
                        $actual_start = '';
                    }

                    if ($row_inner->date_complete_actual != '') {
                        $actual_complete = date('m/d/Y', strtotime($row_inner->date_complete_actual));
                    } else {
                        $actual_complete = '';
                    }
                    if ($row_inner->status == 0) {
                        $tracking = 'Completed';
                        $trk_inner_class = 'label-primary';
                    } elseif ($row_inner->status == 1) {
                        $tracking = 'Started';
                        $trk_inner_class = 'label-yellow';
                    } elseif ($row_inner->status == 2) {
                        $tracking = 'Not Started';
                        $trk_inner_class = 'label-success';
                    } elseif ($row_inner->status == 7) {
                        $tracking = 'Canceled';
                        $trk_inner_class = 'label-danger';
                    }
                    if ($row_inner->service_id == '10' || $row_inner->service_id == '41') {
                        $query_result = get_sum_of_amount_from_financial_acc($order_id, 'grand_total');
                        if ($query_result[0]['total'] != '0') {
                            $sub_tot = $query_result[0]['total'];
                            $query_corp_result = get_bookkeeping_by_order_id($order_id);
                            $corp_tax = $query_corp_result['corporate_tax_return'];
                            if ($corp_tax == 'y') {
                                $tot = $sub_tot + 35;
                            } else {
                                $tot = $sub_tot;
                            }
                        } else {
                            $query_sub_result = get_sum_of_amount_from_financial_acc($order_id, 'total_amount');
                            $tot = $query_sub_result[0]['total'];
                        }
                        if ($tot == '' || $tot == 0) {
                            $tot = $row_inner->retail_price;
                        }
                    }
                    if ($status_rt6_val == 'Yes') { //check rt6 start
                        ?>
                        <tr <?= ( strtotime($row_inner->date_completed) < strtotime(date('Y-m-d')) ) ? "class='text-danger'" : ""; ?>>
                            <td title="Service ID" style="text-align: center;">#<?= $invoiced_id; ?>-<?= $keysval ?></td>
                            <td title="Assign" style="text-align: center;" class="">
                                <?php if ($row_inner->assign_user_id == 0): ?>
                                    <?php
                                    if ($usertype != 3) {
                                        if ($usertype == 1 || ($usertype == 2 & $role == 4)) {
                                            ?>
                                            <a href="javascript:void(0);" onclick="show_service_assign_modal('<?= $row_inner->service_request_id; ?>', '<?= $all_staffs; ?>');" class="label label-success status_assign"><i class="fa fa-plus"></i> Assign</a>
                                        <?php } else { ?>
                                            <a href="javascript:void(0);" onclick="assignService('<?= $row_inner->service_request_id; ?>', '<?php echo $user_id; ?>');" class="label label-success status_assign"><i class="fa fa-plus"></i> Assign</a>
                                            <?php
                                        }
                                    }
                                    ?>
                                <?php else: ?>
                                    <label class="label label-primary m-b-5 p-t-5 p-b-5 status_assign"><?= staff_info_by_id($row_inner->assign_user_id)['full_name']; ?></label>
                                    <?php
                                    if ($usertype == 3 || ($usertype == 2 && $role == 3)) {
                                        
                                    } else {
                                        ?>
                                        <a href="javascript:void(0);" onclick="assignService(<?= $row_inner->service_request_id; ?>, 0);" class="label label-danger status_assign"><i class="fa fa-remove"></i></a>
                                    <?php } ?>
                                <?php endif; ?>
                            </td> 
                            <td title="Service Name" style="text-align: center;"><?= $row_inner->service_name; ?></td>
                            <td title="Retail Price" style="text-align: center;">
                                $<?= ($row_inner->service_id == '10' || $row_inner->service_id == '41') ? $tot : $row_inner->retail_price; ?>
                            </td>
                            <td title="Override Price" style="text-align: center;">$<?= $row_inner->price_charged; ?></td>    
                            <td title="Responsible Dept" style="text-align: center;"><?= $row_inner->service_department_name; ?></td>
                            <?php if ($usertype == "3"): ?>
                                <td align='left' title="Tracking Description">
                                    <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                </td>
                            <?php else: ?>
                                <td align='center' title="Tracking Description">
                                    <?php
                                    if (($usertype == 3 && $role == 1) || ($usertype == 2 && $role == 3)) {
                                        $check_if_service_already_assigned = check_if_service_already_assigned($row_inner->service_request_id);
                                        if ($check_if_service_already_assigned == 0) {
                                            ?>
                                            <a href='javascript:void(0);' id='trackinginner-<?php echo $row_inner->service_request_id; ?>' onclick='change_status_inner(<?= $row_inner->service_request_id; ?>,<?= $row_inner->status; ?>, <?= $row_inner->service_request_id ?>);'>
                                                <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                            </a>
                                            <?php
                                        } else {
                                            if ($check_if_service_already_assigned == sess('user_id')) {
                                                ?>
                                                <a href='javascript:void(0);' id='trackinginner-<?php echo $row_inner->service_request_id; ?>' onclick='change_status_inner(<?= $row_inner->service_request_id; ?>,<?= $row_inner->status; ?>, <?= $row_inner->service_request_id ?>);'>
                                                    <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                                </a>
                                            <?php } else {
                                                ?>
                                                <a href='javascript:void(0);' id='trackinginner-<?php echo $row_inner->service_request_id; ?>'>
                                                    <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                                </a>
                                                <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <a href='javascript:void(0);' id='trackinginner-<?php echo $row_inner->service_request_id; ?>' onclick='change_status_inner(<?= $row_inner->service_request_id; ?>,<?= $row_inner->status; ?>, <?= $row_inner->service_request_id ?>);'>
                                            <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                        </a>
                                    <?php } ?>
                                </td>
                            <?php endif; ?>
                            <td align='center' title="Start Date" style="text-align: center;">
                                T:<?= $start_date; ?><br>
                                <?php if (isset($actual_start) && $actual_start != '') { ?>
                                    A:<?= $actual_start; ?> 
                                <?php } ?>       
                            </td>
                            <td align='center' title="Complete Date" style="text-align: center;">
                                T:<?= $end_date; ?><br>
                                <?php if (isset($actual_complete) && $actual_complete != '') { ?>
                                    A:<?= $actual_complete; ?>
                                <?php } ?>    
                            </td>
                            <?php
                            if ($service_id == '11') {
                                if ($row_inner->service_id == '11') {
                                    echo "<td align='center' title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a id="orderservice-' . $row_inner->service_id .'-'. $row_inner->service_request_id. '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollemp\',\'' . $row_inner->service_request_id . '\',\'' . $row_inner->service_id . '\',\'' . $reference_id . '\',\'' . $order_id . '\')"><b>' . $note_count_inner . '</b></a>' : '<a id="orderservice-' . $row_inner->service_id .'-'. $row_inner->service_request_id. '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollemp\',\'' . $row_inner->service_request_id . '\',\'' . $row_inner->service_id . '\',\'' . $reference_id . '\',\'' . $order_id . '\')"><b>' . $note_count_inner . '</b></a>') . "</span></td>";
                                } else {
                                    echo "<td align='center' title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a id="orderservice-' . $row_inner->service_id .'-'. $row_inner->service_request_id. '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollrt6\',\'' . $row_inner->service_request_id . '\',\'' . $row_inner->service_id . '\',\'' . $reference_id . '\',\'' . $order_id . '\')"><b>' . $note_count_inner . '</b></a>' : '<a id="orderservice-' . $row_inner->service_id .'-'. $row_inner->service_request_id. '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollrt6\',\'' . $row_inner->service_request_id . '\',\'' . $row_inner->service_id . '\',\'' . $reference_id . '\',\'' . $order_id . '\')"><b>' . $note_count_inner . '</b></a>') . "</span></td>";
                                }
                            } else {
                                echo "<td align='center' title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a id="orderservice-' . $row_inner->service_id .'-'. $row_inner->service_request_id. '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'service\',\'' . $row_inner->service_request_id . '\',\'' . $row_inner->service_id . '\',\'' . $reference_id . '\',\'' . $order_id . '\')"><b>' . $note_count_inner . '</b></a>' : '<a id="orderservice-' . $row_inner->service_id .'-'. $row_inner->service_request_id. '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'service\',\'' . $row_inner->service_request_id . '\',\'' . $row_inner->service_id . '\',\'' . $reference_id . '\',\'' . $order_id . '\')"><b>' . $note_count_inner . '</b></a>') . "</span></td>";
                            }
                            ?>
                            <td title="SOS" style="text-align: center;">
                                <span>
                                    <a id="sosservicecount-<?= $order_id; ?>" class="d-inline p-t-5 p-b-5 p-r-8 p-l-8 label service-sos-count-<?= $row_inner->service_request_id; ?> <?php echo (get_sos_count('order', $row_inner->service_id, $order_id) == 0) ? 'label-primary' : 'label-danger'; ?>" title="SOS" href="javascript:void(0)" onclick="show_sos('order', '<?= $row_inner->service_id; ?>', '<?= $all_staff_id_list; ?>', '<?= $order_id; ?>', '<?= $row_inner->service_request_id; ?>');"><?php echo (get_sos_count('order', $row_inner->service_id, $order_id) == 0) ? '<i class="fa fa-plus"></i>' : '<i class="fa fa-bell"></i>'; ?></a>                                                   
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                $input_status = 'complete';
                                if ($row_inner->service_id != $service_id) {
                                    if ($row_inner->input_form != 'y') {
                                        echo 'N/A';
                                    } else {
                                        if ($row_inner->input_form_status == 'n') {
                                            $input_status = 'incomplete';
                                            ?>
                                            <span class="label input-form-incomplete">Incomplete <a href="<?= base_url() . 'services/home/related_services/' . $row_inner->service_request_id; ?>" class="text-white p-5" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i> </a></span>
                                        <?php } else { ?>
                                            <span class="label input-form-complete">Completed <a href="<?= base_url() . 'services/home/related_services/' . $row_inner->service_request_id; ?>" class="text-white p-5" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i> </a></span>
                                            <?php
                                        }
                                    }
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                                <input type="hidden" class="input-form-status-<?= $row_inner->service_request_id; ?>" value="<?= $input_status; ?>" />
                            </td>
                        </tr>
                        <?php
                    } //check rt6 end
                }
            }
            ?>
        </table>
    </div>
</div>