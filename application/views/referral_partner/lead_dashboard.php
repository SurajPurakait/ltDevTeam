<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h1><br>Dashboard For Lead</h1>
                        </div>
                    </div>
                    <hr>
                    <div class="filters">
                        <div class="dropdown pull-right">
                            <button title="Create Lead" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" onclick="window.location.href = '<?= base_url("/referral_partner/referral_partners/add_lead") ?>';"><i class="fa fa-plus"></i></button>
                        </div>
                    </div><br>
                    <hr class="hr-line-dashed">
                    <label id="clear_filter" class="filter-text btn btn-ghost" style="display: none;"><span></span>
                        <a href="javascript:void(0);" onclick="load_partners_dashboard('main', 'all', 'remove_filter');"><i class="fa fa-times" aria-hidden="true"></i></a>
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
                    <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
                </div>
            </form>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url(); ?>referral_partner/Referral_partners/addNotesmodal_dashboard_for_lead">
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


<!-- Modal -->
<!-- <div class="modal fade" id="assignto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">                
                <h4 class="modal-title" id="myModalLabel">Assign Lead</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

                <form name="assignto-form" id="assignto-form" method="POST">
                <div id="pwd-modal-body" class="modal-body">
                    <div class="form-group">
                        <label>Choose Client Type<span class="text-danger">*</span></label>
                        <select class="form-control" onchange="assignContainerAjax(this.value,'');" name="client_type" id="client_type" title="Client Type" required="">
                                    <option value="">Select</option> 
                                    <option value="1">Business Client</option>
                                    <option value="2">Individual</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                    </div>
                    <div id="assign_container">
                           
                        </div>
                     <input type="hidden" name="hiddenid" id="hiddenid" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="assign_client()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

<script>
    $(function () {
        load_partners_lead_dashboard();
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
 function load_partners_lead_dashboard() {
        $.ajax({
            type: "POST",
            url: base_url + 'referral_partner/referral_partners/load_partners_lead_dashboard',
            success: function (data) {
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
</script>