<?php
$project_date = date('Y-m-d');
if (isset($project_recurrence_main_data) && !empty($project_recurrence_main_data)) {
    if ($project_recurrence_main_data['client_fiscal_year_end'] == 1) {
        $get_client_fye = get_client_fye($client_reference_id);
        $current_year = date('Y', strtotime($project_date));
        if ($project_recurrence_main_data['fye_type'] == 1) {

            $get_project_creation_date = $this->db->get_where('projects', ['id' => $insert_id])->row_array();
            $creation_date = date('Y-m-d', strtotime($project_date));

            $fye_day = $project_recurrence_main_data['fye_day'];
            $fye_is_weekday = $project_recurrence_main_data['fye_is_weekday'];
            $fye_month = $project_recurrence_main_data['fye_month'];

            $after_days = (int) $fye_month * 30;
            $current_due = $project_recurrence_main_data['actual_due_year'] . '-' . $get_client_fye;

            $newDate = strtotime($current_due . ' + ' . $after_days . ' days');

            $project_recurrence_main_data['actual_due_day'] = $fye_day;
            $project_recurrence_main_data['actual_due_month'] = date('m', $newDate);
            $project_recurrence_main_data['actual_due_year'] = date('Y', $newDate);

            if ($project_recurrence_main_data['actual_due_month'] <= 12) {
                $due_date = $project_recurrence_main_data['actual_due_year'] . '-' . $project_recurrence_main_data['actual_due_month'] . '-' . $project_recurrence_main_data['actual_due_day'];
            } else {
                $due_date = $project_recurrence_main_data['actual_due_year'] . '-' . ($project_recurrence_main_data['actual_due_month'] % 12) . '-' . $project_recurrence_main_data['actual_due_day'];
            }

            if ($due_date <= $creation_date) {
                $project_recurrence_main_data['actual_due_year'] = $project_recurrence_main_data['actual_due_year'] + 1;
            } else {
                $project_recurrence_main_data['actual_due_year'] = $project_recurrence_main_data['actual_due_year'];
            }
        }
    }
//                    day month and year creation
    unset($project_recurrence_main_data['actual_due_day']);
    unset($project_recurrence_main_data['actual_due_month']);
    unset($project_recurrence_main_data['actual_due_year']);
    if ($project_recurrence_main_data['pattern'] == 'annually' || $project_recurrence_main_data['pattern'] == 'none') {
        $project_recurrence_main_data['actual_due_day'] = $project_recurrence_main_data['due_day'];
        $project_recurrence_main_data['actual_due_month'] = $project_recurrence_main_data['due_month'];
        $current_month = date('m', strtotime($project_date));
        $current_day = date('d', strtotime($project_date));
        $current_year = date('Y', strtotime($project_date));
        if ($project_recurrence_main_data['due_month'] >= $current_month && $project_recurrence_main_data['due_day'] >= $current_day) {
            $project_recurrence_main_data['actual_due_year'] = ($current_year == date('Y') ? date('Y') : $current_year);
        } else {
            $project_recurrence_main_data['actual_due_year'] = ($current_year == date('Y') ? date('Y') : $current_year);
        }
    } elseif ($project_recurrence_main_data['pattern'] == 'monthly') {

        $current_month = date('m', strtotime($project_date));
        $current_day = date('d', strtotime($project_date));
        $current_year = date('Y', strtotime($project_date));
        $project_recurrence_main_data['actual_due_day'] = $project_recurrence_main_data['due_day'];
        $project_recurrence_main_data['actual_due_month'] = (int) $current_month + (int) $project_recurrence_main_data['due_month'];
        if ($project_recurrence_main_data['due_day'] >= $current_day) {

            if ($project_recurrence_main_data['actual_due_month'] <= 12) {
                $project_recurrence_main_data['actual_due_year'] = ($current_year == date('Y') ? date('Y') : $current_year);
            } else {
                $project_recurrence_main_data['actual_due_year'] = ($current_year == date('Y') ? date('Y') : $current_year) + 1;
            }
        } else {

            if ($project_recurrence_main_data['actual_due_month'] <= 12) {
                $project_recurrence_main_data['actual_due_year'] = ($current_year == date('Y') ? date('Y') : $current_year);
            } else {
                $year = intdiv($project_recurrence_main_data['actual_due_month'], 12);
                $project_recurrence_main_data['actual_due_year'] = ($current_year == date('Y') ? date('Y') : $current_year) + $year;
            }
        }
    } elseif ($project_recurrence_main_data['pattern'] == 'weekly') {
        $day_array = array('1' => 'Sunday', '2' => 'Monday', '3' => 'Tuesday', '4' => 'Wednesday', '5' => 'Thursday', '6' => 'Friday', '7' => 'Saturday');
        $current_day = $day_array[$project_recurrence_main_data['due_month']];
        $current_months = date('m', strtotime($project_date));
        $current_days = date('d', strtotime($project_date));
        $current_year = date('Y', strtotime($project_date));
        $givenDate = date('Y-m-d', mktime(0, 0, 0, $current_months, $current_days + $project_recurrence_main_data['due_day'], ($current_year == date('Y') ? date('Y') : $current_year)));
        $project_recurrence_main_data['actual_due_day'] = date('d', strtotime('next ' . $current_day, strtotime($givenDate)));
        $project_recurrence_main_data['actual_due_month'] = date('m', strtotime('next ' . $current_day, strtotime($givenDate)));
        $project_recurrence_main_data['actual_due_year'] = ($current_year == date('Y') ? date('Y') : $current_year);
    } elseif ($project_recurrence_main_data['pattern'] == 'quarterly') {
//                                $current_month = date('m');
        $current_month = date('m', strtotime($project_date));
        $current_day = date('d', strtotime($project_date));
        $current_year = date('Y', strtotime($project_date));
        if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
            $next_quarter[1] = '4';
            $next_quarter[2] = '5';
            $next_quarter[3] = '6';
            $due_year = ($current_year == date('Y') ? date('Y') : $current_year);
        } elseif ($current_month == '4' || $current_month == '5' || $current_month == '6') {
            $next_quarter[1] = '7';
            $next_quarter[2] = '8';
            $next_quarter[3] = '9';
            $due_year = ($current_year == date('Y') ? date('Y') : $current_year);
        } elseif ($current_month == '7' || $current_month == '8' || $current_month == '9') {
            $next_quarter[1] = '10';
            $next_quarter[2] = '11';
            $next_quarter[3] = '12';
            $due_year = ($current_year == date('Y') ? date('Y') : $current_year);
        } else {
            $next_quarter[1] = '1';
            $next_quarter[2] = '2';
            $next_quarter[3] = '3';
            $due_year = date(($current_year == date('Y') ? date('Y') : $current_year)) + 1;
        }
        $project_recurrence_main_data['actual_due_day'] = $project_recurrence_main_data['due_day'];
        if ($project_recurrence_main_data['due_month'] > $current_month) {
            $project_recurrence_main_data['actual_due_month'] = $project_recurrence_main_data['due_month'];
        } else {
            $project_recurrence_main_data['actual_due_month'] = $next_quarter[$project_recurrence_main_data['due_month']];
        }
        $project_recurrence_main_data['actual_due_year'] = $due_year;
    } elseif ($project_recurrence_main_data['pattern'] == 'periodic') {
//                                $current_month = date('m');
        $current_month = date('m', strtotime($project_date));
        $current_day = date('d', strtotime($project_date));
        $current_year = date('Y', strtotime($project_date));
        $project_recurrence_main_data['actual_due_day'] = $project_recurrence_main_data['due_day'];
        $project_recurrence_main_data['actual_due_month'] = (int) $project_recurrence_main_data['due_month'];
        if ($project_recurrence_main_data['actual_due_day'] >= $current_day) {
            if ($project_recurrence_main_data['actual_due_month'] < $current_month) {
                $project_recurrence_main_data['actual_due_year'] = ($current_year == date('Y') ? date('Y') : $current_year) + 1;
            } else {
                $project_recurrence_main_data['actual_due_year'] = ($current_year == date('Y') ? date('Y') : $current_year);
            }
        } else {
            if ($project_recurrence_main_data['actual_due_month'] <= $current_month) {
                $project_recurrence_main_data['actual_due_year'] = ($current_year == date('Y') ? date('Y') : $current_year) + 1;
            } else {
                $project_recurrence_main_data['actual_due_year'] = ($current_year == date('Y') ? date('Y') : $current_year);
            }
        }
//                                $periodic_day= json_decode($project_recurrence_main_data['periodic_due_day']);
//                                $periodic_month=json_decode($project_recurrence_main_data['periodic_due_month']);
//                                unset($project_recurrence_main_data['periodic_due_day']);
//                                unset($project_recurrence_main_data['periodic_due_month']);
    } else {
        $project_recurrence_main_data['actual_due_day'] = '0';
        $project_recurrence_main_data['actual_due_month'] = '0';
        $project_recurrence_main_data['actual_due_year'] = '0';
    }
