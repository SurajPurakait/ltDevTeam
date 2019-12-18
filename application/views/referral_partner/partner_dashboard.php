<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="row m-l-2 m-b-10">
                                <a href="<?= base_url(); ?>referral_partner/referral_partners/new_referral_agent?q=partner" class="btn btn-lg btn-primary p-l-20 p-r-20  m-r-10" style="font-size:12px"><i class="fa fa-plus"></i> Add New Partner</a>
                                <a href="<?= base_url(); ?>partners" class="btn btn-lg btn-success p-l-20 p-r-20 m-r-10" style="font-size:12px">Partners Dashboard</a>
                                <a href="<?= base_url(); ?>lead_management/home" class="btn btn-lg btn-warning p-l-20 p-r-20" style="font-size:12px">Leads Dashboard</a>
                            </div>
                            <div class="filter-outer">
                                <form name="filter_form" id="filter-form"  method="post" onsubmit="service_filter_form()">
                                    <div class="form-group filter-inner m-b-5">
                                        <div class="filter-div row" id="original-filter">
                                            <div class="col-md-3 m-t-5">
                                                <select class="form-control variable-dropdown" name="variable_dropdown[]" onchange="change_variable_dd(this)">
                                                    <option value="">All Variable</option>
                                                    <option value="1">Type</option>
                                                    <option value="2">Requested By</option>
                                                    <option value="3">Requested Date</option>
                                                    <option value="4">Partner Name</option>
                                                    <!--<option value="5">Language</option>-->
                                                    <!--<option value="6">Source</option>-->
                                                </select>
                                            </div>
                                            <div class="col-md-4 m-t-5">
                                                <select class="form-control condition-dropdown" name="condition_dropdown[]">
                                                    <option value="">All Condition</option>
                                                    <option value="1">Is</option>
                                                    <option value="3">Is not</option>
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
                                        <div class="col-md-12">
                                            <div class="">
                                                <button class="btn btn-success" type="button" onclick="ref_partner_filter_form()">Apply Filter</button>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label class="filter-text m-t-8"></label>
                                    </div>
                                </div>   
                                <input id="hiddenflag" value="" type="hidden">
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4 col-lg-offset-1 text-center m-t-8">
                            <div class="bg-aqua table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr id="byme">
                                            <th>My Partners</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-byme-0">
                                                    <span class="label label-warning" id="requested_by_me_new" onclick="load_partners_dashboard('','',1); "><?= get_partner_count(1); ?></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php 
                                            $staff_info = staff_info();
                                            if($staff_info['type'] == 1) { 
                                        ?>
                                        <!-- <tr id="tome" class="bg-success"> -->
                                        <tr id="tome" class="action-row-border-top action-row-border-bottom" style="background: #596571;">
                                            <th>Team Partners</th>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="filter-button" id="filter-tome-0">
                                                    <!-- 2 : used for byother -->
                                                    <span class="label label-warning" id="requested_to_me_new" onclick="load_partners_dashboard('','',2);"><?= get_partner_count(2); ?></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php 
                                            } else {
                                        ?>
                                        <tr></tr>
                                        <?php        
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4 col-lg-offset-1 m-t-8">
                            <a class="btn notification-btn" href="javascript:void(0);" title="Partner Notifications">Notifications <span class="label label-danger"><?= get_partner_notifications_count('partner'); ?></span></a>
                        </div>
                    </div>
                    <hr class="hr-line-dashed">
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
                <div id="notes-modal-body" class="modal-body no-padding"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="setpwd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">     
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Create Password</h4>                
            </div>

            <form name="setpwd-form" method="POST" action="<?php echo base_url(); ?>referral_partner/Referral_partners/set_password">
                <div id="pwd-modal-body" class="modal-body">
                    <div class="form-group">
                        <label>Set Password</label>
                        <input type="password" name="password" id="pwd" placeholder="Enter Password" value="******" class="form-control">
                    </div>
                    <input type="hidden" name="hiddenid" id="hiddenid" value="">
                    <input type="hidden" name="staffrequestedby" id="staffrequestedby" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="assignto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">                
                <h4 class="modal-title" id="myModalLabel">Assign Client</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form name="assignto-form" id="assignto-form" method="POST">
                <div id="pwd-modal-body" class="modal-body">
                    <div class="form-group">
                        <label>Choose Client Type<span class="text-danger">*</span></label>
                        <select class="form-control" onchange="assignContainerAjax(this.value, '');" name="client_type" id="client_type" title="Client Type" required="">
                            <option value="">Select</option> 
                            <option value="1">Business Client</option>
                            <option value="2">Individual</option>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div id="assign_container">

                    </div>
                    <div id="notediv">
                        <div class="form-group">
                            <label>Note</label>
                            <textarea name="refnote" class="form-control"></textarea>
                        </div>
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
</div>


<!-- Modal -->
<div class="modal fade" id="showNotesclient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <div id="notes-modal-body" class="modal-body"></div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url(); ?>referral_partner/Referral_partners/addRefPartnerClientNotes">
                    <div class="form-group" id="add_note_div">
                        <label>Add Note</label>
                        <div class="note-textarea">
                            <textarea class="form-control" name="referral_partner_note[]"  title="Referral Partner Note"></textarea>
                        </div>
                        <a href="javascript:void(0)" class="text-success add-referreal-note"><i class="fa fa-plus"></i> Add Notes</a>
                    </div>
                    <input type="hidden" name="ref_partner_table_id" id="ref_partner_table_id">
                    <button type="submit" class="btn btn-primary">Save Note</button>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    var content = $(".filter-div").html();
    var variable_dd_array = [];
    var element_array = [];
    $(function () {
        load_partners_dashboard('<?= $type; ?>', '<?= $stat; ?>', '<?= ($req_by != '') ? $req_by:''; ?>', '<?= $lead_type; ?>');
        $(".filter-dropdown").change(function () {
            var filterval = $(".filter-dropdown option:selected").val();
            load_partners_dashboard('', '', filterval);
        });
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

    function add_new_filter_row() {
        var random = Math.floor((Math.random() * 999) + 1);
        var clone = '<div class="filter-div row" id="clone-' + random + '">' + content + '<div class="col-md-1"><a href="javascript:void(0);" onclick="remove_new_filter_row(' + random + ')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i></a></div></div>';
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
        
        $.ajax({
            type: "POST",
            data: {
                val: val
            },
            url: '<?= base_url(); ?>' + 'referral_partner/referral_partners/get_filter_dropdown_options',
            dataType: "html",
            success: function (result) {
                $("#" + divid).find('.criteria-div').html(result);
                $(".chosen-select").chosen();
                $("#" + divid).find('.condition-dropdown').val('');
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
</script>
