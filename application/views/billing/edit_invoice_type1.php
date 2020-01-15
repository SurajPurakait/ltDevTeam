<!-- <pre><?php //print_r($order_summary);         ?></pre> -->
<h3>Business Information</h3><span class="company-data"></span>
<div class="form-group">
    <label class="col-lg-2 control-label">Existing Client<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select disabled="" class="form-control type_of_client disabled_field" name="type_of_client" id="type_of_client_ddl" onchange="clientTypeChange(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);" title="Type Of Client" required>
            <option value="">Select an option</option>
            <option <?= $order_summary['new_existing'] == '0' ? 'selected=\'selected\'' : ''; ?> value="0">Yes</option>
            <option <?= $order_summary['new_existing'] == '1' ? 'selected=\'selected\'' : ''; ?> value="1">No</option>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<?php $staff_office = staff_office_for_invoice($invoice_id); ?>
<div class="form-group client_type_div0">
    <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select disabled="" class="form-control client_type_field0" name="staff_office" id="staff_office" onchange="refresh_existing_client_list(this.value);" title="Office" required="">
            <option value="<?= $order_summary['office_id']; ?>"><?= $order_summary['office']; ?></option>
            <?php // load_ddl_option("staff_office_list", $staff_office, (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<div class="form-group client_type_div0" id="client_list">
    <label class="col-lg-2 control-label">Existing Client List<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select disabled="" class="form-control client_type_field0" name="client_list" id="client_list_ddl" title="Client List" onchange="fetchExistingClientData(this.value, <?= $reference_id; ?>, '<?= $reference; ?>', 1);">
            <option value="<?= $reference_id; ?>"><?= $client_name; ?></option>
            <?php /* foreach ($completed_orders as $data) {
              ?>
              <option <?= $order_summary['existing_reference_id'] == $data['reference_id'] ? 'selected=\'selected\'' : ''; ?> value="<?= $data['reference_id']; ?>"><?= $data['name']; ?></option>
              <?php
              }
             */ ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<div class="errorMessage text-danger"></div>
<div class="form-group client_type_div1" id="name_of_business">
    <label class="col-lg-2 control-label">Name of Company<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <input placeholder="Name of Company" id="business_name" class="form-control client_type_field1" type="text" name="name_of_business1" title="Name of Business" >
        <div class="errorMessage text-danger"></div>
    </div>
</div>

<div class="form-group display_div" id="fein_div">
    <label class="col-lg-2 control-label">Federal ID</label>
    <div class="col-lg-10">
        <input placeholder="xx-xxxxxxx" data-mask="99-9999999" class="form-control value_field" id="fein" type="text" name="fein" value="" title="Federal ID">
        <div class="errorMessage text-danger"></div>
    </div>
</div>

<div class="form-group display_div" id="state_div">
    <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select class="form-control required_field value_field" name="state" id="state" title="State of Incorporation" required="">
            <option value="">Select an option</option>
            <?php load_ddl_option("state_list"); ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>

<div class="form-group display_div" id="type_div">
    <label class="col-lg-2 control-label">Type of Company<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select class="form-control required_field value_field" name="type" id="type" title="Type of Company" required="">
            <option value="">Select an option</option>
            <?php load_ddl_option("company_type_list"); ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>

<div class="form-group display_div" id="start_month_year_div">
    <label class="col-lg-2 control-label">Month & Year to Start</label>
    <div class="col-lg-10">
        <input placeholder="mm/yyyy" id="start_month_year" class="date_my form-control value_field" type="text" title="Month & Year to Start" name="start_year" value="">
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<div class="form-group display_div" id="fiscal_year_end_div">
    <label class="col-lg-2 control-label">Fiscal Year End<span class="text-danger">*</span></label>
    <div class="col-lg-10">
        <select class="form-control required_field value_field" name="fiscal_year_end" id="fye" title="Fiscal year end" required="">
            <option class="form-control" value="">Select an option</option>
            <?php load_ddl_option("fiscal_year_end", 12); ?>
        </select>
        <div class="errorMessage text-danger"></div>
    </div>
</div>

<div class="form-group display_div" id="business_description_div">
    <label class="col-lg-2 control-label">Business Description</label>
    <div class="col-lg-10">
        <textarea class="form-control value_field" name="business_description" id="business_description"  title="Business Description"><?= $order_summary['new_existing'] == '1' ? $order_summary['business_description'] : ""; ?></textarea>
        <div class="errorMessage text-danger"></div>
    </div>