//                            end of new date 
//                            echo $project_recurrence_main_data['actual_due_month'];die;
    if ($project_recurrence_main_data['pattern'] == 'monthly') {
//                        $cur_day = date('d');
        $cur_month = date('m', strtotime($project_date));
        $cur_day = date('d', strtotime($project_date));
        $current_year = date('Y', strtotime($project_date));
        if ($cur_day <= $project_recurrence_main_data['actual_due_day']) {
            if ($cur_month <= $project_recurrence_main_data['actual_due_month']) {
                $project_recurrence_main_data['actual_due_month'] = $cur_month;
            } else {
                $project_recurrence_main_data['actual_due_month'] = $project_recurrence_main_data['actual_due_month'];
            }
        } else {
            if ($cur_month <= $project_recurrence_main_data['actual_due_month']) {
                $project_recurrence_main_data['actual_due_month'] = $project_recurrence_main_data['actual_due_month'];
            } else {
                $project_recurrence_main_data['actual_due_month'] = $cur_month;
            }
        }
    }
    unset($project_recurrence_main_data['id']);
    if ($project_recurrence_main_data['pattern'] != 'annually') {
        if ($project_recurrence_main_data['actual_due_month'] <= 12) {
            $due_date = $project_recurrence_main_data['actual_due_year'] . '-' . $project_recurrence_main_data['actual_due_month'] . '-' . $project_recurrence_main_data['actual_due_day'];
        } else {
            $due_date = $project_recurrence_main_data['actual_due_year'] . '-' . ($project_recurrence_main_data['actual_due_month'] % 12) . '-' . $project_recurrence_main_data['actual_due_day'];
        }
    } else {
        $current_month = date('m', strtotime($project_date));
        $current_day = date('d', strtotime($project_date));
        $current_year = date('Y', strtotime($project_date));
        if ($project_recurrence_main_data['actual_due_day'] > $current_day) {
            if ($project_recurrence_main_data['actual_due_month'] >= $current_month) {
                $due_date = $project_recurrence_main_data['actual_due_year'] . '-' . $project_recurrence_main_data['actual_due_month'] . '-' . $project_recurrence_main_data['actual_due_day'];
            } else {
                $due_date = $project_recurrence_main_data['actual_due_year'] + 1 . '-' . $project_recurrence_main_data['actual_due_month'] . '-' . $project_recurrence_main_data['actual_due_day'];
            }
        } else {
            if ($project_recurrence_main_data['actual_due_month'] > $current_month) {
                $due_date = $project_recurrence_main_data['actual_due_year'] . '-' . $project_recurrence_main_data['actual_due_month'] . '-' . $project_recurrence_main_data['actual_due_day'];
            } else {
                $due_date = $project_recurrence_main_data['actual_due_year'] + 1 . '-' . $project_recurrence_main_data['actual_due_month'] . '-' . $project_recurrence_main_data['actual_due_day'];
            }
        }
    }
