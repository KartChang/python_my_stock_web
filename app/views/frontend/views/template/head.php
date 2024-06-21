<?php
?>
<?php if(ENVIRONMENT == 'development'):?>
        
        <meta name="robots" content="noindex,nofollow">
        <meta name="googlebot" content="noindex,nofollow">
<?php endif;?>

        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title><?php echo config_item('webTitle')?></title>
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/google_fonts.css">
        
        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/font-awesome5.10.0.css">
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-icons1.4.1.css">

        <!-- Libraries Stylesheet -->
        <link href="<?php echo base_url()?>assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <!-- <link href="<?php echo base_url()?>assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" /> -->

        <!-- Customized Bootstrap Stylesheet -->
        <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="<?php echo base_url()?>assets/css/style.css" rel="stylesheet">
        
        <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.css">

        <style type="text/css" lang="scss">
            :root {
                --primary: #FFFFFF;
                --light: #AAA;
                --normal-font-color: #DDD;
                --normal-bg-color: #191C24;
            }

            body {
                color: var(--normal-font-color);
            }

            .border {
                border: 1px solid #666 !important;
            }

            a {
                color: #AAA;
                text-decoration: none;
            }

            a:hover{
                color: #FFF;
            }

            .btn-secondary {
                color: #fff;
                background-color: #333;
                border-color: #333;
            }

            .table {
                --bs-table-bg: rgba(0,0,0,0);
                --bs-table-striped-color: var(--normal-font-color);
                --bs-table-striped-bg: rgba(0,0,0,0.05);
                --bs-table-active-color: var(--normal-font-color);
                --bs-table-active-bg: rgba(0,0,0,0.1);
                --bs-table-hover-color: var(--normal-font-color);
                --bs-table-hover-bg: rgba(150,150,150,0.2);
                width: 100%;
                margin-bottom: 1rem;
                color: var(--normal-font-color);
                vertical-align: top;
                border-color: #000;
            }
            
            .modal-content {
                background-color: var(--normal-bg-color);
            }

            .btn-close {
                background-color: #666;
            }

            .card-header {
                background-color: rgba(0,0,0,0.35);
            }

            label.error {
                font-size: 12px;
                color: red;
            }
        </style>
        