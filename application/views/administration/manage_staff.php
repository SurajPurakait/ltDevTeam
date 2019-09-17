<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins form-inline">
                <a class="btn btn-success" id="add_staff" onclick="show_staff_modal('add', '');"
                   href="javascript:void(0);"><i class="fa fa-plus"></i> Add Staff</a> &nbsp;
                   <select name="ofc" id="ofc" class="form-control">
                    <option value="">Select Office</option>   
                     <?php foreach($staff_office as $so){ ?>
                    <option value="<?php echo $so['id']; ?>"><?php echo $so['name']; ?></option>
                    <?php } ?>
                   </select> &nbsp;
                   <select name="dept" id="dept" class="form-control">
                    <option value="">Select Department</option>
                    <?php foreach($staff_depts as $sd){ ?>
                    <option value="<?php echo $sd['id']; ?>"><?php echo $sd['name']; ?></option>
                    <?php } ?>   
                   </select> &nbsp;
                   <select name="type" id="type" class="form-control">
                    <option value="">Select Type</option>
                    <?php foreach($staff_type as $st){ ?>
                    <option value="<?php echo $st['id']; ?>"><?php echo $st['name']; ?></option>
                    <?php } ?>   
                   </select>
                <div class="ibox-content ajaxdiv-staff m-t-10">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div id="staff-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>
<script type="text/javascript">
    loadstaffdata();
    $(document).ready(function(){
        $("#ofc").change(function(){
            var ofc = $("#ofc option:selected").val();
            var dept = $("#dept option:selected").val();
            var type = $("#type option:selected").val();
            loadstaffdata(ofc,dept,type);
        });
        $("#dept").change(function(){
            var ofc = $("#ofc option:selected").val();
            var dept = $("#dept option:selected").val();
            var type = $("#type option:selected").val();
            loadstaffdata(ofc,dept,type);
        });
        $("#type").change(function(){
            var ofc = $("#ofc option:selected").val();
            var dept = $("#dept option:selected").val();
            var type = $("#type option:selected").val();
            loadstaffdata(ofc,dept,type);
        });
    });
</script>
