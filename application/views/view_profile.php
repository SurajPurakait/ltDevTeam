<?php

$staffinfo=staff_info();


?>
<div class="wrapper wrapper-content">
    <div class="ibox-content m-b-md">        
        <table class="table table-striped m-b-0">
            <tr>
                <td width="250">
                    <h4>FirstName</h4>
                </td>
                <td>
                    <input type="text" name="first_name" id="first_name" value="<?php echo $staffinfo['first_name']; ?>" class="form-control">
                </td>
            </tr>
            <tr>
                <td width="250">
                    <h4>LastName</h4>
                </td>
                <td>
                    <input type="text" name="last_name" id="last_name" value="<?php echo $staffinfo['last_name']; ?>" class="form-control">
                </td>
            </tr>
            
            <tr>
                <td width="250">
                    <h4>Date Of Birth</h4>
                </td>
                <td>
                    <input type="text" name="birth_date" id="birth_date" value="<?php echo $staffinfo['birth_date']; ?>" class="form-control">
                </td>
            </tr>
            
            <tr>
                <td>
                    <h4>Office</h4>
                </td>
                <td>
                    <h4 style="font-weight: normal;"><?php echo staff_office_name(sess('user_id')); ?></h4>
                </td>
            </tr>
            <tr>
                <td>
                    <h4>Department</h4>
                </td>
                <td>
                    <h4 style="font-weight: normal;"><?php echo staff_department_name(sess('user_id')); ?></h4>
                </td>
            </tr>
            <tr>
                <td>
                    <h4>Contact Info</h4>
                </td>
                <td>
                    <h4 style="font-weight: normal;"><input type="text" name="phno" id="phno" value="<?php echo ($staffinfo['phone']=='') ? 'N/A' : $staffinfo['phone']; ?>" class="form-control"></h4>
                </td>
            </tr>
            
             <tr>
                <td>
                    <h4>Cell Phone</h4>
                </td>
                <td>
                    <h4 style="font-weight: normal;"><input type="text" name="cell" id="cell" value="<?php echo ($staffinfo['cell']=='') ? 'N/A' : $staffinfo['cell']; ?>" class="form-control"></h4>
                </td>
            </tr>
            
            <tr>
                <td>
                    <h4>Extension</h4>
                </td>
                <td>
                    <h4 style="font-weight: normal;"><input type="text" name="extension" id="extension" value="<?php echo $staffinfo['extension']?>" class="form-control"></h4>
                </td>
            </tr>
            <tr>
                <td width="250">
                    <h4>Social Security Number</h4>
                </td>
                <?php $ssn = substr_replace($staffinfo['ssn_itin'], '-', 4, 0);
                       $ssn = substr_replace($ssn, '-', 7, 0);
                 ?>
                <td>
                    <h4 style="font-weight: normal;"><?php echo $ssn; ?></h4>
                </td>
            </tr>
            <tr>
                <td>
                    <h4>Profile Picture</h4>
                </td>
                <td>
                    <img src="<?php echo base_url(); ?>uploads/<?php echo $staffinfo['photo']; ?>" width="100">
                </td>
            </tr>
            <tr>
                <td>
                    <h4>Username</h4>
                </td>
                <td>
                    <h4 style="font-weight: normal;"><?php echo $staffinfo['user']; ?></h4>
                </td>
            </tr>
            <tr>
                <td>
                    <h4>Time Of Expiration</h4>
                </td>
                <td>
                    <h4 style="font-weight: normal;"><?php echo $staffinfo['date']; ?></h4>
                </td>
            </tr>
            <tr>
                <td width="250">
                    <h4>Password</h4>
                </td>
                <td>
                    <input type="password" name="pwd" id="pwd" value="*******" class="form-control">
                </td>
            </tr>
            
            
             <tr>
                <td>
                    <h4>Status</h4>
                </td>
                <td>
                    <h4 style="font-weight: normal;">
                         <?php
                        if ($staffinfo['status']== '1') {
                        echo "Active";
                       } else {
                       echo "Inctive";
                        }
                        
                        
                      ?>
                    
                    </h4>
                </td>
            </tr>
            
             <tr>
                <td>
                    <h4>Type</h4>
                </td>
                <td>
                    <h4 style="font-weight: normal;"><?php echo staff_department_name(sess('user_id')); ?></h4>
                </td>
            </tr>
            
            <tr>
                <td width="250">                    
                </td>
                <td>
                    <button class="btn btn-primary m-t-15" onclick="update_profile(this);">Update</button>
                </td>
            </tr>
           </table>
    </div>
</div>
<script type="text/javascript">
    function update_profile(that){
        that.disabled = true;
        that.innerHTML = 'Processing...';
        var base_url = '<?php echo base_url(); ?>';
        var fname = $("#first_name").val();
        var lname = $("#last_name").val();
        var birth_date = $("#birth_date").val();
        var phno = $("#phno").val();
        var cell = $("#cell").val();
        var extension = $("#extension").val();
        //alert(phno);
        var pwd = $("#pwd").val();
         $.ajax({
        type: 'POST',
        data: {
          fname: fname,
          lname: lname,
          birth_date: birth_date,
          phno: phno,
          cell: cell,
          extension: extension,
          pwd: pwd
        },
        url: base_url + 'home/update_profile',
        success: function (result) {
            if(result.trim()==1){
                swal({title: "Success!", text: "Profile Successfully Update!", type: "success"}, function () {
                    goURL(base_url + 'home/view_profile');
                });
            }else{
                that.disabled = false;
                that.innerHTML = 'Update';
                swal("ERROR!", "Unable To Update Profile!", "error");
            }            
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
     });
    }
</script>