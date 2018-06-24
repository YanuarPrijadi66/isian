	<?php
		$level = $this->session->userdata('level');
		$nama  = $this->session->userdata('nama');
	?>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1 class="hit-the-floor"><b><i>Home</i></b></h1>
					<ol class="breadcrumb">
						<li class="active">
							<img src="<?php echo base_url();?>utama/assists/images/icons/house.png" width=24 height=24> Home
						</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Header -->
					<h2><strong><font color="green"><center><div id="idJam"></div></center></font></strong></h2>
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
						<strong><center>Selamat datang <font color="blue"><?php echo $nama;?></font></center></strong>
					</h2>
					<?php
						/*
						session_start();
						echo '<pre>Session :<br/>' . print_r($_SESSION, true) . '</pre>';
						echo '<pre>Cookie  :<br/>' . print_r($_COOKIE, true) . '</pre>';
						*/
					?>
				</section>
				<!-- ./inner Main -->
			</div>
			<!-- ./main -->

