<?php $staff_info = staff_info(); ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="search_main_cat" id="search_main_cat" class="form-control" onchange="get_marketing_subcat(this.value);filter();">
                                    <option value="">Select Main Category</option>
                                    <?php
                                    if (!empty($main_cat)) {
                                        foreach ($main_cat as $c) {
                                            ?>
                                            <option value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-b-10" id="marketing_sub_cat">
                                <select name="search_sub_cat" id="search_sub_cat" class="form-control" onchange="subcat_filter(this.value);">
                                    <option value="">Select Sub Category</option>
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="ofc" id="ofc" class="form-control m-b-1" onchange="filter();">
                                <option value="">Select Office</option>   
                                <?php foreach ($staff_office as $so) { ?>
                                    <option value="<?= $so['id']; ?>"><?= $so['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="staff" id="staff" class="form-control" onchange="filter();">
                                <option value="">Select Staff</option>   
                                <?php foreach ($staff_list as $sl) { ?>
                                    <option value="<?= $sl['id']; ?>"><?= $sl['last_name'] . ', ' . $sl['first_name'] . ' ' . $sl['middle_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id="load_data"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="changePurchaseStatus" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad1" value="1"/>
                                <label for="rad1"><strong>Not Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad2" value="2"/>
                                <label for="rad2"><strong>Started</strong></label>
                            </div>
                        </div>
                        <div class="funkyradio">
                            <div class="funkyradio-success">
                                <input type="radio" name="radio" id="rad3" value="3"/>
                                <label for="rad3"><strong>Completed</strong></label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="rowid" value="">
                <input type="hidden" id="baseurl" value="<?= base_url(); ?>">
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save-btn" onclick="updatePurchaseStatus()">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    load_marketing_materials_purchase_list('<?= $staff_info["type"]; ?>', '', '', '', '');
    function load_marketing_materials_purchase_list(type, main_cat, sub_cat, ofc, staff) {
        $.ajax({
            type: 'POST',
            data: {
                type: type,
                main_cat: main_cat,
                sub_cat: sub_cat,
                ofc: ofc,
                staff: staff
            },
            url: base_url + 'marketing_materials/load_marketing_materials_purchase_list',
            success: function (result) {
//            console.log(result);
                $("#load_data").html(result);
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    }
    function filter() {
        var mc = $("#search_main_cat option:selected").val();
        var sc = $("#search_sub_cat option:selected").val();
        var ofc = $("#ofc option:selected").val();
        var staff = $("#staff option:selected").val();
        load_marketing_materials_purchase_list('<?= $staff_info["type"]; ?>', mc, sc, ofc, staff);
    }
    function subcat_filter(sc) {
        var mc = $("#search_main_cat option:selected").val();
        var ofc = $("#ofc option:selected").val();
        var staff = $("#staff option:selected").val();
        load_marketing_materials_purchase_list('<?= $staff_info["type"]; ?>', mc, sc, ofc, staff);
    }
</script>