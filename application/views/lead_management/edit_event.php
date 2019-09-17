<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" method="post" id="edit_event">
                <div class="ibox-content m-b-20">
                    <h3>Add New Event</h3>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-control" name="office_id" id="office_id" onchange="loadStaffDLLValue(this.value, '');" title="Office" required="">
                                <option value="<?= $events_data['office_id'] ;?>">
                                    <?php
                                        $CI =& get_instance();
                                        $CI->load->model('lead_management');
                                        $result= $CI->lead_management->get_office_name_by_id($events_data["office_id"]);
                                        echo $result;
                                    ?>
                                </option>
                                <?php load_ddl_option("staff_office_list", "", (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Event Type<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input placeholder="" required class="form-control" nameval="" type="text" id="event_type" name="event_type" title="Event Type" value="<?= $events_data['event_type']; ?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Event Name<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input placeholder="" required class="form-control" nameval="" type="text" id="event_name" name="event_name" title="Event Name" value="<?= $events_data['event_name'] ;?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Description</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="description" name="description" title="Description"><?= $events_data['description'] ;?></textarea>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group lead-staff-div" style="display: none;">
                        <label class="col-lg-2 control-label">Lead Staff</label>
                        <div class="col-lg-10">
                            <select class="form-control" name="lead_staff" id="lead_staff" title="Lead Staff">
                                <option value="">Select an option</option>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php
                            $date_of_event = date('m/d/Y', strtotime($events_data['event_date']));
                        ?>
                        <label class="col-lg-2 control-label">Date<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" required title="Event Date" id="event_date" name="event_date" value="<?= $date_of_event;?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Location<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input placeholder="" class="form-control" type="text" id="location" name="location" title="Location" value="<?= $events_data['location'] ;?>">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-success" type="button" onclick="edit_event()">Save Changes</button> &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-default" type="button" onclick="cancel_event()">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    loadStaffDLLValue(getIdVal('office_id'), '');
    $(function () {
        $("#event_date").datepicker({
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: 'mm/dd/yyyy',
            autoHide: true
        });
        $("#event_date").attr("onblur", 'checkDate(this);');
    });

    function edit_event(){
        if (!requiredValidation('edit_event')) {
            return false;
        }

        var form_data = new FormData(document.getElementById("edit_event"));

        $.ajax({
            type: "POST",
            data: form_data,
            url: base_url + 'lead_management/event/update_event/<?= $events_data["id"] ?>',
            dataType: "html",
            processData: false,
            contentType: false,
            // enctype: 'multipart/form-data',
            cache: false,
            success: function (result) {
                if(result.trim() == "1"){
                    swal({title: "Success!", text: "Event Successfully Updated!", type: "success"}, function () {
                            goURL(base_url + 'lead_management/event');
                        });
                }else{
                    swal("ERROR!", "Unable To Update Event", "error");
                }
                // if (result.trim() == "1") {
                //     if (from_menu == 'lead') {
                //         swal({title: "Success!", text: "Lead Prospect Successfully Edited!", type: "success"}, function () {
                //             goURL(base_url + 'lead_management/home');
                //         });
                //     } else {
                //         swal({title: "Success!", text: "Lead Prospect Successfully Edited!", type: "success"}, function () {
                //             goURL(base_url + 'referral_partner/referral_partners/referral_partner_dashboard');
                //         });
                //     }

                // } else if (result.trim() == "-1") {
                //     swal("ERROR!", "Unable To Edit Lead Prospect", "error");
                // }
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
