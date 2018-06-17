	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1 class="hit-the-floor"><font color="red">Data Presensi</font></h1>
			<ol class="breadcrumb">
				<li>
					<a href="home">
						<img src="<?php echo base_url();?>utama/assists/images/icons/house.png" width=24 height=24> Home
					</a>
				</li>
				<li class="active">
					<img src="<?php echo base_url();?>utama/assists/images/icons/calendar_multi_week.ico" width=24 height=24> Presensi Siswa
				</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
            <div class="row" id="presensiSiswaId"></div>
			
		</section>
	</div>
	
	<!-- Modal Edit User Block -->
	<div class="modal fade in" id="cetakSiswaPresensi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="border-radius: 15px;"></div>

	<script>
		$(document).ready(function()
		{
			stopTimer();
			showSiswaPresensi();
		});
	</script>
	
		
