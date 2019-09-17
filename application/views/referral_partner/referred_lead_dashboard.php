<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h1><br>Dashboard Referred Leads</h1></div>
                        <div class="col-md-6">
                            <div class="bg-aqua table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <th>New</th>                                            
                                            <th>Active</th>
                                            <th>Inactive</th>
                                            <th>Completed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $staffinfo = staff_info();
                                            //if($staffinfo['type']!=3){
                                         ?>
                                        <tr>
                                            <th>Referred To Me</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byothers-0">
                                                    <span class="label label-warning" id="requested_by_others_new" onclick="load_referred_leads_dashboard(0);"><?php echo load_referred_leads_count(0); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byothers-3">
                                                    <span class="label label-warning" id="requested_by_others_active" onclick="load_referred_leads_dashboard(3);"><?php echo load_referred_leads_count(3); ?></span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byothers-2">
                                                    <span class="label label-warning" id="requested_by_others_inactive" onclick="load_referred_leads_dashboard(2);"><?php echo load_referred_leads_count(2); ?></span>
                                                </a>
                                            </td>
                                            
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byothers-1">
                                                    <span class="label label-warning" id="requested_by_others_completed" onclick="load_referred_leads_dashboard(1);"><?php echo load_referred_leads_count(1); ?></span>
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
                        <a href="javascript:void(0);" onclick="load_referred_leads_dashboard(7);"><i class="fa fa-times" aria-hidden="true"></i></a>
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
        load_referred_leads_dashboard(7);
        // $('.add-referreal-note').click(function () {
        //     var textnote = $(this).prev('.note-textarea').html();
        //     var note_label = $(this).parent().parent().find("label").html();
        //     var div_count = Math.floor((Math.random() * 999) + 1);
        //     var newHtml = '<div class="form-group" id="note_div' + div_count + '"> ' +
        //             textnote +
        //             '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove Note</a>' +
        //             '</div>';
        //     $(newHtml).insertAfter($(this).closest('.form-group'));
        // });
    });
 function load_referred_leads_dashboard(status='') {
        $.ajax({
            type: "POST",
            url: base_url + 'referral_partner/referral_partners/load_referred_leads_dashboard',
            data: {status:status},
            success: function (data) {
                $("#load_data").html(data);
                if(status!='' || status==0){
                    if(status==0){
                        var statusval = 'New';
                    }else if(status==1){
                        var statusval = 'Completed';
                    }else if(status==2){
                        var statusval = 'Inactive'; 
                    }else if(status==3){
                        var statusval = 'Active'; 
                    }
                    var typeval = 'Referred To Me' + ' ' + statusval;
                    $("#clear_filter span").html('');
                    if(status!=7){
                        $("#clear_filter span").html(typeval);
                        $("#clear_filter").show();
                    }else{
                        $("#clear_filter span").html('');
                        $("#clear_filter").hide();
                    }                    
                }else{
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