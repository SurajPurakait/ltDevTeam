<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#"><img src="<?php echo base_url(); ?>uploads/<?php echo $franchise_info['photo']; ?>" style="height:80px;"></a>
                            <div class="m-l-5" style="display: inline-block;">
                                <h2 class="text-info"><?php echo $franchise_info['office_id']; ?></h2>
                            </div>
                            
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="javascript:void(0);" class="btn btn-warning" style="width: 100px" onclick="cancel_office()">Back</a>                            
                            <a href="javascript:void(0);" class="btn btn-danger" style="width: 100px" onclick="delete_office('<?= $franchise_info['id']; ?>');">Delete</a>
                        </div>
                    </div>
                    <br>
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active"><a class="nav-link active" data-toggle="tab" href="#tab-1"> INFO</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">FEES</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">

                                    <form class="form-horizontal" method="post" id="form_office_modal" onsubmit="return false;">

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Select Type<span class="text-danger">*</span></label>
                                            <div class="col-lg-9">
                                                <select id="ofc_type" name="type" class="form-control" <?= count($office_staff) > 0 ? "disabled='disabled'" : ""; ?> title="Office Type" onchange="get_staff_for_role();">
                                                    <?php
                                                    if (!empty($office_type_list)) {
                                                        foreach ($office_type_list as $otl) {
                                                            ?>
                                                            <option <?php echo $franchise_info['type'] == $otl['id'] ? "selected='selected'" : ""; ?>
                                                                value="<?php echo $otl['id']; ?>"><?php echo $otl['name']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">From<span class="text-danger">*</span></label>
                                            <div class="col-lg-9">
                                                <select id="from_type" name="from_type" class="form-control chosen-select"
                                                        data-placeholder="Select One Option" required title="From Office">
                                                    <option value="1" <?php echo $franchise_info['from_type'] == '1' ? "selected='selected'" : ""; ?>>Taxleaf</option>
                                                    <option value="2" <?php echo $franchise_info['from_type'] == '2' ? "selected='selected'" : ""; ?>>ContadorMiami</option>
                                                </select>
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Name<span class="text-danger">*</span></label>
                                            <div class="col-lg-9">
                                                <input placeholder="Name" class="form-control" nameval="" type="text" name="name" required id="name"
                                                       title="Name" value="<?php echo $franchise_info['name']; ?>">
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Office ID<span class="text-danger">*</span></label>
                                            <div class="col-lg-9">
                                                <input placeholder="Office Id" nameval="" class="form-control" type="text" name="office_id" required id="office_id"
                                                       title="Office ID" value="<?php echo $franchise_info['office_id']; ?>">
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Merchant Token</label>
                                            <div class="col-lg-9">
                                                <input placeholder="Merchant Token" class="form-control" type="text" name="merchant_token" id="merchant_token"
                                                       title="Merchant Token" value="<?php echo $franchise_info['merchant_token']; ?>">
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Address<span class="text-danger">*</span></label>
                                            <div class="col-lg-9">
                                                <input placeholder="Address" class="form-control" type="text" name="address" id="address"
                                                       required title="Address" value="<?php echo $franchise_info['address']; ?>">
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">City<span class="text-danger">*</span></label>
                                            <div class="col-lg-9">
                                                <input placeholder="City" nameval="" class="form-control" type="text" id="city" name="city" required
                                                       title="City" value="<?php echo $franchise_info['city']; ?>">
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">State<span class="text-danger">*</span></label>
                                            <div class="col-lg-9">
                                                <select id="state" name="state" class="form-control chosen-select"
                                                        data-placeholder="Select One Option" required title="State">
                                                    <option value="">Select</option>
                                                    <?php
                                                    if (!empty($state_list)) {
                                                        foreach ($state_list as $sl) {
                                                            if ($sl['id'] != 0) {
                                                                ?>
                                                                <option <?php echo $franchise_info['state'] == $sl['id'] ? "selected='selected'" : ""; ?>
                                                                    value="<?php echo $sl['id']; ?>"><?php echo $sl['state_name']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                </select>
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Zip<span class="text-danger">*</span></label>
                                            <div class="col-lg-9">
                                                <input placeholder="Zip" class="form-control" type="text" zipval="" id="zip" name="zip" required
                                                       title="Zip" value="<?php echo $franchise_info['zip']; ?>">
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Email Address<span class="text-danger">*</span></label>
                                            <div class="col-lg-9">
                                                <input placeholder="Email address" class="form-control" id="emailaddress" type="email"
                                                       name="email" required title="Email Address"
                                                       value="<?php echo $franchise_info['email']; ?>">
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Phone<span class="text-danger">*</span></label>
                                            <div class="col-lg-9">
                                                <input placeholder="Phone" class="form-control" type="text" phoneval="" id="phone" name="phone" required
                                                       title="Phone" value="<?php echo $franchise_info['phone']; ?>">
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Fax</label>
                                            <div class="col-lg-9">
                                                <input placeholder="Fax" class="form-control" type="text" id="fax" name="fax" title="Fax"
                                                       value="<?php echo $franchise_info['fax']; ?>">
                                            </div>
                                        </div>
                                        <?php if ($franchise_info['photo'] != "") {
                                            ?>
                                            <div class="form-group" id="uploaded_photo">
                                                <label class="col-lg-3 control-label">Photo</label>
                                                <div class="col-lg-9">
                                                    <img src="<?php echo base_url(); ?>uploads/<?php echo $franchise_info['photo']; ?>"
                                                         class="editimg" height="50" width="50">
                                                </div>
                                            </div>
                                        <?php }
                                        ?>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Upload Photo</label>
                                            <div class="col-lg-9">
                                                <input class="p-t-5" type="file" name="photo" id="photo" allowed_types="jpg|png|jpeg" title="Photo">
                                                <div class="errorMessage text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="text-right m-r-15">
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="franchise_office_id" value="<?php echo $franchise_info['id']; ?>">
                                            <button class="btn btn-success" style="float:right;" type="button" onclick="update_franchise()">Save changes</button>&nbsp;&nbsp;&nbsp;
                                            <!-- <button class="btn btn-default" type="button" onclick="cancel_office()">Cancel</button> -->
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body p-t-40 p-b-20">
                                    
            <div class="filter-outer">
                <form name="filter_form" id="filter-form"  method="post">
                    <div class="form-group filter-inner">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 35%;">Category</th>
                                <th style="width: 35%;">Service</th>
                                <th style="width: 35%;">% Fee</th>
                            </tr>
                            <?php foreach($info_service_list as $service){
                            $fees = service_fees($franchise_info['id'], $service['id']); ?>
                            <tr>
                                <td><?= $service['catname']; ?></td>
                                <td>
                                    <?= $service['description']; ?>
                                    <input type="hidden" name="service[]" value="<?= $service['id']; ?>">  
                                </td>
                                <td><input type="text" placeholder="0.00" name="percentage[]" id="percentage" class="form-control" value="<?= isset($fees['percentage']) ? $fees['percentage'] : '0.00' ?>"></td>
                            </tr>

                        <?php } ?>
                           <!--  <tr>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td><input type="text" placeholder="" name="" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td><input type="text" placeholder="" name="" class="form-control"></td>
                            </tr> -->
                            
                        </table>
                    </div>
                    <div class="col-md-12 text-right">  
                        <div class="m-b-10">
                            <input type="hidden" name="franchise_office_id" id="franchise_office_id" value="<?php echo $franchise_info['id']; ?>">
                            <button class="btn btn-success"  type="button" onclick="save_service_fees()">Submit</button>
                        </div>
                    </div>
                    
                </form>  
                <input id="hiddenflag" value="" type="hidden">
            </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // var content = $(".filter-div").html();
    // var variable_dd_array = [];
    var elementArray = [];

    // function add_new_row_service() {
    //     var random = Math.floor((Math.random() * 999) + 1);
    //     var clone = '<div class="filter-div row m-b-10" id="clone-' + random + '">' + content + '<div class="col-md-1"><a href="javascript:void(0);" onclick="remove_new_row_service(' + random + ')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i></a></div></div>';
    //     $('.filter-inner').append(clone);
    //     $.each(variable_dd_array, function (key, value) {
    //         $("#clone-" + random + " .variable-dropdown option[value='" + value + "']").remove();
    //     });
    //     $("div.add_filter_div:not(:first)").remove();
    // }

    // function remove_new_row_service(random) {
    //     var divid = 'clone-' + random;
    //     var variable_dropdown_val = $("#clone-" + random + " .variable-dropdown option:selected").val();
    //     var index = variable_dd_array.indexOf(variable_dropdown_val);
    //     variable_dd_array.splice(index, 1);
    //     $("#" + divid).remove();
    // }

    function changeVariableService(element) {

        var divID = $(element).parent().parent().attr('id');
        var variableValue = $(element).children("option:selected").val();
        // alert(divID);return false;
        // alert(variableValue);return false;

        var checkElement = elementArray.includes(element);
        // var officeValue = '';
        if (checkElement == true) {
            variable_dd_array.pop();
            variable_dd_array.push(variableValue);
        } else {
            elementArray.push(element);
            variable_dd_array.push(variableValue);
        }

        // $.ajax({
        //     type: "POST",
        //     data: {
        //         variable: variableValue
        //         // office: officeValue

        //     },
        //     url: '<?//= base_url(); ?>' + 'administration/office/get_service_dropdown_options',
        //     dataType: "html",
        //     success: function (result) {
        //         // alert(result);return false;
        //         // $("#" + divID).find('.criteria-div').html(result);
        //         // $(".chosen-select").chosen();
        //         // $("#" + divID).find('.condition-dropdown').val('');
        //         $("#" + divID).nextAll(".filter-div").each(function () {
        //             $(this).find('.remove-filter-button').trigger('click');
        //         });
        //     },
        //     beforeSend: function () {
        //         openLoading();
        //     },
        //     complete: function (msg) {
        //         closeLoading();
        //     }
        // });
    }
</script>