//                    checking user date vs calculated pattern due date
//    if ($due_date == $user_due_date) {
//        $due_date = $due_date;
//    } else {
//        $due_date = $user_due_date;
//    }

    if ($project_recurrence_main_data['generation_month'] == '') {
        $project_recurrence_main_data['generation_month'] = '0';
    }

    if ($project_recurrence_main_data['generation_day'] == '') {
        $project_recurrence_main_data['generation_day'] = '0';
    }
    $total_days=cal_days_in_month(CAL_GREGORIAN, $project_recurrence_main_data['actual_due_month'], $project_recurrence_main_data['actual_due_year']);
    $generation_days = ((int) $project_recurrence_main_data['generation_month'] * $total_days) + (int) $project_recurrence_main_data['generation_day'];

    $project_recurrence_main_data['due_date'] = $due_date;
//                    echo $due_date;die;
    if ($project_recurrence_main_data['pattern'] == 'monthly') {
        $next_due_date = date("Y-m-d", strtotime("+1 month", strtotime($due_date)));
        $project_recurrence_main_data['next_due_date'] = $next_due_date;
    } elseif ($project_recurrence_main_data['pattern'] == 'annually') {
        $next_due_date = date("Y-m-d", strtotime("+1 year", strtotime($due_date)));
        $project_recurrence_main_data['next_due_date'] = $next_due_date;
    } elseif ($project_recurrence_main_data['pattern'] == 'weekly') {
        $next_due_date = date("Y-m-d", strtotime("+7 days", strtotime($due_date)));
        $project_recurrence_main_data['next_due_date'] = $next_due_date;
    } elseif ($project_recurrence_main_data['pattern'] == 'quarterly') {
        $next_due_date = date("Y-m-d", strtotime("+3 months", strtotime($due_date)));
        $project_recurrence_main_data['next_due_date'] = $next_due_date;
    } elseif ($project_recurrence_main_data['pattern'] == 'periodic') {
        $next_due_date = '0000-00-00';
        $project_recurrence_main_data['next_due_date'] = $next_due_date;
    } else {
        $project_recurrence_main_data['next_due_date'] = '0000-00-00';
    }
    if ($project_recurrence_main_data['generation_type'] == 2 || $project_recurrence_main_data['pattern'] == 'periodic') {
        $generation_date = NULL;
    } else {
        $generation_date = date('Y-m-d', strtotime('-' . $generation_days . ' days', strtotime($project_recurrence_main_data['next_due_date'])));
    }
    $project_recurrence_main_data['generation_date'] = $generation_date;

    //project start date section
    $actual_month=date('m',strtotime($due_date));
    $actual_year=date('Y',strtotime($due_date));
    $total_days=cal_days_in_month(CAL_GREGORIAN, $actual_month, $actual_year);
    $project_start_day = ((int) $project_recurrence_main_data['target_start_months'] * $total_days) + (int) $project_recurrence_main_data['target_start_days'];
    $project_start_date = date('Y-m-d', strtotime('-' . $project_start_day . ' days', strtotime($due_date)));
    $dueDate = strtotime($due_date);
    ?>
    <input type="hidden" id="target_start_month" value="<?= $project_recurrence_main_data['target_start_months'] ?>">
    <input type="hidden" id="target_start_day" value="<?= $project_recurrence_main_data['target_start_days'] ?>">
    <input type="hidden" id="actual_target_start_date" value="<?= date('m/d/Y', strtotime($project_start_date)) ?>">
    <input type="hidden" id="actual_due_date" value="<?= $due_date ?>">
    <input type="hidden" id="project_pattern" value="<?= $project_recurrence_main_data['pattern'] ?>">
    <input type="hidden" id="actual_month" value="<?= $project_recurrence_main_data['actual_due_month'] ?>">
    <input type="hidden" id="actual_year" value="<?= $project_recurrence_main_data['actual_due_year'] ?>">

    <div class="col-md-6">
        <label class="col-lg-12 control-label">Due Date:<span class="text-danger">*</span></label>
        <div class="form-group">
            <input placeholder="mm/dd/yyyy" id="due_date" name="project[due_date]" class="form-control datepicker_creation_date" type="text" title="Due Date" value="<?= date('m/d/Y', strtotime($due_date)) ?>" onchange="change_project_start_date(this.value)">
            <div class="errorMessage text-danger"></div>
        </div>
    </div>

    <div class="col-md-6">
        <label class="col-lg-12 control-label">Start Date:<span class="text-danger">*</span></label>
        <div class="form-group">
            <input placeholder="mm/dd/yyyy" id="task_start_date" class="form-control datepicker_creation_date" name="project[start_date]" type="text" title="Start Date" value="<?= date('m/d/Y', strtotime($project_start_date)); ?>" onchange="change_project_due_date(this.value)">
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    
    <div class="col-md-12">
        <h3 class="m-0 p-b-10 col-lg-12">Next Recurrence:</h3>
        <div class="col-md-7">
            <div class="form-inline">
                <label class="control-label"><input type="radio" name="recurrence[generation_type]" <?php echo ($project_recurrence_main_data['generation_type'] == '1') ? 'checked' : ''; ?> value="1" readonly onclick="//check_generation_type(this.value)"></label>&nbsp;
                <input class="form-control" type="number" id="generation_month" name="recurrence[generation_month]" value="<?php echo $project_recurrence_main_data['generation_month']; ?>" min="0" max="12" readonly style="width: 100px">&nbsp;
                <label class="control-label">month(s)</label>&nbsp;
                <input class="form-control" value="<?php echo $project_recurrence_main_data['generation_day']; ?>" type="number" id="generation_day" name="recurrence[generation_day]" min="1" readonly max="31" style="width: 100px">&nbsp;
            </div>
        </div>
        <div class="col-md-5">
            <label class="control-label">Day(s) before next occurrence due date</label>
        </div>
    </div>
