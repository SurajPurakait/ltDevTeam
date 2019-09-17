<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
    <input type="hidden" value="<?php echo base_url(); ?>" id="base_url">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon-->
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url() ?>assets/img/favicon.ico" type="image/x-icon">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?php echo base_url() ?>assets/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

    <!-- Forms plugins -->
    <link href="<?php echo base_url() ?>assets/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/cropper/cropper.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/nouslider/jquery.nouislider.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/ionRangeSlider/ion.rangeSlider.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css"
          rel="stylesheet">

    <link href="<?php echo base_url() ?>assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">

    <link href="<?php echo base_url() ?>assets/css/loading.css" rel="stylesheet">

    <!-- sweetalert -->
    <link href="<?php echo base_url() ?>assets/js/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet">
     <!-- c3 pie chart -->
     <link href="<?php echo base_url() ?>assets/css/plugins/c3/c3.min.css" rel="stylesheet">

    <script src="<?php echo base_url() ?>assets/js/plugins/sweetalert-master/dist/sweetalert.min.js"></script>
    <!-- Mainly scripts -->
    <script src="<?php echo base_url() ?>assets/js/scripts.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/jeditable/jquery.jeditable.js"></script>
    
    <!-- sweetalert -->
    <script src="<?php echo base_url() ?>assets/js/plugins/sweetalert-master/dist/sweetalert.min.js"></script>
    <!-- Data Tables -->
    <script src="<?php echo base_url() ?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url() ?>assets/js/inspinia.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/pace/pace.min.js"></script>

    <!-- Chosen -->
    <script src="<?php echo base_url() ?>assets/js/plugins/chosen/chosen.jquery.js"></script>

    <!-- pie chart -->
    <script src="<?php echo base_url() ?>assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    
     <script src="<?php echo base_url() ?>assets/js/plugins/c3/c3.min.js"></script>

    <!-- JSKnob -->
    <script src="<?php echo base_url() ?>assets/js/plugins/jsKnob/jquery.knob.js"></script>

    <!-- Input Mask-->
    <script src="<?php echo base_url() ?>assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>

    <!-- Data picker -->
    <script src="<?php echo base_url() ?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- NouSlider -->
    <script src="<?php echo base_url() ?>assets/js/plugins/nouslider/jquery.nouislider.min.js"></script>

    <!-- Switchery -->
    <script src="<?php echo base_url() ?>assets/js/plugins/switchery/switchery.js"></script>

    <!-- IonRangeSlider -->
    <script src="<?php echo base_url() ?>assets/js/plugins/ionRangeSlider/ion.rangeSlider.min.js"></script>

    <!-- iCheck -->
    <script src="<?php echo base_url() ?>assets/js/plugins/iCheck/icheck.min.js"></script>

    <!-- MENU -->
    <script src="<?php echo base_url() ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Color picker -->
    <script src="<?php echo base_url() ?>assets/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

    <!-- Image cropper -->
    <script src="<?php echo base_url() ?>assets/js/plugins/cropper/cropper.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/js/plugins/jquery-ui/jquery-ui.css">
    <script src="<?php echo base_url() ?>assets/js/plugins/jquery-ui/jquery-ui.js"></script>

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/plugins/select2/select2.css">
    <script src="<?php echo base_url() ?>assets/js/plugins/select2/select2.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="<?php echo base_url() ?>assets/js/modal.js"></script>
    <script src="<?php echo base_url() ?>assets/js/administration.js"></script>
    <script src="<?php echo base_url() ?>assets/js/lead_management.js"></script>
    <script src="<?php echo base_url() ?>assets/js/system.js"></script>
    <script src="<?php echo base_url() ?>assets/js/services.js"></script>
    <script src="<?php echo base_url() ?>assets/js/main_services.js"></script>
    <script src="<?php echo base_url() ?>assets/js/videos.js"></script>
    <script src="<?php echo base_url() ?>assets/js/action.js"></script>
    <script src="<?php echo base_url() ?>assets/js/billing.js"></script>
    <script src="<?php echo base_url() ?>assets/js/referral_partner.js"></script>
    <script src="<?php echo base_url() ?>assets/js/marketing.js"></script>


    <script src="<?php echo base_url() ?>assets/datepicker.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/datepicker.css">
    <script>
        $(function () {
            $('.hello').datepicker({
                autoHide: true,
            });
        });
        $(window).bind("load", function () {
            $('#loading_modal').css('display', 'none');
        });
    </script>
</head>

<body>
    <div class="modal_loading" id="loading_modal" style="display: block;">
        <div class="cssload-thecube">
            <div class="cssload-cube cssload-c1"></div>
            <div class="cssload-cube cssload-c2"></div>
            <div class="cssload-cube cssload-c4"></div>
            <div class="cssload-cube cssload-c3"></div>
        </div>
        <h2 class="text-center"><strong>Loading.. !</strong> Please Wait.</h2>
    </div>
    <div class="loader-mini"><div class="loading-text"><i class="fa fa-refresh fa-spin fa-fw"></i> Please wait. Loading...</div></div>
    <div id="wrapper">
        <?php
        if ($title != 'Owner | Tax Leaf') {
            $this->load->view('incl/menu.php', array('menu' => $menu, 'main_menu' => $main_menu));
        }
        ?>
        <div id="page-wrapper" class="gray-bg <?php echo ($title == 'Owner | Tax Leaf') ? ' no-margins' : ''; ?>">
            <div class="row" <?php echo ($title == 'Owner | Tax Leaf') ? 'style="display:none;"' : ''; ?>>
                <div class="taxleaf-small-logo"><img src="<?php echo base_url() ?>assets/img/logo-small.png"></div>
                <nav class="navbar navbar-static-top fixed-nav" role="navigation" style="margin-bottom: 0;">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="javascript:void(0);"><i class="fa fa-bars"></i>
                        </a>

                    </div>
                    <div class="row wrapper border-bottom white-bg page-heading">
                        <div class="">
                            <h2><?php echo ucwords(str_replace("_", " ", $main_menu)); ?></h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="<?php echo base_url() ?>home/dashboard">Home</a>
                                </li>
                                <?php
                                if (isset($main_menu)) {
                                    ?>
                                    <li class="active">
                                        <strong><?php echo $header_title; ?></strong>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li class="active">
                                        <strong>Home</strong>
                                    </li>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>

                </nav>
            </div>
