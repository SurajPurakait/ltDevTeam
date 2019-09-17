<?php
$staff_info = staff_info();
$staff_id = sess('user_id');
$staff_dept = $staff_info['department'];
$stafftype = $staff_info['type'];
$staffrole = $staff_info['role'];
$staff_department = explode(',', $staff_info['department']);
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h1><br>Sales Tax Processing</h1>
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" onclick="window.location.href = '<?= base_url("/action/home/add_sales_tax") ?>';"><i class="fa fa-plus"></i>  Add Sales Tax Processing </button>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-aqua table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <th class="text-center">New</th>
                                            <th class="text-center">Started</th>
                                            <th class="text-center">Completed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Requested By Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-leads-0">
                                                    <span class="label label-warning" id="requested_by_me_new" onclick="load_business_dashboard('', '', 1, 0);">0</span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-leads-1">
                                                    <span class="label label-warning" id="requested_by_me_started" onclick="load_business_dashboard('', '', 1, 1);">0</span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-leads-3">
                                                    <span class="label label-warning" id="requested_by_me_completed" onclick="load_business_dashboard('', '', 1, 2);">0</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php if ($stafftype == 1 || ($stafftype == 2 && (in_array(6, $staff_department) || in_array(8, $staff_department))) || ($stafftype == 3 && $staffrole == 2)) { ?>
                                            <tr>
                                                <th>Requested By Others</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-ref-0">
                                                        <span class="label label-warning" id="requested_by_others_new" onclick="load_business_dashboard('', '', 2, 0);">0</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-ref-1">
                                                        <span class="label label-warning" id="requested_by_others_started" onclick="load_business_dashboard('', '', 2, 1);">0</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-ref-3">
                                                        <span class="label label-warning" id="requested_by_others_completed" onclick="load_business_dashboard('', '', 2, 2);">0</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-inline">
                        <label class="control-label">Filter : </label>&nbsp;
                        <select name="client" id="client" class="form-control">
                            <option value="">Client Name</option>   
                            <?php foreach ($client as $ci) { ?>
                                <option value="<?= $ci['reference_id']; ?>"><?= $ci['name']; ?></option>
                            <?php } ?>
                        </select> &nbsp;
                        <select name="added_by" id="added_by" class="form-control">
                            <option value="">Added By</option>   
                            <?php foreach ($staff_office as $so) { ?>
                                <option value="<?php echo $so['id']; ?>"><?php echo $so['name']; ?></option>
                            <?php } ?>
                        </select> &nbsp;
                        <label id="clear_filter_val" class="filter-text btn btn-ghost" style="display: none;"><span></span>
                            <a href="javascript:void(0);" onclick="load_business_dashboard('', '', '', '3');"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </label>
                    </div>
                    <div class="ajaxdiv-staff" id="load_data">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal_area" class="modal fade" aria-hidden="true" style="display: none;"></div>

<!-- Modal -->
<div class="modal fade" id="showNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" action="<?php echo base_url(); ?>action/home/updateSalesTaxProcessNotes">
                <div id="notes-modal-body" class="modal-body no-padding">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function () {
        load_business_dashboard('', '', '', '3');
        load_business_dashboard_count(1, 0);
        load_business_dashboard_count(1, 1);
        load_business_dashboard_count(1, 2);
        load_business_dashboard_count(2, 0);
        load_business_dashboard_count(2, 1);
        load_business_dashboard_count(2, 2);
//
//        $("#ofc").change(function () {
//            var ofc = $("#ofc option:selected").val();
//            load_business_dashboard(ofc);
//        });
        $("#client").change(function () {
            var cl = $("#client option:selected").val();
            var ab = $("#added_by option:selected").val();
            var req = $("#requested_by option:selected").val();
            load_business_dashboard(cl, ab, req, '3');
        });
        $("#added_by").change(function () {
            var cl = $("#client option:selected").val();
            var ab = $("#added_by option:selected").val();
            var req = $("#requested_by option:selected").val();
            load_business_dashboard(cl, ab, req, '3');
        });

    });

    function show_salestax_process_notes(reference, reference_id) {
        $.ajax({
            type: 'POST',
            url: base_url + 'modal/show_salestax_process_notes',
            data: {
                reference: reference,
                reference_id: reference_id
            },
            success: function (result) {
                $('#showNotes #notes-modal-body').html(result);
                openModal('showNotes');
            }
        });
    }
    function client_name() {
//        alert('hi');
        var client_id = document.getElementById('client').value;
//        alert(client_id);exit;
        $.ajax({
//            alert('hi');
            type: "POST",
            url: base_url + 'action/home/ajax_client_type',
            data: {
                client_id: client_id
            }, success: function (data) {
                $("#load_data").html(data);

            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    }
    function added_by() {
        var added_by_id = document.getElementById('added_by').value;
        $.ajax({
            type: "POST",
            url: base_url + 'action/home/ajax_added_by',
            data: {
                added_by_id: added_by_id
            }, success: function (data) {
                $("#load_data").html(data);

            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    }

    function load_business_dashboard(clienttype, added_by, req_by, status) {
        if (req_by == 1) {
            var rval = 'Requested By Me';
        } else if (req_by == 2) {
            var rval = 'Requested By Others';
        }
        if (status == 0) {
            var sval = 'New';
        } else if (status == 1) {
            var sval = 'Started';
        } else if (status == 2) {
            var sval = 'Completed';
        }
        $.ajax({
            type: "POST",
            url: base_url + 'action/home/load_sale_tax_data',
            data: {
                clienttype: clienttype,
                added_by: added_by,
                req_by: req_by,
                status: status
            },
            success: function (data) {
                $("#load_data").html(data);
                if (status == 1 || status == 0 || status == 2) {
                    $("#clear_filter_val").show();
                    $("#clear_filter_val span").html('');
                    $("#clear_filter_val span").html(rval + ' ' + sval);
                } else {
                    $("#clear_filter_val span").html('');
                    $("#clear_filter_val").hide();
                }
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    }

    function load_business_dashboard_count(req_by, status) {
        $.ajax({
            type: "POST",
            url: base_url + 'action/home/load_sale_tax_data_count',
            data: {
                req_by: req_by,
                status: status
            },
            success: function (data) {
                if (req_by == 1) {
                    var rval = 'requested_by_me';
                } else if (req_by == 2) {
                    var rval = 'requested_by_others';
                }
                if (status == 0) {
                    var sval = 'new';
                } else if (status == 1) {
                    var sval = 'started';
                } else if (status == 2) {
                    var sval = 'completed';
                }
                var idval = rval + '_' + sval;
                //alert(data);
                $("#" + idval).html(data.trim());
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    }
</script>