<div class="clearfix result-header">
    <?php if (count($result) != 0) : ?>
        <h2 class="text-primary pull-left result-count-h2"><?= isset($page_number) ? ($page_number * 20) : count($result) ?> Results found <?= isset($page_number) ? 'of ' . count($result) : '' ?></h2>
    <?php endif; ?>
    <div class="pull-right text-right p-t-4">
        <div class="dropdown" style="display: inline-block;">
            <a href="javascript:void(0);" id="sort-by-dropdown" data-toggle="dropdown" class="dropdown-toggle btn btn-success">Sort By <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a id="order_serial_id-val" href="javascript:void(0);" onclick="sort_service_dashboard('ord.order_serial_id')">ID</a></li>
                <li><a id="client_name-val" href="javascript:void(0);" onclick="sort_service_dashboard('client_name')">Client Name</a></li>
                <li><a id="office_id-val" href="javascript:void(0);" onclick="sort_service_dashboard('office')">Office ID</a></li>
                <li><a id="status-val" href="javascript:void(0);" onclick="sort_service_dashboard('ord.status')">Tracking</a></li>
                <li><a id="order_date-val" href="javascript:void(0);" onclick="sort_service_dashboard('ord.order_date')">Requested Date</a></li>
                <li><a id="start_date-val" href="javascript:void(0);" onclick="sort_service_dashboard('ord.start_date')">Start Date</a></li>
                <li><a id="complete_date-val" href="javascript:void(0);" onclick="sort_service_dashboard('ord.complete_date')">Complete Date</a></li>
            </ul>
        </div>
        <div class="sort_type_div" style="display: none;">
            <a href="javascript:void(0);" id="sort-asc" onclick="sort_service_dashboard('', 'DESC')" class="btn btn-success" data-toggle="tooltip" title="Ascending Order" data-placement="top"><i class="fa fa-sort-amount-asc"></i></a>
            <a href="javascript:void(0);" id="sort-desc" onclick="sort_service_dashboard('', 'ASC')" class="btn btn-success" data-toggle="tooltip" title="Descending Order" data-placement="top"><i class="fa fa-sort-amount-desc"></i></a>
            <a href="javascript:void(0);" onclick="serviceFilter();" class="btn btn-white text-danger" data-toggle="tooltip" title="Remove Sorting" data-placement="top"><i class="fa fa-times"></i></a>
        </div>
    </div>
