<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tax Leaf | Login</title>
        <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/animate.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
    </head>
    <body class="gray-bg login-bubble">

        <div class="middle-box text-center  animated fadeInDown">
            <div class="irs-peeking-out"></div>
            <div class="loginscreen">
                <div>
                    <img src="<?php echo base_url() ?>assets/img/logo.png"><hr>
                </div>                
                <?php echo $this->session->flashdata('auth_error') != '' ? $this->session->flashdata('auth_error') : ""; ?>
                <?php $ssn_blank_error = $this->session->flashdata('ssn_blank_error');
                    if(isset($ssn_blank_error)) { ?>
                        <p>Please provide your SSN to start your session</p>
                  <form class="m-t" role="form" action="<?php echo base_url() ?>home/updatessn" method="post">
                    <div class="form-group">
                        <input type="text" name="ssn_no" class="form-control" data-mask="999-99-9999" placeholder="___-__-____" />
                        <?php echo $this->session->flashdata('ssn_no_error') != '' ? $this->session->flashdata('ssn_no_error') : ""; ?>
                        <?php echo $this->session->flashdata('ssn_invalid_error') != '' ? $this->session->flashdata('ssn_invalid_error') : ""; ?>
                        <?php 
                        if($ssn_blank_error!='blank_error'){
                        echo $this->session->flashdata('ssn_blank_error') != '' ? $this->session->flashdata('ssn_blank_error') : ""; 
                        }
                        ?>
                        <?php echo $this->session->flashdata('ssn_digit_error') != '' ? $this->session->flashdata('ssn_digit_error') : ""; ?>
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                    <button type="submit" class="btn btn-primary block full-width m-b">Update SSN</button>
                </form>  
                <?php } else{ ?>
                    <p>Please provide last six digit of your SSN to start your session</p>
                <form class="m-t" role="form" action="<?php echo base_url() ?>home/checkssn" method="post">
                    <div class="form-group">
                        <input type="password" name="ssn_no" onkeyup="check_character_count();" onkeydown="check_character_count();" id="ssn_no" class="form-control" placeholder="Last Six Digit of Social Security Number" autofocus>
                        <?php echo $this->session->flashdata('ssn_no_error') != '' ? $this->session->flashdata('ssn_no_error') : ""; ?>
                        <?php echo $this->session->flashdata('ssn_invalid_error') != '' ? $this->session->flashdata('ssn_invalid_error') : ""; ?>
                        <?php echo $this->session->flashdata('ssn_digit_error') != '' ? $this->session->flashdata('ssn_digit_error') : ""; ?>
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                    <button type="submit" class="btn btn-primary block full-width m-b">Verify</button>
                </form>
                <?php } ?>
            </div>
        </div>
        <div class="text-center">&copy; 2018 taxleaf.com - All Rights Reserved Login</div>

        <!-- Mainly scripts -->
        <script src="<?php echo base_url() ?>assets/js/jquery-2.1.1.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>
        <script type="text/javascript">
            function check_character_count(){
                var str = $("#ssn_no").val().length;
                if(str>6){
                    $(".ssn_invalid_error").remove();
                    $("#ssn_no").after('<div class="text-danger ssn_invalid_error">You cannot input more than 6 digits</div>');
                    $("#ssn_no").val($("#ssn_no").val().substr(0, 6));
                }else{
                    $(".ssn_invalid_error").remove();
                }
            }
        </script>
    </body>

</html>