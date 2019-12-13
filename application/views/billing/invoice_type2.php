<h3>Individual Information</h3>
<input type="hidden" value="0" id="type" name="type">
<div class="form-group">
    <label class="col-lg-2 control-label">Existing Individual<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <?php if($is_recurrence == 'y'){ ?>
        <select class="form-control type_of_individual" name="type_of_individual" id="type_of_individual_ddl" onchange="individualTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>');" title="Type Of Individual" required>
            <option value="0" <?= $client_id != '' ? 'selected="selected"' : ''; ?>>Yes</option>
            <option <?= $client_id == '' ? 'selected="selected"' : ''; ?> value="1">No</option>
        </select>

        <?php }else{ ?>

        <select class="form-control type_of_individual" name="type_of_individual" id="type_of_individual_ddl" onchange="individualTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>');" title="Type Of Individual" required>
            <option value="0" <?= $client_id != '' ? 'selected="selected"' : ''; ?>>Yes</option>
            <option <?= $client_id == '' ? 'selected="selected"' : ''; ?> value="1">No</option>
        </select>
        <?php } ?>

        <div class="errorMessage text-danger"></div>
    </div>
</div>
<div class="form-group client_type_div0">
    <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select class="form-control chosen-select client_type_field0" name="staff_office" id="staff_office" onchange="refresh_existing_individual_list(this.value, '');" title="Office" required="">
            <option value="">Select Office</option>
            <?php load_ddl_option("staff_office_list", $office_id, (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<div id="individual_list" class="client_type_div0">
    <div class="form-group">
        <label class="col-lg-2 control-label">Individual List<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <?php if($is_recurrence == 'y'){ ?>
            <select class="form-control individual_list client_type_field0" name="individual_list[]" id="individual_list_ddl" onchange="fetchExistingIndividualData(this.value, <?= $reference_id; ?>, '<?= $reference; ?>');" title="Individual List" multiple>
                <option value="">Select an option</option>
                <?php //load_ddl_option("existing_individual_list_new"); ?>
            </select>
            <?php }else{ ?>
            <select class="form-control individual_list client_type_field0" name="individual_list" id="individual_list_ddl" onchange="fetchExistingIndividualData(this.value, <?= $reference_id; ?>, '<?= $reference; ?>');" title="Individual List">
                <option value="">Select an option</option>
                <?php //load_ddl_option("existing_individual_list_new"); ?>
            </select>
            <?php } ?>   
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
</div>
<div id="personal_information" class="display_div">
    <div class="form-group">
        <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <input placeholder="" class="form-control value_field required_field" type="text" id="individual_first_name" nameval="" name="first_name" title="First Name" required><div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Middle Name</label>
        <div class="col-lg-10">
            <input placeholder="" class="form-control value_field" type="text" id="individual_middle_name" nameval="" name="middle_name" title="Middle Name"><div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <input placeholder="" class="form-control value_field required_field" type="text" id="individual_last_name" nameval="" name="last_name" title="Last Name" required>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">SSN/ITIN</label>
        <div class="col-lg-10">
            <input placeholder="" class="form-control value_field" type="text" id="individual_ssn_itin" name="ssn_itin" title="SSN/ITIN">
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Date of Birth<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <input placeholder="mm/dd/yyyy" id="individual_dob" class="form-control datepicker_mdy value_field required_field" type="text" required title="Date of Birth" name="birth_date">
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
</div>


<div id="contact_info_div">
    <?php if($is_recurrence != 'y'){ ?>    
    <h3>Contact Info<span class="text-danger">*</span><span class="display_div">&nbsp; (<a href="javascript:void(0);" class="contactadd" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>'); return false;">Add Contact</a>)</span></h3>
    <div id="contact-list">
        <input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">
        <div class="errorMessage text-danger"></div>
    </div>
    <div class="hr-line-dashed"></div>
    <?php } ?>
</div>

<div id="documents_div" class="display_div">
    <h3>Documents &nbsp; (<a data-toggle="modal" class="documentadd" onclick="document_modal('add', '<?= $reference ?>', '<?= $reference_id ?>');" href="javascript:void(0);">Add document</a>)</h3> 
    <div id="document-list"></div>
</div>

<div id="other_info_div" class="display_div">
    <div class="hr-line-dashed"></div>
    <h3>Other Info</h3>
    <div class="form-group">
        <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select class="form-control value_field required_field" name="language" id="individual_language" title="Language" required="">
                <option class="form-control" value="">Select an option</option>
                <?php load_ddl_option("language_list"); ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Country of Residence<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select class="form-control value_field required_field" name="country_residence" id="individual_country_residence" title="Country of Residence" required="">
                <option class="form-control" value="">Select an option</option>
                <?php load_ddl_option("get_countries"); ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Country of Citizenship<span
                class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select class="form-control value_field required_field" name="country_citizenship" id="individual_country_citizenship" title="Country of Citizenship" required="">
                <option class="form-control" value="">Select an option</option>
                <?php load_ddl_option("get_countries"); ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
</div>
<div id="internal_data_div" class="display_div">
    <div class="hr-line-dashed"></div>
    <h3>Internal Data</h3><span class="internal-data"></span>
    <div class="form-group office-internal">
        <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select class="form-control chosen-select value_field required_field" name="office" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office" required="">
                <option value="">Select an option</option>
                <?php load_ddl_option("staff_office_list"); ?>
            </select>
            <div class="errorMessage text-danger"></div>                                    
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Partner<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select name="partner" id="partner" class="form-control value_field required_field" title="Partner" required>
                <option value="">Select an option</option>
            </select>

            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Manager<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select name="manager" class="form-control value_field required_field" id="manager" title="Manager" required>
                <option value="">Select an option</option>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Client Association</label>
        <div class="col-lg-10">
            <input placeholder="" class="form-control value_field" type="text" id="client_association" name="client_association" title="Client Association" value="">
            <div class="errorMessage text-danger"></div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Practice Id</label>
        <div class="col-lg-10">
            <input placeholder="Practice Id" class="form-control" type="text" name="internal_data[practice_id]" id="practice_id" title="Practice Id">
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select class="form-control chosen-select value_field required_field" name="referred_by_source" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required>
                <option value="">Select an option</option>
                <?php load_ddl_option("referer_by_source"); ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label id="referred-label" class="col-lg-2 control-label">Referred By Name</label>
        <div class="col-lg-10">
            <input placeholder="" class="form-control value_field" type="text" id="referred_by_name" name="referred_by_name" title="Referred By Name" value="">
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Existing Practice ID</label>
        <div class="col-lg-10">
            <input placeholder="" class="form-control value_field" type="text" name="existing_practice_id" title="Existing Practice ID" value="">
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
</div>
<div id="service_section_div"></div>
<input type="hidden" id="section_id" value="">
<input type="hidden" name="reference" id="reference" value="<?= $reference; ?>">
<input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
<script>
    <?php if($client_id != ''): ?>
        individualTypeChange(0, <?= $reference_id; ?>, '<?= $reference; ?>');
        refresh_existing_individual_list("<?= $office_id ?>", '<?= $client_id; ?>');
        fetchExistingIndividualData("<?= $title_id ?>", <?= $reference_id; ?>, '<?= $reference; ?>', 1);
        $("#individual_list").show();
        
    <?php else: ?>
        individualTypeChange(1, <?= $reference_id; ?>, '<?= $reference; ?>');
        $("#individual_list").hide();
    <?php endif; ?>    
    addService();
    $('#individual_dob').datepicker({dateFormat: 'mm/dd/yyyy', autoHide: true});
    $('#individual_dob').attr("onblur", 'checkDate(this);');
//    function openModalFunc(type) {
//        var reference = $("#reference").val();
//        var existing_id = $("#existing_individual_id").val();
//        var individual_id = $("#individual_id").val();
//        if (type == 'contact') {
//            contact_modal('add', reference, (existing_id != '') ? existing_id : individual_id);
//        }
//        if (type == 'document') {
//            document_modal('add', reference, (existing_id != '') ? existing_id : individual_id);
//        }
//    }
</script>