		<?php
			$nama = $this->session->userdata('nama');
		?>
		
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
			
				<!-- Sidebar user panel -->
				<div class="user-panel">
					<div class="pull-left image">
						<img src="<?php echo base_url();?>utama/assists/photos/home.png" class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
						<p><font color="red"><b><i><?php echo $nama;?></i></b></font></p>
						<a href="#"><i class="glyphicon glyphicon-record text-green"></i> Online</a>
					</div>
				</div>
				<!-- /.sidebar user panel -->
				
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu" id="ulNavMenu">
				</ul>
			</section>
			<!-- /.sidebar -->
		</aside>

	<!-- ------------------------------------------------------------------------------------------
	--                                   Batas Akhir Navigation                                  --
	------------------------------------------------------------------------------------------- -->
	
	<script>
		$(document).ready(function()
		{
			showNavAdmin();
		});
	</script>

	
