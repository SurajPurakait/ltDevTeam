<?php
$project_date = date('Y-m-d');
if (isset($project_recurrence_main_data) && !empty($project_recurrence_main_data)) {
    $template_cat_id=get_template_cat_id($project_recurrence_main_data['template_id']);
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
//        echo $givenDate;
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
        if($template_cat_id==1){
            $due_date = $project_recurrence_main_data['actual_due_year'] + 1 . '-' . 03 . '-' . $project_recurrence_main_data['actual_due_day'];
        }else{
            $due_date = $project_recurrence_main_data['actual_due_year'] + 1 . '-' . 01 . '-' . $project_recurrence_main_data['actual_due_day'];
        }
    }
    if ($project_recurrence_main_data['generation_month'] == '') {
        $project_recurrence_main_data['generation_month'] = '0';
    }

    if ($project_recurrence_main_data['generation_day'] == '') {
        $project_recurrence_main_data['generation_day'] = '0';
    }
    if($template_cat_id==1){
        $actual_month = date('m', strtotime('-1 month', strtotime($due_date)));
    }else{
        $actual_month = date('m', strtotime($due_date));
    }
    $actual_year = date('Y', strtotime($due_date));
    $total_days = cal_days_in_month(CAL_GREGORIAN, $actual_month, $actual_year);
    $generation_days = ((int) $project_recurrence_main_data['generation_month'] * (int) $total_days) + (int) $project_recurrence_main_data['generation_day'];
//    echo $generation_days;
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
        if($template_cat_id==1){
            if($project_recurrence_main_data['pattern']!='annually'){
                $generation_date=date('Y',strtotime($generation_date)).'-'.date('m',strtotime($generation_date)).'-'.$project_recurrence_main_data['due_day'];
            }else{
                $generation_date=date('Y',strtotime($generation_date)).'-'.'01'.'-'.$project_recurrence_main_data['due_day'];
            }
        }else{
            if($project_recurrence_main_data['pattern']!='annually'){
                $generation_date=date('Y',strtotime($generation_date)).'-'.date('m',strtotime($generation_date)).'-'.'01';
            }else{
                $generation_date=date('Y',strtotime($generation_date)).'-'.'01'.'-'.'01';
            }
        }
    }
    $project_recurrence_main_data['generation_date'] = $generation_date;
    $month_array = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'Dececmber');
    $quarter_array=array(1=>'Q1-Jan/Mar',2=>'Q2-Apr/Jun',3=>'Q3-Jul/Sep',4=>'Q4-Oct/Dec');
    //project start date section
    $actual_month = date('m', strtotime('-1 month', strtotime($due_date)));
    $actual_year = date('Y', strtotime($due_date));
    $total_days = cal_days_in_month(CAL_GREGORIAN, $actual_month, $actual_year);
    $project_start_day = ((int) $project_recurrence_main_data['target_start_months'] * $total_days) + (int) $project_recurrence_main_data['target_start_days'];
    if($project_recurrence_main_data['pattern']!='annually'){
        $project_start_date = date('Y-m-d', strtotime('-' . $project_start_day . ' days', strtotime($due_date)));
    }else{
        if($template_cat_id==3){
            $project_start_date = date("Y-m-d",strtotime($project_date));
        }else{
            $project_start_date=date("Y-m-d",strtotime($project_date));
        }
    }
    $dueDate = strtotime($due_date);
    ?>
    
    <input type="hidden" id="project_pattern" value="<?= $project_recurrence_main_data['pattern'] ?>">
    <input type="hidden" id="due_day" value="<?= $project_recurrence_main_data['due_day'] ?>">
    <input type="hidden" id="target_start_month" value="<?= $project_recurrence_main_data['target_start_months'] ?>">
    <input type="hidden" id="generation_day" value="<?= $project_recurrence_main_data['generation_day'] ?>">
    <input type="hidden" id="generation_month" value="<?= $project_recurrence_main_data['generation_month'] ?>">
    <input type="hidden" id="template_cat_id" value="<?= $template_cat_id ?>">
    <div class="col-md-6">
        <label class="col-lg-12 control-label">Starting Period:<span class="text-danger">*</span></label>
        <div class="form-group">
            <?php 
            if($project_recurrence_main_data['pattern']!='annually'){ 
                if($project_recurrence_main_data['pattern']=='quarterly'){ ?>
                    <select id="project_start_quarter" name="project[start_month]" onchange="change_project_due_date(this.value)">
                        <?php $select_month = date('m', strtotime($project_start_date)); ?>
                        <option value="">Select Quarter</option>
                        <?php foreach ($quarter_array as $key => $quarter) { ?>
                            <option value="<?= $key ?>" <?= $key == $select_month ? 'selected' : '' ?> ><?= $quarter ?></option>
                        <?php } ?>
                    </select>
                <?php }else{ ?>
                    <select id="project_start_month" name="project[start_month]" onchange="change_project_due_date(this.value)">
                        <?php $select_month = date('m', strtotime($project_start_date)); ?>
                        <option value="">Select Month</option>
                        <?php foreach ($month_array as $key => $month) { ?>
                            <option value="<?= $key ?>" <?= $key == $select_month ? 'selected' : '' ?> ><?= $month ?></option>
                        <?php } ?>
                    </select>
            <?php } } ?>
            <?php $years = array_combine(range(date("Y"), 2019), range(date("Y"), 2019)); ?>
            <select id="project_start_year" name="project[start_year]" onchange="change_project_due_date()">
                <?php $select_month = date('Y', strtotime($project_start_date)); ?>
                <option value="">Select Year</option>
                <?php foreach ($years as $key => $year) { ?>
                    <option value="<?= $key ?>" <?= $key == $select_month ? 'selected' : '' ?> ><?= $year ?></option>
                <?php } ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="col-md-6">
        <label class="col-lg-12 control-label">Due Date:<span class="text-danger">*</span></label>
        <div class="form-group">
            <input placeholder="mm/dd/yyyy" id="due_date" name="project[due_date]" class="form-control datepicker_due_date" type="text" title="Due Date" value="<?= date('m/d/Y', strtotime($due_date)) ?>" onchange="change_project_start_date(this.value)">
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="col-md-12">
        <h3 class="m-0 p-b-10 col-lg-12">Next Recurrence: <span id='next_recurrence' ><?= date('m/d/Y', strtotime($generation_date)); ?></span></h3>
    </div>
    <input type="hidden" name="project[next_due_date]" id="next_due_date" value="<?= $next_due_date ?>">
    <input type="hidden" name="project[generation_date]" id="generation_date" value="<?= $generation_date ?>">
