<h3>Individual Information</h3>
<input type="hidden" value="0" id="type" name="type">
<div class="form-group">
    <label class="col-lg-2 control-label">Existing Individual<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select class="form-control type_of_individual" name="type_of_individual" id="type_of_individual_ddl" onchange="individualTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>');" title="Type Of Individual" required>
            <option value="0" <?= $client_id != '' ? 'selected="selected"' : ''; ?>>Yes</option>
            <option <?= $client_id == '' ? 'selected="selected"' : ''; ?> value="1">No</option>
        </select>
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

            <select class="form-control individual_list client_type_field0" name="individual_list" id="individual_list_ddl" onchange="fetchExistingIndividualData(this.value, <?= $reference_id; ?>, '<?= $reference; ?>');" title="Individual List">
                <option value="">Select an option</option>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
</div>
<div id="personal_information" class="display_div">
    <div class="form-group">
        <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <input placeholder="" class="form-control value_field required_field" type="text" id="individual_first_name" nameval="" name="first_name" title="First Name" required>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Middle Name</label>
        <div class="col-lg-10">
            <input placeholder="" class="form-control value_field" type="text" id="individual_middle_name" nameval="" name="middle_name" title="Middle Name">
            <div class="errorMessage text-danger"></div>
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
        <label class="col-lg-2 control-label">SSN/ITIN<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <input data-mask="999-99-9999" placeholder="___-__-____" class="form-control value_field required_field" type="text" id="individual_ssn_itin" name="ssn_itin" title="SSN/ITIN" required>
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
    <div class="hidden">
        <div class="form-group" style="display:none;">
            <label class="col-lg-2 control-label">Practice Id</label>
            <div class="col-lg-10">
                <input placeholder="Practice Id" class="form-control" type="text" name="internal_data[practice_id]" id="practice_id" title="Practice Id">
                <div class="errorMessage text-danger"></div>
            </div>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
</div>


<div id="contact_info_div">
    <h3>Contact Info<span class="text-danger">*</span><span class="display_div">&nbsp; (<a href="javascript:void(0);" class="contactadd" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>'); return false;">Add Contact</a>)</span></h3>
    <div id="contact-list">
        <input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">
        <div class="errorMessage text-danger"></div>
    </div>
    <div class="hr-line-dashed"></div>
</div>
<input type="hidden" value="<?= $reference; ?>" name="reference" id="reference">
<script>
    individualTypeChange(1, <?= $reference_id; ?>, '<?= $reference; ?>');
    $(function() {
        $("#individual_dob").datepicker({
            autoHide: true,
        });
    });
</script>