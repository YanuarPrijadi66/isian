	<?php
		$level = $this->session->userdata('level');
		$induk = $this->session->userdata('username');
		$nama  = $this->session->userdata('nama');
	?>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header hit-the-floor">
					<h1 class="hit-the-floor">Home</h1>
					<ol class="breadcrumb">
						<li class="active">
							<a href="#">
								<img src="<?php echo base_url();?>utama/assists/images/icons/house.png" width=24 height=24> Home
							</a>
						</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Header -->
					<h2 style="color: blue;text-shadow: 1px 1px 2px yellow, 0 0 25px green, 0 0 5px darkgreen;">
						<strong><center><div id="idJam"></div></center></strong>
					</h2>
					<hr />
					<input type="hidden" id="lapel" name="lapel" value="<?php echo $level;?>">
					<?php
						date_default_timezone_set("Asia/Jakarta");
				
						$waktu = intval(date("G"));
						if(($waktu < 10) and ($waktu > 4))
							echo '<h2 style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
								<strong><center>Selamat Pagi</center></strong></h2>';
						elseif($waktu < 17)
							echo '<h2 style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
								<strong><center>Selamat Siang</center></strong></h2>';
						elseif($waktu < 20)
							echo '<h2 style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
								<strong><center>Selamat Sore</center></strong></h2>';
						else
							echo '<h2 style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
								<strong><center>Selamat Malam</center></strong></h2>';
					?>
					<br/>
					<h2 style="color: yellow;text-shadow: 1px 1px 2px yellow, 0 0 25px green, 0 0 5px darkgreen;">
						<strong><center>Selamat datang - <?php echo $nama;?></center></strong>
					</h2>
				</section>
			</div>
			<!-- ./main -->
	
