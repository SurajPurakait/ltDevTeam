<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="form_title" onsubmit="saveIndividual(); return false;">
                        <!--<h3>Individual Information</h3>-->
                        <input type="hidden" value="0" id="type" name="type">
<!--                        <div class="form-group">
                            <label class="col-lg-2 control-label">Title<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="title" title="Title" id="selecttitle" required="true">
                                    <option value="">Select an option</option>
                                    <option value="MANAGING MEMBER">MANAGING MEMBER</option>
                                    <option value="MEMBER">MEMBER</option>
                                    <option value="PRESIDENT">PRESIDENT</option>
                                    <option value="VICE PRESIDENT">VICE PRESIDENT</option>
                                    <option value="SECRETARY">SECRETARY</option>
                                    <option value="TREASURER">TREASURER</option>
                                    <option value="DIRECTOR">DIRECTOR</option>
                                    <option value="MANAGER">MANAGER</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Percentage/Shares<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Only numbers (%)" id="per_id" class="form-control" type="text" name="percentage" title="Percentage" required value="<?//= !empty($title_val) ? $title_val->percentage : "" ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>-->
                        <h3>Personal Information</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="first_name" nameval="" name="first_name" title="First Name" maxlength="20" required value="<?= !empty($title_val) ? $title_val->first_name : "" ?>"><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Middle Name</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="middle_name" nameval="" name="middle_name" title="Middle Name" maxlength="20" value="<?= !empty($title_val) ? $title_val->middle_name : "" ?>"><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="last_name" nameval="" name="last_name" title="Last Name" maxlength="20" required value="<?= !empty($title_val) ? $title_val->last_name : "" ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">SSN/ITIN<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input data-mask="999-99-9999" placeholder="___-__-____" class="form-control" type="text" id="ssn_itin"  name="ssn_itin" title="SSN/ITIN" required value="<?= !empty($title_val) ? $title_val->ssn_itin : "" ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Date of Birth</label>
                            <div class="col-lg-10">
                                <input placeholder="mm/dd/yyyy" id="dob" class="form-control datepicker_mdy" type="text" onblur="checkDate(this)" title="Date of Birth" name="birth_date">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Contact Info<span class="text-danger">*</span> &nbsp; (<a href="javascript:void(0);" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $individual_id; ?>'); return false;">Add Contact</a>)</h3> 
                        <div id="contact-list">
                            <input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <h3>Documents &nbsp; (<a onclick="document_modal('add', '<?= $reference ?>', '<?= $individual_id; ?>');" href="javascript:void(0);">Add Document</a>)</h3>
                        <div id="document-list"></div>
                        <div class="errorMessage text-danger"></div>


                        <div class="hr-line-dashed"></div>
                        <h3>Other Info</h3>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="language" id="language1" title="Language" required="">
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("language_list", !empty($title_val) ? $title_val->language_id : ""); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Country of Residence<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="country_residence" id="country_residence" title="Country of Residence" required="">
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("get_countries", !empty($title_val) ? $title_val->country_residence_id : ""); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Country of Citizenship<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="country_citizenship" id="country_citizenship" title="Country of Citizenship" required="">
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("get_countries", !empty($title_val) ? $title_val->country_residence_id : ""); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <h3>Internal Data</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="internal_data[office]" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office" required="">
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("staff_office_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Partner<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="internal_data[partner]" id="partner" title="Partner" required>
                                    <option value="">Select an option</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Manager<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="internal_data[manager]" id="manager" title="Manager" required>
                                    <option value="">Select an option</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Client Association</label>
                            <div class="col-lg-10">
                                <input placeholder="Client Association" class="form-control" type="text" name="internal_data[client_association]" id="client_association" title="Client Association">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hidden">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Practice Id</label>
                            <div class="col-lg-10">
                                <input placeholder="Practice Id" class="form-control" type="text" name="internal_data[practice_id]" id="practice_id" title="Practice Id">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="internal_data[referred_by_source]" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("referer_by_source"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="referred-label" class="col-lg-2 control-label">Referred By Name</label>
                            <div class="col-lg-10">
                                <input placeholder="Referred By Name" class="form-control" type="text" id="referred_by_name" name="internal_data[referred_by_name]" title="Referred By Name">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" id="language" name="internal_data[language]" title="Language">
                                    <!--<option value="">Select an option</option>-->
                                    <?php load_ddl_option("language_list"); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div>
                            <?= note_func('Notes', 'n', 1, 'reference_id', $reference_id); ?>
                        </div>
                        <div class="hr-line-dashed"></div>
                         <div class="form-group">
                                <label class="col-lg-2 control-label">Attachments</label>
                                <div class="col-lg-10">
                                    <input placeholder="Attachments" id="attachments" type="file" name="attachments" >
                                    <!--<div class="errorMessage text-danger"></div>-->
                                </div>
                            </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="editval" id="editval" value="add">
                                <input type="hidden" name="company_id" id="company_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="individual_id" id="individual_id" value="<?= $individual_id; ?>">
                                <input type="hidden" name="title_id" id="title_id" value="<?= $title_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="<?= $reference; ?>">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $individual_id; ?>">
                                <input type="hidden" name="action" id="action" value="save_owner">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                                <button class="btn btn-success" type="button" onclick="saveIndividual()">Save</button> &nbsp;
                                <button class="btn btn-default" type="button" onclick="go('action/home/individual_dashboard')">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
    <div id="document-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
    <div class="modal_loading" id="loading_modal"></div>
</div>

<script>
    $('#dob').datepicker({dateFormat: 'mm/dd/yyyy', autoHide: true});
    //get_document_list('<?= $individual_id; ?>', "individual")
    //get_contact_list('<?= $individual_id; ?>', "individual");
    $(function () {
        $("#copy-contact").click(function () {
            var company_id = $(this).attr('value');
            var individual_id = $(this).attr('ref_id');
            $.ajax({
                type: "POST",
                url: '<?= base_url(); ?>services/home/copy_contact',
                data: {
                    company_id: company_id,
                    individual_id: individual_id
                },
                cache: false,
                success: function (data) {
//                    alert(data);return false;
                    if (data.trim() != '') {
                        //$("#copy-contact").hide();
                        get_contact_list(individual_id, "individual");
                    } else {
                        swal("Error", "No Contact Added/Already Exists", "error");
                    }
                }
            });
        });
    });
</script>