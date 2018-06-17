	<?php
		$pilih = $this->input->get('pl');
	?>
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1 class="hit-the-floor"><center><?php if($pilih == 'wali') echo 'Daftar Wali Kelas'; else echo 'Daftar Kelas';?></center></h1>
			<ol class="breadcrumb">
				<li>
					<a href="home">
						<img src="<?php echo base_url();?>utama/assists/images/icons/house.png" width=24 height=24> Home
					</a>
				</li>
				<li class="active">
				<?php 
					if($pilih == 'wali')
						echo '<img src="'.base_url().'utama/assists/images/icons/group.png" width=24 height=24> Wali Kelas';
					else
						echo '<img src="'.base_url().'utama/assists/images/icons/table.ico" width=24 height=24> Kelas';
				?>
				</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
            <div class="row" id="idDataWali"></div>
			
		</section>
	</div>
	
	<!-- Modal Edit User Block -->
	<div class="modal fade in" id="editWaliModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="border-radius: 15px;"></div>

	<script>
		$(document).ready(function()
		{
			stopTimer();
			showDataAll('pl=wali&id=<?php echo $pilih;?>');
		});
	</script>
	
		
