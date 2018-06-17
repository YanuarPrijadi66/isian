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
		
		<script src="<?php echo base_url();?>utama/assets/js/myscript.js"></script>
		
	</head>

	<?php
		$induk = $this->session->userdata('username');
		$nama  = $this->session->userdata('nama');
	?>

	<!--
	<body class="hold-transition skin-blue fixed sidebar-mini">
	-->
	<body class="skin-blue fixed" data-spy="scroll" data-target="#scrollspy">
		<div id="loader" style="display: none">
		</div>
		<!-- Modal Edit Siswa Block -->
		<div class="modal fade in" id="editSiswaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="border-radius: 15px;"></div>
		<!-- Modal Keperluan Suket -->
		<div class="modal fade in" id="showSuketModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="border-radius: 15px;"></div>
		<div class="wrapper">
			<header class="main-header">
				<!-- Logo -->
				<a href="home" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><b>Isian</b></span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><b>Isian Siswa</b></span>
				</a>

				<!-- Header Navbar: style can be found in header.less --
				<nav class="navbar navbar-static-top">
				-->
				<nav class="navbar navbar-static-top" role="navigation" style="height:50px;">
					<!-- Sidebar toggle button--
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					-->
					<a href="#" data-toggle="offcanvas" role="button">
						<img src="<?php echo base_url();?>utama/assists/images/icons/application_side_list.png" width=28 height=28 style="margin-top:10px;margin-left:10px;">
						<span class="sr-only">Toggle navigation</span>
					</a>

					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="<?php echo base_url();?>utama/assists/photos/home.png" width=24 height=24 class="img-circle" alt="User Image">
									<span class="hidden-xs"><font color="red"><b><i><?php echo $nama;?></i></b></font></span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
										<img src="<?php echo base_url();?>utama/assists/photos/home.png" class="img-circle" alt="User Image">
										<p><?php echo $nama.' - Siswa'?></p>
									</li>
									<li class="user-footer">
										<div class="pull-left">
											<a href="profil" class="btn btn-default btn-flat">Profile</a>
										</div>
										<div class="pull-right">
											<a href="logout" class="btn btn-default btn-flat">Sign out</a>
										</div>
									</li>
								</ul>
							</li>
							<!-- Control Sidebar Toggle Button -->
							<li>
								<a href="#" data-toggle="control-sidebar">
									<img src="<?php echo base_url();?>utama/assists/images/icons/configuration.ico" width=28 height=28 style="margin-top:-6px;">
								</a>
							</li>
						</ul>
					</div>
				</nav>
			</header>

	<!-- ------------------------------------------------------------------------------------------
	--                                       Batas Akhir Header                                  --
	------------------------------------------------------------------------------------------- -->