<?php } ?>
<script>
    $(document).ready(function () {
        $(".datepicker_creation_date").datepicker({format: 'mm/dd/yyyy', autoHide: true});
    });
    function change_project_start_date(due_date) {
        var target_start_month = $("#target_start_month").val();
        var target_start_day = $('#target_start_day').val();
        var actual_target_start_date = $("#actual_target_start_date").val();
        var actual_due_date = $("#actual_due_date").val();
        var due_date = $('#due_date').val();
        var a = new Date(due_date);
        var actual_month=a.getMonth();
        var actual_year=a.getYear();
        alert(actual_month);
        var total_days=new Date(actual_year, actual_month, 0).getDate();
        var target_start_days = (parseInt(target_start_month) * parseInt(total_days) + parseInt(target_start_day));
        a.setDate(a.getDate() - parseInt(target_start_days));
        var dateEnd = (a.getMonth() + 1) + '/' + a.getDate() + '/' + a.getFullYear();
        $('#task_start_date').val(dateEnd);
    }
    function change_project_due_date(start_date) {
        var actual_start_date = $('#task_start_date').val();
        var actual_due_date = $("#actual_due_date").val();
        var project_pattern =$("#project_pattern").val();
        var p = new Date(actual_due_date);
        var actual_day = p.getDate();
        var actual_month = p.getMonth();
        var parse_due_date = Date.parse(actual_due_date);
        var parse_start_date = Date.parse(actual_start_date);
        var old_date = new Date(parse_due_date);
        var new_date = new Date(parse_start_date);
        var actual_month=new_date.getMonth();
        var actual_year=new_date.getYear();
        var total_days=new Date(actual_year, actual_month, 0).getDate();
        if(project_pattern=='monthly'){
            if (parse_start_date > parse_due_date) {
                var future_new_date = new_date.getDate();
                var future_new_month = new_date.getMonth();
                if (future_new_date > actual_day) {
                    new_date.setDate(new_date.getDate() + parseInt(total_days));
                    var new_due_date = (new_date.getMonth() + 1) + '/' + actual_day + '/' + new_date.getFullYear();
                } else {
                    var new_due_date = (new_date.getMonth() + 1) + '/' + actual_day + '/' + new_date.getFullYear();
                }
                $("#due_date").val(new_due_date);
            } else {
                var dueDate = (old_date.getMonth() + 1) + '/' + old_date.getDate() + '/' + old_date.getFullYear();
                $("#due_date").val(dueDate);
            }
        }
        if(project_pattern=='weekly'){
                var future_new_date = new_date.getDate();
                var future_new_month = new_date.getMonth();
                new_date.setDate(new_date.getDate() + parseInt(7));
                var new_due_date = (new_date.getMonth() + 1) + '/' + actual_day + '/' + new_date.getFullYear();
                $("#due_date").val(new_due_date);
        }
    }
</script>