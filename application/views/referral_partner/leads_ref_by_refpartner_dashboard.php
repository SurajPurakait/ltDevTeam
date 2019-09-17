<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h1><br>Leads Referred By Referral Partners</h1>                            
                        </div>
                        <div class="col-md-6">
                            <div class="bg-aqua table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <th class="text-center">New</th>
                                            <th class="text-center">Active</th>
                                            <th class="text-center">Inactive</th>
                                            <th class="text-center">Completed</th>                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Referred To Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-leads-0">
                                                    <span class="label label-warning" id="requested_by_me_new" onclick="load_dashboard(1, 0);"><?= count_leads_ref_by_refpartner(1, 0); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-3">
                                                    <span class="label label-warning" id="requested_by_me_active" onclick="load_dashboard(1, 3);"><?= count_leads_ref_by_refpartner(1, 3); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-2">
                                                    <span class="label label-warning" id="requested_by_me_inactive" onclick="load_dashboard(1, 2);"><?= count_leads_ref_by_refpartner(1, 2); ?></span>
                                                </a>
                                            </td>

                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-1">
                                                    <span class="label label-warning" id="requested_by_me_completed" onclick="load_dashboard(1, 1);"><?= count_leads_ref_by_refpartner(1, 1); ?></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $staffinfo = staff_info();
                                        if ($staffinfo['type'] != 3) {
                                            ?>
                                            <tr>
                                                <th>Referred To Others</th>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byothers-0">
                                                        <span class="label label-warning" id="requested_by_others_new" onclick="load_dashboard(2, 0);"><?= count_leads_ref_by_refpartner(2, 0); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byothers-3">
                                                        <span class="label label-warning" id="requested_by_others_active" onclick="load_dashboard(2, 3);"><?= count_leads_ref_by_refpartner(2, 3); ?></span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byothers-2">
                                                        <span class="label label-warning" id="requested_by_others_inactive" onclick="load_dashboard(2, 2);"><?= count_leads_ref_by_refpartner(2, 2); ?></span>
                                                    </a>
                                                </td>

                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="filter-button" id="filter-byothers-1">
                                                        <span class="label label-warning" id="requested_by_others_completed" onclick="load_dashboard(2, 1);"><?= count_leads_ref_by_refpartner(2, 1); ?></span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        } else {
                                            if ($staffinfo['role'] == 2) {
                                                ?>
                                                <tr>
                                                    <th>Referred To Others</th>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" class="filter-button" id="filter-byothers-0">
                                                            <span class="label label-warning" id="requested_by_others_new" onclick="load_dashboard(2, 0);"><?= count_leads_ref_by_refpartner(2, 0); ?></span>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" class="filter-button" id="filter-byothers-3">
                                                            <span class="label label-warning" id="requested_by_others_active" onclick="load_dashboard(2, 3);"><?= count_leads_ref_by_refpartner(2, 3); ?></span>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" class="filter-button" id="filter-byothers-2">
                                                            <span class="label label-warning" id="requested_by_others_inactive" onclick="load_dashboard(2, 2);"><?= count_leads_ref_by_refpartner(2, 2); ?></span>
                                                        </a>
                                                    </td>

                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" class="filter-button" id="filter-byothers-1">
                                                            <span class="label label-warning" id="requested_by_others_completed" onclick="load_dashboard(2, 1);"><?= count_leads_ref_by_refpartner(2, 1); ?></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>   
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr class="hr-line-dashed m-t-8 m-b-5">
                        <div class="col-md-4">                         
                            <div class="form-group m-t-10">
                                <select name="referred_dropdown" id="referred_dropdown" class="form-control">
                                    <option value="">Select</option>
                                    <option <?= $request_type == 1 ? 'selected="selected"' : ''; ?> value="1">Referred To Me</option>
                                    <option <?= $request_type == 2 ? 'selected="selected"' : ''; ?> value="2">Referred To Others</option>
                                </select>
                            </div>                              
                        </div>
                        <div class="col-md-8 p-l-0">                                                         
                            <div class="form-group m-t-10">
                                <label id="clear_filter" class="filter-text btn btn-ghost" style="display: none;"><span></span>
                                    <a href="javascript:void(0);" onclick="load_dashboard('', '<?= $status; ?>');"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </label>
                            </div>                            
                        </div>                  
                    </div>
                    <hr class="hr-line-dashed m-t-2 m-b-5">
                    <div id="load_data"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal_area" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div class="modal fade" id="showNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" action="<?= base_url(); ?>referral_partner/Referral_partners/update_leads_by_refPartnerNotes">
                <div id="notes-modal-body" class="modal-body p-b-0">

                </div>
                <div class="modal-body p-t-0 text-right">
                    <button type="submit" class="btn btn-primary">Update Note</button>
                </div>
            </form>
            <div class="modal-body">
                <form method="post" action="<?= base_url(); ?>referral_partner/Referral_partners/addNotesmodal_leads_by_refPartner">
                    <div class="modal-body">
                        <h4>Add New Note</h4>
                        <div class="form-group" id="add_note_div">
                            <div class="note-textarea">
                                <textarea class="form-control" name="referral_partner_note[]"  title="Referral Partner Note"></textarea>
                            </div>
                            <a href="javascript:void(0)" class="text-success add-referreal-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                        </div>
                        <input type="hidden" name="refid" id="refid">
                        <input type="hidden" name="related_table_id" id="related_table_id">
                        <input type="hidden" name="reference" id="reference">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Note</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
<?php if ($status == 0 || $status == 3 || $status == 2 || $status == 4) { ?>
            load_dashboard('<?= $request_type; ?>', '<?= $status; ?>', '<?= $lead_type; ?>');
<?php } else { ?>
            load_dashboard('<?= $request_type; ?>', '', '<?= $lead_type; ?>');
<?php } ?>
        $('.add-referreal-note').click(function () {
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"> ' +
                    textnote +
                    '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove Note</a>' +
                    '</div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
        $("#referred_dropdown").change(function () {
            var refval = $("#referred_dropdown option:selected").val();
            load_dashboard(refval, 4);
        });
    });
    function load_dashboard(by, status, leadType) {
        $.ajax({
            type: "POST",
            data: {
                by: by,
                status: status,
                lead_type: leadType
            },
            url: base_url + 'referral_partner/referral_partners/load_lead_ref_by_refpartner_dashboard',
            success: function (data) {
                //alert(data);
                $("#load_data").html(data);
                if (by != '' && (status != '' || status == 0)) {
                    if (status == 0) {
                        var statusval = 'New';
                    } else if (status == 1) {
                        var statusval = 'Completed';
                    } else if (status == 2) {
                        var statusval = 'Inactive';
                    } else if (status == 3) {
                        var statusval = 'Active';
                    }
                    //var typeval = byval + ' ' + statusval;
                    $("#clear_filter span").html('');
                    $("#referred_dropdown").val(by);
                    $("#clear_filter span").html(statusval);
                    $("#clear_filter").show();
                } else if (by == '' && (status == 1 || status == 0 || status == 2 || status == 3)) {
                    if (status == 0) {
                        var statusval = 'New';
                    } else if (status == 1) {
                        var statusval = 'Completed';
                    } else if (status == 2) {
                        var statusval = 'Inactive';
                    } else if (status == 3) {
                        var statusval = 'Active';
                    }
                    //var typeval = byval + ' ' + statusval;
                    $("#clear_filter span").html('');
                    $("#referred_dropdown").val(by);
                    $("#clear_filter span").html(statusval);
                    $("#clear_filter").show();
                } else if (by != '' && status == '') {
                    if (status == 0) {
                        var statusval = 'New';
                    } else if (status == 1) {
                        var statusval = 'Completed';
                    } else if (status == 2) {
                        var statusval = 'Inactive';
                    } else if (status == 3) {
                        var statusval = 'Active';
                    }
                    //var typeval = byval + ' ' + statusval;
                    $("#clear_filter span").html('');
                    $("#referred_dropdown").val(by);
                    $("#clear_filter span").html(statusval);
                    $("#clear_filter").show();
                } else if (by == '' && status == '4') {
                    $("#clear_filter span").html('');
                    $("#referred_dropdown").val('');
                    $("#clear_filter").hide();
                } else {
                    //alert(status);
                    $("#clear_filter span").html('');
                    $("#referred_dropdown").val('');
                    $("#clear_filter").hide();
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
</script>