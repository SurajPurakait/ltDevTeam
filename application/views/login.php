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
                <p>Sign in to start your session</p>
                <?php echo $this->session->flashdata('auth_error') != '' ? $this->session->flashdata('auth_error') : ""; ?>
                <form class="m-t" role="form" action="<?php echo base_url() ?>home/checkpost" method="post">
                    <div class="form-group">
                        <input type="text" name="login[user]" class="form-control" placeholder="Username" autofocus>
                        <?php echo $this->session->flashdata('username_error') != '' ? $this->session->flashdata('username_error') : ""; ?>
                    </div>
                    <div class="form-group">
                        <input type="password" name="login[password]" class="form-control" placeholder="Password">
                        <?php echo $this->session->flashdata('password_error') != '' ? $this->session->flashdata('password_error') : ""; ?>
                    </div>
                    <input type="hidden" name="action" value="login">
                    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                </form>
                Forgot Password <a href="<?php echo base_url();?>home/forgot_password">Click Here</a>
            </div>
        </div>
        <div class="text-center">&copy; 2018 taxleaf.com - All Rights Reserved Login</div>

        <!-- Mainly scripts -->
        <script src="<?php echo base_url() ?>assets/js/jquery-2.1.1.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>

    </body>

</html>