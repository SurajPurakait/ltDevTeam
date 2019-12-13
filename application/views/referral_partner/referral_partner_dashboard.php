<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h1><br>Dashboard Partners</h1>
                            <?php $staffinfo = staff_info(); ?>
                            <button title="Create Referral Partner" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" onclick="window.location.href = '<?= base_url("/referral_partner/referral_partners/add_lead/").$staffinfo['office_manager']; ?>';"><i class="fa fa-plus"></i> Refer a Lead to: <?php echo get_assigned_by_staff_name($staffinfo['office_manager']); ?></button>
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
                                            <th>Referred By Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-leads-0">
                                                    <span class="label label-success" id="requested_by_me_new" onclick="load_referral_partners_dashboard(1, 0);"><?php echo load_partner_count(1, 0); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-3">
                                                    <span class="label label-warning" id="requested_by_me_active" onclick="load_referral_partners_dashboard(1, 3);"><?php echo load_partner_count(1, 3); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-2">
                                                    <span class="label label-danger" id="requested_by_me_inactive" onclick="load_referral_partners_dashboard(1, 2);"><?php echo load_partner_count(1, 2); ?></span>
                                                </a>
                                            </td>                                            
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-1">
                                                    <span class="label label-primary" id="requested_by_me_completed" onclick="load_referral_partners_dashboard(1, 1);"><?php echo load_partner_count(1, 1); ?></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $staffinfo = staff_info();
                                            //if($staffinfo['type']!=3){
                                         ?>
                                        <tr>
                                            <th>Referred To Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byothers-0">
                                                    <span class="label label-success" id="requested_by_others_new" onclick="load_referral_partners_dashboard(2, 0);"><?php echo load_partner_count(2, 0); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byothers-3">
                                                    <span class="label label-warning" id="requested_by_others_active" onclick="load_referral_partners_dashboard(2, 3);"><?php echo load_partner_count(2, 3); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byothers-2">
                                                    <span class="label label-danger" id="requested_by_others_inactive" onclick="load_referral_partners_dashboard(2, 2);"><?php echo load_partner_count(2, 2); ?></span>
                                                </a>
                                            </td>
                                            
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byothers-1">
                                                    <span class="label label-primary" id="requested_by_others_completed" onclick="load_referral_partners_dashboard(2, 1);"><?php echo load_partner_count(2, 1); ?></span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php //} ?>
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-line-dashed">
                    <label id="clear_filter" class="filter-text btn btn-ghost" style="display: none;"><span></span>
                        <a href="javascript:void(0);" onclick="load_referral_partners_dashboard();"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </label>
                    <div id="load_data"></div>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" action="<?php echo base_url(); ?>referral_partner/Referral_partners/updateNotes">
                <div id="notes-modal-body" class="modal-body"></div>
                <div class="modal-footer">
                </div>
            </form>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url(); ?>referral_partner/Referral_partners/addNotesmodal_dashboard_partners">
                        <div class="form-group" id="add_note_div">
                                <div class="note-textarea">
                                    <textarea class="form-control" name="referral_partner_note[]"  title="Referral Partner Note"></textarea>
                                </div>
                                <a href="javascript:void(0)" class="text-success add-referreal-note"><i class="fa fa-plus"></i> Add Notes</a>
                        </div>
                    <input type="hidden" name="lead_id" id="lead_id">
                    <button type="submit" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        load_referral_partners_dashboard();
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
    });
 function load_referral_partners_dashboard(type='',status='') {
        $.ajax({
            type: "POST",
            url: base_url + 'referral_partner/referral_partners/load_referral_partners_dashboard',
            data: {type:type,status:status},
            success: function (data) {
                $("#load_data").html(data);
                if(type!='' && (status!='' || status==0)){
                    //alert(status);
                    if(type==1){
                        var byval = 'Referred By Me';
                    }else if(type==2){
                        var byval = 'Referred To Me'; 
                    }
                    if(status==0){
                        var statusval = 'New';
                    }else if(status==1){
                        var statusval = 'Completed';
                    }else if(status==2){
                        var statusval = 'Inactive'; 
                    }else if(status==3){
                        var statusval = 'Active'; 
                    }
                    var typeval = byval + ' ' + statusval;
                    $("#clear_filter span").html('');
                    $("#clear_filter span").html(typeval);
                    $("#clear_filter").show();
                }else{
                    //alert(status);
                    $("#clear_filter span").html('');
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