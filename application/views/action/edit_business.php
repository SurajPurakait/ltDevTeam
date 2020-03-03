<?php
    $staff_info = staff_info();
    // print_r($staff_info);exit;
?>
<div class="wrapper wrapper-content">        
    <form class="form-horizontal" method="post" id="form_create_new_company">
        <div class="tabs-container">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-link active"><a href="#general_info" aria-controls="#general_info" role="tab" data-toggle="tab">GENERAL</a></li>
                <li class="nav-link"><a href="#contact_info" aria-controls="#contact_info" role="tab" data-toggle="tab">CONTACT </a></li>
                <li class="nav-link"><a href="#owner_info" aria-controls="#owner_info" role="tab" data-toggle="tab">OWNER</a></li>
                <!-- <li class="nav-link"><a href="#other_info" aria-controls="#other_info" role="tab" data-toggle="tab">OTHER</a></li> -->                    
                <!--<li class="nav-link"><a href="#account_info" aria-controls="#account_info" role="tab" data-toggle="tab">ACCOUNT</a></li>-->
  <!--               <li class="nav-link"><a href="#billing_info" aria-controls="#billing_info" role="tab" data-toggle="tab">INVOICE</a></li> -->                    
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="general_info">
                    <div class="panel-body">                 
                        <h3>Business Information</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">State of Incorporation<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="company[state_opened]" id="state_opened" title="State of Incorporation" required="" <?= ($staff_info['type'] == 3) ? 'style="pointer-events: none;"':''; ?>>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("state_list", $company_data[0]['state_opened']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Name of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input placeholder="Name of Company" class="form-control" id="name1" type="text" name="new_company[name1]" value="<?= $company_data[0]['name'] ?>" title="Name of Business" required="" <?= ($staff_info['type'] == 3) ? 'style="pointer-events: none;"':''; ?>;>
                                <div class="errorMessage text-danger"></div>
                                <input style="display: none;" placeholder="Option 2" class="form-control" type="text" name="new_company[name2]" value="<?= isset($company_name_option_data[0]['name2']) ? $company_name_option_data[0]['name2'] : '' ?>"  title="Name of Business">
                                <input style="display: none;" placeholder="Option 3" class="form-control" type="text" name="new_company[name3]" value="<?= isset($company_name_option_data[0]['name3']) ? $company_name_option_data[0]['name3'] : '' ?>" title="Name of Business">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Federal ID</label>
                            <div class="col-lg-10">
                                <input placeholder="xx-xxxxxxx" data-mask="99-9999999" class="form-control" id="fein" type="text" name="company[fein]" value="<?= $company_data[0]['fein'] ?>" title="Federal ID" <?= ($staff_info['type'] == 3) ? 'style="pointer-events: none;"':''; ?>>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Type of Company<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="company[type]" id="type" title="Type of Company" required="" <?= ($staff_info['type'] == 3) ? 'style="pointer-events: none;"':''; ?>>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("company_type_list", $company_data[0]['type']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Fiscal Year End<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="company[fye]" id="fye" title="Fiscal year end" required="" <?= ($staff_info['type'] == 3) ? 'style="pointer-events: none;"':''; ?>>
                                    <option class="form-control" value="">Select an option</option>
                                    <?php load_ddl_option("fiscal_year_end", $company_data[0]['fye']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group" id="dba_div">
                            <label class="col-lg-2 control-label">DBA (if any)</label>
                            <div class="col-lg-10">
                                <input placeholder="DBA" id="dba" class="form-control" type="text" name="company[dba]" title="DBA" value="<?php echo $company_data[0]['dba'] ?>" <?= ($staff_info['type'] == 3) ? 'style="pointer-events: none;"':''; ?>>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Business Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="company[business_description]" id="business_description" title="Business Description" <?= ($staff_info['type'] == 3) ? 'style="pointer-events: none;"':''; ?>><?= urldecode($company_data[0]['business_description']) ?></textarea>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <!--//START-->
                        <div class="hr-line-dashed"></div>
                        <h3>Internal Data</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Office<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="internal_data[office]" onchange="load_partner_manager_ddl(this.value);" id="office" title="Office" required="" <?= ($staff_info['type'] == 3 && $staff_info['role'] != 2) ? 'style="pointer-events: none;"':''; ?>>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("staff_office_list", $company_internal_data[0]['office']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Partner<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="internal_data[partner]" id="partner" title="Partner" required <?= ($staff_info['type'] == 3 && $staff_info['role'] != 2) ? 'style="pointer-events: none;"':''; ?>>
                                    <option value="">Select an option</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Manager<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="internal_data[manager]" id="manager" title="Manager" required <?= ($staff_info['type'] == 3 && $staff_info['role'] != 2) ? 'style="pointer-events: none;"':''; ?>>
                                    <option value="">Select an option</option>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Client Association</label>
                            <div class="col-lg-10">
                                <input placeholder="Client Association" class="form-control" type="text" name="internal_data[client_association]" value="<?= $company_internal_data[0]['client_association'] ?>" id="client_association" title="Client Association" <?= ($staff_info['type'] == 3 && $staff_info['role'] != 2) ? 'style="pointer-events: none;"':''; ?>>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <!-- <div class="hidden"> -->
                        <?php
                            $staff_info = staff_info(sess('user_id'));
                            if ($staff_info['type'] == '1' || ($staff_info['role'] == '4' && $staff_info['type'] == '2')) {
                        ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Client Id</label>
                            <div class="col-lg-10">
                                <input placeholder="Practice Id" class="form-control" type="text" name="internal_data[practice_id]" id="practice_id" value="<?= $company_internal_data[0]['practice_id']; ?>" title="Practice Id">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Client Id</label>
                            <div class="col-lg-10">
                                <input placeholder="Practice Id" class="form-control" type="text" name="internal_data[practice_id]" id="practice_id" value="<?= $company_internal_data[0]['practice_id']; ?>" title="Practice Id" disabled>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <?php        
                            }
                        ?>
                        <!-- </div> -->
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Referred By Source<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="internal_data[referred_by_source]" id="referred_by_source" onchange="change_referred_name_status(this.value);" title="Referred By Source" required <?= ($staff_info['type'] == 3 && $staff_info['role'] != 2) ? 'style="pointer-events: none;"':''; ?>>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("referer_by_source", $company_internal_data[0]['referred_by_source']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="referred-label" class="col-lg-2 control-label">Referred By Name</label>
                            <div class="col-lg-10">
                                <input placeholder="Referred By Name" class="form-control" type="text" id="referred_by_name" name="internal_data[referred_by_name]" value="<?= $company_internal_data[0]['referred_by_name'] ?>" title="Referred By Name" <?= ($staff_info['type'] == 3 && $staff_info['role'] != 2) ? 'style="pointer-events: none;"':''; ?>>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Language<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" id="language" name="internal_data[language]" title="Language" required="" <?= ($staff_info['type'] == 3 && $staff_info['role'] != 2) ? 'style="pointer-events: none;"':''; ?>>
                                    <option value="">Select an option</option>
                                    <?php load_ddl_option("language_list", $company_internal_data[0]['language']); ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>

                        <!--//END-->
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="<?= $reference; ?>">
                                <input type="hidden" name="service_id" id="service_id" value="<?= isset($company_order_data[0]['service_id']) ? $company_order_data[0]['service_id'] : 0; ?>">
                                <input type="hidden" name="action" id="action" value="create_new_company">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                                <input type="hidden" name="editval" id="editval" value="<?= isset($company_order_data[0]['id']) ? $company_order_data[0]['id'] : ''; ?>">
                                <button class="btn btn-success" type="button" onclick="request_create_business()">Save</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="go('action/home/business_dashboard')">Cancel</button>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="tab-pane" role="tabpanel" id="contact_info">
                    <div class="panel-body">
                        <h3>Contact Info<span class="text-danger">*</span>&nbsp; <a href="javascript:void(0);" class="btn btn-primary" onclick="contact_modal('add', '<?= $reference; ?>', '<?= $reference_id; ?>');
                                return false;"><span class="fa fa-plus"></span>&nbsp; Add Contact</a></h3>
                        <div id="contact-list">
                            <input type="hidden" title="Contact Info" id="contact-list-count" required="required" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="<?= $reference; ?>">
                                <input type="hidden" name="service_id" id="service_id" value="<?= isset($company_order_data[0]['service_id']) ? $company_order_data[0]['service_id'] : 0; ?>">
                                <input type="hidden" name="action" id="action" value="create_new_company">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                                <input type="hidden" name="editval" id="editval" value="<?= isset($company_order_data[0]['id']) ? $company_order_data[0]['id'] : ''; ?>">
                                <button class="btn btn-success" type="button" onclick="request_create_business()">Save</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="go('action/home/business_dashboard')">Cancel</button>
                            </div>
                        </div>                           
                    </div>
                </div>
                <div class="tab-pane" role="tabpanel" id="owner_info">
                    <div class="panel-body">                         
                        <h3>Owners<span class="text-danger">*</span> &nbsp; <a href="javascript:void(0);" class="btn btn-primary" onclick="open_owner_popup(<?= isset($company_order_data[0]['service_id']) ? $company_order_data[0]['service_id'] : 0; ?>, '<?= $reference_id; ?>', 0);
                                return false;"><span class="fa fa-plus"></span>&nbsp; Add owner</a></h3>
                        <div id="owners-list">
                            <input type="hidden" title="Owners" id="owners-list-count" required="required" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="<?= $reference; ?>">
                                <input type="hidden" name="service_id" id="service_id" value="<?= isset($company_order_data[0]['service_id']) ? $company_order_data[0]['service_id'] : 0; ?>">
                                <input type="hidden" name="action" id="action" value="create_new_company">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                                <input type="hidden" name="editval" id="editval" value="<?= isset($company_order_data[0]['id']) ? $company_order_data[0]['id'] : ''; ?>">
                                <button class="btn btn-success" type="button" onclick="request_create_business()">Save</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="go('action/home/business_dashboard')">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="contact-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="document-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<div id="accounts-form" class="modal fade" aria-hidden="true" style="display: none;"></div>
<script type="text/javascript">
    loadBillingDashboard('', '', '', '', '<?= $reference_id . '-company'; ?>');
    get_contact_list('<?= $reference_id; ?>', 'company');
    reload_owner_list('<?= $reference_id; ?>', 'main');
    get_document_list('<?= $reference_id; ?>', 'company');
    $(function () {
        load_partner_manager_ddl('<?= $company_internal_data[0]['office']; ?>', '<?= $company_internal_data[0]['partner']; ?>', '<?= $company_internal_data[0]['manager']; ?>');
        $("#referred_by_source").change(function () {
            var source = $("#referred_by_source option:selected").val();
            if (source == '1' || source == '9' || source == '10') {
                $("#referred-label").html('Referred By Name');
                $("#referred-by-name").removeAttr('required');
            } else {
                $("#referred-label").html('Referred By Name<span class="text-danger">*</span>');
                $("#referred-by-name").attr('required', true);
            }
        });
        $(".form-tab").click(function (e) {
            e.preventDefault();
            var showIt = $(this).attr('data-form');
            $(".ibox").hide();
            $(showIt).show();
        });

    });
</script>