	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1 class="hit-the-floor"><b><i>Data Pelanggaran</i></b></h1>
			<ol class="breadcrumb">
				<li>
					<a href="home">
						<img src="<?php echo base_url();?>utama/assists/images/icons/house.png" width=24 height=24> Home
					</a>
				</li>
				<li class="active">
					<img src="<?php echo base_url();?>utama/assists/images/icons/stop2.ico" width=24 height=24> Pelanggaran
				</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
            <div class="row" id="langgarSiswaId"></div>
			
		</section>
	</div>
	
	<script>
		$(document).ready(function()
		{
			stopTimer();
			showSiswaLanggar();
		});
	</script>
	
		
