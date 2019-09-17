<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <?php if($title_val->percentage==''){ ?>
                    <div class="form-group clearfix">
                            <label class="col-lg-2 control-label">Existing Client<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control type_of_client" name="type_of_client" id="type_of_client" title="Type Of Client" onchange="getclientTypeChange(this.value);" required>
                                    <option value="0">Yes</option>
                                    <option selected="selected" value="1">No</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="client_type_div2 clearfix">
                        <div class="form-group officediv clearfix">
                            <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="staff_office" id="staff_office" title="Office" onchange="refresh_existing_individual_list(this.value);" required="">
                                    <option value="">Select Office</option>
                                    <?php load_ddl_option("staff_office_list", "", (staff_info()['type'] != 1) ? "staff_office" : ""); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group clearfix" id="individual_list">
                            <label class="col-lg-2 control-label">Existing Client List<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control individual_list" name="individual_list" id="individual_list_ddl" title="Individual List">
                                    <option value="">Select an option</option>
                                </select>        
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-lg-2 control-label">Title<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="ownertitle" title="Title" id="ownertitle" required="true">
                                    <?php
                                    if ($company_type != '') {
                                        if ($company_type == 3 || $company_type == 6 ) {
                                            if (!empty($title_val)) {
                                                ?>
                                                <option value="MANAGER" <?= ($title_val->title == 'MANAGER') ? 'selected' : ''; ?>>MANAGER</option>
                                                <option value="MANAGING MEMBER" <?= ($title_val->title == 'MANAGING MEMBER') ? 'selected' : ''; ?>>MANAGING MEMBER</option>
                                                <option value="MEMBER" <?= ($title_val->title == 'MEMBER') ? 'selected' : ''; ?>>MEMBER</option>
                                            <?php } else { ?>
                                                <option value="MANAGER">MANAGER</option>
                                                <option value="MANAGING MEMBER">MANAGING MEMBER</option>
                                                <option value="MEMBER">MEMBER</option>
                                            <?php } ?>
                                            <?php
                                        } elseif ($company_type == 2 or $company_type == 1 or $company_type == 4 or $company_type == 5) {
                                            if (!empty($title_val)) {
                                                ?>
                                                <option value="PRESIDENT" <?= ($title_val->title == 'PRESIDENT') ? 'selected' : ''; ?>>PRESIDENT</option>
                                                <option value="VICE PRESIDENT" <?= ($title_val->title == 'VICE PRESIDENT') ? 'selected' : ''; ?>>VICE PRESIDENT</option>
                                                <option value="SECRETARY" <?= ($title_val->title == 'SECRETARY') ? 'selected' : ''; ?>>SECRETARY</option>
                                                <option value="TREASURER" <?= ($title_val->title == 'TREASURER') ? 'selected' : ''; ?>>TREASURER</option>
                                                <option value="DIRECTOR" <?= ($title_val->title == 'DIRECTOR') ? 'selected' : ''; ?>>DIRECTOR</option>
                                                <option value="MANAGER" <?= ($title_val->title == 'MANAGER') ? 'selected' : ''; ?>>MANAGER</option>
                                            <?php } else { ?>
                                                <option value="PRESIDENT">PRESIDENT</option>
                                                <option value="VICE PRESIDENT">VICE PRESIDENT</option>
                                                <option value="SECRETARY">SECRETARY</option>
                                                <option value="TREASURER">TREASURER</option>
                                                <option value="DIRECTOR">DIRECTOR</option>
                                                <option value="MANAGER">MANAGER</option>
                                            <?php } ?>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Percentage/Shares<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Only numbers (%)" id="percentage_shares" class="form-control" type="text" name="percentage_shares" title="Percentage" required value="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <button class="btn btn-success" type="button" onclick="select_existing_owner()">Save changes</button>
                       </div>
                    <div class="client_type_div1 clearfix">    
                    <form class="form-horizontal" method="post" id="form_title" onsubmit="save_owner(); return false;">
                        <h3>Title Information</h3>
                        <input type="hidden" value="<?= $company_type; ?>" id="type" name="type">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Title<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="title" title="Title" id="selecttitle" required="true">
                                    <?php
                                    if ($company_type != '') {
                                        if ($company_type == 3 || $company_type == 6 ) {
                                            if (!empty($title_val)) {
                                                ?>
                                                <option value="MANAGER" <?= ($title_val->title == 'MANAGER') ? 'selected' : ''; ?>>MANAGER</option>
                                                <option value="MANAGING MEMBER" <?= ($title_val->title == 'MANAGING MEMBER') ? 'selected' : ''; ?>>MANAGING MEMBER</option>
                                                <option value="MEMBER" <?= ($title_val->title == 'MEMBER') ? 'selected' : ''; ?>>MEMBER</option>
                                            <?php } else { ?>
                                                <option value="MANAGER">MANAGER</option>
                                                <option value="MANAGING MEMBER">MANAGING MEMBER</option>
                                                <option value="MEMBER">MEMBER</option>
                                            <?php } ?>
                                            <?php
                                        } elseif ($company_type == 2 or $company_type == 1 or $company_type == 4 or $company_type == 5) {
                                            if (!empty($title_val)) {
                                                ?>
                                                <option value="PRESIDENT" <?= ($title_val->title == 'PRESIDENT') ? 'selected' : ''; ?>>PRESIDENT</option>
                                                <option value="VICE PRESIDENT" <?= ($title_val->title == 'VICE PRESIDENT') ? 'selected' : ''; ?>>VICE PRESIDENT</option>
                                                <option value="SECRETARY" <?= ($title_val->title == 'SECRETARY') ? 'selected' : ''; ?>>SECRETARY</option>
                                                <option value="TREASURER" <?= ($title_val->title == 'TREASURER') ? 'selected' : ''; ?>>TREASURER</option>
                                                <option value="DIRECTOR" <?= ($title_val->title == 'DIRECTOR') ? 'selected' : ''; ?>>DIRECTOR</option>
                                                <option value="MANAGER" <?= ($title_val->title == 'MANAGER') ? 'selected' : ''; ?>>MANAGER</option>
                                            <?php } else { ?>
                                                <option value="PRESIDENT">PRESIDENT</option>
                                                <option value="VICE PRESIDENT">VICE PRESIDENT</option>
                                                <option value="SECRETARY">SECRETARY</option>
                                                <option value="TREASURER">TREASURER</option>
                                                <option value="DIRECTOR">DIRECTOR</option>
                                                <option value="MANAGER">MANAGER</option>
                                            <?php } ?>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Percentage/Shares<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Only numbers (%)" id="per_id" class="form-control" type="text" name="percentage" title="Percentage" required value="<?= !empty($title_val) ? $title_val->percentage : "" ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <h3>Personal Information</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">First Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="first_name" name="first_name" title="First Name" required value="<?= !empty($title_val) ? $title_val->first_name : "" ?>"><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Middle Name</label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="middle_name" name="middle_name" title="Middle Name" value="<?= !empty($title_val) ? $title_val->middle_name : "" ?>"><div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Last Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="" class="form-control" type="text" id="last_name" name="last_name" title="Last Name" required value="<?= !empty($title_val) ? $title_val->last_name : "" ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">SSN/ITIN</label>
                            <div class="col-lg-10">
                                <?php
                                if(isset($title_val->ssn_itin) && $title_val->ssn_itin!=''){
                                    $ssn = substr_replace($title_val->ssn_itin, '-', 4, 0);
                                    $ssn = substr_replace($ssn, '-', 7, 0); 
                                }else{
                                    $ssn = '';
                                }                                
                                ?>
                                <input placeholder="" class="form-control" type="text" id="ssn_itin" name="ssn_itin" title="SSN/ITIN" data-mask="999-99-9999" placeholder="___-__-____" value="<?= $ssn; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Date of Birth</label>
                            <div class="col-lg-10">
                                <?php
                                    if(isset($title_val->birth_date) && $title_val->birth_date!='0000-00-00'){
                                        $dob = normalizeDatehelper($title_val->birth_date);
                                    }else{
                                        $dob = '';
                                    }
                                 ?>
                                <input placeholder="dd/mm/yyyy" id="dob" class="form-control datepicker_mdy" type="text" title="Date of Birth" name="birth_date" value="<?= $dob; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div id="contact_info_div">
                        <h3>Contact Info<span class="text-danger">*</span> &nbsp; (<a href="javascript:void(0);" class="contactadd" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $individual_id; ?>'); return false;">Add Contact</a>)</h3> 
                        <?php
                        if ($individual_contact_exists == 0) {
                            if ($main_contact_exists != 0) {
                                ?>
                                <a href="javascript:void(0);" id="copy-contact" ref_id="<?= $individual_id; ?>" value="<?= $reference_id; ?>">Copy Main Contact</a>
                                <?php
                            }
                        }
                        ?>
                        <div id="contact-list">
                            <input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                      </div>
                        <div class="hr-line-dashed"></div>

                        <h3>Documents &nbsp; (<a onclick="document_modal('add', '<?= $reference ?>', '<?= $individual_id ?>');" href="javascript:void(0);">Add Document</a>)</h3>
                        <div id="document-list"></div>
                        <div class="errorMessage text-danger"></div>


                        <div class="hr-line-dashed"></div>
                        <h3>Other Info</h3>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="language" id="language" title="Language" required="">
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

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="company_id" id="company_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="individual_id" id="individual_id" value="<?= $individual_id; ?>">
                                <input type="hidden" name="title_id" id="title_id" value="<?= $title_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="<?= $reference; ?>">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id1; ?>">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $individual_id; ?>">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="<?= $quant_contact; ?>">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="<?= $quant_documents; ?>">
                                <input type="hidden" name="action" id="action" value="save_owner">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                                <button class="btn btn-success" type="button" onclick="save_owner()">Save changes</button> &nbsp;
                                <button class="btn btn-default" type="button" onclick="self.close()">Cancel</button>
                            </div>
                        </div>

                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;">
    </div>
    <div id="document-form" class="modal fade" aria-hidden="true" style="display: none;">
    </div>
    <div class="modal_loading" id="loading_modal"></div>
</div>

<script>
    $('#dob').datepicker({dateFormat: 'mm/dd/yyyy', autoHide: true});
    $('#dob').attr("onblur", 'checkDate(this);');
    <?php if($_GET['tid']!=0){ ?>
    get_document_list('<?= $individual_id; ?>', "individual");
    get_contact_list('<?= $individual_id; ?>', "individual");
    <?php } ?>

    function getclientTypeChange(val){
        if(val=='1'){
            $(".client_type_div1").show();
            $(".client_type_div2").hide();
        }else{
            $(".client_type_div1").hide(); 
            $(".client_type_div2").show();
        }
    }

    $(function () {
        $(".client_type_div2").hide();
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
                },
                beforeSend: function () {
                    openLoading();
                },
                complete: function (msg) {
                    closeLoading();
                }
            });
        });
    });
</script>