</div>
<?php
$user_id = sess('user_id');
$user_info = staff_info();
$user_dept = $user_info['department'];
$usertype = $user_info['type'];
$role = $user_info['role'];
$row_number = 0;
if (!empty($result)) :

    foreach ($result as $row_count => $row) :

        if (isset($page_number)) {
            if ($page_number != 1) {
                if ($row_count < (($page_number - 1) * 20)) {
                    continue;
                }
            }
            if ($row_count == ($page_number * 20)) {
                break;
            }
        }

        if ($row->status == 0) {
            $tracking = 'Completed';
            $trk_inner_class = 'label-primary';
        } elseif ($row->status == 1) {
            $tracking = 'Started';
            $trk_inner_class = 'label-yellow';
        } elseif ($row->status == 2) {
            $tracking = 'Not Started';
            $trk_inner_class = 'label-success';
        } elseif ($row->status == 7) {
            $tracking = 'Canceled';
            $trk_inner_class = 'label-danger';
        } 
        ?>

        <?php $order_info = get_order_info_for_services($row->order_id); 
            $all_staffs = str_replace(' ', '', $order_info['all_staffs']);

            $requested_staff_id = $order_info['staff_requested_service'];
            $all_staff_id_list = explode(',', $all_staffs);
            $all_staff_id_list = array_merge($all_staff_id_list, [$requested_staff_id]);
            $all_staff_id_list = array_unique($all_staff_id_list);
            $all_staff_id_list_info = implode(',', $all_staff_id_list);

            $note_count_inner = 0;
                if ($order_info['service_id'] == '11') {
                    if ($row->service_id == '11') {
                        $note_count_inner = getNoteCountforpayrollform('Note', 'n', 4, 'reference_id', $order_info['company_id']);
                    } elseif ($row->service_id == '42') {
                        $note_count_inner = getNoteCountforpayrollform('Rt6 Note', 'n', 5, 'reference_id', $order_info['company_id']);
                    } else {
                        $note_count_inner = getNoteCount('service', $row->service_request_id);
                    }
                } else {
                    $note_count_inner = getNoteCount('service', $row->service_request_id);
                }
        ?>

        <div class="panel panel-default service-panel">
            <div class="panel-heading panel-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <th class="text-center" style='white-space: nowrap;'>Service ID</th>
                            <th class="text-center" style='white-space: nowrap;'>Assign</th>
                            <th class="text-center" style='white-space: nowrap;'>Name</th>
                            <th class="text-center" style='white-space: nowrap;'>Retail Price</th>
                            <th class="text-center" style='white-space: nowrap;'>Override Price</th>
                            <th class="text-center" style='white-space: nowrap;'>Responsible Dept</th>
                            <th class="text-center" style='white-space: nowrap;'>Tracking</th>
                            <th class="text-center" style='white-space: nowrap;'>Start</th>
                            <th class="text-center" style='white-space: nowrap;'>Complete</th>
                            <th class="text-center" style='white-space: nowrap;'>Notes</th>
                            <th class="text-center" style='white-space: nowrap;'>SOS</th>
                            <th class="text-center" style='width:120px; text-align: center; white-space: nowrap; display: flex;'>Input Form</th>
                        </tr>
                        <tr>
                            <td title="Service ID" class="text-center"><?= $row->invoice_id ?></td>
                            
                             <td title="Assign" class="text-center">
                                <?php if ($row->assign_user_id == 0): ?>
                                    <?php
                                    if ($usertype != 3) {
                                        if ($usertype == 1 || ($usertype == 2 & $role == 4)) {
                                            ?>
                                            <a href="javascript:void(0);" onclick="show_service_assign_modal('<?= $row->service_request_id; ?>', '<?= $all_staffs ; ?>');" class="label label-success status_assign"><i class="fa fa-plus"></i> Assign</a>
                                        <?php } else { ?>
                                            <a href="javascript:void(0);" onclick="assignService('<?= $row->service_request_id; ?>', '<?php echo $user_id; ?>');" class="label label-success status_assign"><i class="fa fa-plus"></i> Assign</a>
                                            <?php
                                        }
                                    }
                                    ?>
                                <?php else: ?>
                                    <label class="label label-primary m-b-5 p-t-5 p-b-5 status_assign"><?= staff_info_by_id($row->assign_user_id)['full_name']; ?></label>
                                    <?php
                                    if ($usertype == 3 || ($usertype == 2 && $role == 3)) {
                                        
                                    } else {
                                        ?>
                                        <a href="javascript:void(0);" onclick="assignService(<?= $row->service_request_id; ?>, 0);" class="label label-danger status_assign"><i class="fa fa-remove"></i></a>
                                    <?php } ?>
                                <?php endif; ?>
                            </td> 

                            <td title="Service Name" class="text-center"><?= $row->service_name; ?></td>
                            <td title="Retail Price" class="text-center">$<?= $row->retail_price ?></td>
                            <td title="Override Price" class="text-center">$<?= $row->price_charged; ?></td>
                            <td title="Responsible Dept" class="text-center">
                                <?php $dept_name = $row->service_department_name;
                                if ($dept_name == '') {
                                    echo "Franchisee<br>";
                                } else {
                                    echo $row->service_department_name;
                                } ?>
                            </td>
                            
                            <?php if ($usertype == "3"){ ?>
                            <td align='left' title="Tracking">
                                <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                            </td>
                            <?php } else{ ?>
                            <td align='center' title="Tracking">
                                <?php
                                if (($usertype == 3 && $role == 1) || ($usertype == 2 && $role == 3)) {
                                    $check_if_service_already_assigned = check_if_service_already_assigned($row->service_request_id);
                                    if ($check_if_service_already_assigned == 0) {
                                        ?>
                                        <a href='javascript:void(0);' id='trackinginner-<?php echo $row->service_request_id; ?>' onclick='change_status_inner(<?= $row->service_request_id; ?>,<?= $row->status; ?>, <?= $row->service_request_id ?>);'>
                                            <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                        </a>
                                        <?php
                                    } else {
                                        if ($check_if_service_already_assigned == sess('user_id')) {
                                            ?>
                                            <a href='javascript:void(0);' id='trackinginner-<?php echo $row->service_request_id; ?>' onclick='change_status_inner(<?= $row->service_request_id; ?>,<?= $row->status; ?>, <?= $row->service_request_id ?>);'>
                                                <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                            </a>
                                        <?php } else {
                                            ?>
                                            <a href='javascript:void(0);' id='trackinginner-<?php echo $row->service_request_id; ?>'>
                                                <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                            </a>
                                            <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <a href='javascript:void(0);' id='trackinginner-<?php echo $row->service_request_id; ?>' onclick='change_status_inner(<?= $row->service_request_id; ?>,<?= $row->status; ?>, <?= $row->service_request_id ?>);'>
                                        <span class='label <?php echo $trk_inner_class; ?> label-block' style="width: 80px;"><?= $tracking; ?></span>
                                    </a>
                                <?php } ?>
                            </td>
                            <?php } ?>

                            <?php
                            $start_date = date('m/d/Y', strtotime($row->date_started));
                            $complete_date = date('m/d/Y', strtotime($row->date_completed)); ?>

                            <td title="Start Date" class="text-center"><?= $start_date ?></td>
                            <td title="Complete Date" class="text-center"><?= $complete_date ?></td>
                            
                            <!-- Notes -->
                            <?php
                            if ($order_info['service_id'] == '11') {
                                if ($row->service_id == '11') {
                                    echo "<td align='center' title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a id="orderservice-' . $row->service_id .'-'. $row->service_request_id. '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollemp\',\'' . $row->service_request_id . '\',\'' . $row->service_id . '\',\'' . $order_info['company_id'] . '\',\'' . $row->order_id . '\')"><b>' . $note_count_inner . '</b></a>' : '<a id="orderservice-' . $row->service_id .'-'. $row->service_request_id. '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollemp\',\'' . $row->service_request_id . '\',\'' . $row->service_id . '\',\'' . $order_info['company_id'] . '\',\'' . $row->order_id . '\')"><b>' . $note_count_inner . '</b></a>') . "</span></td>";
                                } else {
                                    echo "<td align='center' title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a id="orderservice-' . $row->service_id .'-'. $row->service_request_id. '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollrt6\',\'' . $row->service_request_id . '\',\'' . $row->service_id . '\',\'' . $order_info['company_id'] . '\',\'' . $row->order_id . '\')"><b>' . $note_count_inner . '</b></a>' : '<a id="orderservice-' . $row->service_id .'-'. $row->service_request_id. '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'payrollrt6\',\'' . $row->service_request_id . '\',\'' . $row->service_id . '\',\'' . $order_info['company_id'] . '\',\'' . $row->order_id . '\')"><b>' . $note_count_inner . '</b></a>') . "</span></td>";
                                }
                            } else {
                                echo "<td align='center' title=\"Notes\"><span>" . (($note_count_inner > 0) ? '<a id="orderservice-' . $row->service_id .'-'. $row->service_request_id. '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'service\',\'' . $row->service_request_id . '\',\'' . $row->service_id . '\',\'' . $order_info['company_id'] . '\',\'' . $row->order_id . '\')"><b>' . $note_count_inner . '</b></a>' : '<a id="orderservice-' . $row->service_id .'-'. $row->service_request_id. '" count="' . $note_count_inner . '" class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'service\',\'' . $row->service_request_id . '\',\'' . $row->service_id . '\',\'' . $order_info['company_id'] . '\',\'' . $row->order_id . '\')"><b>' . $note_count_inner . '</b></a>') . "</span></td>";
                            }
                            ?>

                            <td title="SOS" style="text-align: center;">
                                <span>
                                    <a id="sosservicecount-<?= $row->order_id; ?>" class="d-inline p-t-5 p-b-5 p-r-8 p-l-8 label service-sos-count-<?= $row->service_request_id; ?> <?php echo (get_sos_count('order', $row->service_id, $row->order_id) == 0) ? 'label-primary' : 'label-danger'; ?>" title="SOS" href="javascript:void(0)" onclick="show_sos('order', '<?= $row->service_id; ?>', '<?= $all_staff_id_list_info; ?>', '<?= $row->order_id; ?>', '<?= $row->service_request_id; ?>');"><?php echo (get_sos_count('order', $row->service_id, $row->order_id) == 0) ? '<i class="fa fa-plus"></i>' : '<i class="fa fa-bell"></i>'; ?></a>                                                   
                                </span>
                            </td>

                            <td title="Input Form" class="text-center">
                                <?php
                                $input_status = 'complete';
                                if ($row->is_order=='y') {
                                    if ($row->input_form != 'y') {
                                        echo 'N/A';
                                    } else {

                                        $inputform_attachments = get_inputform_attachments($row->service_request_id);
                                        $inputform_notes = get_inputform_notes($row->service_request_id);
                                        
                                        if ($row->input_form_status == 'n') {
                                            $input_status = 'incomplete';
                                            ?>
                                            <a href="<?= base_url() . 'services/home/related_services/' . $row->service_request_id; ?>" class="btn btn-primary btn-xs" target="_blank" style="float: left;"><i class="fa fa-plus" aria-hidden="true"></i> Edit</a>
                                            <a href="<?= base_url() . 'services/home/related_services_view/' . $row->service_request_id; ?>" class="btn btn-primary btn-xs" target="_blank" style="float: right;"><i class="fa fa-eye" aria-hidden="true"></i> View </a>
                                            
                                        <?php } elseif ($inputform_attachments == '' || $inputform_notes == '') { ?>
                                            
                                            <a href="<?= base_url() . 'services/home/related_services/' . $row->service_request_id; ?>" class="btn btn-primary btn-xs" target="_blank" style="float: left;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </a>
                                            <a href="<?= base_url() . 'services/home/related_services_view/' . $row->service_request_id; ?>" class="btn btn-primary btn-xs" target="_blank" style="float: right;"><i class="fa fa-eye" aria-hidden="true"></i> View </a>
                                        
                                        <?php } else { ?>
                                             <a href="<?= base_url() . 'services/home/related_services/' . $row->service_request_id; ?>" class="btn btn-primary btn-xs" target="_blank" style="float: left;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </a>
                                             <a href="<?= base_url() . 'services/home/related_services_view/' . $row->service_request_id; ?>" class="btn btn-primary btn-xs" target="_blank" style="float: right;"><i class="fa fa-eye" aria-hidden="true"></i> View </a>
                                        <?php
                                        }
                                    }
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                                <input type="hidden" class="input-form-status-<?= $row->service_request_id; ?>" value="<?= $input_status; ?>" />
                            </td>

                        </tr>
                    </table>
                </div>

            </div>
        </div>

    <?php
        $row_number = $row_count + 1;
    endforeach;
    if (isset($page_number) && $row_number < count($result)) : ?>
        <div class="text-center p-0 load-more-btn">
            <a href="javascript:void(0);" onclick="loadNewServiceDashboard('', '', 'on_load', '', <?= $page_number + 1; ?>);" class="btn btn-success btn-sm m-t-30 p-l-15 p-r-15"><i class="fa fa-arrow-down"></i> Load more result</a>
        </div>
    <?php endif; ?>
    <script>
        $(function() {
            $('h2.result-count-h2').html('<?= $row_number . ' Results found of ' . count($result) ?>');
            <?php if (isset($page_number) && $row_number == count($result)) : ?>
                $('.load-more-btn').remove();
            <?php endif; ?>
        });
    </script>
    <?php if (isset($load_type) && isset($page_number) && $page_number == 1) :
        $filter_array = isset($load_type) ? array_merge(array_count_values(array_column($result, 'tome_filter_value')), array_count_values(array_column($result, 'byothers_filter_value')), array_count_values(array_column($result, 'byme_filter_value')), array_count_values(array_column($result, 'tome_late_filter_value')), array_count_values(array_column($result, 'byothers_late_filter_value')), array_count_values(array_column($result, 'byme_late_filter_value'))) : [];
        $assign_status = isset($load_type) ? array_count_values(array_column($result, 'assign_status')) : [];
    ?>
        <script>
            $(function() {
                <?php foreach ($filter_array as $key => $value) : ?>
                    $('a#filter-<?= $key; ?> span.label').html('<?= $value != '' ? $value : 0; ?>');
                <?php endforeach; ?>
                $('a#filter-unassigned-u span.label').html('<?= isset($assign_status['unassigned']) ? $assign_status['unassigned'] : 0; ?>');
            });
        </script>
    <?php endif;
else : ?>
    <div class="text-center m-t-30">
        <div class="alert alert-danger">
            <i class="fa fa-times-circle-o fa-4x"></i>
            <h3><strong>Sorry !</strong> no data found</h3>
        </div>
    </div>
<?php endif; ?>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>