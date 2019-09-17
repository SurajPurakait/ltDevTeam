<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tax Leaf | Change Password</title>
        <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/css/animate.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
    </head>
    <body class="gray-bg login-bubble">
        <div class="middle-box text-center animated fadeInDown">
            <div class="irs-peeking-out"></div>
            <div class="loginscreen">
                <div>
                    <img src="<?= base_url() ?>assets/img/logo.png"><hr>
                </div>
                <p class="text-danger">Your session has been expired, please reset your password! </p>
                <?= $this->session->flashdata('auth_error') != '' ? $this->session->flashdata('auth_error') : ""; ?>
                <form class="m-t" role="form" action="<?= base_url() ?>home/change_password_new/<?= $id ?>" method="post">
                    <input type="hidden" value="<?= $id;?>">
                    <div class="form-group">
                        <input type="password" name="change_password[old_password]" class="form-control" placeholder="Old password" autofocus>
                        <?= $this->session->flashdata('old_password_error') != '' ? $this->session->flashdata('old_password_error') : ""; ?>
                    </div>
                    <div class="form-group">
                        <input type="password" name="change_password[new_password]" class="form-control" placeholder="New Password">
                        <?= $this->session->flashdata('new_password_error') != '' ? $this->session->flashdata('new_password_error') : ""; ?>
                    </div>
                    <div class="form-group">
                        <input type="password" name="change_password[retype_password]" class="form-control" placeholder="Retype Password">
                        <?= $this->session->flashdata('retype_password_error') != '' ? $this->session->flashdata('retype_password_error') : ""; ?>
                    </div>
                    <input type="hidden" name="action" value="change_password">
                    <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>
                </form>                
            </div>
        </div>
        <div class="text-center">&copy; <?= date('Y'); ?> taxleaf.com - All Rights Reserved Login</div>
        <script src="<?= base_url() ?>assets/js/jquery-2.1.1.js"></script>
        <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
    </body>
</html>