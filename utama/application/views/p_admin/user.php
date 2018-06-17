	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1 class="hit-the-floor"><center>Data User Admin</center></h1>
			<ol class="breadcrumb">
				<li>
					<a href="home">
						<img src="<?php echo base_url();?>utama/assists/images/icons/house.png" width=24 height=24> Home
					</a>
				</li>
				<li class="active">
					<img src="<?php echo base_url();?>utama/assists/images/icons/List.ico" width=24 height=24> Data Admin
				</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
            <div class="row" id="idDataAdmin"></div>
			
		</section>
	</div>
	
	<!-- Modal Edit User Block -->
	<div class="modal fade in" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="border-radius: 15px;"></div>

	<script>
		$(document).ready(function()
		{
			stopTimer();
			showDataAll('pl=admin&m=1');
		});
	</script>
	
		
