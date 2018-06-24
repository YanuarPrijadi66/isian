<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Siswa - Isian Siswa</title>
		<link rel="shortcut icon" href="<?php echo base_url();?>utama/assists/images/jatim2.png" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>utama/assets/css/style.css" />

		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.6 -->
		<link rel="stylesheet" href="<?php echo base_url();?>utama/assets/adminlte2/bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo base_url();?>utama/assets/font-awesome/css/font-awesome.min.css">
		<!-- Ionicons --
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<!-- jvectormap --
		<link rel="stylesheet" href="<?php echo base_url();?>utama/assets/adminlte2/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo base_url();?>utama/assets/adminlte2/dist/css/AdminLTE.min.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
			folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="<?php echo base_url();?>utama/assets/adminlte2/dist/css/skins/_all-skins.min.css">

		<!-- Alertify -->
		<link rel="stylesheet" href="<?php echo base_url();?>utama/assets/alertify/themes/alertify.core.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>utama/assets/alertify/themes/alertify.default.css" id="toggleCSS" />
		<script src="<?php echo base_url();?>utama/assets/alertify/lib/alertify.min.js"></script>

		<!-- Sweet Alert -->
		<script src="<?php echo base_url();?>utama/assets/sweetalert/dist/sweetalert.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>utama/assets/sweetalert/dist/sweetalert.css">
	
		<!-- jQuery 2.2.3 -->
		<script src="<?php echo base_url();?>utama/assets/adminlte2/plugins/jQuery/jquery-2.2.3.min.js"></script>
		
		<script src="<?php echo base_url();?>utama/assets/js/myscript.min.js"></script>
		
	</head>

	<?php
		$induk = $this->session->userdata('username');
		$nama  = $this->session->userdata('nama');
	?>

	<!--
	<body class="hold-transition skin-blue fixed sidebar-mini">
	-->
	<body class="skin-blue fixed" data-spy="scroll" data-target="#scrollspy">
	
		<div id="loader" style="display: none"></div>
		<div id="idHeaderSiswa"></div>
		