<?php } ?>
<script>
    $(document).ready(function () {
        $(".datepicker_due_date").datepicker({format: 'mm/dd/yyyy', autoHide: true});
    });
    function change_project_start_date(due_date) {
         due_date=new Date(due_date)
        var month=due_date.getMonth();
    }
    function change_project_due_date(select_month='') {
        var project_pattern =$("#project_pattern").val();
        var template_cat_id=$('#template_cat_id').val();
        if(project_pattern=='monthly'){
            if(select_month==''){
                select_month=$("#project_start_month").val();
            }
            var select_year=$("#project_start_year").val();
            var due_day=$('#due_day').val();
            var target_start_month=$("#target_start_month").val();
            var generation_day=$('#generation_day').val();
            var generation_month=$("#generation_month").val();
            var create_date=new Date(select_month+' '+due_day+' '+select_year);
            var next_month=parseInt(select_month)+parseInt(target_start_month);
            var day_of_select_month=new Date(select_year, select_month, 0).getDate();
            var next_month_of_selected_month= new Date(create_date.getFullYear(), create_date.getMonth(), create_date.getDate()+30);
            var day_of_next_selected_month=new Date(next_month_of_selected_month.getYear(),next_month_of_selected_month.getMonth(),0).getDate();
            if(target_start_month==1){
                var total_days=30;
            }else{
                var total_days=parseInt(day_of_select_month)+parseInt(day_of_next_selected_month)+parseInt(1);
            }
            if(next_month==13){
                next_month=01;
            }else if(next_month==14){
                next_month=02;
            }
            create_date.setDate(create_date.getDate() + parseInt(total_days));
            var due_date=next_month + '/' + due_day + '/' + create_date.getFullYear();
            $("#due_date").val(due_date);
            var next_due_month=parseInt(next_month)+parseInt(1);
            var next_due=new Date(due_date);
            next_due.setDate(next_due.getDate() + parseInt(31));
            if(next_due_month==13){
                next_due_month=01;
            }
            var next_due_date=next_due_month + '/' + due_day + '/' + next_due.getFullYear();
            $('#next_due_date').val(next_due_date);
            var next_recurrence=new Date(next_due_date);
            var new_month=next_recurrence.getMonth();
            var actual_year=next_recurrence.getYear();
            var sales_month=new Date(actual_year, new_month, 0).getDate();
            var total_recurrence_days=(parseInt(generation_month)*parseInt(sales_month))+parseInt(generation_day);
            next_recurrence.setDate(next_recurrence.getDate() - parseInt(total_recurrence_days));
            var next_recurrence_month=parseInt(next_due_month)-parseInt(target_start_month);
            if(next_recurrence_month==0){
                next_recurrence_month=12;
            }if(next_recurrence_month==-1){
                next_recurrence_month=11;
            }
            if(template_cat_id==1){
                var next_recurrence_date=next_recurrence_month + '/' + due_day + '/' + next_recurrence.getFullYear();
            }else {
                var next_recurrence_date=(next_recurrence.getMonth()+ 1) + '/' + next_recurrence.getDate() + '/' + next_recurrence.getFullYear();
            }
            $("#next_recurrence").text(next_recurrence_date);
            $('#generation_date').val(next_recurrence_date);
        }
        else if(project_pattern=='quarterly'){
            if(select_month==''){
                select_month=$("#project_start_quarter").val();
            }
            var select_year=$("#project_start_year").val();
            var due_day=$('#due_day').val();
            if(select_month==1){
                var due_date= 04+'/'+due_day + "/"+ select_year;
                var next_due_date= 07+'/'+due_day + "/"+ select_year;
                var next_recurrence_date= 04+'/'+01 + "/"+ select_year;
            }else if(select_month==2){
                due_date= 07+'/'+due_day + "/"+ select_year;
                next_due_date= 10+'/'+due_day + "/"+ select_year;
                next_recurrence_date= 07+'/'+01 + "/"+ select_year;
            }else if(select_month==3){
                due_date= 10+'/'+due_day + "/"+ select_year;
                next_due_date= 01+'/'+due_day + "/"+ (parseInt(select_year) +parseInt(1));
                next_recurrence_date= 10+'/'+01 + "/"+ select_year;
            }else{
                due_date= 01+'/'+due_day + "/"+ (parseInt(select_year) +parseInt(1));
                next_due_date= 04+'/'+due_day + "/"+ (parseInt(select_year) +parseInt(1));
                next_recurrence_date=01+'/'+01 + "/"+ (parseInt(select_year) +parseInt(1));
            }
            $("#due_date").val(due_date);
            $('#next_due_date').val(next_due_date);
            $("#next_recurrence").text(next_recurrence_date);
            $('#generation_date').val(next_recurrence_date);
        }
        else if(project_pattern=='annually'){
            var select_year=$("#project_start_year").val();
            var due_day=$('#due_day').val();
            var next_year=(parseInt(select_year) +parseInt(1));
            if(template_cat_id==1){
                var due_date= 03+'/'+due_day + "/"+ next_year;
                var next_due_date= 03+'/'+due_day + "/"+ (parseInt(next_year) +parseInt(1));
                var next_recurrence_date= 01+'/'+01 + "/"+ next_year;
            }else{
                var due_date= 01+'/'+due_day + "/"+ next_year;
                var next_due_date= 01+'/'+due_day + "/"+ (parseInt(next_year) +parseInt(1));
                var next_recurrence_date= 01+'/'+01 + "/"+ next_year;
            }
            $("#due_date").val(due_date);
            $('#next_due_date').val(next_due_date);
            $("#next_recurrence").text(next_recurrence_date);
            $('#generation_date').val(next_recurrence_date);
        }
    }
</script>