</div>

<?php if($is_recurrence != 'y'){ ?>
<div id="contact_info_div">
    <div class="hr-line-dashed"></div>
    <h3>Contact Info<span class="text-danger">*</span><span class="display_div">&nbsp; (<a href="javascript:void(0);" class="contactadd" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>'); return false;">Add Contact</a>)</span></h3>
    <div id="contact-list">
        <input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">
        <div class="errorMessage text-danger"></div>
    </div>
</div>
<?php } ?>

<div id="owners_div" class="display_div">
    <div class="hr-line-dashed"></div>
    <h3>Owners<span class="text-danger">*</span> &nbsp; (<a href="javascript:void(0);" class="owneradd" onclick="open_owner_popup(1, '<?= $reference_id; ?>', 0); return false;">Add owner</a>)</h3>
    <div id="owners-list">
        <input type="hidden" class="required_field" title="Owners" id="owners-list-count" required="required" value="">
        <div class="errorMessage text-danger"></div>
    </div>
</div>

<div id="internal_data_div" class="display_div">
    <div class="hr-line-dashed"></div>
    <h3>Internal Data</h3><span class="internal-data"></span>
    <div class="form-group office-internal">
        <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select class="form-control required_field value_field" name="office" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office" required="">
                <option value="">Select an option</option>
                <?php load_ddl_option("staff_office_list"); ?>
            </select>
            <div class="errorMessage text-danger"></div>                                    
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Partner<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select name="partner" id="partner" class="form-control required_field value_field" title="Partner" required>
                <option value="">Select an option</option>
            </select>

            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Manager<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select name="manager" class="form-control required_field value_field" id="manager" title="Manager" required>
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
        <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select class="form-control required_field value_field" name="referred_by_source" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required>
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
        <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
        <div class="col-lg-10">
            <select class="form-control required_field value_field" id="language" name="language" title="Language" required="">
                <option value="">Select an option</option>
                <?php load_ddl_option("language_list"); ?>
            </select>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Existing Practice ID</label>
        <div class="col-lg-10">
            <input placeholder="" id="existing_practice_id" class="form-control value_field" type="text" name="existing_practice_id" title="Existing Practice ID" readonly>
            <div class="errorMessage text-danger"></div>
        </div>
    </div>
</div>

<div id="documents_div" class="display_div">
    <div class="hr-line-dashed"></div>
    <h3>Documents &nbsp; (<a data-toggle="modal" class="documentadd" onclick="document_modal('add', '<?= $reference ?>', '<?= $reference_id ?>');" href="javascript:void(0);">Add document</a>)</h3> 
    <div id="document-list"></div>
</div>
<div class="hr-line-dashed"></div>
<div id="service_section_div"></div>
<input type="hidden" name="reference" id="reference" value="company">
<input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
<script>
    clientTypeChange('<?= $order_summary['new_existing']; ?>', '<?= $reference_id; ?>', '<?= $reference; ?>', 1);
    showExistingServices();
    $(function () {
<?php if ($order_summary['new_existing'] == 0): ?>
            fetchExistingClientData('<?= $order_summary['reference_id']; ?>', <?= $reference_id; ?>, '<?= $reference; ?>', 1);
            $('.display_div').hide();
<?php else: ?>
            document.getElementById('state').value = '<?= $order_summary['state_opened']; ?>';
            document.getElementById('type').value = '<?= $order_summary['company_type']; ?>';
            //            document.getElementById('business_description').value = '<?= urlencode($order_summary['business_description']); ?>';
            document.getElementById('fye').value = '<?= $order_summary['fiscal_year_end']; ?>';
            document.getElementById('business_name').value = '<?= $order_summary['name_of_company']; ?>';
            document.getElementById('fein').value = '<?= $order_summary['federal_ID']; ?>';
            document.getElementById('start_month_year').value = '<?= $order_summary['start_month_year']; ?>';
            document.getElementById('existing_practice_id').value = '<?= $order_summary['existing_practice_ID']; ?>';
            get_contact_list('<?= $reference_id; ?>', 'company');
            reload_owner_list('<?= $reference_id; ?>', 'main');
            get_document_list('<?= $reference_id; ?>', 'company');
            getInternalData('<?= $reference_id; ?>', 'company');
<?php endif; ?>
    });
    $('#start_month_year').datepicker({
        format: 'mm/yyyy',
        autoHide: true
    });
    $('#start_month_year').attr("onblur", 'checkDate(this);');
</script>