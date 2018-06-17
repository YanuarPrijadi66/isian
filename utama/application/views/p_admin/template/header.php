<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Admin - Isian Siswa</title>
		<link rel="shortcut icon" href="<?php echo base_url();?>utama/assists/images/jatim2.png" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>utama/assets/css/style.css" />

		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		
		<!-- Bootstrap 3.3.6 -->
		<link rel="stylesheet" href="<?php echo base_url();?>utama/assets/adminlte2/bootstrap/css/bootstrap.min.css">
		
		<!-- Ionicons --
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo base_url();?>utama/assets/font-awesome/css/font-awesome.min.css">
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
		<!-- Bootstrap 3.3.6 -->
		<script src="<?php echo base_url();?>utama/assets/adminlte2/bootstrap/js/bootstrap.min.js"></script>
		<!-- FastClick -->
		<script src="<?php echo base_url();?>utama/assets/adminlte2/plugins/fastclick/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="<?php echo base_url();?>utama/assets/adminlte2/dist/js/app.min.js"></script>
		<!-- My Script -->
		<script src="<?php echo base_url();?>utama/assets/js/myscript.js"></script>
		
		<style>
			/* Center the loader */
			/* Add animation to "page content" */
			.animate-bottom 
			{
				position: relative;
				-webkit-animation-name: animatebottom;
				-webkit-animation-duration: 1s;
				animation-name: animatebottom;
				animation-duration: 1s
			}

			@-webkit-keyframes animatebottom 
			{
				from { bottom:-100px; opacity:0 } 
				to { bottom:0px; opacity:1 }
			}

			@keyframes animatebottom 
			{ 
				from{ bottom:-100px; opacity:0 } 
				to{ bottom:0; opacity:1 }
			}

			#myDiv 
			{
				display: none;
				text-align: center;
			}
		</style>
		
		<?php
			$nama = $this->session->userdata('nama');
			$username = $this->session->userdata('username');
		?>
			
	<body class="hold-transition skin-purple fixed" data-spy="scroll" data-target="#scrollspy">

		<div id="loader" style="display: none;"></div>
		
		<div class="wrapper">
			<header class="main-header">
				<!-- Logo -->
				<a href="home" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><b>Isian</b></span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><b>Isian Siswa</b></span>
				</a>

				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>

					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="<?php echo base_url();?>utama/assists/photos/home.png" class="user-image" alt="User Image">
										<span class="hidden-xs"><font color="red"><b><i><?php echo $nama;?></i></b></font></span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
										<img src="<?php echo base_url();?>utama/assists/photos/home.png" class="img-circle" alt="User Image">
											<p><?php echo $nama;?> - Admin</p>
									</li>
									<!-- Menu Footer-->
									<li class="user-footer">
										<div class="pull-left">
											<a href="#" class="btn btn-default btn-flat">Profile</a>
										</div>
										<div class="pull-right">
											<a href="logout" class="btn btn-default btn-flat">Sign out</a>
										</div>
									</li>
								</ul>
							</li>
							<!-- Control Sidebar Toggle Button --
							<li>
								<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
							</li>
							-->
						</ul>
					</div>
					
				</nav>
			</header>

	<!-- ------------------------------------------------------------------------------------------
	--                                       Batas Akhir Header                                  --
	------------------------------------------------------------------------------------------- -->
	
