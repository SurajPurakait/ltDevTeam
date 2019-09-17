<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tax Leaf | Forgot Password</title>
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
                <form class="m-t" role="form" action="<?php echo base_url();?>home/check_username" method="post">
                    <div class="form-group">
                        <div class="form-group">
                        <input type="text" name="forgot_password[user]" class="form-control" placeholder="Username" autofocus>
                        <?php echo $this->session->flashdata('username_error') != '' ? $this->session->flashdata('username_error') : ""; ?>
                    </div>
                    <input type="hidden" name="action" value="forgot_password">
                    <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>
                 </div>
                </form>
                <a class="btn btn-primary block full-width m-b" href="<?php echo base_url();?>">Back</a>
                
           
        </div>
        <div class="text-center">&copy; 2018 taxleaf.com - All Rights Reserved Login</div>

        <!-- Mainly scripts -->
        <script src="<?php echo base_url() ?>assets/js/jquery-2.1.1.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>

    </body>

</html>