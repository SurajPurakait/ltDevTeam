<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                   <form class="form-horizontal" method="post" id="event_modal_form_submit" onsubmit="return false;">
                    <h3>Edit New Event</h3>
    
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Office</label>
                        <div class="col-lg-10">
                            <select class="form-control" name="office_id" id="office_id" title="Office" required="">
                                <!-- <option value="">Select Office</option> -->
                                <?php load_ddl_option("staff_office_list", $eventdetails['office_id'], (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
                            </select>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Event Type</label>
                        <div class="col-lg-10">
                           
                            <select class="form-control" name="event_type" id="event_type" title="Event Type" required="">

                                <option  <?= ($eventdetails['event_type'] == "Conference") ? "selected" : ""; ?> value="Conference">Conference</option>

                                <option <?= ($eventdetails['event_type'] == "Expo") ? "selected" : ""; ?> value="Expo">Expo</option>

                                <option  <?= ($eventdetails['event_type'] == "Meeting") ? "selected" : ""; ?> value="Meeting">Meeting</option>

                                <option <?= ($eventdetails['event_type'] == "Networking") ? "selected" : ""; ?> value="Networking">Networking</option>

                                <option <?= ($eventdetails['event_type'] == "Party") ? "selected" : ""; ?> value="Party">Party</option>

                                <option <?= ($eventdetails['event_type'] == "Trade Show") ? "selected" : ""; ?> value="Trade Show">Trade Show</option>

                                <option <?= ($eventdetails['event_type'] == "Seminar") ? "selected" : ""; ?> value="Seminar">Seminar</option>

                                <option <?= ($eventdetails['event_type'] == "Other") ? "selected" : ""; ?> value="Other">Other</option>

                            </select>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Event Name</label>
                        <div class="col-lg-10">
                            <input placeholder="" required class="form-control" nameval="" type="text" id="event_name" name="event_name" title="Event Name" value="<?=$eventdetails['event_name'];  ?>">
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Description</label>
                        <div class="col-lg-10">
                        <textarea class="form-control" id="description" name="description" title="Description"><?= $eventdetails['description']; ?></textarea>
                            
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Date</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" required title="Event Date" id="event_date" name="event_date" value="<?= date("m/d/Y", strtotime($eventdetails['event_date']));  ?>">
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Location</label>
                        <div class="col-lg-10">
                            <input placeholder="" class="form-control" type="text" id="location" name="location" title="Location" value="<?= $eventdetails['location'];  ?>">
                           
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    
                    <div class="form-group">
                        <label class="col-lg-2 control-label">
                        <h3>Lead Information</h3></label>
                        <label class="col-lg-10 control-label"><a href="javascript:void(0);" class="contactadd" onclick="add_leads_modal()"><h3 class="text-left">( Add Leads )</h3></a></label>
                    </div> 

                    <div class="form-group">
                        <div class="m-l-10" id="leads_information">
                        </div>
                    </div>

                    <div class="form-group" id="lead_id"></div>

                    <div class="form-group" id="lead_id">
                        <!-- <label class="col-lg-2 control-label">Leads info </label> -->
                        <div class="col-lg-10">
                            <?php foreach ($lead_list_details as $lead): ?>

                            <div id="lead_info_div_<?= $lead["id"] ?>" class="row">
                                <div class="col-lg-10 col-lg-offset-2" style="padding-top:8px">
                                    <p>
                                        <b></b><?= $lead["last_name"]." ," .$lead["first_name"] ?><br>
                                        
                                        <b>Email:</b> <?= $lead["email"]; ?><br>
                                        <b>Phone:</b> <?= $lead["phone1"]; ?><br>
                                        <b>Company:</b> <?= $lead["company_name"]; ?><br>
                                    
                                       <!--  <input type="hidden" name="event_id" value="<?//= $lead["id"]; ?>"> -->
                                    </p>

                                    <p>
                                        <i class="fa fa-edit contactedit" style="cursor:pointer"
                                           onclick="add_leads_modal('edit', '<?= $lead["id"]; ?>')"
                                           title="Edit this addlead info"></i>
                                       
                                    </p>
                                </div>
                            </div>

                            <?php endforeach; ?>
                            <?php if (count($lead_list_details) == 0) { ?>
                                <input type="hidden" name="addlead_info" id="addlead_info" value="" required title="lead Info">
                            <?php } else { ?>
                                <input type="hidden" name="addlead_info" value="<?php echo count($lead_list_details); ?>" required="" id="addlead_info" title="lead Info">
                            <?php } ?>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="id" id="dept_id" value="<?php echo $eventdetails['id']; ?>">
                                <button class="btn btn-success" type="button" id="eventupdate"  onclick="update_event(<?php echo $eventdetails['id']; ?>)">Save Changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Add leads modal div -->
<div id="addlead-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>
<!-- End of add leads modal -->

<script type="text/javascript">
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
 </script>

