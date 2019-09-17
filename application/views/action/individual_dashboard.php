<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins form-inline">
                <a class="btn btn-success" onclick="show_staff_modal('add', '');"
                   href="<?= base_url("/action/home/add_individual") ?>"><i class="fa fa-plus"></i> Add Individual</a> &nbsp;
                <select name="ofc" id="ofc" class="form-control m-b-5">
                    <option value="">All Offices</option>   
                    <?php foreach ($staff_office as $so) { ?>
                        <option value="<?php echo $so['id']; ?>"><?php echo $so['name']; ?></option>
                    <?php } ?>
                </select>  
                <select name="manager" id="manager" class="form-control m-b-5">
                    <option value="">Select Manager</option>   
                    <?php foreach ($staff_list as $sl) { ?>
                        <option value="<?php echo $sl['id']; ?>"><?php echo $sl['last_name'].', '.$sl['first_name'].' '.$sl['middle_name']; ?></option>
                    <?php } ?>
                </select>  
                <select name="partner" id="partner" class="form-control m-b-5">
                    <option value="">Select Partner</option>   
                    <?php foreach ($staff_list as $sl) { ?>
                        <option value="<?php echo $sl['id']; ?>"><?php echo $sl['last_name'].', '.$sl['first_name'].' '.$sl['middle_name']; ?></option>
                    <?php } ?>
                </select>  
                <select name="ref_source" id="ref_source" class="form-control m-b-5">
                    <option value="">Select Referred By Source</option>   
                    <?php foreach ($reffered_by_source as $rs) { ?>
                        <option value="<?php echo $rs['id']; ?>"><?php echo $rs['source']; ?></option>
                    <?php } ?>
                </select>     

                <br>
                <div id="load_data" class="ibox-content m-t-10">
                    <div class="">
                        <table id="service-tab" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">First Name</th>
                                <th style="white-space: nowrap;">Last Name</th>
                                <th style="white-space: nowrap;">Client ID</th>
                                <th style="white-space: nowrap;">Office ID</th>
                                <th style="white-space: nowrap;">Action</th>
                            </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        load_individual_dashboard();
        $("#ofc").change(function () {
            var ofc_id = $("#ofc option:selected").val();
            get_mngrs(ofc_id);
            $('#service-tab').DataTable().destroy();
            load_individual_dashboard(ofc_id,document.getElementById('manager').value,document.getElementById('partner').value,document.getElementById('ref_source').value);
        });
         $("#manager").change(function () {
            var manager_id = $("#manager option:selected").val();
            $('#service-tab').DataTable().destroy();
            load_individual_dashboard(document.getElementById('ofc').value,manager_id,document.getElementById('partner').value,document.getElementById('ref_source').value);
        });
         $("#partner").change(function () {
            var partner_id = $("#partner option:selected").val();
            $('#service-tab').DataTable().destroy();
            load_individual_dashboard(document.getElementById('ofc').value,document.getElementById('manager').value,partner_id,document.getElementById('ref_source').value);
        });
         $("#ref_source").change(function () {
            var ref_source = $("#ref_source option:selected").val();
            $('#service-tab').DataTable().destroy();
            load_individual_dashboard(document.getElementById('ofc').value,document.getElementById('manager').value,document.getElementById('partner').value,ref_source);
        });
    });

    function get_mngrs(ofc_id){
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