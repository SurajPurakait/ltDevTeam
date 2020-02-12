<?php 
    if ($modal_type != "edit") {
?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Add Partner Service</h3>
            </div>
            <form role="form" id="add-services-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Service Category</label>
                        <select title="Service Category" class="form-control chosen-select" name="servicecat" id="servicecat" onchange="get_related_services('');" required>
                            <?php
                            if (!empty($categories)) {
                                foreach ($categories as $value) {
                                    ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Service Name<span class="text-danger">*</span></label>
                        <input title="Service Name" class="form-control" type="text" onkeyup="generate_shortcode();" name="servicename" id="servicename" required>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group" style="display: none;">
                        <label>Service Shortname</label>
                        <input title="Service Shortname" class="form-control" type="text" name="servicesn" id="servicesn" value="" disabled>
                        <input type="hidden" name="shorthidden" id="shorthidden">
                    </div>
                    <div class="form-group">
                        <label>Fixed Cost<span class="text-danger">*</span></label>
                        <input title="Fixed Cost" class="form-control" type="text" name="fixedcost" id="fixedcost" required phoneval>
                        <!-- <span>&#36;</span>  -->
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Retail Price<span class="text-danger">*</span></label>
                        <input title="Retail Price" class="form-control" type="number" name="retailprice" id="retailprice" required>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group">
                        <label>Responsible Assigned<span class="text-danger">*</span></label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="1" type="radio" id="responsible_franchisee" name="responsible_assigned" required="" title="Responsible Assigned" onclick="show_corporate_departments(this.value)"> Franchisee
                        </label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="2" type="radio" id="responsible_corporate" name="responsible_assigned" required="" title="Responsible Assigned" onclick="show_corporate_departments(this.value)"> Corporate
                        </label>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group" id="corporate_dept_div"  style="display: none;">
                        <label>Select Department<span class="text-danger">*</span></label>
                        <select id="dept" name="dept" class="form-control" title="Department" required>
                            <?php
                            if (!empty($department_list)) {
                                foreach ($department_list as $key => $value) {
                                    if ($value['id'] != 1 && $value['id'] != 2) {
                                        ?>
                                        <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group">
                        <label>Target Starting Day<span class="text-danger">*</span></label>
                        <input title="Target For Start(days)" class="form-control" type="number" name="startdays" id="startdays" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Target Completed Day<span class="text-danger">*</span></label>
                        <input title="Target For Completion(days)" class="form-control" type="number" name="enddays" id="enddays" required>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group">
                        <label>Client Type<span class="text-danger">*</span></label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="checkbox-inline">
                            <input class="checkboxclass" value="0" type="checkbox" id="business_clients" name="client_type" required="" title="Client Type"> Business Clients
                        </label>
                        <label class="checkbox-inline">
                            <input class="checkboxclass" value="1" type="checkbox" id="individual_clients" name="client_type" required="" title="Client Type"> Individual Clients
                        </label>
                        <div class="errorMessage text-danger"></div>
                    </div>

                    <div class="form-group">
                        <label>Input Form<span class="text-danger">*</span></label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="y" type="radio" id="inputform1" name="input_form" required="" title="Input Form"> Yes
                        </label>
                        <label class="checkbox-inline">
                            <input class="checkclass" value="n" type="radio" id="inputform2" name="input_form" required="" title="Input Form"> No
                        </label>
                        <div class="errorMessage text-danger" id="input_form_error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label>Related Services</label>
                        <select title="Related Services" class="form-control" id="relatedserv" name="relatedserv" multiple="multiple">
                            <option value=""></option>
                        </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="note" id="note"></textarea>
                    </div>                           

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" id="baseurl" value="<?= base_url(); ?>">
                    <button type="button" class="btn btn-primary" onclick="addRelatedservice()">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(function () {
            get_related_services("", "");
            generate_shortcode();
        });

        function show_corporate_departments($val){
            // alert($val);return false;
            if($val == 2){
                document.getElementById('corporate_dept_div').style.display = 'block';
            }else{
                document.getElementById('corporate_dept_div').style.display = 'none';
            }
        }
    </script>
<?php
    }
?>