<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tax Leaf | New Password</title>
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

                <form class="m-t" role="form" action="<?php echo base_url(); ?>home/update_password/<?php echo $id ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="password" autofocus>
                            <?php echo $this->session->flashdata('password_error') != '' ? $this->session->flashdata('password_error') : ""; ?>
                        </div>
                        <div class="form-group">
                            <input type="password" name="retype_password" class="form-control" placeholder="retype password" autofocus>
                            <div class="errorMessage text-danger"><?php echo $this->session->flashdata('retype_password_error') != '' ? $this->session->flashdata('retype_password_error') : ""; ?>
                            <?php echo $this->session->flashdata('update_password_error') != '' ? $this->session->flashdata('update_password_error') : ""; ?></div>
                        </div>
                        <input type="hidden" name="action" value="forgot_password">
                        <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>
                    </div>

                </form>
                <a class="btn btn-primary block full-width m-b" href="<?php echo base_url(); ?>">Back</a>


            </div>
            <div class="text-center">&copy; 2018 taxleaf.com - All Rights Reserved Login</div>

            <!-- Mainly scripts -->
            <script src="<?php echo base_url() ?>assets/js/jquery-2.1.1.js"></script>
            <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>

    </body>

</html>