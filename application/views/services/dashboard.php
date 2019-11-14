<?php
$stafftype = $staffInfo['type'];
$staffrole = $staffInfo['role'];
$user_id = sess('user_id');
if ($status == '') {
    $status = '4';
}
?>
<style type="text/css">
    .service-requests {
        width: 100%;
    }

    .service-requests tr th,
    .service-requests tr td {
        padding: 8px;
    }

    .service-mother {
        background: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .service-mother.has-child {
        cursor: pointer;
    }

    .service-child {
        background: #fff;
        border-bottom: 1px solid #ddd;
    }

    .label-block {
        display: block;
        padding: 5px 8px;
    }
</style>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="filter-outer">
                                <form name="filter_form" id="filter-form"  method="post" onsubmit="service_filter_form()">
                                    <div class="form-group filter-inner">
                                        <div class="filter-div row m-b-10" id="original-filter">
                                            <div class="col-md-3 m-t-5">
                                                <select class="form-control variable-dropdown" name="variable_dropdown[]" onchange="change_variable_dd(this)">
                                                    <option value="">All Variable</option>
                                                    <option value="1">Category</option>
                                                    <option value="10">Client ID</option>
                                                    <option value="7">Complete Date</option>
                                                    <option value="13">Creation Date</option>
                                                    <option value="14">Department</option>
                                                    <option value="3">Office</option>
                                                    <option value="9">ORDER#</option>
                                                    <option value="5">Requested By</option>
                                                    <option value="15">Request Type</option>
                                                    <option value="2">Service Name</option>                                                    
                                                    <option value="6">Start Date</option>
                                                    <option value="12">Target End Date</option>
                                                    <option value="11">Target Start Date</option>
                                                    <option value="4">Tracking</option>                                                    
                                                </select>
                                            </div>
                                            <div class="col-md-4 m-t-5">
                                                <select class="form-control condition-dropdown" name="condition_dropdown[]" onchange="change_condition_dd(this)">
                                                    <option value="">All Condition</option>
                                                    <option value="1">Is</option>
                                                    <option value="2">Is in the list</option>
                                                    <option value="3">Is not</option>
                                                    <option value="4">Is not in the list</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 m-t-5 criteria-div">
                                                <select class="form-control criteria-dropdown chosen-select" placeholder="All Criteria" name="criteria_dropdown[][]">
                                                    <option value="">All Criteria</option>
                                                </select>
                                            </div>
                                            <div class="col-md-1 m-t-5">
                                                <div class="add_filter_div">
                                                    <a href="javascript:void(0);" onclick="add_new_filter_row()" class="add-filter-button btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add Filter"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">  
                                            <div class="m-b-10">
                                                <button class="btn btn-success" type="button" onclick="service_filter_form()">Apply Filter</button>
                                                <a href='javascript:void(0);' id=btn_service onclick="loadServiceDashboard('','','on_load','',1);" class="btn btn-ghost" style="display: none;"><i class='fa fa-times' aria-hidden='true'></i> Clear filter</a>
                                                <!--<label class="filter-text"></label>-->
                                            </div>
                                        </div>
                                    </div>
                                </form>  
                                <input id="hiddenflag" value="" type="hidden">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="bg-aqua table-responsive">
                                <table class="table table-borderless" style="border-collapse: separate;">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <th class="text-center">Not Started</th>
                                            <th class="text-center">Started</th>
                                            <th class="text-center">Late</th>
                                            <th class="text-center">SOS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($stafftype == 1 || $stafftype == 2 || $stafftype == 3) { ?>
                                            <tr>
                                                <th>By ME</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byme-2">
                                                        <span class="label label-warning">-</span>
                                                    </a></td>
                                                <td class="text-center">                                                    
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byme-1">
                                                        <span class="label label-primary">-</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byme-3">
                                                        <span class="label label-danger">-</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a class="filter-button" onclick="sos_filter('order', 'byme');" title="By Me"><span class="label label-success label-byme" id="sos-byme"><?= sos_dashboard_count('order', 'byme'); ?></span></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($stafftype == 1 || $stafftype == 2) {
                                            ?>
                                            <tr>
                                                <th>To ME</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-tome-2">
                                                        <span class="label label-warning">-</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-tome-1">
                                                        <span class="label label-primary">-</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-tome-3">
                                                        <span class="label label-danger">-</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a class="filter-button" onclick="sos_filter('order', 'tome');" title="To Me"><span class="label label-success label-tome" id="sos-tome"><?= sos_dashboard_count('order', 'tome'); ?></span></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($stafftype == 1 || ($stafftype == 3 && $staffrole == 2) || ($stafftype == 2 && $staffrole == 4)) {
                                            ?>
                                            <tr>
                                                <th>Others</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byothers-2">
                                                        <span class="label label-warning">-</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byothers-1">
                                                        <span class="label label-primary">-</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byothers-3">
                                                        <span class="label label-danger">-</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-4">
                                    <a class="btn notification-btn filter-button p-l-0" id="filter-unassigned-u" title="By Me">Unassigned <span class="label label-success label-byme">-</span></a>
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <a class="btn notification-btn filter-button p-l-0" id="service-notifcation-toggle" value='forme' onclick="openServiceNotificationModal('');" href="javascript:void(0);" title="Service Notifications">Notifications <span class="label label-danger notification_count"><?= get_service_notifications_count('forme'); ?></span></a>
                                </div>
                                <div class="col-xs-6 count_mobile">
                                    <?php
                                    $sos_noti_count = sos_dashboard_count_for_reply('order', 'tome');
                                    if ($sos_noti_count != 0) {
                                        ?>
                                        <a href="javascript:void(0);" onclick="this.parentElement.style.display = 'none';" class="count_reply_close"><i class="fa fa-times text-danger" aria-hidden="true"></i></a>
                                        <span class="label label-danger p-5 count_reply">
                                            <h4> <i class="fa fa-bell"></i>
                                                <?php if ($sos_noti_count == 1) { ?>    
                                                    New reply (<?= sos_dashboard_count_for_reply('order', 'tome'); ?>).
                                                <?php } else { ?>
                                                    New replies (<?= sos_dashboard_count_for_reply('order', 'tome'); ?>).
                                                <?php } ?>
                                            </h4>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>                    
                    <div class="ajaxdiv"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="dept" value="<?= $staffInfo['department']; ?>">
<!-- Modal -->
<div class="modal fade" id="show_notes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" id="modal_note_form_update" onsubmit="update_service_note()">    
                <div id="notes-modal-body" class="modal-body p-b-0">

                </div>
                <div class="modal-body p-t-0 text-right">
                    <button type="button" class="btn btn-primary" id="update_note" onclick="update_service_note()">Update Note</button>
                </div>
            </form>
            <hr class="m-0"/>
            <form method="post" id="modal_note_form" onsubmit="add_service_notes()">    
                <div class="modal-body">
                    <h4>Add Note</h4>
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="referral_partner_note[]"  title="Referral Partner Note"></textarea>
                        </div>
                        <a href="javascript:void(0)" class="text-success add-referreal-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                    </div>
                    <input type="hidden" name="reference_id" id="reference_id">
                    <input type="hidden" name="related_table_id" id="related_table_id">
                    <input type="hidden" name="reference" id="reference">

                    <input type="hidden" name="order_id" id="order_id">
                    <input type="hidden" name="serviceid" id="serviceid">
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_note" onclick="add_service_notes();" class="btn btn-primary">Save Note</button>
                    <!-- <button type="submit" id="save_note" class="btn btn-primary" onclick="document.getElementById('modal_note_form').submit();this.disabled = true;this.innerHTML = 'Processing...';">Save Note</button> -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- Sos Modal -->
<div class="modal fade" id="showSos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">SOS</h4>
            </div>
            <div id="notes-modal-body" class="modal-body p-b-0"></div>
            <form method="post" id="sos_note_form" onsubmit="add_sos()">    
                <div class="modal-body">
                    <h4 id="sos-title">Add New SOS</h4>
                    <div class="form-group" id="add_sos_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="sos_note"  title="SOS Note"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="reference" id="reference" value="order">
                    <input type="hidden" name="refid" id="refid">
                    <input type="hidden" name="staffs" id="staffs">
                    <input type="hidden" name="serviceid" id="serviceid">
                    <input type="hidden" name="replyto" id="replyto" value="">
                    <input type="hidden" name="servreqid" id="servreqid" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_sos" class="btn btn-primary" onclick="add_sos()">Post SOS</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Sos Modal -->
<div id="changeStatusinner" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad2" value="2"/>
                                <label for="rad2"><strong>Not Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad1" value="1"/>
                                <label for="rad1"><strong>Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad0" value="0"/>
                                <label for="rad0"><strong>Completed</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad7" value="7"/>
                                <label for="rad7"><strong>Canceled</strong></label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="suborderid" value="">
                <input type="hidden" id="baseurl" value="<?= base_url(); ?>">
            </div>
            <div class="modal-footer text-center">
                <input type="hidden" id="sos_read_status" />
                <input type="hidden" id="input_form_status" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-tracking" onclick="updateStatusinner()">Save changes</button>
            </div>
            <div class="modal-body" style="display: none;" id="log_modal">
                <div style="height:200px; overflow-y: scroll">
                    <table id="status_log" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>time</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- notes modal -->
<div id="modal_area" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div class="modal fade" id="notification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="notification">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div id="msg-modal-body" class="modal-body"></div>
        </div>
    </div>
</div>
<!-- attachments modal -->

<div class="modal fade" id="modal_area_attach" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="notification">
        <div class="modal-content">
            <div class="modal-header">Attachments</div>
            <div id="modal-body-attachments" class="modal-body"></div>
            <div class="modal-footer">   
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="service_notification_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close m-t-2" data-dismiss="modal" aria-label="Close" onclick="closeServiceNotificationModal()"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Notifications
                    <!--<div class="dropdown pull-right m-r-5">-->   
                    <a class="pull-right m-r-5" href="javascript:void(0);" title="Clear All" id="service-notification-clear" onclick="clearServiceNotificationList('<?= sess('user_id'); ?>');"><i class="fa fa-trash-o"></i></a>
                    <a class="pull-right m-r-5 service_title" href="javascript:void(0);" title="For Me" value='forother' id="service-notifcation-toggle" onclick="openServiceNotificationModal('');"><i class="fa fa-exchange"></i></a>
                    <!--</div>-->
                </h4>
            </div>
            <div id="service-modal-body" class="modal-body"></div>
            <div id="service_clear"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    loadServiceDashboard('<?= $status == '' ? 4 : ''; ?>', '<?= $category_id ?>', 'on_load', '<?= $office_id; ?>', 1);
    var content = $(".filter-div").html();
    var variable_dd_array = [];
    var element_array = [];
    function show_notes_outer(reference, reference_id, new_staffs, order_id) {
        var url = '<?= base_url(); ?>services/home/getNotesContent';
        var data = {
            reference: reference,
            reference_id: reference_id,
            loc: 'outer'
        };
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                $('#notes-modal-body').html(data);
                $("#show_notes #reference_id").val(reference_id);
                $("#show_notes #order_id").val(reference_id);
                $("#reference").val(reference);
                $("#related_table_id").val(1);
                $.ajax({
                    url: '<?= base_url(); ?>services/home/add_model_note',
                    type: 'POST',
                    data: {
                        required: "n",
                        reference: reference,
                        reference_id: reference_id,
                        multiple: "y"
                    },
                    success: function (data) {
                        $('#add_note_div').html(data);
                        openModal('show_notes');
                    }
                });
            },
            dataType: 'html'
        });
    }
    function show_attachments(reference, reference_id,order_id) {
        var url = '<?= base_url(); ?>services/home/getAttacments';
        var data = {
            reference: reference,
            reference_id: reference_id,
            order_id:order_id
        };
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                // alert(data);return false;
                $('#modal-body-attachments').html(data);
                openModal('modal_area_attach');
            },
            dataType: 'html'
        });

    }
    function show_notes(reference, reference_id, service_id, row_inner_id, order_id) {
        // alert(order_id);return false;
        if (reference == 'payrollemp') {
            var url = '<?= base_url(); ?>services/home/getNotesContentPayrollform';
            var data = {reference: reference, reference_id: reference_id};
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (data) {
                    //alert(data);
                    $('#notes-modal-body').html(data);
                    $("#show_notes #reference_id").val(reference_id);
                    $("#show_notes #serviceid").val(service_id);
                    $("#show_notes #order_id").val(order_id);
                    $("#reference").val(reference);
                    $("#related_table_id").val(4);
                    $.ajax({
                        url: '<?= base_url(); ?>services/home/add_model_note',
                        type: 'POST',
                        data: {
                            required: "n",
                            reference: reference,
                            reference_id: reference_id,
                            multiple: "y"
                        },
                        success: function (data) {
                            $('#add_note_div').html(data);
                            openModal('show_notes');
                        }
                    });
                    openModal('show_notes');
                },
                dataType: 'html'
            });
        } else if (reference == 'payrollrt6') {
            var url = '<?= base_url(); ?>services/home/getNotesContentPayrollform';
            var data = {reference: reference, reference_id: reference_id};
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (data) {
                    //alert(data);
                    $('#notes-modal-body').html(data);
                    $("#show_notes #reference_id").val(reference_id);
                    $("#show_notes #serviceid").val(service_id);
                    $("#show_notes #order_id").val(order_id);
                    $("#reference").val(reference);
                    $("#related_table_id").val(5);
                    $.ajax({
                        url: '<?= base_url(); ?>services/home/add_model_note',
                        type: 'POST',
                        data: {
                            required: "n",
                            reference: reference,
                            reference_id: reference_id,
                            multiple: "y"
                        },
                        success: function (data) {
                            $('#add_note_div').html(data);
                            openModal('show_notes');
                        }
                    });
                    openModal('show_notes');
                },
                dataType: 'html'
            });
        } else {
            var url = '<?= base_url(); ?>services/home/getNotesContent';
            var data = {reference: reference, reference_id: reference_id, loc: 'inner', service_id: service_id};
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (data) {
                    // alert(data);
                    $('#notes-modal-body').html(data);
                    $("#show_notes #reference_id").val(reference_id);
                    $("#show_notes #serviceid").val(service_id);
                    $("#show_notes #order_id").val(order_id);
                    $("#reference").val(reference);
                    $("#related_table_id").val(1);
                    $.ajax({
                        url: '<?= base_url(); ?>services/home/add_model_note',
                        type: 'POST',
                        data: {
                            required: "n",
                            reference: reference,
                            reference_id: reference_id,
                            multiple: "y"
                        },
                        success: function (data) {
                            $('#add_note_div').html(data);
                            openModal('show_notes');
                        }
                    });
                    openModal('show_notes');
                },
                dataType: 'html'
            });
        }
    }
    function change_status_inner(id, status, section_id) {
        openModal('changeStatusinner');
        var txt = 'Change Status of SubOrder id #' + id;
        $("#changeStatusinner .modal-title").html(txt);
        if (status == 0) {
            $("#changeStatusinner #rad0").prop('checked', true);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad7").prop('checked', false);
        } else if (status == 1) {
            $("#changeStatusinner #rad1").prop('checked', true);
            $("#changeStatusinner #rad0").prop('checked', false);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad7").prop('checked', false);
        } else if (status == 2) {
            $("#changeStatusinner #rad2").prop('checked', true);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false);
            $("#changeStatusinner #rad7").prop('checked', false);
        } else if (status == 7) {
            $("#changeStatusinner #rad7").prop('checked', true);
            $("#changeStatusinner #rad2").prop('checked', false);
            $("#changeStatusinner #rad1").prop('checked', false);
            $("#changeStatusinner #rad0").prop('checked', false);
        }
        $("#changeStatusinner #sos_read_status").val(($("a.service-sos-count-" + id).html() == '<i class="fa fa-bell"></i>') ? 'not_cleared' : 'cleared');
        $("#changeStatusinner #input_form_status").val($("input.input-form-status-" + id).val());
        $.get($('#baseurl').val() + "services/home/get_tracking_log/" + section_id + "/service_request", function (data) {
            $("#status_log > tbody > tr").remove();
            var returnedData = JSON.parse(data);
            for (var i = 0, l = returnedData.length; i < l; i++) {
                $('#status_log > tbody:last-child').append("<tr><td>" + returnedData[i]["stuff_id"] + "</td>" + "<td>" + returnedData[i]["department"] + "</td>" + "<td>" + returnedData[i]["status"] + "</td>" + "<td>" + returnedData[i]["created_time"] + "</td></tr>");
            }
            if (returnedData.length >= 1)
                $("#log_modal").show();
            else
                $("#log_modal").hide();
        });
        $("#changeStatusinner #suborderid").val(id);
    }
    function openModal(id) {
        $('#' + id).modal({
            backdrop: 'static',
            keyboard: false
        });
    }
    $(document).ready(function () {
        $(".chosen-select").chosen();
        $(".filter-button").click(function () {
            var id = $(this).attr('id');
            var sp = id.split("-");
            var status = sp[2];
            var requestType = sp[1];
            var requestTypeName = '';
            var requestBy = $('.staff-dropdown option:selected').val();
            var filterval = '';
            if (requestType == 'byme') {
                requestTypeName = 'By ME';
            } else if (requestType == 'tome') {
                requestTypeName = 'To ME';
            } else if (requestType == 'byothers') {
                requestTypeName = 'By Others';
            }
            if (status == 0) {
                filterval = 'Completed';
            } else if (status == 1) {
                filterval = 'Started';
            } else if (status == 2) {
                filterval = 'Not Started';
            } else if (status == 3) {
                filterval = 'Late';
            }
            var hiddenflag = requestType + '-' + status;
            var categoryID = $('.category-dropdown option:selected').val();
            var departmentID = $('.dept-dropdown option:selected').val();
            var officeID = $('.office-dropdown option:selected').val();
            var staffType = $('.stafftype-dropdown option:selected').val();
            var sort = $('.sort-dropdown option:selected').val();
            $.ajax({
                type: "POST",
                data: {
                    status: status,
                    request_type: requestType,
                    category_id: categoryID,
                    request_by: requestBy,
                    department_id: departmentID,
                    office_id: officeID,
                    staff_type: staffType,
                    sort: sort
                },
                url: '<?= base_url(); ?>' + 'services/home/service_dashboard_filter',
                dataType: "html",
                success: function (result) {
                    //alert(result);
                    $(".ajaxdiv").html(result);
                    if(requestType != 'unassigned') {
                        $(".filter-text").addClass('btn btn-ghost');
                        $(".filter-text").html('<span class="byclass ' + requestType + '">Requested ' + requestTypeName + ' <a href="javascript:void(0);" onclick="removefilter(\'' + requestTypeName + '\',' + status + ')"><i class="fa fa-times" aria-hidden="true"></i></a></span>');
                    }                    
                    $(".status-dropdown").val(status);
                    $("#hiddenflag").val(hiddenflag);
                    if ((status + requestType) == '') {
                        clearFilter();
                    } else {
                        if(requestType != 'unassigned') {
                            reflactFilterWithSummery(status + '-' + filterval, requestType + '-' + requestTypeName);
                        }
                    }
                },
                beforeSend: function () {
                    openLoading();
                },
                complete: function (msg) {
                    closeLoading();
                }
            });
        });
    });
    function updateStatusinner() {
        var statusval = $('#changeStatusinner input:radio[name=radio]:checked').val();
        var suborderid = $('#changeStatusinner #suborderid').val();
        var base_url = $('#baseurl').val();
        $.ajax({
            type: "POST",
            data: {
                statusval: statusval,
                suborderid: suborderid,
                input_form_status: $('#changeStatusinner #input_form_status').val(),
                sos_read_status: $('#changeStatusinner #sos_read_status').val()
            },
            url: base_url + 'services/home/update_suborder_status',
            dataType: "html",
            success: function (result) {
                if (result.trim() == 'error_on_input_form') {
                    swal("Can not change status!", "Please complete input form first...!", "error");
                } else if (result.trim() == 'error_on_sos_read_status') {
                    swal("Can not change status!", "Please clear SOS notification first...!", "error");
                } else {
                    var res = JSON.parse(result.trim());
                    if (res.sub_order_status == 0) {
                        var tracking = 'Completed';
                        var trk_inner_class = 'label-primary';
                    } else if (res.sub_order_status == 1) {
                        var tracking = 'Started';
                        var trk_inner_class = 'label-yellow';
                    } else if (res.sub_order_status == 2) {
                        var tracking = 'Not Started';
                        var trk_inner_class = 'label-success';
                    } else if (res.sub_order_status == 7) {
                        var tracking = 'Canceled';
                        var trk_inner_class = 'label-danger';
                    }

                    if (res.main_order_status == 0) {
                        var tracking_main = 'Completed';
                        var trk_class_main = 'label-primary';
                    } else if (res.main_order_status == 1) {
                        var tracking_main = 'Started';
                        var trk_class_main = 'label-yellow';
                    } else if (res.main_order_status == 2) {
                        var tracking_main = 'Not Started';
                        var trk_class_main = 'label-success';
                    } else if (res.main_order_status == 7) {
                        var tracking_main = 'Canceled';
                        var trk_class_main = 'label-danger';
                    }

                    $("#trackinginner-" + res.sub_order_id).removeAttr('onclick');
                    $("#trackinginner-" + res.sub_order_id).attr('onclick', 'change_status_inner(' + res.sub_order_id + ',' + res.sub_order_status + ',' + res.sub_order_id + ')');
                    $("#trackinginner-" + res.sub_order_id).html("<span class='label " + trk_inner_class + " label-block' style='width: 80px;'>" + tracking + "</span>");
                    $("#trackingmain-" + res.main_order_id).html('<span class="label ' + trk_class_main + ' label-block" style="width: 80px; display: inline-block; text-align: center;">' + tracking_main + '</span>');
                    $("#changeStatusinner").modal('hide');
                }
            },
            beforeSend: function () {
                $("#save-tracking").prop('disabled', true).html('Processing...');
                openLoading();
            },
            complete: function (msg) {
                $("#save-tracking").removeAttr('disabled').html('Save changes');
                closeLoading();
            }
        });
    }
    function removefilter(flag, flagval) {
        var categoryID = $('.category-dropdown option:selected').val();
        var status = $('.status-dropdown option:selected').val();
        var requestBy = $('.staff-dropdown option:selected').val();
        var departmentID = $('.dept-dropdown option:selected').val();
        var officeID = $('.office-dropdown option:selected').val();
        var staffType = $('.stafftype-dropdown option:selected').val();
        var sort = $('.sort-dropdown option:selected').val();
        if ($('.filter-text').children().length <= 1) {
            var requestType = '';
        } else {
            if (flag == 'by') {
                requestType = '';
            } else {
                requestType = flagval;
            }
        }
        $.ajax({
            type: "POST",
            data: {
                status: status,
                request_type: requestType,
                category_id: categoryID,
                request_by: requestBy,
                department_id: departmentID,
                office_id: officeID,
                staff_type: staffType,
                sort: sort
            },
            url: '<?= base_url(); ?>' + 'services/home/service_dashboard_filter',
            dataType: "html",
            success: function (result) {
                //alert(result);
                $(".ajaxdiv").html(result);
                if (flag == 'by') {
                    $(".byclass").remove();
                } else {
                    $(".statusclass").remove();
                }
                if ($('.filter-text').children().length <= 0) {
                    $(".filter-text").removeClass('btn btn-ghost');
                    $("#hiddenflag").val('');
                }
                $(".filter-text").html('').removeClass('btn btn-ghost');
            }
        });
    }
    function add_new_filter_row() {
        var random = Math.floor((Math.random() * 999) + 1);
        var clone = '<div class="filter-div row m-b-10" id="clone-' + random + '">' + content + '<div class="col-md-1"><a href="javascript:void(0);" onclick="remove_new_filter_row(' + random + ')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i></a></div></div>';
        $('.filter-inner').append(clone);
        $.each(variable_dd_array, function (key, value) {
            $("#clone-" + random + " .variable-dropdown option[value='" + value + "']").remove();
        });
        $("div.add_filter_div:not(:first)").remove();
    }

    function remove_new_filter_row(random) {
        var divid = 'clone-' + random;
        var variable_dropdown_val = $("#clone-" + random + " .variable-dropdown option:selected").val();
        var index = variable_dd_array.indexOf(variable_dropdown_val);
        variable_dd_array.splice(index, 1);
        $("#" + divid).remove();
    }

    function change_condition_dd(element) {
        var divid = $(element).parent().parent().attr('id');
        //alert(divid);
        var val = $(element).children("option:selected").val();

        var variable_ddval = $(element).parent().parent().find(".variable-dropdown option:selected").val();

        if (variable_ddval == 6 || variable_ddval == 7 || variable_ddval == 11 || variable_ddval == 12 || variable_ddval == 13) {
            if (val == 2 || val == 4) {
                $.ajax({
                    type: "POST",
                    data: {val: val, variable_ddval: variable_ddval},
                    url: '<?= base_url(); ?>' + 'services/home/get_filter_dropdown_options_multiple_dateval',
                    dataType: "html",
                    success: function (result) {
                        $("#" + divid).find('.criteria-div').html(result);
                    },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    data: {
                        val: variable_ddval
                    },
                    url: '<?= base_url(); ?>' + 'services/home/get_filter_dropdown_options',
                    dataType: "html",
                    success: function (result) {
                        $("#" + divid).find('.criteria-div').html(result);
                    },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                });
            }
        } else {
            if (val == 2 || val == 4) {
                $("#" + divid).find(".criteria-dropdown").chosen("destroy");
                $("#" + divid).find(".criteria-dropdown").attr("multiple", "");
                $("#" + divid).find(".criteria-dropdown").chosen();
                $("#" + divid).find(".search-choice-close").trigger('click');
            } else {
                $("#" + divid).find(".criteria-dropdown").removeAttr('multiple');
                $("#" + divid).find(".criteria-dropdown").chosen("destroy");
                $("#" + divid).find(".criteria-dropdown").val('');
                $("#" + divid).find(".criteria-dropdown").chosen();
                $("#" + divid).find(".search-choice-close").trigger('click');
            }
        }
    }
    function change_variable_dd(element) {
        var divid = $(element).parent().parent().attr('id');
        //alert(divid);
        var val = $(element).children("option:selected").val();
        var check_element = element_array.includes(element);
        if (check_element == true) {
            variable_dd_array.pop();
            variable_dd_array.push(val);
        } else {
            element_array.push(element);
            variable_dd_array.push(val);
        }
        if (val == 5) {
            var check_ofc_val = variable_dd_array.includes('3');
            if (check_ofc_val == true) {
                var ofc_val = $("select[name='criteria_dropdown[office][]']").val();
            } else {
                var ofc_val = '';
            }
        } else {
            var ofc_val = '';
        }
        $.ajax({
            type: "POST",
            data: {
                val: val,
                ofc_val: ofc_val
            },
            url: '<?= base_url(); ?>' + 'services/home/get_filter_dropdown_options',
            dataType: "html",
            success: function (result) {
                $("#" + divid).find('.criteria-div').html(result);
                $("#" + divid).find('.condition-dropdown').removeAttr('disabled').val('');
                if (val == 15) {
                    $("#" + divid).find('.condition-dropdown option:not(:eq(0),:eq(1))').remove();
                } else {
                    $("#" + divid).find('.condition-dropdown').html('<option value="">All Condition</option><option value="1">Is</option><option value="2">Is in the list</option><option value="3">Is not</option><option value="4">Is not in the list</option>');
                }
                $(".chosen-select").chosen();
                $("#" + divid).nextAll(".filter-div").each(function () {
                    $(this).find('.remove-filter-button').trigger('click');
                });
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    }
    var reflactFilterWithSummery = function (status, requestType) {
        clearFilter();
        $("select.variable-dropdown:first").val(4);
        var statusArray = status.split('-');
        $('select.criteria-dropdown:first').empty().html('<option value="' + statusArray[0] + '">' + statusArray[1] + '</option>').attr({'readonly': true, 'name': 'criteria_dropdown[tracking][]'});
        $("select.criteria-dropdown:first").trigger("chosen:updated");
        $("select.condition-dropdown:first").val(1).attr('disabled', true);
        element_array.push($("select.condition-dropdown:first"));
        variable_dd_array.push(4);
        add_new_filter_row();
        $("select.variable-dropdown:eq(1)").val(15);
        var requestTypeArray = requestType.split('-');
        $('select.criteria-dropdown:eq(1)').empty().html('<option value="' + requestTypeArray[0] + '">' + requestTypeArray[1] + '</option>').attr({'readonly': true, 'name': 'criteria_dropdown[request_type][]'});
        $("select.criteria-dropdown:eq(1)").trigger("chosen:updated");
        $("select.condition-dropdown:eq(1)").val(1).attr('disabled', true);
        element_array.push($("select.condition-dropdown:eq(1)"));
        variable_dd_array.push(15);
    }
</script>