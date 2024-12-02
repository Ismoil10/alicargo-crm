<?$template_path = '/core/template_viho/';?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EvoBot CRM is a platform made by Evosoft Soltuions LLC">
    <meta name="keywords" content="Enjoy making your own bot without writing code">
    <meta name="author" content="Evosoft Solutions">
    <link rel="icon" href="<?=$template_path?>assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?=$template_path?>assets/images/favicon.png" type="image/x-icon">
    <title>EvoBot - CRM</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/chartist.css">
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/date-picker.css">
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/prism.css">
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/vector-map.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/style.css">
    <link id="color" rel="stylesheet" href="<?=$template_path?>assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/css/datatables.css">
	
	<link rel="stylesheet" type="text/css" href="<?=$template_path?>assets/js/select2/select2.min.css">
  
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.1/css/lightbox.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">	
	<!-- JQUERY -->
	
	<script src="<?=$template_path?>assets/js/jquery-3.5.1.min.js"></script>
  </head>
  
  <?if ($_SESSION['user']['id']!=NULL) {require 'navbar.php';}?>