<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins form-inline">
                <a class="btn btn-success m-b-5" href="<?= base_url("/action/home/add_business") ?>"><i class="fa fa-plus"></i> Business</a> &nbsp;
                <select name="ofc" id="ofc" class="form-control m-b-5">
                    <option value="">All Offices</option>   
                    <?php foreach ($staff_office as $so) { ?>
                        <option value="<?php echo $so['id']; ?>"><?php echo $so['name']; ?></option>
                    <?php } ?>
                </select>
                <select name="manager" id="manager" class="form-control m-b-5">
                    <option value="">All Manager</option>   
                    <?php foreach ($staff_list as $sl) { ?>
                        <option value="<?php echo $sl['id']; ?>"><?php echo $sl['last_name'] . ', ' . $sl['first_name'] . ' ' . $sl['middle_name']; ?></option>
                    <?php } ?>
                </select>  
                <select name="partner" id="partner" class="form-control m-b-5">
                    <option value="">All Partner</option>   
                    <?php foreach ($staff_list as $sl) { ?>
                        <option value="<?php echo $sl['id']; ?>"><?php echo $sl['last_name'] . ', ' . $sl['first_name'] . ' ' . $sl['middle_name']; ?></option>
                    <?php } ?>
                </select>  
                <select name="ref_source" id="ref_source" class="form-control m-b-5">
                    <option value="">All Referred By Source</option>   
                    <?php foreach ($reffered_by_source as $rs) { ?>
                        <option value="<?php echo $rs['id']; ?>"><?php echo $rs['source']; ?></option>
                    <?php } ?>
                </select> 
                <select name="company_type" id="company_type" class="form-control m-b-5">
                    <option value="">All Type Of Company</option>   
                    <?php foreach ($company_type as $ct) { ?>
                        <option value="<?php echo $ct['id']; ?>"><?php echo $ct['type']; ?></option>
                    <?php } ?>
                </select>                
            </div>
        </div>
    </div>
    <div class="ibox-content m-t-10" id="load_data">
        <div class="">
    <table id="service-tab" class="table table-bordered table-striped">
        <thead>
            <tr> 
                <th style="white-space: nowrap;">Company Name</th>               
                <th style="white-space: nowrap;">Practice ID</th>
                <th style="white-space: nowrap;">Office</th>
                <th style="white-space: nowrap;">Action</th>
                <!-- <th style="white-space: nowrap;">Partner</th>
                <th style="white-space: nowrap;">Manager</th> 
                <th style="white-space: nowrap;">Referred by Source</th>-->
            </tr>
        </thead>
    </table>
</div>
    </div>
</div>

<script>
    $(function () {
        load_business_dashboard();
        $("#ofc").change(function () {
            var ofc = $("#ofc option:selected").val();
            get_mngrs(ofc);
            $('#service-tab').DataTable().destroy();
            load_business_dashboard(ofc, document.getElementById('manager').value, document.getElementById('partner').value, document.getElementById('ref_source').value, document.getElementById('company_type').value);
        });
        $("#manager").change(function () {
            var manager_id = $("#manager option:selected").val();
            $('#service-tab').DataTable().destroy();
            load_business_dashboard(document.getElementById('ofc').value, manager_id, document.getElementById('partner').value, document.getElementById('ref_source').value, document.getElementById('company_type').value);
        });
        $("#partner").change(function () {
            var partner_id = $("#partner option:selected").val();
            $('#service-tab').DataTable().destroy();
            load_business_dashboard(document.getElementById('ofc').value, document.getElementById('manager').value, partner_id, document.getElementById('ref_source').value, document.getElementById('company_type').value);
        });
        $("#ref_source").change(function () {
            var ref_source = $("#ref_source option:selected").val();
            $('#service-tab').DataTable().destroy();
            load_business_dashboard(document.getElementById('ofc').value, document.getElementById('manager').value, document.getElementById('partner').value, ref_source, document.getElementById('company_type').value);
        });
        $("#company_type").change(function () {
            var company_type = $("#company_type option:selected").val();
            $('#service-tab').DataTable().destroy();
            load_business_dashboard(document.getElementById('ofc').value, document.getElementById('manager').value, document.getElementById('partner').value, document.getElementById('ref_source').value, company_type);
        });
    });

    function get_mngrs(ofc_id) {
        $.ajax({
        type: "POST",
        data: {
            ofc_id: ofc_id
        },
        url: base_url + 'action/home/get_mngrs',
        success: function (data) {
            $("#manager").html(data);
        }
      });
    }
</script>
