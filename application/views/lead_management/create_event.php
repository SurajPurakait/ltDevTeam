<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" method="post" id="form_add_new_event">
                <div class="ibox-content m-b-20">
                    <h3>Add New Event</h3>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-control" name="office_id" id="office_id" onchange="loadStaffDLLValue(this.value, '');" title="Office" required="">
                                <option value="">Select Office</option>
                                <?php load_ddl_option("staff_office_list", "", (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Event Type<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <!-- <input placeholder="" required class="form-control" nameval="" type="text" id="event_type" name="event_type" title="Event Type"> -->
                            <select class="form-control" name="event_type" id="event_type" title="Event Type" required="">
                                <option value="">Select Event</option>
                                <option value="Conference">Conference</option>
                                <option value="Expo">Expo</option>
                                <option value="Meeting">Meeting</option>
                                <option value="Networking">Networking</option>
                                <option value="Party">Party</option>
                                <option value="Trade Show">Trade Show</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Other">Other</option>

                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Event Name<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input placeholder="" required class="form-control" nameval="" type="text" id="event_name" name="event_name" title="Event Name">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Description</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="description" name="description" title="Description"></textarea>
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
                        <label class="col-lg-2 control-label">Date<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" required title="Event Date" id="event_date" name="event_date">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Location<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input placeholder="" class="form-control" type="text" id="location" name="location" title="Location">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label"><a href="javascript:void(0);" class="contactadd" onclick="add_leads_modal()"><h3>Add Leads</h3></a></label>
                        

                    </div> 
                    <div class="form-group">
                        <div class="col-lg-10" id="leads_information">
                        </div>
                    </div>

                    <div class="form-group" id="lead_id" name="lead_id"></div>   


                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-success" type="button" id="eventadd" onclick="add_event()">Save Changes</button> &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-default" type="button" onclick="cancel_event()">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Add leads modal div -->
<div id="addlead-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>
<!-- End of add leads modal -->

<script>
    loadStaffDLLValue(getIdVal('office_id'), '');
    $(function () {
        // $("#event_date").change(function(){
        //     var a = $("#event_date").val();
        //     alert(a);return false;
        // });
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
</script>
