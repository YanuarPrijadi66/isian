<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('m_data');
    }
	
	// =========================
	// # Fungsi Navigasi Admin #
	// =========================
	function showHeaderAdmin()
	{
			$nama = $this->session->userdata('nama');
		$level    = $this->session->userdata('level');
		$username = $this->session->userdata('username');
		if($level == 94)
		{
			$query = $this->db->select('*')
					->from('tb_wali')
					->where('kd_guru', $username)
					->get();
			$hasil = $query -> num_rows();
			if($hasil > 0)
			{
				$row = $query->row();
				$kelas = $row->kelas;
			}
			
		}
		echo
		'<div class="wrapper">
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
									<img src="'.base_url().'utama/assists/photos/home.png" class="user-image" alt="User Image">
										<span class="hidden-xs"><font color="red"><b><i>'.$nama.'</i></b></font></span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
										<img src="'.base_url().'utama/assists/photos/home.png" class="img-circle" alt="User Image">
											<p>'.$nama.' - ';if($level > 95) echo 'Admin'; else echo 'Wali Kls'; echo '</p>
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

			<!-- Left side column. contains the logo and sidebar -->
			<aside class="main-sidebar">
				<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">
			
					<!-- Sidebar user panel -->
					<div class="user-panel">
						<div class="pull-left image">
							<img src="'.base_url().'utama/assists/photos/home.png" class="img-circle" alt="User Image">
						</div>
						<div class="pull-left info">
							<p><font color="red"><b><i>'.$nama.'</i></b></font></p>
							<a href="#"><i class="glyphicon glyphicon-record text-green"></i> Online</a>
						</div>
					</div>
					<!-- /.sidebar user panel -->
				
					<!-- sidebar menu: : style can be found in sidebar.less -->
					<ul class="sidebar-menu" id="ulNavMenu">
						<li class="header">MAIN NAVIGATION</li>
						<li>
							<a href="home">
								<img src="'.base_url().'utama/assists/images/icons/house.png" width=24 height=24>
								&nbsp;Beranda
							</a>
						</li>
						<li class="treeview">
							<a href="#">
								<img src="'.base_url().'utama/assists/images/icons/community.ico" width=24 height=24>
								<span>Data</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li>
									<a href="#" onclick="showDataSekolah()">
										<img src="'.base_url().'utama/assists/images/icons/house.png" width=24 height=24>
										&nbsp;Data Sekolah
									</a>
								</li>
								<li>
									<a href="#" onclick="showDataKKM()">
										<img src="'.base_url().'utama/assists/images/icons/property.ico" width=24 height=24>
										&nbsp;Data Ketuntasan
									</a>
								</li>';
								if($level > 95)
									echo
								'<li>
									<a href="awal?pl=admin">
										<img src="'.base_url().'utama/assists/images/icons/administrator.png" width=24 height=24>
										&nbsp;Data Admin
									</a>
								</li>';
								echo
								'<li>
									<a href="awal?pl=wali&pl1=kelas">
										<img src="'.base_url().'utama/assists/images/icons/table.ico" width=24 height=24>
										&nbsp;Data Kelas
									</a>
								</li>
								<li>
									<a href="awal?pl=wali&pl1=wali">
										<img src="'.base_url().'utama/assists/images/icons/group.png" width=24 height=24>
										&nbsp;Data Walikelas
									</a>
								</li>
								<li>
									<a href="#">
										<img src="'.base_url().'utama/assists/images/icons/group.png" width=24 height=24>
										<span>Data Siswa</span>
										<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu">
										<li>
											<a href="awal?pl=siswa">
												<img src="'.base_url().'utama/assists/images/icons/personal-information.ico" width=24 height=24>
												&nbsp;Data Siswa
											</a>
										</li>';
										if($level > 95)
											echo
										'<li>
											<a href="#" id="siswa" onclick="showImportData(this)">
												<img src="'.base_url().'utama/assists/images/icons/database_add.png" width=24 height=24>
												&nbsp;Import Data
											</a>
										</li>
										<li>
											<a href="exportData?pl=datasiswa">
												<img src="'.base_url().'utama/assists/images/icons/file_extension_xls.png" width=24 height=24>
												&nbsp;Export Data
											</a>
										</li>';
										echo
									'</ul>
								</li>
							</ul>
						</li>
						<li class="treeview">
							<a href="#">
								<img src="'.base_url().'utama/assists/images/bk.png" width=24 height=24>
								<span>Counseling</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li>
									<a href="awal?pl=presensi">
										<img src="'.base_url().'utama/assists/images/icons/calendar_multi_week.ico" width=24 height=24>
										&nbsp;Absensi / Presensi
									</a>
								</li>
								<li>
									<a href="awal?pl=langgar">
										<img src="'.base_url().'utama/assists/images/icons/stop2.ico" width=24 height=24>
										&nbsp;Pelanggaran
									</a>
								</li>
							</ul>
						</li>
						<li class="treeview">
							<a href="#">
								<img src="'.base_url().'utama/assists/images/icons/address-book.ico" width=24 height=24>
								<span>Penilaian</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li>
									<a href="awal?pl=ulangan">
										<img src="'.base_url().'utama/assists/images/icons/event.ico" width=24 height=24>
										&nbsp;Ulangan Harian
									</a>
								</li>
								<li>
									<a href="awal?pl=rapor">
										<img src="'.base_url().'utama/assists/images/icons/address-book.ico" width=24 height=24>
										&nbsp;Nilai Rapor
									</a>
								</li>
							</ul>
						</li>';
						if($level > 95)
							echo
						'<li>
							<a href="awal?pl=pesan">
								<img src="'.base_url().'utama/assists/images/icons/new-message.ico" width=24 height=24>
								&nbsp;Baca Pesan
							</a>
						</li>';
						echo
						'<li>
							<a href="logout">
								<img src="'.base_url().'utama/assists/images/icons/exit.png" width=24 height=24>
								&nbsp;Logout
							</a>
						</li>
					</ul>
				</section>
				<!-- /.sidebar -->
			</aside>
		</div>';

		exit;
	}
	
	// ===========================
	// # Fungsi Tampil Data Form #
	// ===========================
	function showDataAll()
	{
		$pilih = $this->input->get('pl');
		if(strtolower($pilih) == 'admin')		$this->showDataAdmin();
		elseif(strtolower($pilih) == 'siswa')	$this->showDataSiswa();
		elseif(strtolower($pilih) == 'pesan')	$this->showDataPesan();
		elseif(strtolower($pilih) == 'presensi')$this->showDataPresensi();
		elseif(strtolower($pilih) == 'langgar')	$this->showDataLanggar();
		elseif(strtolower($pilih) == 'rapor')	$this->showDataRapor();
		elseif(strtolower($pilih) == 'ulangan')	$this->showDataUlangan();
		elseif(strtolower($pilih) == 'wali')	$this->showDataWali();
		exit;
	}
		
	// ===================================
	// # Fungsi Tampilan Mengimport Data #
	// ===================================
	public function showImportData()
	{
		if(isset($_GET['id'])) 
			$pilih = $this->input->get('id'); 
		else 
			$pilih = 'siswa';
		$pilih1 = 'Data ' . $pilih;
		if(strtolower($pilih) == 'rapor') $pilih1 = 'Nilai Rapor';
		elseif(strtolower($pilih) == 'ulangan') $pilih1 = 'Nilai Ulangan';
		
		echo
		'<input type="hidden" id="pilih" name="pilih" value="'.$pilih.'">
		<!-- modal-dialog -->
		<div class="modal-dialog" role="document">
			<!-- modal-content -->
			<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
				<!-- modal header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title" id="isianUserLabel" style="margin-bottom:0px;margin-top:0px;color: yellow;text-shadow: 2px 2px 4px black, 0 0 25px white, 0 0 5px darkblue;">
						<center>
							<img src="'.base_url().'utama/assists/images/icons/file_extension_xls.png" width=36 height=36> <b>Import '.ucwords(strtolower($pilih1)).'</b>
						</center>
					</h3>
				</div>
				<!-- ./modal header -->

				<!-- modal body -->
				<div class="modal-body">
					<div class="panel panel-primary">
						<div class="panel-body">
							<font color="red"><b>Pilih File Excel (Excel 2003) :</b></font>
							<br /><br />
							<input type="file" id="namaFile" name="namaFile" accept=".xls">
							<br/>
							<label>
								<input type="checkbox" name="drop" id="drop" value="1" />
								&nbsp;&nbsp;<u>Kosongan '.ucwords(strtolower($pilih1)).' terlebih dahulu</u>
							</label>
							<br />
							<br />
							<p>*) <b>file yang bisa di import adalah xls (Excel 2003).</b></p>
							*) <font color="red"><b>Download contoh '.ucwords(strtolower($pilih1)).' ada disini <a href="dl_contoh?id='.$pilih.'">Contoh '.ucwords(strtolower($pilih1)).'</a></b></font>
							<br/>
						</div>
					</div>
				</div>
				<!-- ./modal body -->
							
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
						<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
					</button>
					<button type="button" id="'.$pilih.'" class="btn btn-primary" onClick="importData(this)" style="border-radius:8px;">
						<img src="'.base_url().'utama/assists/images/icons/save.ico" width=20 height=20> Import
					</button>
				</div>
				<!-- ./modal footer -->
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->';

		exit;
	}

	// ===========================
	// # Fungsi menghapus 1 item #
	// ===========================
	function hapusData()
	{
		$nomer = $this->input->get('id');
		$pilih = $this->input->get('pl');
		
		if(strtolower($pilih) == 'siswa')
		{
			$query = $this->db->select('*')
					->from('tb_siswa')
					->where('no_ujian_smp', $nomer)
					->get();
			if($query->num_rows() > 0)
				$this->db->where('no_ujian_smp', $nomer)->delete('tb_siswa');
		}
		elseif(strtolower($pilih) == 'admin')
		{
			$query = $this->db->select('*')
					->from('tb_admin')
					->where('username', $nomer)
					->get();
			if($query->num_rows() > 0)
				$this->db->where('username', $nomer)->delete('tb_admin');
		}
		elseif(strtolower($pilih) == 'langgar')
		{
			$query = $this->db->select('*')
					->from('tb_langgar')
					->where('no', $nomer)
					->get();
			if($query->num_rows() > 0)
				$this->db->where('no', $nomer)->delete('tb_langgar');
		}
		elseif(strtolower($pilih) == 'ulangan')
		{
			$query = $this->db->select('*')
					->from('tb_ulangan')
					->where('no', $nomer)
					->get();
			if($query->num_rows() > 0)
				$this->db->where('no', $nomer)->delete('tb_ulangan');
		}
		elseif(strtolower($pilih) == 'rapor')
		{
			$query = $this->db->select('*')
					->from('tb_nilai')
					->where('no', $nomer)
					->get();
			if($query->num_rows() > 0)
				$this->db->where('no', $nomer)->delete('tb_nilai');
		}
		elseif(strtolower($pilih) == 'pesan')
		{
			$query = $this->db->select('*')
					->from('tb_pesan')
					->where('urut', $nomer)
					->get();
			if($query->num_rows() > 0)
				$this->db->where('urut', $nomer)->delete('tb_pesan');
		}
		elseif(strtolower($pilih) == 'kelas')
		{
			$query = $this->db->select('*')
					->from('tb_kelas')
					->where('kd_kelas', $nomer)
					->get();
			if($query->num_rows() > 0)
				$this->db->where('kd_kelas', $nomer)->delete('tb_kelas');
			$query = $this->db->select('*')
					->from('tb_wali')
					->where('kelas', $nomer)
					->get();
			if($query->num_rows() > 0)
				$this->db->where('kelas', $nomer)->delete('tb_wali');
		}
		
		$outp[0] = 'sukses';
		$outp[1] = 'Sukses menghapus data';
		echo json_encode($outp);
		
		exit;
	}
	
	// ====================================================
	// # Fungsi menghapus semua data / mengosongkan tabel #
	// ====================================================
	function hapusDataAll()
	{
		$pilih = $this->input->get('id');
		$truncate = '';
		$outp = array();
		if(strtolower($pilih) == 'siswa')		$truncate = "TRUNCATE TABLE tb_siswa";
		elseif(strtolower($pilih) == 'admin')	$truncate = "TRUNCATE TABLE tb_admin";
		elseif(strtolower($pilih) == 'langgar')	$truncate = "TRUNCATE TABLE tb_langgar";
		elseif(strtolower($pilih) == 'rapor')	$truncate = "TRUNCATE TABLE tb_nilai";
		elseif(strtolower($pilih) == 'ulangan')	$truncate = "TRUNCATE TABLE tb_ulangan";
		elseif(strtolower($pilih) == 'pesan')	$truncate = "TRUNCATE TABLE tb_pesan";
		elseif(strtolower($pilih) == 'wali')	$truncate = "TRUNCATE TABLE tb_wali";
		elseif(strtolower($pilih) == 'kelas')	$truncate = "TRUNCATE TABLE tb_kelas";
		if($truncate != '')
		{
			$sql = $this->db->query($truncate);
			if(strtolower($pilih) == 'kelas')
				$sql = $this->db->query("TRUNCATE TABLE tb_wali");
			$outp[0] = 'sukses';
			$outp[1] = 'Tabel berhasil dikosongkan';
		}
		else
		{
			$outp[0] = 'error';
			$outp[1] = 'Tabel gagal dikosongkan';
		}
		$outp[2] = $pilih;
		echo json_encode($outp);

		exit;
	}

	// ===============================
	// # Fungsi Download contoh data #
	// ===============================
	public function dl_contoh() 
	{
		$pilih = $this->input->get('id');
		if(strtolower($pilih) == 'siswa')		$namafile = 'contoh_siswa_isian.xls';
		elseif(strtolower($pilih) == 'admin')	$namafile = 'contoh_admin_isian.xls';
		elseif(strtolower($pilih) == 'rapor')	$namafile = 'contoh_nilai_rapor.xls';
		elseif(strtolower($pilih) == 'ulangan')	$namafile = 'contoh_nilai_ulangan.xls';
		elseif(strtolower($pilih) == 'wali')	$namafile = 'contoh_wali_isian.xls';
		$target = './utama/assists/files/excel/'.$namafile;
		if(file_exists($target))
		{
			$this->load->helper('download');
			$data = file_get_contents($target);
			force_download($namafile, $data);
		}
		else redirect('home');
		exit;
	}
	
	// *********************************************************************************************
	// ***                                   Akhir Fungsi Umum                                   ***
	// *********************************************************************************************
	
	// *******************************************************************************************
	// ***                                   Awal Data Admin                                   ***
	// *******************************************************************************************
	function showDataAdmin()
	{
		$userAktif = $this->session->userdata('username');
		
		$pilih = $this->input->get('pl');
		if(isset($_GET['id'])) {$username = $_GET['id'];} else {$username = '';}
		if(isset($_GET['cr'])) {$cari = $_GET['cr'];} else {$cari = '';}
		if(isset($_GET['m']))  {$mulai = $_GET['m'];} else {$mulai = 1;}
		
		echo
                '<div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <center><b><i>Daftar Admin</i></b></center>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
									<tr style="background:green;color:yellow;">
										<th><center>No.</center></th>
										<th><center>Username</center></th>
										<th><center>Nama</center></th>
										<th><center>Status</center></th>
										<th><center>Login Akhir</center></th>
										<th><center>Sts Login</center></th>
										<th><center> # </center></th>
									</tr>
                                </thead>
                                <tbody>';
										$sts_log = array('Y' => 'Aktif', 'N' => 'Tdk Aktif');
										$jml_data = 20;
										$awal = ($mulai - 1) * $jml_data;
										$nomer = $awal;
										$query = $this->db->select('*')
												->from('tb_admin')
												->limit($jml_data, $awal)
												->order_by('status', 'desc')
												->order_by('nama', 'asc')
												->get();
										foreach($query->result() as $row)
										{
											$nomer++;
											$userid    = $row->username;
											$nama_admin = $row->nama;
											$status     = $row->status;
											$log_akhir  = $row->login_terakhir;
											$sts_login  = $row->login_status;
											if($userid == $userAktif)
												echo '<tr style="background:red;color:white;">';
											elseif($userid == $username)
												echo '<tr style="background:yellow;color:red;">';
											else
												echo '<tr class="gradeA">';
											echo
												'<td><center>'.$nomer.		'</center></td>
												<td><center><a href="#" id="'.$userid.'&m='.$mulai.'" onclick="editDataAdmin(this)">'.$userid.'</a></center></td>
												<td><a href="#" id="'.$userid.'&m='.$mulai.'" onclick="editDataAdmin(this)">'.$nama_admin.'</a></td>
												<td><center><a href="#" id="'.$userid.'&m='.$mulai.'" onclick="editDataAdmin(this)">'.$status.'</a></center></td>
												<td><center><a href="#" id="'.$userid.'&m='.$mulai.'" onclick="editDataAdmin(this)">'.$log_akhir.'</a></center></td>
												<td><center><a href="#" id="'.$userid.'&m='.$mulai.'" onclick="editDataAdmin(this)">'.$sts_log[$sts_login].'</a></center></td>';
											if($userid == $userAktif)
												echo
												'<td>&nbsp;</td>';
											else
												echo
												'<td><center>
													<a href="#" id="'.$userid.'&pl=admin" onclick="hapusData(this)">
														<img src="'.base_url().'utama/assists/images/icons/delete.ico" width=20 height=20>
													</a></center>
												</td>';
											echo
											'</tr>';
										}
										if($nomer == 0)
											echo
											'<tr style="background:red;color:yellow;">
												<td colspan="7"><b><center>Tidak ada data</center></b></td>
											</tr>';
									echo
								'</tbody>
							</table>
							<!--
							*) Anda dapat mempersiapkan dan mengedit data melalui microsoft Excel. Format file dapat di <a href="dl_contoh?id=admin">download disini</a><br />
							*) Rubahlah contoh diatas kemudian simpan dan <a href="#" id="admin" onClick="showImportData(this)">import disini.</a>
							-->
						</div>
						<center>';
							$query = $this->db->select('*')
									->from('tb_admin')
									->get();
							$rowcounts = $query->num_rows();
							$numpages  = ceil($rowcounts / $jml_data);
							$sisa      = $rowcounts % $jml_data;
							if($sisa > 0) $numpages++;
							$pagenow   = ceil($awal / $jml_data)+1;
							$nextpage  = $pagenow + 1;
							$lastpage  = $pagenow - 1;
							
							if($rowcounts > $jml_data)
							{
								if($pagenow <= 1)
									echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_start.png" width=24 height=24 style="margin-top:-4px;">
										</button>';
								else
									echo '<a href="#" id="pl=admin&m=1&cr='.$cari.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_start_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								if($pagenow <= 1)
									echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_rewind.png" width=24 height=24 style="margin-top:-4px;">
										</button>';
								else
									echo '<a href="#" id="pl=admin&m='.$lastpage.'&cr='.$cari.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_rewind_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								echo '<button type="button" class="btn btn-primary" disabled>'.$pagenow.'</button>';
								if($numpages > $pagenow)
									echo '<a href="#" id="pl=admin&m='.$nextpage.'&cr='.$cari.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_fastforward_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								else
									echo '<button type="button" class="btn btn-danger" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_fastforward.png" width=16 height=16>
										</button>';
								if($pagenow >= $numpages)
									echo '<button type="button" class="btn btn-danger" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_end.png" width=16 height=16>
										</button>';
								else
									echo '<a href="#" id="pl=admin&m='.$numpages.'&cr='.$cari.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_end_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
							}
								
						echo
						'</center>
						<br />
						<center>
							<a href="#" id="admin" class="btn btn-danger" onclick="hapusDataAll(this)">
								<img src="'.base_url().'utama/assists/images/icons/stop.ico" width=24 height=24> Hapus Semua Data
							</a>
							&nbsp;&nbsp;&nbsp;
							<a href="#" id="admin" class="btn btn-success" onclick="editDataAdmin(this)">
								<img src="'.base_url().'utama/assists/images/icons/add_card.ico" width=24 height=24> Tambah Data
							</a>
						</center>
						<br />
					</div>
				</div>';
		exit;
	}
	
	// =====================
	// # Fungsi Edit Admin #
	// =====================
	function showAdminModal()
	{
		$username = $this->input->get('id');
		
		if($username == 'admin')
		{
			$username = '';
			$password = '';
			$nama     = '';
			$status   = '';
		}
		else
		{
			$query = $this->db->select('*')
					->from('tb_admin')
					->where('username', $username)
					->get();
			$row = $query->row();
			$password = $this->m_data->decryptIt($row->password);
			$nama     = $row->nama;
			$status   = $row->status;
		}
		
		$sts_arr = array('Administrator', 'Admin', 'TU');
		
		echo
				'<!-- modal-dialog -->
				<div class="modal-dialog" role="document">
					<!-- modal-content -->
					<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
						<!-- modal header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title" id="isianAdminLabel" style="margin-bottom:0px;margin-top:0px;color: yellow;text-shadow: 2px 2px 4px black, 0 0 25px white, 0 0 5px darkblue;">
								<center><b>Edit Data Admin</b></center>
							</h3>
						</div>
						<!-- ./modal header -->

						<!-- modal body -->
						<div class="modal-body" id="isianDataAdmin">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Username :
										</label>
										<input type="text" class="form-control" name="username" id="username" value="'.$username.'">
									</div>
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Nama :
										</label>
										<input type="text" class="form-control" name="nama" id="nama" value="'.$nama.'">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<!-- /input-group -->
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Password :
										</label>
										<div class="input-group margin" style="margin-top:0px;margin-left:0px;">
											<input type="password" class="form-control" id="password" name="password" value="'.$password.'">
											<span class="input-group-btn">
												<button type="button" class="btn btn-info btn-flat" style="margin-top:-1px;height:35px;border-radius:6px;" onclick="showHidePass();">
													<i id="simbol" class="glyphicon glyphicon-eye-open"></i>
												</button>
											</span>
										</div>
										<!-- ./input-group -->
									</div>
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Level :
										</label>
										<select class="form-control" name="status" id="status">';
		for($i = 0; $i < count($sts_arr); $i++)
		{
			if($status == $sts_arr[$i])
				echo						'<option value="'.$sts_arr[$i].'" selected> '.$sts_arr[$i].'</option>';
			else
				echo						'<option value="'.$sts_arr[$i].'"> '.$sts_arr[$i].'</option>';
		}
		echo							'</select>
									</div>
								</div>
							</div>
							<!-- ./row -->
						</div>
						<!-- ./modal body -->
							
						<!-- modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
							</button>
							<button type="button" class="btn btn-primary" onClick="simpanDataAdmin()" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/save.ico" width=20 height=20> Simpan
							</button>
						</div>
						<!-- ./modal footer -->
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->';
		exit;
	}
	
	// ============================
	// # Fungsi simpan data admin #
	// ============================
	public function simpanDataAdmin()
	{
		$username = $this->input->post('username');
		$password = $this->m_data->encryptIt($this->input->post('password'));
		$nama     = $this->input->post('nama');
		$status   = $this->input->post('status');
		
		$data = array(
					'username' => $username,
					'password' => $password,
					'nama' => $nama,
					'status' => $status
					);
					
		$query = $this->db->select('*')
				->from('tb_admin')
				->where('username', $username)
				->get();
		$rowcounts = $query->num_rows();
		if($rowcounts > 0)
			$this->db->where('username', $username)->update('tb_admin', $data);
		else
			$this->db->insert('tb_admin', $data);

		$outp[0] = 'sukses';
		if($rowcounts > 0)
			$outp[1] = 'Sukses merubah data Admin';
		else
			$outp[1] = 'Sukses menambah data Admin';
		echo json_encode($outp);
		
		exit;
	}
	
	// **********************************************************************************************
	// ***                                   Akhir Fungsi Admin                                   ***
	// **********************************************************************************************
	
	// *********************************************************************************************
	// ***                                   Awal Data Sekolah                                   ***
	// *********************************************************************************************
	function showDataSekolah()
	{
		date_default_timezone_set("Asia/Jakarta");
		$level    = $this->session->userdata('level');
		
		$query = $this->db->select('*')
				->from('tb_sekolah')
				->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$nama_sekolah	= $row->nama_sekolah;
			$npsn			= $row->npsn;
			$alamat			= $row->alamat;
			$kodepos		= $row->kodepos;
			$telepon		= $row->telepon;
			$fax			= $row->fax;
			$kota			= $row->kota;
			$propinsi		= $row->propinsi;
			$kepsek			= $row->kepsek;
			$nip			= $row->nip;
			$pangkat		= $row->pangkat;
			$golongan		= $row->golongan;
			$tanggal		= $row->tanggal;
			$usek			= $row->usek;
			$unas			= $row->unas;
			$website		= $row->website;
			$email			= $row->email;
			$tapel			= $row->tapel;
			$semester		= $row->semester;
		}
		else
		{
			$nama_sekolah	= '';
			$npsn			= '';
			$alamat			= '';
			$kodepos		= '';
			$telepon		= '';
			$fax			= '';
			$kota			= '';
			$propinsi		= '';
			$kepsek			= '';
			$nip			= '';
			$pangkat		= '';
			$golongan		= '';
			$tanggal		= date("Y/m/d");
			$usek			= '';
			$unas			= '';
			$website		= '';
			$email			= '';
			$tapel			= 2017;
			$semester		= 1;
		}
		$tingkat = 9;
		
		echo
		'<!-- modal-dialog -->
		<div class="modal-dialog modal-lg" role="document">
			<!-- modal-content -->
			<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
				<!-- modal header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title" id="dataSekolahLabel" style="margin-bottom:0px;margin-top:0px;color: yellow;text-shadow: 2px 2px 4px black, 0 0 25px white, 0 0 5px darkblue;">
						<center><b>
						<img src="'.base_url().'utama/assists/images/icons/house.png" width=32 height=32> Data Sekolah
						</b></center>
					</h3>
				</div>
				<!-- ./modal header -->

				<!-- modal body -->
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">					<!-- ----- Kolom 1 ------ -->
							<div class="form-group">
								<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
									Nama Sekolah : (tanpa kota)
								</label>
								<input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah" value="'.$nama_sekolah.'">
							</div>
							<div class="form-group">
								<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
									Alamat :
								</label>
								<input type="text" class="form-control" name="alamat" id="alamat" value="'.$alamat.'">
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Kabupaten / Kota :
										</label>
										<input type="text" class="form-control" name="kota" id="kota" value="'.$kota.'">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Provinsi :
										</label>
										<input type="text" class="form-control" name="propinsi" id="propinsi" value="'.$propinsi.'">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Kodepos :
										</label>
										<input type="text" class="form-control" name="kodepos" id="kodepos" value="'.$kodepos.'">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Telepon :
										</label>
										<input type="text" class="form-control" name="telepon" id="telepon" value="'.$telepon.'">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Fax :
										</label>
										<input type="text" class="form-control" name="fax" id="fax" value="'.$fax.'">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Semester :
										</label>
										<select class="form-control" name="semester" id="semester">
											<option value="1" ';if($semester == 1) echo ' selected ';echo '> Ganjil </option>
											<option value="2" ';if($semester == 2) echo ' selected ';echo '> Genap </option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">					<!-- ----- Kolom 2 ------ -->
							<div class="form-group">
								<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
									NPSN :
								</label>
								<input type="text" class="form-control" name="npsn" id="npsn" value="'.$npsn.'">
							</div>
							<div class="form-group">
								<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
									Nama Kepala Sekolah :
								</label>
								<input type="text" class="form-control" name="kepsek" id="kepsek" value="'.$kepsek.'">
							</div>
							<div class="form-group">
								<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
									NIP Kepala Sekolah :
								</label>
								<input type="text" class="form-control" name="nip" id="nip" value="'.$nip.'">
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Pangkat :
										</label>
										<input type="text" class="form-control" name="pangkat" id="pangkat" value="'.$pangkat.'">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Golongan :
										</label>
										<input type="text" class="form-control" name="golongan" id="golongan" value="'.$golongan.'">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Tahun Pelajaran :
										</label>
										<input type="number" class="form-control" name="tapel" id="tapel" value="'.$tapel.'" oninput="rubahTapel(this)">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label id="tapel1" style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;margin-left: -20px;margin-top:30px;">';
											echo '- '.($tapel + 1);
										echo
										'</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">					<!-- ----- Kolom 3 ------ -->
							<div class="form-group">
								<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
									Website : (tanpa http)
								</label>
								<input type="text" class="form-control" name="website" id="website" value="'.$website.'">
							</div>
							<div class="form-group">
								<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
									Email :
								</label>
								<input type="text" class="form-control" name="email" id="email" value="'.$email.'">
							</div>
							<div class="form-group">
								<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
									Sekolah Penyelenggara Ujian Sekolah :
								</label>
								<input type="text" class="form-control" name="usek" id="usek" value="'.$usek.'">
							</div>
							<div class="form-group">
								<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
									Sekolah Penyelenggara Ujian Nasional :
								</label>
								<input type="text" class="form-control" name="unas" id="unas" value="'.$unas.'">
							</div>
							<div class="form-group">
								<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
									Tanggal Kelulusan :
								</label>
								<input type="date" class="form-control" name="tanggal" id="tanggal" value="'.$tanggal.'">
							</div>
						</div>
					</div>
					<hr />
					<div class="hit-the-floor" style="margin-top: -38px;">
						<center><h3><b>Rombel</b></h3></center>
					</div>
					<div class="row">';
					$kls_array = array('X', 'XI', 'XII');
					for($i = 0; $i < 3; $i++)
					{
						echo
						'<div class="col-md-4">
							<h4 style="margin-bottom:0px;margin-top:-6px;color: yellow;text-shadow: 2px 2px 4px black, 0 0 25px white, 0 0 5px darkblue;">
								<center><b>Kelas '.$kls_array[$i].'</b></center>
							</h4><br/>
							<table style="width: 100%; border-collapse: collapse;margin-top: -10px;">
								<tr style="background-color: cyan; border: 1px solid black;">
									<td style="text-align: center; padding: 4px 0; horizontal-align:middle; border: 1px solid black;">
										<b>Prodi</b>
									</td>
									<td style="text-align: center; padding: 4px 0; horizontal-align:middle; border: 1px solid black;">
										<b>Rombel</b>
									</td>
									<td style="text-align: center; padding: 4px 0; horizontal-align:middle; border: 1px solid black;">
										<b>Siswa</b>
									</td>
									<td style="text-align: center; padding: 4px 0; horizontal-align:middle; border: 1px solid black;">
										<b>Maksi</b>
									</td>
								</tr>';
								$tingkat++;
								$query = $this->db->select('*')
											->from('tb_kelas')
											->where('tingkat', $tingkat)
											->group_by('kd_prodi')
											->order_by('kd_prodi', 'desc')
											->get();
								if($query->num_rows() > 0)
								{
									foreach($query->result() as $row)
									{
										$prodi = $row->kd_prodi;
										$maksi = $row->maksi;
										$rata2 = $row->siswa;
										$query1 = $this->db->select('*')
													->from('tb_siswa')
													->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
													->where('tb_kelas.tingkat', $tingkat)
													->where('tb_kelas.kd_prodi', $prodi)
													->get();
										$jml_siswa = $query1->num_rows();
										
										$jmlMaksi = 0;
										$query1 = $this->db->select('*')
													->from('tb_kelas')
													->where('tingkat', $tingkat)
													->where('kd_prodi', $prodi)
													->get();
										$jml_rombel = $query1->num_rows();
										foreach($query1->result() as $row1)
										{
											$jmlMaksi += $row1->siswa;
										}
										echo
										'<tr style="background-color: white; border: 1px solid black;">
											<td style="text-align: center; padding: 4px 0; horizontal-align:middle; border: 1px solid black;">
												<b>'.$prodi.'</b>
											</td>
											<td style="text-align: center; padding: 4px 0; horizontal-align:middle; border: 1px solid black;">
												<b>'.$jml_rombel.'</b>
											</td>
											<td style="text-align: center; padding: 4px 0; horizontal-align:middle; border: 1px solid black;">
												<b>'.$jml_siswa.'</b>
											</td>
											<td style="text-align: center; padding: 4px 0; horizontal-align:middle; border: 1px solid black;">
												<b>'.$jmlMaksi.'</b>
											</td>
										</tr>';
									}
								}
								echo
							'</table>
						</div>';
					}
					echo
					'</div>
				</div>
				<!-- ./modal body -->
							
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
						<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
					</button>';
					if($level > 95)
						echo
					'<button type="button" class="btn btn-primary" onClick="simpanDataSekolah()" style="border-radius:8px;">
						<img src="'.base_url().'utama/assists/images/icons/save.ico" width=20 height=20> Simpan
					</button>';
					echo
				'</div>
				<!-- ./modal footer -->
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->';

		exit;
	}
	
	// ==============================
	// # Fungsi simpan data sekolah #
	// ==============================
	function simpanDataSekolah()
	{
		date_default_timezone_set("Asia/Jakarta");
		$namaSekolah = $this->input->post('nama_sekolah');
		$npsn		 = $this->input->post('npsn');
		$alamat		 = $this->input->post('alamat');
		$kota		 = $this->input->post('kota');
		$propinsi	 = $this->input->post('propinsi');
		$tanggal	 = $this->input->post('tanggal');
		$kepsek		 = $this->input->post('kepsek');
		$nip		 = $this->input->post('nip');
		$usek		 = $this->input->post('usek');
		$unas		 = $this->input->post('unas');
		$kodepos	 = $this->input->post('kodepos');
		$telepon	 = $this->input->post('telepon');
		$fax		 = $this->input->post('fax');
		$pangkat	 = $this->input->post('pangkat');
		$golongan	 = $this->input->post('golongan');
		$tapel	 	 = $this->input->post('tapel');
		$semester	 = $this->input->post('semester');
		$website	 = $this->input->post('website');
		$email	 	 = $this->input->post('email');
		$data	= array(
						'nama_sekolah' => $namaSekolah,
						'npsn' => $npsn,
						'alamat' => $alamat,
						'kota' => $kota,
						'propinsi' => $propinsi,
						'tanggal' => $tanggal,
						'kepsek' => $kepsek,
						'nip' => $nip,
						'usek' => $usek,
						'unas' => $unas,
						'kodepos' => $kodepos,
						'telepon' => $telepon,
						'fax' => $fax,
						'pangkat' => $pangkat,
						'golongan' => $golongan,
						'tapel' => $tapel,
						'semester' => $semester,
						'website' => $website,
						'email' => $email
						);
		$query = $this->db->select('*')
				->from('tb_sekolah')
				->get();
		$rowcounts = $query->num_rows();
		if($rowcounts > 0)
			$this->db->update('tb_sekolah', $data);
		else
			$this->db->insert('tb_sekolah', $data);
		
		$outp[0] = 'sukses';
		if($rowcounts > 0)
			$outp[1] = 'Sukses merubah data Sekolah';
		else
			$outp[1] = 'Sukses menambah data Sekolah';
		echo json_encode($outp);
		exit;
	}
	
	// **********************************************************************************************
	// *********************************     Akhir Data Sekolah     *********************************
	// **********************************************************************************************
	
	// *****************************************************************************************
	// **********************************    Awal Data KKM     *********************************
	// *****************************************************************************************
	function showDataKKM()
	{
		date_default_timezone_set("Asia/Jakarta");
		$level    = $this->session->userdata('level');
		
		$query = $this->db->select('*')
				->from('tb_kkm')
				->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$kkm			= $row->kkm;
			$pred1_nama		= $row->pred1_nama;
			$pred1_bawah	= $row->pred1_bawah;
			$pred1_atas		= $row->pred1_atas;
			$pred2_nama		= $row->pred2_nama;
			$pred2_bawah	= $row->pred2_bawah;
			$pred2_atas		= $row->pred2_atas;
			$pred3_nama		= $row->pred3_nama;
			$pred3_bawah	= $row->pred3_bawah;
			$pred3_atas		= $row->pred3_atas;
			$pred4_nama		= $row->pred4_nama;
			$pred4_bawah	= $row->pred4_bawah;
			$pred4_atas		= $row->pred4_atas;
			$pred5_nama		= $row->pred5_nama;
			$pred5_bawah	= $row->pred5_bawah;
			$pred5_atas		= $row->pred5_atas;
		}
		else
		{
			$kkm			= 0;
			$pred1_nama		= '';
			$pred1_bawah	= 0;
			$pred1_atas		= 0;
			$pred2_nama		= '';
			$pred2_bawah	= 0;
			$pred2_atas		= 0;
			$pred3_nama		= '';
			$pred3_bawah	= 0;
			$pred3_atas		= 0;
			$pred4_nama		= '';
			$pred4_bawah	= 0;
			$pred4_atas		= 0;
			$pred5_nama		= '';
			$pred5_bawah	= 0;
			$pred5_atas		= 0;
		}
		
		echo
		'<!-- modal-dialog -->
		<div class="modal-dialog" role="document">
			<!-- modal-content -->
			<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
				<!-- modal header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title" id="dataSekolahLabel" style="margin-bottom:0px;margin-top:0px;color: yellow;text-shadow: 2px 2px 4px black, 0 0 25px white, 0 0 5px darkblue;">
						<center><b>
							<img src="'.base_url().'utama/assists/images/icons/property.ico" width=32 height=32> Kriteria Ketuntasan Minimal
						</b></center>
					</h3>
				</div>
				<!-- ./modal header -->

				<!-- modal body -->
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-md-3 control-label" style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
										KKM :
									</label>
									<div class="col-md-4">
										<input type="number" min="0" max="100" class="form-control" name="kkm" id="kkm" value="'.$kkm.'">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table width=100% style=" border-collapse: collapse;">
								<thead>
									<tr style="background-color: cyan;height: 30px;border: 1px solid black;">
										<th><center>Predikat</center></th>
										<th><center>Batas Bawah ( >= )</center></th>
										<th><center>Batas Atas ( < )</center></th>
									</tr>
								<thead>
								<tbody>
									<tr style="border: 1px solid black;">
										<td><b><input type="text" class="form-control" name="pred1_nama" id="pred1_nama" value="'.$pred1_nama.'" style="text-align: center;" ></td>
										<td style="background-color: #E0E0E0;"><center><b><input type="number" min="0" max="100" name="pred1_bawah" id="pred1_bawah" value="'.$pred1_bawah.'" style="text-align: center;color: red;" disabled></center></b></td>
										<td><input type="number" min="0" max="100" class="form-control" name="pred1_atas" id="pred1_atas" value="'.$pred1_atas.'" style="text-align: center;" oninput="cekKKM(this)"></td>
									</tr>
									<tr style="border: 1px solid black;">
										<td><b><input type="text" class="form-control" name="pred2_nama" id="pred2_nama" value="'.$pred2_nama.'" style="text-align: center;" ></td>
										<td style="background-color: #E0E0E0;"><center><b><input type="number" min="0" max="100" name="pred2_bawah" id="pred2_bawah" value="'.$pred2_bawah.'" style="text-align: center;color: red;" disabled></center></b></td>
										<td><input type="number" min="0" max="100" class="form-control" name="pred2_atas" id="pred2_atas" value="'.$pred2_atas.'" style="text-align: center;" oninput="cekKKM(this)"></td>
									</tr>
									<tr style="border: 1px solid black;">
										<td><b><input type="text" class="form-control" name="pred3_nama" id="pred3_nama" value="'.$pred3_nama.'" style="text-align: center;" ></td>
										<td style="background-color: #E0E0E0;"><center><b><input type="number" min="0" max="100" name="pred3_bawah" id="pred3_bawah" value="'.$pred3_bawah.'" style="text-align: center;color: red;" disabled></center></b></td>
										<td><input type="number" min="0" max="100" class="form-control" name="pred3_atas" id="pred3_atas" value="'.$pred3_atas.'" style="text-align: center;" oninput="cekKKM(this)"></td>
									</tr>
									<tr style="border: 1px solid black;">
										<td><b><input type="text" class="form-control" name="pred4_nama" id="pred4_nama" value="'.$pred4_nama.'" style="text-align: center;" ></td>
										<td style="background-color: #E0E0E0;"><center><b><input type="number" min="0" max="100" name="pred4_bawah" id="pred4_bawah" value="'.$pred4_bawah.'" style="text-align: center;color: red;" disabled></center></b></td>
										<td><input type="number" min="0" max="100" class="form-control" name="pred4_atas" id="pred4_atas" value="'.$pred4_atas.'" style="text-align: center;" oninput="cekKKM(this)"></td>
									</tr>
									<tr style="border: 1px solid black;">
										<td><b><input type="text" class="form-control" name="pred5_nama" id="pred5_nama" value="'.$pred5_nama.'" style="text-align: center;" ></td>
										<td style="background-color: #E0E0E0;"><center><b><input type="number" min="0" max="100" name="pred5_bawah" id="pred5_bawah" value="'.$pred5_bawah.'" style="text-align: center;color: red;" disabled></center></b></td>
										<td><input type="number" min="0" max="100" class="form-control" name="pred5_atas" id="pred5_atas" value="'.$pred5_atas.'" style="text-align: center;" oninput="cekKKM(this)"></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<br/>
					<div style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
						<center><b>*) Isikan A,B,C,D dan E untuk predikat<br/>
							<font color="red">Batas Atas sama dengan Batas Bawah kriteria sesudahnya</font></b>
						</center>
					</div>
				</div>
				<!-- ./modal body -->
							
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
						<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
					</button>';
					if($level > 94)
						echo
					'<button type="button" class="btn btn-primary" onClick="simpanDataKKM()" style="border-radius:8px;">
						<img src="'.base_url().'utama/assists/images/icons/save.ico" width=20 height=20> Simpan
					</button>';
					echo
				'</div>
				<!-- ./modal footer -->
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->';

		exit;
	}
	
	// ==========================
	// # Fungsi simpan Data KKM #
	// ==========================
	function simpanDataKKM()
	{
		$kkm = $this->input->post('kkm');
		$pred1_nama  = $this->input->post('pred1_nama');
		$pred1_bawah = $this->input->post('pred1_bawah');
		$pred1_atas  = $this->input->post('pred1_atas');
		$pred2_nama  = $this->input->post('pred2_nama');
		$pred2_bawah = $this->input->post('pred2_bawah');
		$pred2_atas  = $this->input->post('pred2_atas');
		$pred3_nama  = $this->input->post('pred3_nama');
		$pred3_bawah = $this->input->post('pred3_bawah');
		$pred3_atas  = $this->input->post('pred3_atas');
		$pred4_nama  = $this->input->post('pred4_nama');
		$pred4_bawah = $this->input->post('pred4_bawah');
		$pred4_atas  = $this->input->post('pred4_atas');
		$pred5_nama  = $this->input->post('pred5_nama');
		$pred5_bawah = $this->input->post('pred5_bawah');
		$pred5_atas  = $this->input->post('pred5_atas');
		
		$data = array('kkm ' => $kkm,
						'pred1_nama'	=> $pred1_nama,
						'pred1_bawah'	=> $pred1_bawah,
						'pred1_atas'	=> $pred1_atas,
						'pred2_nama'	=> $pred2_nama,
						'pred2_bawah'	=> $pred2_bawah,
						'pred2_atas'	=> $pred2_atas,
						'pred3_nama'	=> $pred3_nama,
						'pred3_bawah'	=> $pred3_bawah,
						'pred3_atas'	=> $pred3_atas,
						'pred4_nama'	=> $pred4_nama,
						'pred4_bawah'	=> $pred4_bawah,
						'pred4_atas'	=> $pred4_atas,
						'pred5_nama'	=> $pred5_nama,
						'pred5_bawah'	=> $pred5_bawah,
						'pred5_atas'	=> $pred5_atas
					);

		$query = $this->db->select('*')
				->from('tb_kkm')
				->get();
		$rowcounts = $query->num_rows();
		if($rowcounts > 0)
			$this->db->update('tb_kkm', $data);
		else
			$this->db->insert('tb_kkm', $data);
		
		$outp[0] = 'sukses';
		if($rowcounts > 0)
			$outp[1] = 'Sukses merubah data KKM';
		else
			$outp[1] = 'Sukses menambah data KKM';
		echo json_encode($outp);
		exit;
	}
	
	// ************************************************************************************************
	// **********************************    Awal Data Wali Kelas     *********************************
	// ************************************************************************************************
	function showDataWali()
	{
		$pilih = $this->input->get('pl');
		$pilih1 = $this->input->get('pl1');
		if(isset($_GET['id'])) {$username = $_GET['id'];} else {$username = '';}
		if(isset($_GET['cr'])) {$cari = $_GET['cr'];} else {$cari = '';}
		if(isset($_GET['m']))  {$mulai = $_GET['m'];} else {$mulai = 1;}
		
		$level    = $this->session->userdata('level');
		echo
                '<div class="col-md-12">
					<input type="hidden" name="pilih" id="pilih" value="'.$pilih1.'">
                    <div class="panel panel-primary">
						<!--
                        <div class="panel-heading">';
						if($pilih1 == 'wali')
                            echo '<center><b><i>Daftar Wali Kelas</i></b></center>';
						else
                            echo '<center><b><i>Daftar Kelas</i></b></center>';
                        echo
						'</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<div class="row">';
								$noKls = '';
								$sts_log = array('Y' => 'Aktif', 'N' => 'Tidak');
								$nomer = 0;
								$jml_data = 0;
								if($pilih1 == 'wali')
									$query = $this->db->select('*')
												->from('tb_kelas')
												->join('tb_wali', 'tb_kelas.kd_kelas = tb_wali.kelas', 'left')
												->order_by('tb_kelas.kd_kelas', 'asc')
												->get();
								else
									$query = $this->db->select('*')
												->from('tb_kelas')
												->order_by('kd_kelas', 'asc')
												->get();
								foreach($query->result() as $row)
								{
									$kelas      = $row->kd_kelas;
									$nama_kelas = $row->nama_kelas;
									if($pilih1 == 'wali') $nama_guru  = $row->nama; else 
									{
										$prodi = $row->kd_prodi;
										$jml_siswa = $row->siswa;
									}
									//if($nama_guru != '') $jml_data++;
									if(substr($kelas,0,2) != $noKls)
									{
										$noKls = substr($kelas, 0, 2);
										echo 
										'<div class="col-md-4">
											<table width="100%" class="table table-striped table-bordered table-hover">
												<thead>
													<tr style="background:green;color:yellow;">
														<th><center>No</center></th>';
														if($pilih1 == 'wali')
															echo
														'<th><center>Kelas</center></th>
														<th><center>Nama</center></th>';
														else
															echo
														'<th><center>Kd Kelas</center></th>
														<th><center>Kelas</center></th>
														<th><center>Prodi</center></th>
														<th><center>Siswa</center></th>
														<th><center>#</center></th>';
														echo
													'</tr>
												</thead>
												<tbody>';
											
									}
									if($kelas == $username)
										echo 
													'<tr style="background:yellow;color:red;">';
									else
										echo 
													'<tr class="gradeA">';
									if($pilih1 == 'wali')
										echo
														'<td><center>'.($nomer + 1).'</center></td>
														<td><center><a href="#" id="pl=wali&pl1=wali&id='.$kelas.'" onclick="editDataWali(this)">'.$nama_kelas.'</a></center></td>
														<td><a href="#" id="pl=wali&pl1=wali&id='.$kelas.'" onclick="editDataWali(this)">'.$nama_guru.'</a></td>
													</tr>';
									else
									{
										echo
														'<td><center>'.($nomer + 1).'</center></td>
														<td><center><a href="#" id="pl=wali&pl1=kelas&id='.$kelas.'" onclick="editDataWali(this)">'.$kelas.'</a></center></td>
														<td><center><a href="#" id="pl=wali&pl1=kelas&id='.$kelas.'" onclick="editDataWali(this)">'.$nama_kelas.'</a></center></td>
														<td><center><a href="#" id="pl=wali&pl1=kelas&id='.$kelas.'" onclick="editDataWali(this)">'.$prodi.'</a></center></td>
														<td><center><a href="#" id="pl=wali&pl1=kelas&id='.$kelas.'" onclick="editDataWali(this)">'.$jml_siswa.'</a></center></td>
														<td>
															<center>';
															if($level > 94)
																echo
																'<a href="#" id="'.$kelas.'&pl=kelas" onclick="hapusData(this)">
																	<img src="'.base_url().'utama/assists/images/icons/delete.ico" width=20 height=20>
																</a>';
															else
																echo '&nbsp;';
															echo
															'</center>
														</td>
													</tr>';
									}
									$nomer++;
									$row1 = $query->row($nomer);
									$cekKls = substr($row1->kd_kelas, 0, 2);
									if(($cekKls != $noKls) or ($nomer >= $query->num_rows()))
									{
										echo	'</tbody>
											</table>
										</div>';
									}
								}
								if($nomer == 0)
									echo '<b><center>Tidak ada data</center></b><br/>';
								echo
							'</div>';
							if(($pilih1 == 'wali') and ($level > 95))
								echo
							'*) Anda dapat mempersiapkan dan mengedit data melalui microsoft Excel. Format file dapat di <a href="dl_contoh?id=wali">download disini</a><br />
							*) Rubahlah contoh diatas kemudian simpan dan <a href="#" id="wali" onClick="showImportData(this)">import disini.</a>
							<br>
							<center>
								<a href="#" id="wali" class="btn btn-danger" onclick="hapusDataAll(this)">
									<img src="'.base_url().'utama/assists/images/icons/stop.ico" width=24 height=24> Hapus Semua Data
								</a>
							</center>';
							elseif($level > 95)
								echo
							'<font color="red"><b>*) Menghapus data kelas menyebabkan data wali kelas juga terhapus</b></font>
							<br/>
							<center>
								<a href="#" id="kelas" class="btn btn-danger" onclick="hapusDataAll(this)">
									<img src="'.base_url().'utama/assists/images/icons/stop.ico" width=24 height=24> Hapus Semua Data
								</a>
								&nbsp;&nbsp;&nbsp;
								<a href="#" id="pl=wali&pl1=kelas&id=" class="btn btn-success" onclick="editDataWali(this)">
									<img src="'.base_url().'utama/assists/images/icons/add_card.ico" width=24 height=24> Tambah Data
								</a>
							</center>';
							echo
						'</div>
					</div>
				</div>';
		exit;
	}
	
	// ===============================
	// # Fungsi Edit Data Wali Kelas #
	// ===============================
	function showWaliModal()
	{
		$level    = $this->session->userdata('level');
		$username = $this->session->userdata('username');
		if($level == 94)
		{
			$query = $this->db->select('*')
					->from('tb_wali')
					->where('kd_guru', $username)
					->get();
			$hasil = $query -> num_rows();
			if($hasil > 0)
			{
				$row = $query->row();
				$kelasM = $row->kelas;
			}
			else
				$kelasM = '';
			
		}
		
		$pilih = $this->input->get('pl');
		$pilih1 = $this->input->get('pl1');
		$kelas = $this->input->get('id');
		
		if($pilih1 == 'wali')
		{
			$query = $this->db->select('*')
					->from('tb_kelas')
					->join('tb_wali', 'tb_wali.kelas = tb_kelas.kd_kelas', 'left')
					->where('tb_kelas.kd_kelas', $kelas)
					->get();
			$row = $query->row();
			$nama_kelas	= $row->nama_kelas;
			$prodi		= $row->kd_prodi;
			$nama_wali	= $row->nama;
			$kd_guru	= $row->kd_guru;
			$password	= $this->m_data->decryptIt($row->password);
			$nip		= $row->nip;
			$golongan	= $row->golongan;
			$pangkat	= $row->pangkat;
		}
		else
		{
			if($kelas != '')
			{
				$query = $this->db->select('*')
							->from('tb_kelas')
							->where('kd_kelas', $kelas)
							->get();
				$row = $query->row();
				$nama_kelas = $row->nama_kelas;
				$prodi      = $row->kd_prodi;
				$jml_siswa  = $row->siswa;
				$tingkat    = $row->tingkat;
				$maksi      = $row->maksi;
			}
			else
			{
				$nama_kelas	= '';
				$prodi		= '';
				$jml_siswa  = 0;
				$tingkat    = 10;
				$maksi      = 36;
			}
		}
		
		echo
				'<!-- modal-dialog -->
				<div class="modal-dialog" role="document">
					<!-- modal-content -->
					<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
						<!-- modal header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title" id="isianAdminLabel" style="margin-bottom:0px;margin-top:0px;color: yellow;text-shadow: 2px 2px 4px black, 0 0 25px white, 0 0 5px darkblue;">';
							if($pilih1 == 'wali')
								echo 
								'<center><b>
									<img src="'.base_url().'utama/assists/images/icons/group.png" width=32 height=32> Edit Wali Kelas
								</b></center>';
							else
							{
								if($kelas == '')
									echo 
									'<center><b>
										<img src="'.base_url().'utama/assists/images/icons/table.ico" width=32 height=32> Tambah Kelas
									</b></center>';
								else
									echo 
									'<center><b>
										<img src="'.base_url().'utama/assists/images/icons/table.ico" width=32 height=32> Edit Kelas
									</b></center>';
							}
							echo
							'</h3>
						</div>
						<!-- ./modal header -->

						<!-- modal body -->
						<div class="modal-body" id="isianDataWali">
						<input type="hidden" name="pilihM" id="pilihM" value="'.$pilih1.'">';
						if($pilih1 == 'wali')
						{
							echo
							'<input type="hidden" name="kelasM" id="kelasM" value="'.$kelas.'">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Kelas :
										</label>
										<input type="text" class="form-control" name="nama_kelas" id="nama_kelas" value="'.$nama_kelas.'" disabled>
									</div>
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Kode Guru :
										</label>
										<input type="text" class="form-control" name="kd_guru" id="kd_guru" value="'.$kd_guru.'">
									</div>
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Nama Guru :
										</label>
										<input type="text" class="form-control" name="nm_wali" id="nm_wali" value="'.$nama_wali.'">
									</div>
									<div class="form-group">
										<!-- /input-group -->
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Password :
										</label>
										<div class="input-group margin" style="margin-top:0px;margin-left:0px;">
											<input type="password" class="form-control" id="password" name="password" value="'.$password.'">
											<span class="input-group-btn">
												<button type="button" class="btn btn-info btn-flat" style="margin-top:-1px;height:35px;border-radius:6px;" onclick="showHidePass();">
													<i id="simbol" class="glyphicon glyphicon-eye-open"></i>
												</button>
											</span>
										</div>
										<!-- ./input-group -->
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											N I P :
										</label>
										<input type="text" class="form-control" name="nip" id="nip" value="'.$nip.'">
									</div>
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Pangkat :
										</label>
										<input type="text" class="form-control" name="pangkat" id="pangkat" value="'.$pangkat.'">
									</div>
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Golongan :
										</label>
										<input type="text" class="form-control" name="golongan" id="golongan" value="'.$golongan.'">
									</div>
								</div>
							</div>
							<!-- ./row -->';
						}
						else
						{
							echo
							'<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Kode :
										</label>
										<input type="text" class="form-control" name="kelasM" id="kelasM" value="'.$kelas.'" ';if($kelas != '') echo ' disabled '; echo '>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Nama Kelas :
										</label>
										<input type="text" class="form-control" name="nm_kelas" id="nm_kelas" value="'.$nama_kelas.'">
									</div>
								</div>
								<div class="col-md-7">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Prodi :
										</label>
										<select class="form-control" name="prodiM" id="prodiM" value="'.$prodi.'">';
										$query = $this->db->select('*')
													->from('tb_prodi')
													->get();
										foreach($query->result() as $row)
										{
											$kd_prodi = $row->prodi;
											$nm_prodi = $row->nama_prodi;
											if($kd_prodi == $prodi)
												echo
												'<option value="'.$kd_prodi.'" selected > '.$nm_prodi.' </option>';
											else
												echo
												'<option value="'.$kd_prodi.'" > '.$nm_prodi.' </option>';
										}
										echo
										'</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Tingkat :
										</label>
										<input type="number" class="form-control" min="10" max="12" name="tingkat" id="tingkat" value="'.$tingkat.'" >
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Jml Siswa :
										</label>
										<input type="number" class="form-control" min="30" max="40" name="jml_siswa" id="jml_siswa" value="'.$jml_siswa.'" >
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Jml Siswa Maks. :
										</label>
										<input type="number" class="form-control" min="30" max="40" name="maksi" id="maksi" value="'.$maksi.'" >
									</div>
								</div>
							</div>';
						}
						echo
						'</div>
						<!-- ./modal body -->
							
						<!-- modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
							</button>';
							if(($level > 95) or (($level == 94) and ($kelas == $kelasM)))
								echo
							'<button type="button" class="btn btn-primary" onClick="simpanDataWali()" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/save.ico" width=20 height=20> Simpan
							</button>';
							echo
						'</div>
						<!-- ./modal footer -->
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->';
		exit;
	}
	
	// =================================
	// # Fungsi simpan Data Wali Kelas #
	// =================================
	function simpanDataWali()
	{
		$pilih = $this->input->post('pilih');
		if($pilih == 'wali')
		{
			$kelas = $this->input->post('kelas');
			$data = array(
							'kelas'		=> $kelas,
							'kd_guru'	=> $this->input->post('kd_guru'),
							'password'	=> $this->m_data->encryptIt($this->input->post('password')),
							'nama'		=> $this->input->post('nm_wali'),
							'nip'		=> $this->input->post('nip'),
							'pangkat'	=> $this->input->post('pangkat'),
							'golongan'	=> $this->input->post('golongan')
						);
			$query = $this->db->select('*')
						->from('tb_wali')
						->where('kelas', $kelas)
						->get();
			if($query->num_rows() > 0)
				$this->db->where('kelas', $kelas)->update('tb_wali', $data);
			else
				$this->db->insert('tb_wali', $data);
		}
		else
		{
			$kd_kelas = $this->input->post('kelas');
			$data = array(
						'kd_kelas'		=> $kd_kelas,
						'nama_kelas'	=> $this->input->post('nm_kelas'),
						'kd_prodi'		=> $this->input->post('prodi'),
						'tingkat'		=> $this->input->post('tingkat'),
						'siswa'			=> $this->input->post('siswa'),
						'maksi'			=> $this->input->post('maksi')
						);
			$query = $this->db->select('*')
						->from('tb_kelas')
						->where('kd_kelas', $kd_kelas)
						->get();
			if($query->num_rows() > 0)
				$this->db->where('kd_kelas', $kd_kelas)->update('tb_kelas', $data);
			else
			{
				$this->db->insert('tb_kelas', $data);
				$data = array('kelas' => $kd_kelas);
				$this->db->insert('tb_wali', $data);
			}			
		}
		$outp = array();
		$outp[0] = 'sukses';
		if($pilih == 'wali')
			$outp[1] = 'Sukses menyimpan data Walikelas';
		else
			$outp[1] = 'Sukses menyimpan data Kelas';
		echo json_encode($outp);
		
		exit;
	}
	
	// *************************************************************************************************
	// *********************************     Akhir Data Wali Kelas     *********************************
	// *************************************************************************************************
	
	// *******************************************************************************************
	// **********************************    Awal Data Siswa     *********************************
	// *******************************************************************************************
	function showDataSiswa()
	{
		$level    = $this->session->userdata('level');
		$username = $this->session->userdata('username');

		$pilih = $this->input->get('pl');
		if(isset($_GET['id'])) {$no_ujian_smp = $_GET['id'];} else {$no_ujian_smp = '';}
		if(isset($_GET['cr'])) {$cari = $_GET['cr'];} else {$cari = '';}
		if(isset($_GET['m']))  {$mulai = $_GET['m'];} else {$mulai = 1;}
		if(isset($_GET['sr'])) {$urut = $_GET['sr'];} else {$urut = '';}
		if(isset($_GET['ur'])) {$naik = $_GET['ur'];} else {$naik = '';}
		$kelas = $this->input->get('kl');
		
		if($level == 94)
		{
			$query = $this->db->select('*')
					->from('tb_wali')
					->where('kd_guru', $username)
					->get();
			$hasil = $query -> num_rows();
			if($hasil > 0)
			{
				$row = $query->row();
				$kelas = $row->kelas;
				$username = $row->kd_guru;
			}
			
		}
		echo
				'<div class="col-md-12">
					<input type="hidden" id="userId" name="userId" value="'.$no_ujian_smp.'">
					<input type="hidden" id="mulai"  name="userId" value="'.$mulai.'">
					<input type="hidden" id="urut"   name="userId" value="'.$urut.'">
					<input type="hidden" id="naik"   name="userId" value="'.$naik.'">
                    <div class="panel panel-primary">
                        <div class="panel-heading text-bayang">
                            <center><b><i>Daftar Siswa</i></b></center>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="inputCetak" class="col-md-2 control-label">Kelas :</label>
											<div class="col-md-4" style="margin-top:4px;margin-left:0px;">
												<input type="radio" id="semua" name="semua" value="0" ';if(($kelas == '') or ($kelas == 'x')) echo 'checked ';if($level < 95) echo ' disabled '; echo 'onclick="showKelasData(this)"> Semua
												&nbsp;&nbsp;&nbsp;
												<input type="radio" id="kelasP" name="semua" value="1" ';if($kelas != '') echo 'checked ';if($level < 95) echo ' disabled '; echo 'onclick="showKelasData(this)"> Per Kelas
											</div>';
											if($kelas == '')
												echo
												'<div class="col-md-5" id="idKelas" style="display:none;margin-top:4px;">';
											else
												echo
												'<div class="col-md-5" id="idKelas" style="margin-top:4px;">';
											echo
												'<label for="inputCetak" class="col-md-5 control-label" style="margin-top:-4px;margin-left:-26px;">Kelas :</label>
												<select class="col-md-7" id="kelasSelect" name="kelasSelect" style="margin-top:-2px;margin-left:0px;height:32px;" oninput="rubahKelasData()" ';if($level < 95) echo ' disabled ';echo '>';
													$query = $this->db->select('*')
																->from('tb_kelas')
																->get();
													if($query->num_rows() > 0)
													{
														foreach($query->result() as $row)
														{
															$kd_kelas = $row->kd_kelas;
															if($kelas == $kd_kelas)
																echo '<option value="'.$row->kd_kelas.'" selected> '.$row->nama_kelas.'</option>';
															else
																echo '<option value="'.$row->kd_kelas.'"> '.$row->nama_kelas.'</option>';
														}
													}
												echo
												'</select>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="inputCari" class="col-md-1 control-label">Cari</label>
											<div class="col-md-8">
												<div class="input-group margin" style="margin-top:0px;margin-left:0px;">
													<input type="text" class="form-control" id="cari" name="cari" value="'.$cari.'">
													<span class="input-group-btn">
														<button type="button" class="btn btn-info" style="margin-top:-1px;height:35px;border-radius:6px;" onclick="cariDataSiswa();">
															<img src="'.base_url().'utama/assists/images/icons/Search.ico" width=20 height=20>
														</button>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
									<tr style="background:green;color:yellow;">
                                        <th><center><label class="text-bayang">No.</label></center></th>
                                        <th>
											<label class="pull-left text-bayang" style="margin-top: 6px;">User ID&nbsp;';
												if(($urut == 'no_ujian_smp') and ($naik == 'asc'))
													echo '<img src="'.base_url().'utama/assists/images/icons/arrow_up.png" width=20 height=20>';
												elseif(($urut == 'no_ujian_smp') and ($naik == 'desc'))
													echo '<img src="'.base_url().'utama/assists/images/icons/arrow_down.png" width=20 height=20>';
												echo
											'</label>';
											if(($urut == 'no_ujian_smp') and ($naik == 'asc'))
												echo
												'<button class="btn btn-warning pull-right" id="pl=siswa&m=1&cr='.$cari.'&sr=no_ujian_smp&ur=desc" style="background-color: green;border: none;" onclick="showPage(this)">
													<img src="'.base_url().'utama/assists/images/icons/sort_descending.png" width=20 height=20>
												</button>';
											else
												echo
												'<button class="btn btn-warning pull-right" id="pl=siswa&m=1&cr='.$cari.'&sr=no_ujian_smp&ur=asc" style="background-color: green;border: none;" onclick="showPage(this)">
													<img src="'.base_url().'utama/assists/images/icons/sort_ascending.png" width=20 height=20>
												</button>';
											echo
										'</th>';
										if(($kelas == '') or ($kelas == 'x'))
										{
											echo
                                        '<th>
											<label class="pull-left text-bayang" style="margin-top: 6px;">Kelas&nbsp;';
												if(($urut == 'kelas') and ($naik == 'asc'))
													echo '<img src="'.base_url().'utama/assists/images/icons/arrow_up.png" width=20 height=20>';
												elseif(($urut == 'kelas') and ($naik == 'desc'))
													echo '<img src="'.base_url().'utama/assists/images/icons/arrow_down.png" width=20 height=20>';
												echo
											'</label>';
											if(($urut == 'kelas') and ($naik == 'asc'))
												echo
												'<button class="btn btn-warning pull-right" id="pl=siswa&m=1&cr='.$cari.'&sr=kelas&ur=desc" style="background-color: green;border: none;" onclick="showPage(this)">
													<img src="'.base_url().'utama/assists/images/icons/sort_descending.png" width=20 height=20>
												</button>';
											else
												echo
												'<button class="btn btn-warning pull-right" id="pl=siswa&m=1&cr='.$cari.'&sr=kelas&ur=asc" style="background-color: green;border: none;" onclick="showPage(this)">
													<img src="'.base_url().'utama/assists/images/icons/sort_ascending.png" width=20 height=20>
												</button>';
											echo
										'</th>';
										}
										echo
                                        '<th><center><label class="text-bayang">NISN</label></center></th>
                                        <th>
											<label class="pull-left text-bayang" style="margin-top: 6px;">Induk&nbsp;';
												if(($urut == 'no_induk') and ($naik == 'asc'))
													echo '<img src="'.base_url().'utama/assists/images/icons/arrow_up.png" width=20 height=20>';
												elseif(($urut == 'no_induk') and ($naik == 'desc'))
													echo '<img src="'.base_url().'utama/assists/images/icons/arrow_down.png" width=20 height=20>';
												echo
											'</label>';
											if(($urut == 'no_induk') and ($naik == 'asc'))
												echo
												'<button class="btn btn-warning pull-right" id="pl=siswa&m=1&cr='.$cari.'&sr=no_induk&ur=desc" style="background-color: green;border: none;" onclick="showPage(this)">
													<img src="'.base_url().'utama/assists/images/icons/sort_descending.png" width=20 height=20>
												</button>';
											else
												echo
												'<button class="btn btn-warning pull-right" id="pl=siswa&m=1&cr='.$cari.'&sr=no_induk&ur=asc" style="background-color: green;border: none;" onclick="showPage(this)">
													<img src="'.base_url().'utama/assists/images/icons/sort_ascending.png" width=20 height=20>
												</button>';
											echo
										'</th>
                                        <th>
											<label class="pull-left text-bayang" style="margin-top: 6px;">Nama Siswa&nbsp;';
												if(($urut == 'nama') and ($naik == 'asc'))
													echo '<img src="'.base_url().'utama/assists/images/icons/arrow_up.png" width=20 height=20>';
												elseif(($urut == 'nama') and ($naik == 'desc'))
													echo '<img src="'.base_url().'utama/assists/images/icons/arrow_down.png" width=20 height=20>';
												echo
											'</label>';
											if(($urut == 'nama') and ($naik == 'asc'))
												echo
												'<button class="btn btn-warning pull-right" id="pl=siswa&m=1&cr='.$cari.'&sr=nama&ur=desc" style="background-color: green;border: none;" onclick="showPage(this)">
													<img src="'.base_url().'utama/assists/images/icons/sort_descending.png" width=20 height=20>
												</button>';
											else
												echo
												'<button class="btn btn-warning pull-right" id="pl=siswa&m=1&cr='.$cari.'&sr=nama&ur=asc" style="background-color: green;border: none;" onclick="showPage(this)">
													<img src="'.base_url().'utama/assists/images/icons/sort_ascending.png" width=20 height=20>
												</button>';
											echo
										'</th>
                                        <th><center><label class="text-bayang">L/P</label></center></th>';
										if(!(($kelas == '') or ($kelas == 'x')))
											echo
											'<th><center><label class="text-bayang">Orang Tua</label></center></th>';
										echo
                                        '<th><center><label class="text-bayang">Isi</label></center></th>
                                        <th><center><label class="text-bayang">Cetak</label></center></th>
                                        <th><center><label class="text-bayang">#</label></center></th>
									</tr>
                                </thead>
                                <tbody>';
									$jml_data = 20;
									$awal = ($mulai - 1) * $jml_data;
									$nomer = $awal;
									if($cari != '')
									{
										if($kelas == '')
											$query = $this->db->select('*')
												->from('tb_siswa')
												->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas')
												->like('tb_siswa.nama', $cari)
												->or_like('tb_siswa.no_ujian_smp', $cari)
												->or_like('tb_siswa.no_induk', $cari)
												->or_like('tb_siswa.kelas', $cari)
												->or_like('tb_siswa.alamat', $cari)
												->or_like('tb_kelas.nama_kelas', $cari)
												->limit($jml_data, $awal)
												->order_by('tb_siswa.kelas', 'asc')
												->order_by('tb_siswa.nama', 'asc')
												->get();
										else
											$query = $this->db->select('*')
												->from('tb_siswa')
												->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas')
												->where('tb_kelas.kd_kelas', $kelas)
												->like('tb_siswa.nama', $cari)
												->or_like('tb_siswa.no_ujian_smp', $cari)
												->or_like('tb_siswa.no_induk', $cari)
												->or_like('tb_siswa.kelas', $cari)
												->or_like('tb_siswa.alamat', $cari)
												->or_like('tb_kelas.nama_kelas', $cari)
												->limit($jml_data, $awal)
												->order_by('tb_siswa.kelas', 'asc')
												->order_by('tb_siswa.nama', 'asc')
												->get();
									}
									elseif(! (($kelas == '') or ($kelas == 'x')))
									{
										if(($urut != '') and ($naik != ''))
											$query = $this->db->select('*')
												->from('tb_siswa')
												->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas')
												->where('tb_kelas.kd_kelas', $kelas)
												->limit($jml_data, $awal)
												->order_by('tb_siswa.'.$urut, $naik)
												->get();
										else
											$query = $this->db->select('*')
												->from('tb_siswa')
												->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas')
												->where('tb_kelas.kd_kelas', $kelas)
												->limit($jml_data, $awal)
												->order_by('tb_siswa.nama', 'asc')
												->get();
									}
									elseif($urut != '')
									{
										if($urut == 'kelas')
										{
											$query = $this->db->select('*')
														->from('tb_siswa')
														->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas')
														->limit($jml_data, $awal)
														->order_by('tb_siswa.kelas', $naik)
														->order_by('tb_siswa.nama', 'asc')
														->get();
										}
										else
										{
											$query = $this->db->select('*')
														->from('tb_siswa')
														->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas')
														->limit($jml_data, $awal)
														->order_by('tb_siswa.'.$urut, $naik)
														->order_by('tb_siswa.nama', 'asc')
														->get();
										}
									}
									else
									{
										$query = $this->db->select('*')
													->from('tb_siswa')
													->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas')
													->limit($jml_data, $awal)
													->order_by('tb_siswa.kelas', 'asc')
													->order_by('tb_siswa.nama', 'asc')
													->get();
									}
									foreach($query->result() as $row)
									{
										$nomer++;
										$userid     = $row -> no_ujian_smp;
										$nama_siswa = $row -> nama;
										$nisn       = $row -> nisn;
										$induk      = $row -> no_induk;
										$gender     = $row -> gender;
										$nama_kelas = $row -> nama_kelas;
										$nama_ayah	= ucwords(strtolower($row -> nama_ayah));
										$isi        = $row -> sts_isi;
										$cetak      = $row -> sts_ctk;
										if($no_ujian_smp == $userid)
											echo '<tr style="background:yellow;color:red;">';
										elseif(fmod($nomer, 2) == 0)
											echo '<tr style="background:lightblue;color:black;">';
										else
											echo '<tr style="background:white;color:black;">';
										echo	'<td><center><b>'.$nomer.'</b></center></td>
												<td><center><a href="#" id="'.$userid.'&m='.$mulai.'&pl=siswa&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" onclick="editDataSiswa(this)">'.$userid.'</a></center></td>';
										if(($kelas == '') or ($kelas == 'x'))
											echo	
												'<td><center><a href="#" id="'.$userid.'&m='.$mulai.'&pl=siswa&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" onclick="editDataSiswa(this)">'.$nama_kelas.'</a></center></td>';
										echo
												'<td><center><a href="#" id="'.$userid.'&m='.$mulai.'&pl=siswa&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" onclick="editDataSiswa(this)">'.$nisn.'</a></center></td>
												<td><center><a href="#" id="'.$userid.'&m='.$mulai.'&pl=siswa&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" onclick="editDataSiswa(this)">'.$induk.'</a></center></td>
												<td><a href="#" id="'.$userid.'&m='.$mulai.'&pl=siswa&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" onclick="editDataSiswa(this)">'.$nama_siswa.'</a></td>
												<td><center><a href="#" id="'.$userid.'&m='.$mulai.'&pl=siswa&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" onclick="editDataSiswa(this)">'.$gender.'</a></center></td>';
										if(!(($kelas == '') or ($kelas == 'x')))
											echo	
												'<td><a href="#" id="'.$userid.'&m='.$mulai.'&pl=siswa&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" onclick="editDataSiswa(this)">'.$nama_ayah.'</a></td>';
										echo
												'<td><center><a href="#" id="'.$userid.'&m='.$mulai.'&pl=siswa&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" onclick="editDataSiswa(this)">'.$isi.'</a></center></td>
												<td><center><a href="#" id="'.$userid.'&m='.$mulai.'&pl=siswa&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" onclick="editDataSiswa(this)">'.$cetak.'</a></center></td>
												<td>
													<center>';
													if($level > 94)
														echo
														'<a href="cetakDataPDF?id='.$this->m_data->encryptIt($userid).'" data-toggle="tooltip" title="Cetak PDF">
															<img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=20 height=20>
														</a>
														<a href="#" id="'.$userid.'" onclick="showSuketModal('.$userid.')" data-toggle="tooltip" title="Cetak Suket">
															<img src="'.base_url().'utama/assists/images/icons/Print.ico" width=20 height=20>
														</a>
														<a href="#" id="'.$userid.'&pl=siswa" onclick="hapusData(this)" data-toggle="tooltip" title="Hapus Data">
															<img src="'.base_url().'utama/assists/images/icons/delete.ico" width=20 height=20>
														</a>';
													else
														echo '&nbsp;';
													echo
													'</center>
												</td>
											</tr>';
									}
									if($nomer == 0)
										echo
											'<tr class="text-bayang" style="background:red;color:yellow;">
												<td colspan="12"><b><center>Tidak ada data</center></b></td>
											</tr>';
									echo
								'</tbody>
							</table>';
							$this->db->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left');
							if(! (($kelas == '') or ($kelas == 'x')))
								$this->db->where('tb_kelas.kd_kelas', $kelas);
							if($cari != '')
								$this->db->like('tb_siswa.nama', $cari)
										->or_like('tb_siswa.no_ujian_smp', $cari)
										->or_like('tb_siswa.no_induk', $cari)
										->or_like('tb_siswa.kelas', $cari)
										->or_like('tb_siswa.alamat', $cari)
										->or_like('tb_kelas.nama_kelas', $cari);
							$query = $this->db->get('tb_siswa');
							$rowcounts = $query->num_rows();
							$numpages  = ceil($rowcounts / $jml_data);
							$sisa      = $rowcounts % $jml_data;
							if($sisa > 0) $numpages++;
							$pagenow   = ceil($awal / $jml_data)+1;
							$nextpage  = $pagenow + 1;
							$lastpage  = $pagenow - 1;
						
							if($nomer > 0)
								echo				
								'<b><font color="blue">Tampil <font color="red">'.($awal+1).'</font> sampai <font color="red">'.$nomer.'</font> dari <font color="red">'.$rowcounts.'</font> data</font></b><br/><br/>';
							if($level > 95)
							echo
							'*) Anda dapat mempersiapkan dan mengedit data melalui microsoft Excel. Format file dapat di <a href="dl_contoh?id=siswa">download disini</a><br />
							*) Rubahlah contoh diatas kemudian simpan dan <a href="#" id="siswa" onClick="showImportData(this)">import disini.</a>';
							echo
						'</div>
						<center>';
							
							if($rowcounts > $jml_data)
							{
								if($pagenow <= 1)
									echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_start.png" width=24 height=24 style="margin-top:-4px;">
										</button>';
								else
									echo '<a href="#" id="pl=siswa&m=1&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_start_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								if($pagenow <= 1)
									echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_rewind.png" width=24 height=24 style="margin-top:-4px;">
										</button>';
								else
									echo '<a href="#" id="pl=siswa&m='.$lastpage.'&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_rewind_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								echo '<button type="button" class="btn btn-primary" disabled>'.$pagenow.'</button>';
								if($numpages > $pagenow)
									echo '<a href="#" id="pl=siswa&m='.$nextpage.'&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_fastforward_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								else
									echo '<button type="button" class="btn btn-danger" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_fastforward.png" width=16 height=16>
										</button>';
								if($pagenow >= $numpages)
									echo '<button type="button" class="btn btn-danger" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_end.png" width=16 height=16>
										</button>';
								else
									echo '<a href="#" id="pl=siswa&m='.$numpages.'&cr='.$cari.'&sr='.$urut.'&ur='.$naik.'&kl='.$kelas.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_end_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
							}
								
						echo
						'</center>
						<br />
						<center>';
							if($level > 95)
							{
								if($nomer > 0)
									echo
									'<a href="#" id="siswa" class="btn btn-danger" onclick="hapusDataAll(this)">
										<img src="'.base_url().'utama/assists/images/icons/stop.ico" width=24 height=24> Hapus Semua Data
									</a>
									&nbsp;&nbsp;&nbsp;';
								echo
								'<a href="#" id="siswa" class="btn btn-success" onclick="editDataSiswa(this)">
									<img src="'.base_url().'utama/assists/images/icons/add_card.ico" width=24 height=24> Tambah Data
								</a>';
							}
							echo
						'</center>
						<br />
					</div>
					<!-- ./panel -->
				</div>
				<!-- ./col -->';
		exit;
	}
	
	// ********************************************************************************************
	// **********************************    Akhir Data Siswa     *********************************
	// ********************************************************************************************
	
	// *****************************************************************************************
	// **********************************    Awal Presensi     *********************************
	// *****************************************************************************************
	function showDataPresensi()
	{
		date_default_timezone_set("Asia/Jakarta");
		if(isset($_GET['m']))  {$mulai = $_GET['m'];} else {$mulai = 1;}
		if(isset($_GET['tg'])) {$tanggal = $_GET['tg'];} else {$tgl = new DateTime(); $tanggal = $tgl->format('Y-m-d');}
		if(isset($_GET['kl'])) {$kelas = $_GET['kl'];} else {$kelas = '';}
		if(isset($_GET['nm'])) {$nama = $_GET['nm'];} else {$nama = '';}
		if(isset($_GET['jm'])) 
		{
			$jam = $_GET['jm'];
			$jam = date('H:i:s', strtotime($jam));
		} 
		else 
		{
			$jam1 = new DateTime(); 
			$jam = $jam1->format('H:i:s');
		}
		
		$this->tampilanPresensi($kelas, $mulai, $tanggal, $jam, $nama);
		
		exit;
	}
	
	// ========================
	// # Fungsi Edit Presensi #
	// ========================
	function rubahPresensi()
	{
		date_default_timezone_set("Asia/Jakarta");
		
		if(isset($_GET['kl'])) {$kelas = $_GET['kl'];} else {$kelas = '';}
		if(isset($_GET['m']))  {$mulai = $_GET['m'];} else {$mulai = 1;}
		if(isset($_GET['nm'])) {$nama = $_GET['nm'];} else {$nama = '';}
		if(isset($_GET['id'])) {$induk = $_GET['id'];} else {$induk = '';}
		if(isset($_GET['jn'])) {$jenis = $_GET['jn'];} else {$jenis = '';}
		if(isset($_GET['tg'])) {$tanggal = $_GET['tg'];} else {$tgl = new DateTime(); $tanggal = $tgl->format('Y-m-d');}
		if(isset($_GET['jm'])) 
		{
			$jam = $_GET['jm'];
			$jam = date('H:i:s', strtotime($jam));
		} 
		else 
		{
			$jam1 = new DateTime(); 
			$jam = $jam1->format('H:i:s');
		}
		
		$query = $this->db->select('*')
					->from('tb_presensi')
					->where('induk', $induk)
					->where('tanggal', $tanggal)
					->get();
		$rowcounts = $query->num_rows();
		if($rowcounts > 0)
		{
			$row = $query->row();
			$jns = $row->jenis;
			if($jns == $jenis)
			{
				$this->db->where('induk', $induk)->where('tanggal', $tanggal)->delete('tb_presensi');
				$jenis = '';
			}
			else
			{
				$data = array('jenis' => $jenis, 'jam' => $jam);
				$this->db->where('induk', $induk)->where('tanggal', $tanggal)->update('tb_presensi', $data);
			}
		}
		else
		{
			$data = array('induk' => $induk, 'tanggal' => $tanggal, 'jenis' => $jenis, 'jam' => $jam);
			$this->db->insert('tb_presensi', $data);
		}
			
		$this->tampilanPresensi($kelas, $mulai, $tanggal, $jam, $nama);
			
		exit;
	}

	// =================================
	// # Fungsi Tampilan Page Presensi #
	// =================================
	function tampilanPresensi($kelas, $mulai, $tanggal, $jam, $nama)
	{
		$level    = $this->session->userdata('level');
		$username = $this->session->userdata('username');
		if($level == 94)
		{
			$query = $this->db->select('*')
					->from('tb_wali')
					->where('kd_guru', $username)
					->get();
			$hasil = $query -> num_rows();
			if($hasil > 0)
			{
				$row = $query->row();
				$kelas = $row->kelas;
			}
		}
		
		echo
			'<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading text-bayang">
						<center><b><i>Daftar Presensi Siswa</i></b></center>
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-horizontal">
									<div class="form-group">
										<label for="inputCetak" class="col-md-2 control-label">Filter :</label>
										<div class="col-md-4" style="margin-top:4px;margin-left:0px;">
											<input type="radio" id="semua" name="semua" value="0" ';if($kelas == '') echo 'checked '; if($level < 96) echo ' disabled '; echo 'onclick="rubahKelas(this)"> Semua
											&nbsp;&nbsp;&nbsp;
											<input type="radio" id="kelasPil" name="semua" value="1" ';if($kelas != '') echo 'checked '; if($level < 96) echo ' disabled '; echo 'onclick="rubahKelas(this)"> Per Kelas
										</div>
										<div class="col-md-5" id="idKelas" ';if(($level > 94) and ($kelas != '')) echo ' style="display:inline;margin-top:4px;">'; else echo ' style="display:none;margin-top:4px;">';
											echo
											'<label for="inputCetak" class="col-md-5 control-label" style="margin-top:-6px;margin-left:-26px;">Kelas :</label>
											<select class="col-md-7" id="kelasSelect" name="kelasSelect" style="margin-top:-4px;margin-left:0px;height: 32px;" ';if($level < 96) echo ' disabled '; echo ' oninput="rubahKelas(this)">';
												$query = $this->db->select('*')
														->from('tb_kelas')
														->get();
												if($query->num_rows() > 0)
												{
													foreach($query->result() as $row)
													{
														$kd_kelas = $row->kd_kelas;
														if($kelas == $kd_kelas)
															echo '<option value="'.$row->kd_kelas.'" selected> '.$row->nama_kelas.'</option>';
														else
															echo '<option value="'.$row->kd_kelas.'"> '.$row->nama_kelas.'</option>';
													}
												}
											echo
											'</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-horizontal">
									<div class="form-group">
										<label for="inputData" class="col-md-2 control-label">Tanggal :</label>
										<div class="col-md-4" style="margin-top:4px;margin-left:0px;">
											<input type="date" id="tanggal" name="tanggal" value="'.$tanggal.'" oninput="rubahKelas(this)">
										</div>
										<label for="inputData" class="col-md-2 control-label">Jam :</label>
										<div class="col-md-4" style="margin-top:4px;margin-left:0px;">
											<input type="time" id="jam" name="jam" value="'.$jam.'">
										</div>
									</div>
								</div>
							</div>
						</div>
						<b><font color="blue">*) Untuk Terlambat / Ijin, <font color="red">setting jam </font><font color="blue">terlebih dahulu</font></b>
						<div class="row">';
							$jml_data = 40;
							$perkolom = 20;
							$awal = ($mulai - 1) * $jml_data;
							$nomer = $awal;
							for($kolom = 0; $kolom < 2; $kolom++)
							{
								if(($kolom == 0) or (($kolom == 1) and ($nomer > ($awal+20))))
								{
							echo
							'<div class="col-md-6">
								<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr style="background:green;color:yellow;">
											<th><center><label class="text-bayang">No.</label></center></th>
											<th><center><label class="text-bayang">Kelas</label></center></th>
											<th><center><label class="text-bayang">Induk</label></center></th>
											<th><center><label class="text-bayang">Nama</label></center></th>
											<th><center><label class="text-bayang">L/P</label></center></th>
											<th><center><label class="text-bayang">Kehadiran</label></center></th>
										</tr>
									</thead>
									<tbody>';
										$awal1 = $awal + $kolom * $perkolom;
										if($kelas != '')
										{
											$query = $this->db->select('*')
														->from('tb_siswa')
														->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
														->where('tb_siswa.kelas', $kelas)
														->limit($perkolom, $awal1)
														->order_by('tb_siswa.nama', 'asc')
														->get();
										}
										else
										{
											$query = $this->db->select('*')
														->from('tb_siswa')
														->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
														->limit($perkolom, $awal1)
														->order_by('tb_siswa.kelas', 'asc')
														->order_by('tb_siswa.nama', 'asc')
														->get();
										}
										foreach($query->result() as $row)
										{
											$nomer++;
											$userid     = $row -> no_ujian_smp;
											$nama_siswa = $row -> nama;
											$induk      = $row -> no_induk;
											$gender     = $row -> gender;
											$nama_kelas = $row -> nama_kelas;
											if($nama == $nama_siswa)
												echo 
												'<tr style="background:yellow;color:red;">';
											elseif(fmod($nomer, 2) == 0)
												echo 
												'<tr style="background:lightblue;color:black;">';
											else
												echo 
												'<tr style="background:white;color:black;">';
												
											echo	'<td><center><b>'.$nomer.'</b></center></td>
													<td><center>'.$nama_kelas.'</center></td>
													<td><center>'.$induk.'</center></td>
													<td>'.ucwords(strtolower($nama_siswa)).'</td>
													<td><center>'.$gender.'</center></td>';
													
											$query1 = $this->db->select('*')
														->from('tb_presensi')
														->where('induk',$induk)
														->where('tanggal', $tanggal)
														->get();
											$adaData = $query1->num_rows();
											if($adaData > 0)
											{
												$row1 = $query1 -> row();
												$jenis = $row1 -> jenis;
												$jamT  = $row1 -> jam;
											}
											else
												$jenis = ' Ada ';
											if($level > 94)
											{
											echo
													'<td>
														<center>
															<a href="#" id="id='.$induk.'&jn=S" onclick="rubahPresensi(this)" data-toggle="tooltip" title="Toggle Sakit">';
																if($jenis == 'S')
																	echo
																	'<img src="'.base_url().'utama/assists/images/icons/temperature_5.png" width=20 height=20 style="background-color:red;">';
																else
																	echo
																	'<img src="'.base_url().'utama/assists/images/icons/key_s.png" width=20 height=20>';
											echo
															'</a>
															<a href="#" id="id='.$induk.'&jn=I" onclick="rubahPresensi(this)" data-toggle="tooltip" title="Toggle Ijin">';
																if($jenis == 'I')
																	echo
																	'<img src="'.base_url().'utama/assists/images/icons/document_info.png" width=20 height=20 style="background-color:red;">';
																else
																	echo
																	'<img src="'.base_url().'utama/assists/images/icons/key_i.png" width=20 height=20>';
											echo
															'</a>
															<a href="#" id="id='.$induk.'&jn=A" onclick="rubahPresensi(this)" data-toggle="tooltip" title="Toggle Alpha">';
																if($jenis == 'A')
																	echo
																	'<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20 style="background-color:red;">';
																else
																	echo
																	'<img src="'.base_url().'utama/assists/images/icons/key_a.png" width=20 height=20>';
											echo
															'</a>
															<a href="#" id="id='.$induk.'&jn=T" onclick="rubahPresensi(this)" data-toggle="tooltip" title="Toggle Terlambat">';
																if($jenis == 'T')
																	echo
																	'<img src="'.base_url().'utama/assists/images/icons/lock.png" width=20 height=20 style="background-color:red;">';
																else
																	echo
																	'<img src="'.base_url().'utama/assists/images/icons/key_t.png" width=20 height=20>';
											echo
															'</a>
														</center>
													</td>';
											}
											else
												echo '<td><center><b>'.$jenis.'</b></center></td>';
											echo
												'</tr>';
										}
										if($nomer == 0)
											echo
												'<tr class="text-bayang" style="background:red;color:yellow;">
													<td colspan="6"><b><center>Tidak ada data</center></b></td>
												</tr>';
										echo
									'</tbody>
								</table>
							</div>
							<!-- ./col -->';
								}
							}
						echo
						'</div>
						<!-- ./row -->';
						if($kelas != '')
						{
							$query = $this->db->select('*')
										->from('tb_siswa')
										->where('tb_siswa.kelas', $kelas)
										->get();
						}
						else
							$query = $this->db->select('*')
										->from('tb_siswa')
										->get();
						$rowcounts = $query->num_rows();
						$numpages  = ceil($rowcounts / $jml_data);
						$sisa      = $rowcounts % $jml_data;
						if($sisa > 0) $numpages++;
						$pagenow   = ceil($awal / $jml_data)+1;
						$nextpage  = $pagenow + 1;
						$lastpage  = $pagenow - 1;
						
						if($nomer > 0)
							echo
							'<b><font color="blue">Tampil <font color="red">'.($awal+1).'</font> sampai <font color="red">'.$nomer.'</font> dari <font color="red">'.$rowcounts.'</font> data</font></b><br/><br/>';
						echo
					'</div>
					<!-- ./panel body -->
					<center>';
							
						if($rowcounts > $jml_data)
						{
							if($pagenow <= 1)
								echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
										<img src="'.base_url().'utama/assists/images/icons/control_start.png" width=24 height=24 style="margin-top:-4px;">
									</button>';
							else
								echo '<a href="#" id="pl=presensi&m=1" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
										<img src="'.base_url().'utama/assists/images/icons/control_start_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
							if($pagenow <= 1)
								echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
										<img src="'.base_url().'utama/assists/images/icons/control_rewind.png" width=24 height=24 style="margin-top:-4px;">
									</button>';
							else
								echo '<a href="#" id="pl=presensi&m='.$lastpage.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
										<img src="'.base_url().'utama/assists/images/icons/control_rewind_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
							echo '<button type="button" class="btn btn-primary" disabled>'.$pagenow.'</button>';
							if($numpages > $pagenow)
								echo '<a href="#" id="pl=presensi&m='.$nextpage.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
										<img src="'.base_url().'utama/assists/images/icons/control_fastforward_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
							else
								echo '<button type="button" class="btn btn-danger" disabled>
										<img src="'.base_url().'utama/assists/images/icons/control_fastforward.png" width=16 height=16>
									</button>';
							if($pagenow >= $numpages)
								echo '<button type="button" class="btn btn-danger" disabled>
										<img src="'.base_url().'utama/assists/images/icons/control_end.png" width=16 height=16>
									</button>';
							else
								echo '<a href="#" id="pl=presensi&m='.$numpages.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
										<img src="'.base_url().'utama/assists/images/icons/control_end_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
						}
								
					echo
					'</center><br/>';
					if($level > 94)
					{
						echo
					'<center>
						<a href="#" id="pl=presensi&id=pdf" class="btn btn-primary" onclick="ctkPresensi(this)">
							<img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=24 height=24> Export Data
						</a>
						&nbsp;&nbsp;&nbsp;
						<a href="#" id="pl=presensi&id=xls" class="btn btn-success" onclick="ctkPresensi(this)">
							<img src="'.base_url().'utama/assists/images/icons/file_extension_xls.png" width=24 height=24> Export Data
						</a>
					</center>
					<br />';
					}
					echo
				'</div>
				<!-- ./panel -->
			</div>
			<!-- ./col -->';
		return;
	}
	
	// ====================================
	// # Fungsi Input buat Print Presensi #
	// ====================================
	public function ctkPresensiModal()
	{
		$tgl = new DateTime(); 
		$pilihan = $this->input->get('pl');
		$pilih = $this->input->get('id');
		if(isset($_GET['sm'])) $semuaM = $this->input->get('sm'); else $semuaM = 0;
		if(isset($_GET['kl'])) $kelasM = $this->input->get('kl'); else $kelasM = '';
		if(isset($_GET['sw'])) $siswaM = $this->input->get('sw'); else $siswaM = '';
		if(isset($_GET['t1'])) $tglCetak1 = $this->input->get('t1'); else $tglCetak1 = $tgl->format('Y-m-d');
		if(isset($_GET['t2'])) $tglCetak2 = $this->input->get('t2'); else $tglCetak2 = $tgl->format('Y-m-d');
		if(isset($_GET['jn'])) $jenisM = $this->input->get('jn'); else $jenisM = 0;
		
		echo
		'<!-- modal-dialog -->
		<div class="modal-dialog" role="document">
			<!-- modal-content -->';
			if(strtolower($pilihan) == 'presensi')
			{
				if($pilih == 'xls')
					echo '<form id="ctkPresensiForm" action="exportData" method="get">';
				else
					echo '<form id="ctkPresensiForm" action="cetakPresensiPDF" method="post">';
			}
			elseif(strtolower($pilihan) == 'langgar')
			{
				if($pilih == 'xls')
					echo '<form id="ctkPresensiForm" action="exportData" method="get">';
				else
					echo '<form id="ctkPresensiForm" action="cetakLanggarPDF" method="post">';
			}
			echo
			'<input type="hidden" id="pl" name="pl" value="'.$pilihan.'">
			<input type="hidden" id="pilih" name="pilih" value="'.$pilih.'">
			<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
				<!-- modal header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title" id="isianUserLabel" style="margin-bottom:0px;margin-top:0px;color: yellow;text-shadow: 2px 2px 4px black, 0 0 25px white, 0 0 5px darkblue;">';
					if(strtolower($pilihan) == 'presensi')
					{
						if($pilih == 'xls')
							echo '<center><b><img src="'.base_url().'utama/assists/images/icons/file_extension_xls.png" width=32 height=32> Cetak Presensi Siswa</b></center>';
						else
							echo '<center><b><img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=32 height=32> Cetak Presensi Siswa</b></center>';
					}
					elseif(strtolower($pilihan) == 'langgar')
					{
						if($pilih == 'xls')
							echo '<center><b><img src="'.base_url().'utama/assists/images/icons/file_extension_xls.png" width=32 height=32> Cetak Pelanggaran Siswa</b></center>';
						else
							echo '<center><b><img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=32 height=32> Cetak Pelanggaran Siswa</b></center>';
					}
					echo
					'</h3>
				</div>
				<!-- ./modal header -->

				<!-- modal body -->
				<div class="modal-body">
					<div class="panel panel-primary" style="background-color: #F0E0C0;border-radius: 16px;">
						<div class="panel-body" style="background-color: #F0E0C0;border-radius: 16px;">

							<div class="row">
								<div class="form-group col-md-12" style="margin-top: -2px;">
									<label class="text-bayang">Pilih : </label>
									&nbsp;&nbsp;&nbsp;
									<input type="radio" id="semuaModal" name="semua" value="0" '; if($semuaM == 0) echo ' checked '; echo ' onclick="showKelas(this)"> Semua
									&nbsp;&nbsp;&nbsp;
									<input type="radio" id="kelasX" name="semua" value="1" onclick="showKelas(this)"> Kelas
									&nbsp;&nbsp;&nbsp;
									<input type="radio" id="siswa" name="semua" value="2" onclick="showKelas(this)"> Siswa
								</div>
								<!--
								<div class="form-group col-md-6">
									<label for="inputCetak" class="col-md-4 control-label">Cetak :</label>
									<div class="col-md-8" style="margin-top: -2px;">
										<input type="radio" id="list" name="rekap" value="0" checked> Detail
										&nbsp;&nbsp;&nbsp;
										<input type="radio" id="rekap" name="rekap" value="1"> Rekap
									</div>
								</div>
								-->
							</div>';
							if(strtolower($pilihan) == 'langgar')
							{
								echo
							'<div class="row">
								<div class="form-group col-md-12" style="margin-top: -2px;">
									<label class="text-bayang">Proses : </label>
									&nbsp;&nbsp;&nbsp;
									<input type="radio" id="jenisA" name="jenis" value="0" '; if($jenisM == 0) echo ' checked '; echo '> Semua
									&nbsp;&nbsp;&nbsp;
									<input type="radio" id="jenisB" name="jenis" value="1"> Belum
									&nbsp;&nbsp;&nbsp;
									<input type="radio" id="jenisP" name="jenis" value="2"> Proses
									&nbsp;&nbsp;&nbsp;
									<input type="radio" id="jenisS" name="jenis" value="2"> Sudah
								</div>
							</div>';
							}
							echo
							'<div class="row" style="margin-top: -8px;">
								<div class="form-group">
									<label class="col-md-2 text-bayang">Tanggal : </label>
									<div class="col-md-4" style="margin-top:-2px;margin-left:0px;">
										<input type="date" id="tglCetak1" name="tglCetak1" value="'.$tglCetak1.'">
									</div>
									<div class="col-md-1" style="margin-top:0px;margin-left:-30px;">
										<label class="col-md-1 text-bayang"><center><b>s/d</b></center></label>
									</div>
									<div class="col-md-4" style="margin-top:-2px;margin-left:0px;">
										<input type="date" id="tglCetak2" name="tglCetak2" value="'.$tglCetak2.'">
									</div>
								</div>
							</div>
							<div class="row" style="margin-top: 4px;">
								<div class="col-md-4 form-group" id="idKelasModal" style="display:none;margin-top: 4px">
									<label class="text-bayang">Kelas : </label>
									&nbsp;&nbsp;&nbsp;
									<select id="kelasPilih" name="kelasPilih" style="height: 32px;width: 100px;" onchange="showKelas(this)">';
										$query = $this->db->select('*')
													->from('tb_kelas')
													->get();
										if($query->num_rows() > 0)
										{
											foreach($query->result() as $row)
											{
												$kd_kelas = $row->kd_kelas;
												if($kelasM == $kd_kelas)
													echo '<option value="'.$row->kd_kelas.'" selected> '.$row->nama_kelas.'</option>';
												else
													echo '<option value="'.$row->kd_kelas.'"> '.$row->nama_kelas.'</option>';
											}
										}
									echo
									'</select>
								</div>
								<div class="col-md-8 form-group" id="idSiswaModal" style="display:none;margin-top: 4px;margin-left: -20px;">
									<label class="text-bayang">Siswa : </label>
									&nbsp;&nbsp;&nbsp;
									<select id="siswaSel" name="siswaSel" style="height: 32px;width: 290px;margin-right: 0;">';
									$query = $this->db->select('*')
												->from('tb_siswa')
												->where('kelas', $kelasM)
												->order_by('nama', 'asc')
												->get();
									if($query->num_rows() > 0)
									{
										foreach($query->result() as $row)
										{
											$no_ujian_smp = $row->no_ujian_smp;
											if($no_ujian_smp == $siswaM)
												echo '<option value="'.$row->no_induk.'" selected> '.$row->nama.'</option>';
											else
												echo '<option value="'.$row->no_induk.'"> '.$row->nama.'</option>';
										}
									}
									echo
									'</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- ./modal body -->
							
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
						<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
					</button>
					<button type="button" id="'.$pilih.'" class="btn btn-primary" style="border-radius:8px;" onclick="cekCtkPresensi()">
						<img src="'.base_url().'utama/assists/images/icons/Print.ico" width=20 height=20> Cetak
					</button>
				</div>
				<!-- ./modal footer -->
			</div>
			<!-- /.modal-content -->
			</form>
		</div>
		<!-- /.modal-dialog -->';

		exit;
	}

	// ******************************************************************************************
	// *********************************     Akhir Presensi     *********************************
	// ******************************************************************************************
	
	// ********************************************************************************************
	// **********************************    Awal Pelanggaran     *********************************
	// ********************************************************************************************
	function showDataLanggar()
	{
		$level    = $this->session->userdata('level');
		$username = $this->session->userdata('username');
		
		$pilih = $this->input->get('pl');

		if(isset($_GET['m']))   $mulai    = $_GET['m']; 	else $mulai = 1;
		if(isset($_GET["id"]))  $id       = $_GET["id"];	else $id    = "";
		if(isset($_GET["idk"])) $indukP   = $_GET["idk"];	else $indukP = "";
		if(isset($_GET["nm"]))  $nama     = $_GET["nm"];	else $nama  = "";
		if(isset($_GET["kl"]))  $kelas    = $_GET["kl"];	else $kelas = "";
		if(isset($_GET["jn"]))  $jenis    = $_GET["jn"];	else $jenis = "";
		if(isset($_GET['tg1'])) $tglAwal  = $_GET['tg1'];	else {$tgl = new DateTime(); $tglAwal = $tgl->format('Y-m-d');}
		if(isset($_GET['tg2'])) $tglAkhir = $_GET['tg2'];	else {$tgl = new DateTime('tomorrow'); $tglAkhir = $tgl->format('Y-m-d');}
		$batasKar = 25;
		
		if($level == 94)
		{
			$query = $this->db->select('*')
					->from('tb_wali')
					->where('kd_guru', $username)
					->get();
			$hasil = $query -> num_rows();
			if($hasil > 0)
			{
				$row = $query->row();
				$kelas = $row->kelas;
			}
		}
		
		echo
			'<div class="col-md-12">
				<input type="hidden" id="pl" name="pl" value="langgar">
				<div class="panel panel-primary">
					<div class="panel-heading text-bayang">
						<center><b><i>Daftar Pelanggaran Siswa</i></b></center>
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-horizontal">
									<div class="form-group">
										<label for="inputCetak" class="col-md-1 control-label">Filter :</label>
										<input type="radio" style="margin-top:12px;" id="semua" name="semua" value="0" ';if($kelas == '') echo 'checked ';if($level < 95) echo ' disabled '; echo ' oninput="rubahKelasLanggar('.$mulai.')"> <b>Semua</b>
										&nbsp;&nbsp;&nbsp;
										<input type="radio" style="margin-top:12px;" id="kelas" name="semua" value="1" ';if($kelas != '') echo 'checked ';if($level < 95) echo ' disabled '; echo ' oninput="rubahKelasLanggar('.$mulai.')"> <b>Per Kelas</b>
										&nbsp;&nbsp;&nbsp;';
										if($kelas == '')
											echo
											'<div id="idKelasLanggar" style="display:none;">';
										else
											echo
											'<div id="idKelasLanggar" style="display:inline;">';
										echo
											'<b>Kelas :&nbsp;</b>
											<select id="kelasSelect" name="kelasSelect" style="height: 32px;" ';if($level < 95) echo ' disabled '; echo ' oninput="rubahKelasLanggar('.$mulai.')">
												<option value=""></option>';
												$query = $this->db->select('*')
														->from('tb_kelas')
														->get();
												if($query->num_rows() > 0)
												{
													foreach($query->result() as $row)
													{
														$kd_kelas = $row->kd_kelas;
														if($kelas == $kd_kelas)
															echo '<option value="'.$row->kd_kelas.'" selected> '.$row->nama_kelas.'</option>';
														else
															echo '<option value="'.$row->kd_kelas.'"> '.$row->nama_kelas.'</option>';
													}
												}
											echo
											'</select>
										</div>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Tanggal :&nbsp;</b>
										<input type="date" id="tglAwal" name="tglAwal" style="height: 32px;" value="'.$tglAwal.'" oninput="rubahKelasLanggar('.$mulai.')">
										&nbsp;&nbsp;&nbsp;<b>s/d&nbsp;&nbsp;&nbsp;</b>
										<input type="date" id="tglAkhir" name="tglAkhir" style="height: 32px;" value="'.$tglAkhir.'" oninput="rubahKelasLanggar('.$mulai.')">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-horizontal">
									<div class="form-group">
										<label for="inputCetak" class="col-md-1 control-label" style="margin-top:-10px;">Status :</label>
										<input type="radio" style="margin-top:-6px;" id="jenisAll" name="jenis" value="0" ';if($jenis == '') echo 'checked '; echo ' oninput="rubahKelasLanggar('.$mulai.')"> <b>Semua</b>
										&nbsp;&nbsp;
										<input type="radio" style="margin-top:-6px;" id="jenisBlm" name="jenis" value="1" ';if($jenis == 'B') echo 'checked '; echo ' oninput="rubahKelasLanggar('.$mulai.')"> <b>Belum</b>
										&nbsp;&nbsp;
										<input type="radio" style="margin-top:-6px;" id="jenisSdh" name="jenis" value="2" ';if($jenis == 'S') echo 'checked '; echo ' oninput="rubahKelasLanggar('.$mulai.')"> <b>Sudah</b>
										&nbsp;&nbsp;
										<input type="radio" style="margin-top:-6px;" id="jenisPrs" name="jenis" value="3" ';if($jenis == 'P') echo 'checked '; echo ' oninput="rubahKelasLanggar('.$mulai.')"> <b>Proses</b>
									</div>
								</div>
							</div>
						</div>
						<div class="row">';
							$jml_data = 20;
							$awal = ($mulai - 1) * $jml_data;
							$nomer = $awal;
							echo
							'<div class="col-md-12">
								<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr style="background:green;color:yellow;">
											<th><center><label class="text-bayang">No.</label></center></th>
											<th><center><label class="text-bayang">Tanggal</label></center></th>
											<th><center><label class="text-bayang">Kelas</label></center></th>
											<th><center><label class="text-bayang">Induk</label></center></th>
											<th><center><label class="text-bayang">Nama</label></center></th>
											<th><center><label class="text-bayang">L/P</label></center></th>
											<th><center><label class="text-bayang">Pelanggaran</label></center></th>
											<th><center><label class="text-bayang">Ditangani</label></center></th>
											<th><center><label class="text-bayang">Oleh</label></center></th>
											<th><center><label class="text-bayang">Solusi</label></center></th>
											<th><center><label class="text-bayang">Status</label></center></th>
										</tr>
									</thead>
									<tbody>';
										if($kelas != '')
										{
											$this->db->join('tb_siswa', 'tb_langgar.induk = tb_siswa.no_induk', 'left')
														->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
														->where('tb_siswa.kelas', $kelas)
														->where('tb_langgar.tanggal >=', $tglAwal)
														->where('tb_langgar.tanggal <=', $tglAkhir);
											if($jenis != '')
												$this->db->where('tb_langgar.statusL', $jenis);
											$this->db->limit($jml_data, $awal)
														->order_by('tb_langgar.tanggal', 'asc')
														->order_by('tb_siswa.nama', 'asc');
											$query = $this->db->get('tb_langgar');
										}
										else
										{
											$this->db->join('tb_siswa', 'tb_langgar.induk = tb_siswa.no_induk', 'left')
														->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
														->where('tb_langgar.tanggal >=', $tglAwal)
														->where('tb_langgar.tanggal <=', $tglAkhir);
											if($jenis != '')
												$this->db->where('tb_langgar.statusL', $jenis);
											$this->db->limit($jml_data, $awal)
														->order_by('tb_langgar.tanggal', 'asc')
														->order_by('tb_siswa.kelas', 'asc')
														->order_by('tb_siswa.nama', 'asc');
											$query = $this->db->get('tb_langgar');
										}
										foreach($query->result() as $row)
										{
											$nomer++;
											$noL		= $row -> no;
											$userid     = $row -> no_ujian_smp;
											$tanggal    = $row -> tanggal;
											$nama_siswa = $row -> nama;
											$induk      = $row -> no_induk;
											$gender     = $row -> gender;
											$nama_kelas = $row -> nama_kelas;
											$mslh		= $row -> masalah;
											$tangani	= $row -> tangani;
											$oleh		= $row -> oleh;
											$solusi		= $row -> solusi;
											$status		= $row -> statusL;
											if (strlen($mslh) > $batasKar)
												$mslh = substr($mslh, 0, strrpos(substr($mslh, 0, $batasKar), ' ')) . '...';
											if (strlen($solusi) > $batasKar)
												$solusi = substr($solusi, 0, strrpos(substr($solusi, 0, $batasKar), ' ')) . '...';
											if($nama == $nama_siswa)
												echo 
												'<tr style="background:yellow;color:red;">';
											elseif(fmod($nomer, 2) == 0)
												echo 
												'<tr style="background:lightblue;color:black;">';
											else
												echo 
												'<tr style="background:white;color:black;">';
												
											echo	'<td><center><b>'.$nomer.'</b></center></td>
													<td><center><a href="#" id="'.$noL.'" onclick="showLanggarModal(this)">'.$tanggal.'</a></center></td>
													<td><center><a href="#" id="'.$noL.'" onclick="showLanggarModal(this)">'.$nama_kelas.'</a></center></td>
													<td><center><a href="#" id="'.$noL.'" onclick="showLanggarModal(this)">'.$induk.'</a></center></td>
													<td><a href="#" id="'.$noL.'" onclick="showLanggarModal(this)">'.ucwords(strtolower($nama_siswa)).'</a></td>
													<td><center><a href="#" id="'.$noL.'" onclick="showLanggarModal(this)">'.$gender.'</a></center></td>
													<td><a href="#" id="'.$noL.'" onclick="showLanggarModal(this)">'.$mslh.'</a></td>
													<td><a href="#" id="'.$noL.'" onclick="showLanggarModal(this)">'.$tangani.'</a></td>
													<td><a href="#" id="'.$noL.'" onclick="showLanggarModal(this)">'.$oleh.'</a></td>
													<td><a href="#" id="'.$noL.'" onclick="showLanggarModal(this)">'.$solusi.'</a></td>
													<td>
														<center>
															<a href="#" id="'.$noL.'" onclick="showLanggarModal(this)">';
																if($status == 'B')
																	echo '<b><font color="green">Belum</font></b>';
																elseif($status == 'S')
																	echo '<b><font color="red">Sudah</font></b>';
																elseif($status == 'P')
																	echo '<b><font color="yellow">Proses</font><b>';
																else
																	echo '&nbsp;';
																echo
															'</a>';
															if($level > 94)
																echo
															'&nbsp;&nbsp;
															<a href="#" id="'.$noL.'&pl=langgar" onclick="hapusData(this)">
																<img src="'.base_url().'utama/assists/images/icons/delete.ico" width=20 height=20>
															</a>';
															echo
														'</center>
													</td>
												</tr>';
										}
										if($nomer == 0)
											echo
												'<tr class="text-bayang" style="background:red;color:yellow;">
													<td colspan="11"><b><center>Tidak ada data</center></b></td>
												</tr>';
										echo
									'</tbody>
								</table>
							</div>
							<!-- ./col -->
						</div>
						<!-- ./row -->';
						if($kelas != '')
						{
							$this->db->join('tb_siswa', 'tb_langgar.induk = tb_siswa.no_induk', 'left')
										->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
										->where('tb_siswa.kelas', $kelas)
										->where('tb_langgar.tanggal >=', $tglAwal)
										->where('tb_langgar.tanggal <=', $tglAkhir);
							if($jenis != '')
								$this->db->where('tb_langgar.statusL', $jenis);
							$query = $this->db->get('tb_langgar');
						}
						else
						{
							$this->db->join('tb_siswa', 'tb_langgar.induk = tb_siswa.no_induk', 'left')
										->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
										->where('tb_langgar.tanggal >=', $tglAwal)
										->where('tb_langgar.tanggal <=', $tglAkhir);
							if($jenis != '')
								$this->db->where('tb_langgar.statusL', $jenis);
							$query = $this->db->get('tb_langgar');
						}
						$rowcounts = $query->num_rows();
						$numpages  = ceil($rowcounts / $jml_data);
						$sisa      = $rowcounts % $jml_data;
						if($sisa > 0) $numpages++;
						$pagenow   = ceil($awal / $jml_data)+1;
						$nextpage  = $pagenow + 1;
						$lastpage  = $pagenow - 1;
						
						if($nomer > 0)
							echo
							'<b><font color="blue">Tampil <font color="red">'.($awal+1).'</font> sampai <font color="red">'.$nomer.'</font> dari <font color="red">'.$rowcounts.'</font> data</font></b><br/><br/>';
						echo
					'</div>
					<!-- ./panel body -->
					<center>';
						if($rowcounts > $jml_data)
						{
							if($pagenow <= 1)
								echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
										<img src="'.base_url().'utama/assists/images/icons/control_start.png" width=24 height=24 style="margin-top:-4px;">
									</button>';
							else
								echo '<a href="#" id="pl=langgar&m=1" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
										<img src="'.base_url().'utama/assists/images/icons/control_start_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
							if($pagenow <= 1)
								echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
										<img src="'.base_url().'utama/assists/images/icons/control_rewind.png" width=24 height=24 style="margin-top:-4px;">
									</button>';
							else
								echo '<a href="#" id="pl=langgar&m='.$lastpage.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
										<img src="'.base_url().'utama/assists/images/icons/control_rewind_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
							echo '<button type="button" class="btn btn-primary" disabled>'.$pagenow.'</button>';
							if($numpages > $pagenow)
								echo '<a href="#" id="pl=langgar&m='.$nextpage.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
										<img src="'.base_url().'utama/assists/images/icons/control_fastforward_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
							else
								echo '<button type="button" class="btn btn-danger" disabled>
										<img src="'.base_url().'utama/assists/images/icons/control_fastforward.png" width=16 height=16>
									</button>';
							if($pagenow >= $numpages)
								echo '<button type="button" class="btn btn-danger" disabled>
										<img src="'.base_url().'utama/assists/images/icons/control_end.png" width=16 height=16>
									</button>';
							else
								echo '<a href="#" id="pl=langgar&m='.$numpages.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
										<img src="'.base_url().'utama/assists/images/icons/control_end_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
						}
					echo
					'</center>';
					if(($level > 94) and ($nomer > 0))
					{
						echo
					'<br/>
					<center>
						<a href="#" id="langgar" class="btn btn-danger" onclick="hapusDataAll(this)">
							<img src="'.base_url().'utama/assists/images/icons/stop.ico" width=24 height=24> Hapus Semua Data
						</a>
						&nbsp;&nbsp;&nbsp;
						<a href="#" id="pl=langgar&id=pdf" class="btn btn-primary" onclick="ctkPresensi(this)">
							<img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=24 height=24> Export Data
						</a>
						&nbsp;&nbsp;&nbsp;
						<button type="button" id="pl=langgar&id=xls" class="btn btn-success" onclick="ctkPresensi(this)">
							<img src="'.base_url().'utama/assists/images/icons/file_extension_xls.png" width=24 height=24> Export Data
						</button>
						&nbsp;&nbsp;&nbsp;
						<a href="#" id="0" class="btn btn-primary" onclick="showLanggarModal(this)">
							<img src="'.base_url().'utama/assists/images/icons/add_card.ico" width=24 height=24> Tambah Data
						</a>
					</center>';
					}
					echo
					'<br />
				</div>
				<!-- ./panel -->
			</div>
			<!-- ./col -->';
			
		exit;
	}

	// ===========================
	// # Fungsi Edit Pelanggaran #
	// ===========================
	function showLanggarModal()
	{
		date_default_timezone_set("Asia/Jakarta");
		$level    = $this->session->userdata('level');
		
		if(isset($_GET["id"])) $id = $_GET["id"]; else $id = '';
		if(($id == '') or ($id == 0))
		{
			$id = '';
			$kelas = '';
			$induk = '';
			$tgl = new DateTime(); 
			$tanggal = $tgl->format('Y-m-d');
			$tangani = $tanggal;
			$jam = $tgl->format('H:i:s');
			$masalah = '';
			$oleh = '';
			$solusi = '';
			$jenis = 'B';
			$nama = '';
		}
		else
		{
			$query = $this->db->select('*')
						->from('tb_langgar')
						->join('tb_siswa', 'tb_siswa.no_induk=tb_langgar.induk', 'left')
						->where('tb_langgar.no', $id)
						->get();
			$row = $query->row();
			$kelas = $row->kelas;
			$induk = $row->induk;
			$tgl = $row->tanggal;
			$tanggal = date("Y-m-d", strtotime($tgl));
			$jam = date("H:i:s", strtotime($tgl));
			$tangani = $row->tangani;
			$masalah = $row->masalah;
			$oleh = $row->oleh;
			$solusi = $row->solusi;
			$jenis = $row->statusL;
			$nama = $row->nama;
		}
		
		echo
				'<input type="hidden" id="nomerP" name="nomerP" value="'.$id.'">
				<!-- modal-dialog -->
				<div class="modal-dialog modal-lg" role="document">
					<!-- modal-content -->
					<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
						<!-- modal header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title hit-the-floor" id="isianUserLabel">
								<center>
									<img src="'.base_url().'utama/assists/images/icons/emotion_unhappy.png" width=36 height=36> <b>Data Pelanggaran Siswa</b>
								</center>
							</h3>
						</div>
						<!-- ./modal header -->

						<!-- modal body -->
						<div class="modal-body" id="idLanggarSiswa">
								
							<div class="row">
								<!-- sisi kiri -->
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-3">
											<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
												Kelas
											</label>
										</div>
										<div class="col-md-6">
											<select id="kelasSelect" name="kelasSelect" style="height:28px;width:50%;" ';
											if($id != '') echo ' disabled ';
											echo ' oninput="showSiswa(this)">
												<option value=""></option>';
												$query = $this->db->select('*')
															->from('tb_kelas')
															->order_by('kd_kelas', 'asc')
															->get();
												if($query->num_rows() > 0)
												{
													foreach($query->result() as $row)
													{
														$kd_kelas = $row->kd_kelas;
														if($kelas == $kd_kelas)
															echo '<option value="'.$row->kd_kelas.'" selected> '.$row->nama_kelas.'</option>';
														else
															echo '<option value="'.$row->kd_kelas.'"> '.$row->nama_kelas.'</option>';
													}
												}
											echo
											'</select>
										</div>
									</div>
									<br/>
									<div class="row">
										<div class="col-md-3">
											<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
												Tanggal
											</label>
										</div>
										<div class="col-md-6">
											<input type="date" class="form-control" id="tanggal" name="tanggal" style="height:28px;" value="'.$tanggal.'">
										</div>
									</div>
									<br/>
									<div class="row">
										<div class="col-md-3">
											<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
												Pelanggaran
											</label>
										</div>
										<div class="col-md-9">
											<textarea id="masalah" name="masalah" rows="3" style="width:100%;padding: 4px 10px;">'.$masalah.'</textarea>
										</div>
									</div>
									<br/>
									<div class="row">
										<div class="col-md-3">
											<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
												Solusi
											</label>
										</div>
										<div class="col-md-9">
											<textarea id="solusi" name="solusi" rows="3" style="width:100%;padding: 4px 10px;">'.$solusi.'</textarea>
										</div>
									</div>
								</div>
								<!-- ./sisi kiri -->
								
								<!-- sisi kanan -->
								<div class="col-md-6">
									<div class="row" id="pilihSiswa">
										<div class="col-md-3">
											<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
												Nama Siswa
											</label>
										</div>
										<div class="col-md-8">
											<select id="indukSelect" name="indukSelect" ';
											if($id != '') echo ' disabled ';
											echo 
											' style="height:28px;width:100%;">';
												$query = $this->db->select('*')
															->from('tb_siswa')
															->where('kelas', $kelas)
															->order_by('nama', 'asc')
															->get();
												if($query->num_rows() > 0)
												{
													foreach($query->result() as $row)
													{
														$namaS = $row->nama;
														$no_induk = $row->no_induk;
														if($no_induk == $induk)
															echo '<option value="'.$no_induk.'" selected> '.$namaS.' </option>';
														else
															echo '<option value="'.$no_induk.'"> '.$namaS.' </option>';
													}
												}
											echo
											'</select>
										</div>
									</div>
									<br/>
									<div class="row">
										<div class="col-md-3">
											<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
												Jam
											</label>
										</div>
										<div class="col-md-6">
											<input type="time" class="form-control" id="jam" name="jam" style="height:28px;" value="'.$jam.'">
										</div>
									</div>
									<br/>
									<div class="row" style="height:28px;margin-top:4px;">
										<div class="col-md-3">
											<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
												Status
											</label>
										</div>
										<div class="col-md-9">
											<input type="radio" id="jnsBlmMdl" name="jenisModal" value="1" ';if($jenis == 'B') echo 'checked '; echo '> <b>Belum</b>
											&nbsp;&nbsp;&nbsp;
											<input type="radio" id="jnsSdhMdl" name="jenisModal" value="2" ';if($jenis == 'S') echo 'checked '; echo '> <b>Sudah</b>
											&nbsp;&nbsp;&nbsp;
											<input type="radio" id="jnsPrsMdl" name="jenisModal" value="3" ';if($jenis == 'P') echo 'checked '; echo '> <b>Proses</b>
										</div>
									</div>
									<br/>
									<div class="row">
										<div class="col-md-3">
											<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
												Tanggal Penanganan
											</label>
										</div>
										<div class="col-md-6">
											<input type="date" class="form-control" id="tangani" name="tangani" style="height:28px;" value="'.$tangani.'">
										</div>
									</div>
									<br/>
									<div class="row">
										<div class="col-md-3">
											<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
												Oleh
											</label>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" id="oleh" name="oleh" style="height:28px;" value="'.$oleh.'">
										</div>
									</div>
								</div>
								<!-- ./sisi kanan -->
							</div>

						</div>
						<!-- ./modal body -->
						
						<!-- modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
							</button>';
							if($level > 94)
								echo
							'<button type="button" class="btn btn-primary" style="border-radius:8px;" onclick="simpanLanggarSiswa()">
								<img src="'.base_url().'utama/assists/images/icons/save.ico" width=20 height=20> Simpan
							</button>';
							echo
						'</div>
						<!-- ./modal footer -->
						
					</div>
					<!-- ./modal content -->
				</div>
				<!-- ./modal dialog -->';
		exit;
	}

	// ==================================
	// # Fungsi simpan Data Pelanggaran #
	// ==================================
	function simpanLanggarSiswa()
	{
		date_default_timezone_set("Asia/Jakarta");
		
		$id			= $this->input->get('id');
		$tgl		= $this->input->get('tg');
		$jam		= $this->input->get('jm');
		$induk		= $this->input->get('in');
		$mslh		= $this->input->get('ms');
		$tangani	= $this->input->get('tn');
		$oleh		= $this->input->get('ol');
		$solusi		= $this->input->get('sl');
		$jenis		= $this->input->get('jn');

		$tanggal = date("Y-m-d H:i:s", strtotime($tgl . ' ' . $jam));
		
		$data	= array(
						'tanggal' => $tanggal,
						'induk' => $induk,
						'masalah' => $mslh,
						'tangani' => $tangani,
						'oleh' => $oleh,
						'solusi' => $solusi,
						'statusL' => $jenis);
		if(($id == '') or ($id == 0))
			$this->db->insert('tb_langgar', $data);
		else
			$this->db->where('no', $id)->update('tb_langgar', $data);
		
		$outp[0] = 'sukses';
		if(($id == '') or ($id == 0))
			$outp[1] = 'Sukses menambah data Pelanggaran';
		else
			$outp[1] = 'Sukses merubah Data Pelanggaran';
		echo json_encode($outp);
		
		exit;
	}
	
	// *********************************************************************************************
	// ***********************************   Akhir Pelanggaran     *********************************
	// *********************************************************************************************
	
	// **************************************************************************************
	// *********************************     Awal Rapor     *********************************
	// **************************************************************************************
	function showDataRapor()
	{
		$level    = $this->session->userdata('level');
		$username = $this->session->userdata('username');
		
		$pilih = $this->input->get('pl');
		if(isset($_GET['id'])) {$noujian = $_GET['id'];} else {$noujian = '';}
		if(isset($_GET['cr'])) {$cari = $_GET['cr'];} else {$cari = '';}
		if(isset($_GET['m']))  {$mulai = $_GET['m'];} else {$mulai = 1;}

		if(isset($_GET['pl'])) $pilih = $this->input->get('pl'); else $pilih = 'rapor';
		if(isset($_GET['kl'])) $kelas = $this->input->get('kl'); else $kelas = '';
		if(isset($_GET['tp'])) $tapel = $this->input->get('tp'); else $tapel = 2017;
		if(isset($_GET['sm'])) $semester = $this->input->get('sm'); else $semester = 1;
		
		if($level == 94)
		{
			$query = $this->db->select('*')
					->from('tb_wali')
					->where('kd_guru', $username)
					->get();
			$hasil = $query -> num_rows();
			if($hasil > 0)
			{
				$row = $query->row();
				$kelas = $row->kelas;
			}
			
		}
		
		echo
				'<div class="col-md-12">
					<input type="hidden" id="userId" name="userId" value="'.$noujian.'">
					<input type="hidden" id="mulai"  name="userId" value="'.$mulai.'">
					<input type="hidden" id="cari"   name="userId" value="'.$cari.'">
					<input type="hidden" id="pilih"  name="pilih"  value="rapor">
                    <div class="panel panel-primary">
                        <div class="panel-heading text-bayang">
                            <center><b><i>Daftar Nilai rapor</i></b></center>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="inputCetak" class="col-md-2 control-label">Kelas :</label>
											<div class="col-md-4" style="margin-top:4px;margin-left:0px;">
												<input type="radio" id="semua" name="semua" value="0" ';if(($kelas == '') or ($kelas == 'x')) echo 'checked ';if($level < 95) echo ' disabled ';echo 'onclick="showKelasRapor()"> Semua
												&nbsp;&nbsp;&nbsp;
												<input type="radio" id="kelasP" name="semua" value="1" ';if($kelas != '') echo 'checked ';if($level < 95) echo ' disabled '; echo 'onclick="showKelasRapor()"> Per Kelas
											</div>';
											if($kelas == '')
												echo
												'<div class="col-md-5" id="idKelas" style="display:none;margin-top:4px;">';
											else
												echo
												'<div class="col-md-5" id="idKelas" style="margin-top:4px;">';
											echo
												'<label for="inputCetak" class="col-md-5 control-label" style="margin-top:-4px;margin-left:-26px;">Kelas :</label>
												<select class="col-md-7" id="kelasSelect" name="kelasSelect" style="margin-top:-2px;margin-left:0px;height:32px;" oninput="showKelasRapor()" ';if($level < 95) echo ' disabled ';echo '>';
													$query = $this->db->select('*')
																->from('tb_kelas')
																->get();
													if($query->num_rows() > 0)
													{
														foreach($query->result() as $row)
														{
															$kd_kelas = $row->kd_kelas;
															if($kelas == $kd_kelas)
																echo '<option value="'.$row->kd_kelas.'" selected> '.$row->nama_kelas.'</option>';
															else
																echo '<option value="'.$row->kd_kelas.'"> '.$row->nama_kelas.'</option>';
														}
													}
												echo
												'</select>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-6">
											<div class="form-horizontal">
												<div class="form-group">
													<label class="col-md-4 control-label">Tapel :</label>
													<input type="number" class="col-md-4" style="height:32px;padding-left:8px;" id="tapel" name="tapel" value="'.$tapel.'" oninput="showKelasRapor()">
													<label class="col-md-4" style="margin-left: -4px;margin-top: 8px;"> - '.($tapel+1).'</label>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-horizontal">
												<div class="form-group">
													<label class="col-md-5 control-label">Semester :</label>
													<select class="col-md-5" id="semester" name="semester" style="margin-top:-2px;margin-left:0px;height:32px;" oninput="showKelasRapor()">
														<option value="1" ';if($semester == 1) echo ' selected '; echo '> Ganjil </option>
														<option value="2" ';if($semester == 2) echo ' selected '; echo '> Genap </option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
									<tr style="background:green;color:yellow;">
                                        <th><center><label class="text-bayang">No.</label></center></th>
										<th><center><label class="text-bayang">Kelas</label></center></th>
                                        <th><center><label class="text-bayang">Induk</label></center></th>
                                        <th><center><label class="text-bayang">Nama Siswa</label></center></th>
                                        <th><center><label class="text-bayang">L/P</label></center></th>
										<th><center><label class="text-bayang">Agm</label></center></th>
										<th><center><label class="text-bayang">PKn</label></center></th>
										<th><center><label class="text-bayang">Indo</label></center></th>
										<th><center><label class="text-bayang">Mat</label></center></th>
										<th><center><label class="text-bayang">Sej</label></center></th>
										<th><center><label class="text-bayang">Ingg</label></center></th>
										<th><center><label class="text-bayang">Seni</label></center></th>
										<th><center><label class="text-bayang">Penj</label></center></th>
										<th><center><label class="text-bayang">PKWU</label></center></th>
                                        <th><center><label class="text-bayang">#</label></center></th>
									</tr>
                                </thead>
                                <tbody>';
									$jmlRec = 0;
									$jml_data = 20;
									$awal = ($mulai - 1) * $jml_data;
									$nomer = $awal;
									
									$this->db->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
										->limit($jml_data, $awal);
									if(! (($kelas == '') or ($kelas == 'x')))
										$this->db->where('tb_kelas.kd_kelas', $kelas);
									$this->db->order_by('tb_siswa.kelas', 'asc')
												->order_by('tb_siswa.nama', 'asc');
									$query = $this->db->get('tb_siswa');
									foreach($query->result() as $row)
									{
										$nomer++;
										$userid     = $row -> no_ujian_smp;
										$nama_siswa = ucwords(strtolower($row -> nama));
										$induk      = $row -> no_induk;
										$gender     = $row -> gender;
										$kelas		= $row -> kelas;
										$nama_kelas = $row -> nama_kelas;
										
										$queri1 = $this->db->select('*')
													->from('tb_nilai')
													->where('induk', $induk)
													->where('tapel', $tapel)
													->where('semester', $semester)
													->get();
										if($queri1->num_rows() > 0)
										{
											$row1 = $queri1->row();
											$noL		= $row1->no;
											$agama_bn	= $row1->agama_bn;
											$pkn_bn		= $row1->pkn_bn;
											$indo_bn	= $row1->indo_bn;
											$mat_bn		= $row1->matwaj_bn;
											$sej_bn		= $row1->sejind_bn;
											$ingg_bn	= $row1->inggris_bn;
											$seni_bn	= $row1->senbud_bn;
											$penjas_bn	= $row1->penjas_bn;
											$pkwu_bn	= $row1->pkwu_bn;
											$jmlRec++;
										}
										else
										{
											$noL		= 0;
											$agama_bn	= 0;
											$pkn_bn		= 0;
											$indo_bn	= 0;
											$mat_bn		= 0;
											$sej_bn		= 0;
											$ingg_bn	= 0;
											$seni_bn	= 0;
											$penjas_bn	= 0;
											$pkwu_bn	= 0;
										}
										if($noujian == $userid)
											echo '<tr style="background:yellow;color:red;">';
										elseif(fmod($nomer, 2) == 0)
											echo '<tr style="background:lightblue;color:black;">';
										else
											echo '<tr style="background:white;color:black;">';
										if($noL > 0)
										{
											echo	
												'<td><center><b>'.$nomer.'</b></center></td>
												<td><center><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$nama_kelas.'</a></center></td>
												<td><center><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$induk.'</a></center></td>
												<td><b><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$nama_siswa.'</a></b></td>
												<td><center><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$gender.'</a></center></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$agama_bn.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$pkn_bn.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$indo_bn.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$mat_bn.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$sej_bn.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$ingg_bn.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$seni_bn.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$penjas_bn.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$userid.'&m='.$mulai.'&pl=rapor&kl='.$kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editRaporSiswa(this)">'.$pkwu_bn.'</a></td>
												<td>';
												if($level > 94)
													echo
													'<center>
														<a href="cetakRaporPDF?pl=rapor&noRec='.$this->m_data->encryptIt($noL).'">
															<img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=20 height=20>
														</a>
														<a href="#" id="'.$noL.'&nm='.$userid.'&pl=rapor" onclick="hapusData(this)">
															<img src="'.base_url().'utama/assists/images/icons/delete.ico" width=20 height=20>
														</a>
													</center>';
												else
													echo '&nbsp;';
												echo
												'</td>';
										}
										else
											echo	
												'<td><center><b>'.$nomer.'</b></center></td>
												<td><center>'.$nama_kelas.'</center></td>
												<td><center>'.$induk.'</center></td>
												<td><b>'.$nama_siswa.'</b></td>
												<td><center>'.$gender.'</center></td>
												<td style="text-align:right;">0</td>
												<td style="text-align:right;">0</td>
												<td style="text-align:right;">0</td>
												<td style="text-align:right;">0</td>
												<td style="text-align:right;">0</td>
												<td style="text-align:right;">0</td>
												<td style="text-align:right;">0</td>
												<td style="text-align:right;">0</td>
												<td style="text-align:right;">0</td>
												<td>&nbsp;</td>';
										echo
											'</tr>';
									}
									if($nomer == 0)
										echo
											'<tr class="text-bayang" style="background:red;color:yellow;">
												<td colspan="15"><b><center>Tidak ada data</center></b></td>
											</tr>';
									echo
								'</tbody>
							</table>';
							$this->db->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left');
							if(! (($kelas == '') or ($kelas == 'x')))
								$this->db->where('tb_kelas.kd_kelas', $kelas);
							$query = $this->db->get('tb_siswa');
							$rowcounts = $query->num_rows();
							$numpages  = ceil($rowcounts / $jml_data);
							$sisa      = $rowcounts % $jml_data;
							if($sisa > 0) $numpages++;
							$pagenow   = ceil($awal / $jml_data)+1;
							$nextpage  = $pagenow + 1;
							$lastpage  = $pagenow - 1;

							if($nomer > 0)
								echo
								'<b><font color="blue">Tampil <font color="red">'.($awal+1).'</font> sampai <font color="red">'.$nomer.'</font> dari <font color="red">'.$rowcounts.'</font> data</font></b><br/><br/>';
							if($level > 94)
								echo
							'*) Anda dapat mempersiapkan dan mengedit data melalui microsoft Excel. Format file dapat di <a href="dl_contoh?id=rapor">download disini</a><br />
							*) Rubahlah contoh diatas kemudian simpan dan <a href="#" id="rapor" onClick="showImportData(this)">import disini.</a>';
							echo
						'</div>
						<center>';
							
							if($rowcounts > $jml_data)
							{
								if($pagenow <= 1)
									echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_start.png" width=24 height=24 style="margin-top:-4px;">
										</button>';
								else
									echo '<a href="#" id="pl=rapor&m=1&kl='.$kelas.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_start_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								if($pagenow <= 1)
									echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_rewind.png" width=24 height=24 style="margin-top:-4px;">
										</button>';
								else
									echo '<a href="#" id="pl=rapor&m='.$lastpage.'&kl='.$kelas.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_rewind_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								echo '<button type="button" class="btn btn-primary" disabled>'.$pagenow.'</button>';
								if($numpages > $pagenow)
									echo '<a href="#" id="pl=rapor&m='.$nextpage.'&kl='.$kelas.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_fastforward_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								else
									echo '<button type="button" class="btn btn-danger" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_fastforward.png" width=16 height=16>
										</button>';
								if($pagenow >= $numpages)
									echo '<button type="button" class="btn btn-danger" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_end.png" width=16 height=16>
										</button>';
								else
									echo '<a href="#" id="pl=rapor&m='.$numpages.'&kl='.$kelas.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_end_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
							}
								
						echo
						'</center>';
						if($level > 94)
						{
							echo
						'<br />
						<center>
							<a href="#" id="rapor" class="btn btn-danger" style="border-radius: 8px;" onclick="hapusDataAll(this)">
								<img src="'.base_url().'utama/assists/images/icons/stop.ico" width=24 height=24> Hapus Semua
							</a>
							&nbsp;&nbsp;&nbsp;
							<a href="#" id="rapor&bg=pdf" class="btn btn-primary" style="border-radius: 8px;" onclick="ctkRaporModal(this)">
								<img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=24 height=24> Cetak
							</a>
							&nbsp;&nbsp;&nbsp;
							<a href="#" id="rapor&bg=xls" class="btn btn-primary" style="border-radius: 8px;" onclick="ctkRaporModal(this)">
								<img src="'.base_url().'utama/assists/images/icons/file_extension_xls.png" width=24 height=24> Cetak
							</a>
							&nbsp;&nbsp;&nbsp;
							<a href="#" id="rapor?bg=xls" class="btn btn-success" style="border-radius: 8px;" onclick="editRaporSiswa(this)">
								<img src="'.base_url().'utama/assists/images/icons/add_card.ico" width=24 height=24> Tambah
							</a>
						</center>
						<br />';
						}
						echo
					'</div>
					<!-- ./panel -->
				</div>
				<!-- ./col -->';
		exit;
	}
	
	// ===========================
	// # Fungsi Edit Nilai Rapor #
	// ===========================
	function showRaporModal()
	{
		$level    = $this->session->userdata('level');
		$username = $this->session->userdata('username');

		if(isset($_GET['id'])) $noL   = $this->input->get('id'); else $noL   = 0;
		if(isset($_GET['nm'])) $indukM = $this->input->get('nm'); else $indukM = '';
		if(isset($_GET['kl'])) $kelasM = $this->input->get('kl'); else $kelasM = '';
		if(isset($_GET['tp'])) $tapelM = $this->input->get('tp'); else $tapelM = 2017;
		if(isset($_GET['sm'])) $semesM = $this->input->get('sm'); else $semesM = '';
		if(strtolower($noL) == 'rapor') $noL = 0;
		
		if($level == 94)
		{
			$query = $this->db->select('*')
					->from('tb_wali')
					->where('kd_guru', $username)
					->get();
			$hasil = $query -> num_rows();
			if($hasil > 0)
			{
				$row = $query->row();
				$kelasM = $row->kelas;
			}
		}
		
		$lintas_nama = '';
		$minat1_nama = '';
		$minat2_nama = '';
		$minat1_s = '';
		$minat2_s = '';
		$lintas_s = '';
		
		$data_mapel = array(array('Agama',				'agama',	0,'',0,''),
							array('PKn', 				'pkn',		0,'',0,''),
							array('Bahasa Indonesia',	'indo',		0,'',0,''),
							array('Matematika',			'matwaj',	0,'',0,''),
							array('Sejarah',			'sejind',	0,'',0,''),
							array('Bahasa Inggris',		'inggris',	0,'',0,''),
							array('Seni Budaya',		'senbud',	0,'',0,''),
							array('Penjas Orkes',		'penjas',	0,'',0,''),
							array('PKWU',				'pkwu',		0,'',0,''),
							array('Fisika / Ekonomi',	'fiseko',	0,'',0,''),
							array('Kimia / Sosiologi',	'kimsos',	0,'',0,''),
							array('Biologi / Geografi',	'biogeo',	0,'',0,''),
							array('Peminatan I', 		'minat1',	0,'',0,''),
							array('Peminatan II',		'minat2',	0,'',0,''),
							array('Lintas minat',		'lintas',	0,'',0,''),
							array('Jumlah',				'jml',		0,'',0,''),
							array('Rata-rata',			'rata2',	0,'',0,'')
							);
		$jmlMapel = count($data_mapel) - 2;
		$i = 0;
		if(($noL > 0) or ($indukM != ''))
		{
			if($noL > 0)
				$queri = $this->db->select('*')
							->from('tb_nilai')
							->where('no', $noL)
							->get();
			else
				$queri = $this->db->select('*')
							->from('tb_nilai')
							->where('tb_nilai.tapel', $tapelM)
							->where('tb_nilai.semester', $semesM)
							->where('tb_nilai.induk', $indukM)
							->get();
			if($queri->num_rows() > 0)
			{
				$row = $queri->row();
				$indukM = $row->induk;
				$tapelM = $row->tapel;
				$semesM = $row->semester;
				$minat1M = $row->minat_s1;
				$minat2M = $row->minat_s2;
				$lintasM = $row->lintas_s;
				$minat1_s = $row->minat_s1;
				$minat2_s = $row->minat_s2;
				$lintas_s = $row->lintas_s;
				$jml_bn = 0;
				$jml_cn = 0;
				for($j = 0; $j < $jmlMapel; $j++)
				{
					$kalim = $data_mapel[$j][1] . '_bn';
					$data_mapel[$j][2] = $row -> $kalim;
					$kalim = $data_mapel[$j][1] . '_bd';
					$data_mapel[$j][3] = $row -> $kalim;
					$kalim = $data_mapel[$j][1] . '_cn';;
					$data_mapel[$j][4] = $row -> $kalim;
					$kalim = $data_mapel[$j][1] . '_cd';
					$data_mapel[$j][5] = $row -> $kalim;
					$jml_bn += $data_mapel[$j][2];
					$jml_cn += $data_mapel[$j][4];
				}
				$ekstra1_s   = $row -> ekstra1_s;
				$ekstra1_n   = $row -> ekstra1_n;
				$ekstra1_d   = $row -> ekstra1_d;
				$ekstra2_s   = $row -> ekstra2_s;
				$ekstra2_n   = $row -> ekstra2_n;
				$ekstra2_d   = $row -> ekstra2_d;
				$spiritual_p = $row -> spiritual_p;
				$spiritual_d = $row -> spiritual_d;
				$sosial_p    = $row -> sosial_p;
				$sosial_d    = $row -> sosial_d;
				$prestasi1_j = $row -> prestasi1_j;
				$prestasi1_k = $row -> prestasi1_k;
				$prestasi2_j = $row -> prestasi2_j;
				$prestasi2_k = $row -> prestasi2_k;
				$komen_wali  = $row -> komen_wali;
				$komen_ortu  = $row -> komen_ortu;
				$naikK       = $row -> naik;
				
				$rata_bn = $jml_bn / $jmlMapel;
				$rata_cn = $jml_cn / $jmlMapel;
				$data_mapel[$jmlMapel][0] = 'Jumlah';
				$data_mapel[$jmlMapel][1] = 'jml';
				$data_mapel[$jmlMapel][2] = $jml_bn;
				$data_mapel[$jmlMapel][4] = $jml_cn;
				$data_mapel[$jmlMapel+1][0] = 'Rata-rata';
				$data_mapel[$jmlMapel+1][1] = 'rata2';
				$data_mapel[$jmlMapel+1][2] = $rata_bn;
				$data_mapel[$jmlMapel+1][4] = $rata_cn;

				$queri = $this->db->select('*')
							->from('tb_prodi')
							->join('tb_kelas', 'tb_prodi.prodi = tb_kelas.kd_prodi', 'left')
							->where('tb_kelas.kd_kelas', $kelasM)
							->get();
				if($queri->num_rows() > 0)
				{
					$row = $queri->row();
					$prodiM = $row->prodi;
				}
				else
					$prodiM = '';
				
				$minat1_nama = '';
				$minat2_nama = '';
				$query = $this->db->select('*')
							->from('tb_minat')
							->get();
				foreach($query->result() as $row)
				{
					$minat = $row->minat;
					$nama_minat = $row->nama_minat;
					if($minat == $minat1_s) $minat1_nama = $nama_minat;
					if($minat == $minat2_s) $minat2_nama = $nama_minat;
				}
				$query = $this->db->select('*')
							->from('tb_lintas')
							->where('lintas', $lintas_s)
							->get();
				if($query->num_rows() > 0)
				{
					$row = $query->row();
					$lintas_nama = $row->nama_lintas;
				}
				else $lintas_nama = '';
			}
		}
		
		$jmlRec = 0;
		$queri = $this->db->select('*')
					->from('tb_siswa')
					->where('kelas', $kelasM)
					->get();
		if($queri->num_rows() <= 0) $indukM = '';
		echo
				'<!-- modal-dialog -->
				<div class="modal-dialog modal-lg" role="document">
					<!-- modal-content -->
					<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
						<!-- modal header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title hit-the-floor" id="isianAdminLabel">';
								if(strtolower($noL) == 0)
									echo '<img src="'.base_url().'utama/assists/images/icons/address-book.ico" width=32 height=32> <b>Tambah Nilai Rapor</b>';
								else
									echo '<img src="'.base_url().'utama/assists/images/icons/address-book.ico" width=32 height=32> <b>Edit Nilai Rapor</b>';
								echo
							'</h3>
						</div>
						<!-- ./modal header -->

						<!-- modal body -->
						<div class="modal-body" id="isianDataUH">
							<!-- Nav tabs -->
							<ul class="nav nav-pills">
								<li class="active"><a href="#dataSiswa" data-toggle="tab"><b>Data Siswa</b></a></li>';
								if(($noL > 0) or (($semesM != '') and ($indukM != '')))
									echo
								'<li><a href="#tahu" data-toggle="tab"><b>Pengetahuan</b></a></li>
								<li><a href="#trampil" data-toggle="tab"><b>Ketrampilan</b></a></li>
								<li><a href="#lain2" data-toggle="tab"><b>Lain-lain</b></a></li>';
								echo
							'</ul>
							<hr/>
							
							<!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane fade in active" id="dataSiswa">
									<h4 style="color: yellow;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
										<strong>Data Siswa</strong>
									</h4>
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Tahun Pelajaran :
												</label>
												<input type="number" class="form-control" name="tapelSel" id="tapelSel" value="'.$tapelM.'" ';if($noL > 0) echo ' disabled '; echo ' oninput="rubahRaporModal()">
											</div>
										</div>
										<div class="col-md-1" style="margin-top:32px;margin-left:-20px;margin-right:10px;">
											<b> - '.($tapelM+1).'</b>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Semester :
												</label>
												<select class="form-control" name="semesSel" id="semesSel" ';if($noL > 0) echo ' disabled '; echo ' oninput="rubahRaporModal()">
													<option value=""> == Pilih Semester == </option>
													<option value="1" ';if($semesM == 1) echo ' selected '; echo '> Ganjil </option>
													<option value="2" ';if($semesM > 1) echo ' selected '; echo '> Genap </option>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Kelas :
												</label>
												<select class="form-control" name="kelasM" id="kelasM" ';if($noL > 0) echo ' disabled '; echo ' oninput="rubahRaporModal()">';
													$queri = $this->db->select('*')
																->from('tb_kelas')
																->get();
													foreach($queri->result() as $row)
													{
														$kd_kelas   = $row->kd_kelas;
														$nama_kelas = $row->nama_kelas;
														if($kd_kelas == $kelasM)
															echo
															'<option value="'.$kd_kelas.'" selected> '.$nama_kelas.' </option>';
														else
															echo
															'<option value="'.$kd_kelas.'"> '.$nama_kelas.' </option>';
													}
													echo
												'</select>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Nama Siswa :
												</label>
												<select class="form-control" name="indukSel" id="indukSel" ';if($noL > 0) echo ' disabled '; echo ' oninput="rubahRaporModal()">
													<option value=""> == Pilih Siswa == </option>';
													$jmlRec = 0;
													$queri = $this->db->select('*')
																->from('tb_siswa')
																->where('kelas', $kelasM)
																->order_by('nama', 'asc')
																->get();
													foreach($queri->result() as $row)
													{
														$namaS   = $row->nama;
														$kd_induk = $row->no_induk;
														if($kd_induk == $indukM)
															echo
															'<option value="'.$kd_induk.'" selected> '.$namaS.' </option>';
														else
															echo
															'<option value="'.$kd_induk.'"> '.$namaS.' </option>';
														$jmlRec++;
													}
													if($jmlRec == 0) $indukM = '';
													echo
												'</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Peminatan I :
												</label>
												<select class="form-control" name="minat1P" id="minat1P" oninput="rubahMinat1(this)">';
													$queri = $this->db->select('*')
																->from('tb_minat')
																->where('prodi', $prodiM)
																->get();
													foreach($queri->result() as $row)
													{
														$minat = $row->minat;
														$nama_minat = $row->nama_minat;
														if($minat == $minat1M)
															echo '<option value="'.$minat.'" selected> '.$nama_minat.' </option>';
														else
															echo '<option value="'.$minat.'"> '.$nama_minat.' </option>';
													}
												echo
												'</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Peminatan II :
												</label>
												<select class="form-control" name="minat2P" id="minat2P" oninput="rubahMinat2(this)">
													<option value=""> == Pilih == </option>';
													$queri = $this->db->select('*')
																->from('tb_minat')
																->where('prodi', $prodiM)
																->get();
													foreach($queri->result() as $row)
													{
														$minat = $row->minat;
														$nama_minat = $row->nama_minat;
														if($minat == $minat2M)
															echo '<option value="'.$minat.'" selected> '.$nama_minat.' </option>';
														else
															echo '<option value="'.$minat.'"> '.$nama_minat.' </option>';
													}
												echo
												'</select>
											</div>
										</div>
										<div class="col-md-3">
											<!--
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Test :
												</label>
												<input type="text" class="form-control" name="test" id="test" value="'.$tapelM.' - '.$semesM.' - '.$kelasM.' - '.$indukM.'">
											</div>
											-->
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Lintas Minat :
												</label>
												<select class="form-control" name="lintasP" id="lintasP" oninput="rubahLintas(this)">';
													$queri = $this->db->select('*')
																->from('tb_lintas')
																->where('prodi', $prodiM)
																->get();
													foreach($queri->result() as $row)
													{
														$lintas = $row->lintas;
														$nama_lintas = $row->nama_lintas;
														if($lintas == $lintasM)
															echo '<option value="'.$lintas.'" selected> '.$nama_lintas.' </option>';
														else
															echo '<option value="'.$lintas.'"> '.$nama_lintas.' </option>';
													}
												echo
												'</select>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade in" id="tahu">
									<h4 style="color: yellow;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
										<strong>Pengetahuan</strong>
									</h4>
									<table style="width:100%;" class="table table-striped table-bordered table-hover">
										<thead>
											<tr style="background:green;color:yellow;">
												<th><center>Mata Pelajaran</center></th>
												<th><center>Nilai</center></th>
												<th><center>Deskripsi</center></th>
											</tr>
										</thead>
										<tbody>';
											for($i = 0; $i < $jmlMapel; $i++)
											{
												if($data_mapel[$i][1] == 'minat2')
												{
													echo '<tr id="minat2UHId" ';if($minat2_s == '') echo 'style="display:none;"'; echo '>';
												}
												else
													echo '<tr>';
												echo
													'<td class="text-bayang" width=20% style="text-align:right;vertical-align:middle;"><b>'.$data_mapel[$i][0];
														if($data_mapel[$i][1] == 'minat1') echo '<br/><span id="minat1UHLbl">'.$minat1_nama.'</span>';
													elseif($data_mapel[$i][1] == 'minat2') echo '<br/><span id="minat2UHLbl">'.$minat2_nama.'</span>';
													elseif($data_mapel[$i][1] == 'lintas') echo '<br/><span id="lintasUHLbl">'.$lintas_nama.'</span>';
													echo '</b></td>
													<td width=6% style="text-align:center;vertical-align:middle;">
														<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_bn" name="'.$data_mapel[$i][1].'_bn" value="'.$data_mapel[$i][2].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
													</td>
													<td width=60%>
														<textarea id="'.$data_mapel[$i][1].'_bd" name="'.$data_mapel[$i][1].'_bd" rows="3" style="width:100%;padding: 4px 10px;">'.$data_mapel[$i][3].'</textarea>
													</td>
												</tr>';
											}
											echo
											'<tr style="color:blue;background-color:cyan;">
												<td class="text-bayang" style="text-align:right;"><b>'.$data_mapel[(count($data_mapel)-2)][0].'</b></td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[(count($data_mapel)-2)][1].'_bn" name="'.$data_mapel[(count($data_mapel)-2)][1].'_bn" value="'.$data_mapel[(count($data_mapel)-2)][2].'" style="width:80px;padding-left:6px;" disabled oninput="cekNilai(this)">
												</td>
												<td>&nbsp;</td>
											</tr>
											<tr style="color:blue;background-color:grey;">
												<td class="text-bayang" style="text-align:right"><b>'.$data_mapel[(count($data_mapel)-1)][0].'</b></td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[(count($data_mapel)-1)][1].'_bn" name="'.$data_mapel[(count($data_mapel)-1)][1].'_bn" value="'.$data_mapel[(count($data_mapel)-1)][2].'" style="width:80px;padding-left:6px;" disabled oninput="cekNilai(this)">
												</td>
												<td>&nbsp;</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade in" id="trampil">
									<h4 style="color: yellow;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
										<strong>Ketrampilan</strong>
									</h4>
									<table style="width:100%;" class="table table-striped table-bordered table-hover">
										<thead>
											<tr style="background:green;color:yellow;">
												<th><center>Mata Pelajaran</center></th>
												<th><center>Nilai</center></th>
												<th><center>Deskripsi</center></th>
											</tr>
										</thead>
										<tbody>';
											for($i = 0; $i < $jmlMapel; $i++)
											{
												if($data_mapel[$i][1] == 'minat2')
												{
													echo '<tr id="minat2TgsId" ';if($minat2_s == '') echo 'style="display:none;"'; echo '>';
												}
												else
													echo '<tr>';
												echo
													'<td class="text-bayang" width=20% style="text-align:right;vertical-align:middle;"><b>'.$data_mapel[$i][0];
														if($data_mapel[$i][1] == 'minat1') echo '<br/><span id="minat1TgsLbl">'.$minat1_nama.'</span>';
													elseif($data_mapel[$i][1] == 'minat2') echo '<br/><span id="minat2TgsLbl">'.$minat2_nama.'</span>';
													elseif($data_mapel[$i][1] == 'lintas') echo '<br/><span id="lintasTgsLbl">'.$lintas_nama.'</span>';
													echo '</b></td>
													<td width=6% style="text-align:center;vertical-align:middle;">
														<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_cn" name="'.$data_mapel[$i][1].'_bn" value="'.$data_mapel[$i][4].'" style="width:66px;padding-left:6px;">
													</td>
													<td width=60%>
														<textarea id="'.$data_mapel[$i][1].'_cd" name="'.$data_mapel[$i][1].'_cd" rows="3" style="width:100%;padding: 4px 10px;">'.$data_mapel[$i][5].'</textarea>
													</td>
												</tr>';
											}
											echo
											'<tr style="color:blue;background-color:cyan;">
												<td class="text-bayang" style="text-align:right;"><b>'.$data_mapel[(count($data_mapel)-2)][0].'</b></td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[(count($data_mapel)-2)][1].'_cn" name="'.$data_mapel[(count($data_mapel)-2)][1].'_cn" value="'.$data_mapel[(count($data_mapel)-2)][4].'" style="width:80px;padding-left:6px;" disabled oninput="cekNilai(this)">
												</td>
												<td>&nbsp;</td>
											</tr>
											<tr style="color:blue;background-color:grey;">
												<td class="text-bayang" style="text-align:right"><b>'.$data_mapel[(count($data_mapel)-1)][0].'</b></td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[(count($data_mapel)-1)][1].'_cn" name="'.$data_mapel[(count($data_mapel)-1)][1].'_cn" value="'.$data_mapel[(count($data_mapel)-1)][4].'" style="width:80px;padding-left:6px;" disabled oninput="cekNilai(this)">
												</td>
												<td>&nbsp;</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade in" id="lain2">
									<h4 style="color: yellow;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
										<strong>Lain - lain</strong>
									</h4>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Ekstrakurikuler I :
												</label>
												<input type="text" class="form-control" name="ekstra1_s" id="ekstra1_s" value="'.$ekstra1_s.'">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Predikat :
												</label>
												<input type="text" class="form-control" name="ekstra1_n" id="ekstra1_n" value="'.$ekstra1_n.'">
											</div>
										</div>
										<div class="col-md-7">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Diskripsi :
												</label>
												<textarea id="ekstra1_d" name="ekstra1_d" rows="3" style="width:100%;padding: 4px 10px;">'.$ekstra1_d.'</textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Ekstrakurikuler II :
												</label>
												<input type="text" class="form-control" name="ekstra2_s" id="ekstra2_s" value="'.$ekstra2_s.'">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Predikat :
												</label>
												<input type="text" class="form-control" name="ekstra2_n" id="ekstra2_n" value="'.$ekstra2_n.'">
											</div>
										</div>
										<div class="col-md-7">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Diskripsi :
												</label>
												<textarea id="ekstra2_d" name="ekstra2_d" rows="3" style="width:100%;padding: 4px 10px;">'.$ekstra2_d.'</textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Predikat :
												</label>
												<input type="text" class="form-control" name="spiritual_p" id="spiritual_p" value="'.$spiritual_p.'">
											</div>
										</div>
										<div class="col-md-10">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Sikap Spiritual Diskripsi :
												</label>
												<textarea id="spiritual_d" name="spiritual_d" rows="2" style="width:100%;padding: 4px 10px;">'.$spiritual_d.'</textarea>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Predikat :
												</label>
												<input type="text" class="form-control" name="sosial_p" id="sosial_p" value="'.$sosial_p.'">
											</div>
										</div>
										<div class="col-md-10">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Sikap Sosial Diskripsi :
												</label>
												<textarea id="sosial_d" name="sosial_d" rows="2" style="width:100%;padding: 4px 10px;">'.$sosial_d.'</textarea>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Prestasi I - Jenis Kegiatan :
												</label>
												<textarea id="prestasi1_j" name="prestasi1_j" rows="2" style="width:100%;padding: 4px 10px;">'.$prestasi1_j.'</textarea>
											</div>
										</div>
										<div class="col-md-7">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Keterangan :
												</label>
												<textarea id="prestasi1_k" name="prestasi1_k" rows="2" style="width:100%;padding: 4px 10px;">'.$prestasi1_k.'</textarea>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Prestasi II - Jenis Kegiatan :
												</label>
												<textarea id="prestasi2_j" name="prestasi2_j" rows="2" style="width:100%;padding: 4px 10px;">'.$prestasi2_j.'</textarea>
											</div>
										</div>
										<div class="col-md-7">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Keterangan :
												</label>
												<textarea id="prestasi2_k" name="prestasi2_k" rows="2" style="width:100%;padding: 4px 10px;">'.$prestasi2_k.'</textarea>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Catatan Walikelas :
												</label>
												<textarea id="komen_wali" name="komen_wali" rows="2" style="width:100%;padding: 4px 10px;">'.$komen_wali.'</textarea>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Tanggapan Orang Tua :
												</label>
												<textarea id="komen_ortu" name="komen_ortu" rows="2" style="width:100%;padding: 4px 10px;">'.$komen_ortu.'</textarea>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Naik Kelas :
												</label>
												<select class="form-control" id="naikK" name="naikK">
													<option value=""> == Pilih == </option>
													<option value="1" ';if($naikK == 1) echo ' selected '; echo '> Naik </option>
													<option value="2" ';if($naikK == 2) echo ' selected '; echo '> Tdk Naik </option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
						<!-- ./modal body -->
							
						<!-- modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
							</button>';
							if(($level > 94) and (($noL > 0) or (($semesM != '') and ($indukM != ''))))
								echo
							'<button type="button" class="btn btn-primary" onClick="simpanNilaiRapor()" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/save.ico" width=20 height=20> Simpan
							</button>';
							echo
						'</div>
						<!-- ./modal footer -->
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->';
		exit;

	}

	// =============================
	// # Fungsi simpan Nilai rapor #
	// =============================
	function simpanNilaiRapor()
	{
		$nil_mapel = array();
		$dt_mapel  = array("agama", "pkn", "indo", "matwaj", "sejind", "inggris", "senbud", "penjas", 
						"pkwu", "fiseko", "kimsos", "biogeo", "minat1", "minat2", "lintas");
		$tapel = $this->input->post('tapel');
		$nil_mapel['tapel'] = $tapel;
		$semes = $this->input->post('semes');
		$nil_mapel['semester'] = $semes;
		$induk = $this->input->post('induk');
		$nil_mapel['induk']			= $induk;
		$nil_mapel['minat_s1']		= $this->input->post('minat_s1');
		$nil_mapel['minat_s2']		= $this->input->post('minat_s2');
		$nil_mapel['lintas_s']		= $this->input->post('lintas_s');
		$nil_mapel['ekstra1_s']		= $this->input->post('ekstra1_s');
		$nil_mapel['ekstra1_n']		= $this->input->post('ekstra1_n');
		$nil_mapel['ekstra1_d']		= $this->input->post('ekstra1_d');
		$nil_mapel['ekstra2_s']		= $this->input->post('ekstra2_s');
		$nil_mapel['ekstra2_n']		= $this->input->post('ekstra2_n');
		$nil_mapel['ekstra2_d']		= $this->input->post('ekstra2_d');
		$nil_mapel['spiritual_p']	= $this->input->post('spiritual_p');
		$nil_mapel['spiritual_d']	= $this->input->post('spiritual_d');
		$nil_mapel['sosial_p']		= $this->input->post('sosial_p');
		$nil_mapel['sosial_d']		= $this->input->post('sosial_d');
		$nil_mapel['prestasi1_j']	= $this->input->post('prestasi1_j');
		$nil_mapel['prestasi1_k']	= $this->input->post('prestasi1_k');
		$nil_mapel['prestasi2_j']	= $this->input->post('prestasi2_j');
		$nil_mapel['prestasi2_k']	= $this->input->post('prestasi2_k');
		$nil_mapel['komen_wali']	= $this->input->post('komen_wali');
		$nil_mapel['komen_ortu']	= $this->input->post('komen_ortu');
		$nil_mapel['naik']			= $this->input->post('naikK');
		
		for($i = 0; $i < count($dt_mapel); $i++)
		{
			$mapel = $dt_mapel[$i] . '_bn';
			$nil_mapel[$mapel] = $this->input->post($mapel);
			$mapel = $dt_mapel[$i] . '_bd';
			$nil_mapel[$mapel] = $this->input->post($mapel);
			$mapel = $dt_mapel[$i] . '_cn';
			$nil_mapel[$mapel] = $this->input->post($mapel);
			$mapel = $dt_mapel[$i] . '_cd';
			$nil_mapel[$mapel] = $this->input->post($mapel);
		}
		$queri = $this->db->select('*')
					->from('tb_nilai')
					->where('tapel', $tapel)
					->where('semester', $semes)
					->where('induk', $induk)
					->get();
		if($queri->num_rows() > 0)
			$this->db->where('tapel', $tapel)->where('semester', $semes)->where('induk', $induk)->update('tb_nilai', $nil_mapel);
		else
			$this->db->insert('tb_nilai', $nil_mapel);
		
		$outp = array();
		$outp[0] = 'sukses';
		$outp[1] = 'Data Nilai Rapor berhasil disimpan';
		echo json_encode($outp);
		
		//print_r($nil_mapel);
		exit;
	}
	
	// ***************************************************************************************
	// **********************************    Akhir Rapor     *********************************
	// ***************************************************************************************
	
	// ***********************************************************************************************
	// ********************************      Awal Ulangan Harian     *********************************
	// ***********************************************************************************************
	function showDataUlangan()
	{
		$level    = $this->session->userdata('level');
		$username = $this->session->userdata('username');
		
		$pilih = $this->input->get('pl');
		if(isset($_GET['id'])) {$noujian = $_GET['id'];} else {$noujian = '';}
		if(isset($_GET['cr'])) {$cari = $_GET['cr'];} else {$cari = '';}
		if(isset($_GET['m']))  {$mulai = $_GET['m'];} else {$mulai = 1;}

		if(isset($_GET['kl'])) $kelas = $this->input->get('kl'); else $kelas = '';
		if(isset($_GET['tp'])) $tapel = $this->input->get('tp'); else $tapel = 2017;
		if(isset($_GET['sm'])) $semester = $this->input->get('sm'); else $semester = 1;
		if($level == 94)
		{
			$query = $this->db->select('*')
					->from('tb_wali')
					->where('kd_guru', $username)
					->get();
			$hasil = $query -> num_rows();
			if($hasil > 0)
			{
				$row = $query->row();
				$kelas = $row->kelas;
			}
			
		}
		echo
				'<div class="col-md-12">
					<input type="hidden" id="userId" name="userId" value="'.$noujian.'">
					<input type="hidden" id="mulai"  name="mulai" value="'.$mulai.'">
					<input type="hidden" id="cari"   name="cari" value="'.$cari.'">
					<input type="hidden" id="pilih"  name="pilih" value="ulangan">
                    <div class="panel panel-primary">
                        <div class="panel-heading text-bayang">
                            <center><b><i>Nilai Ulangan Harian</i></b></center>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-horizontal">
										<div class="form-group">
											<label for="inputCetak" class="col-md-2 control-label">Kelas :</label>
											<div class="col-md-4" style="margin-top:4px;margin-left:0px;">
												<input type="radio" id="semua" name="semua" value="0" ';if(($kelas == '') or ($kelas == 'x')) echo 'checked '; if($level < 95) echo ' disabled '; echo 'onclick="showKelasRapor()"> Semua
												&nbsp;&nbsp;&nbsp;
												<input type="radio" id="kelasP" name="semua" value="1" ';if($kelas != '') echo 'checked '; if($level < 95) echo ' disabled '; echo 'onclick="showKelasRapor()"> Per Kelas
											</div>';
											if($kelas == '')
												echo
												'<div class="col-md-5" id="idKelas" style="display:none;margin-top:4px;">';
											else
												echo
												'<div class="col-md-5" id="idKelas" style="margin-top:4px;">';
											echo
												'<label for="inputCetak" class="col-md-5 control-label" style="margin-top:-4px;margin-left:-26px;">Kelas :</label>
												<select class="col-md-7" id="kelasSelect" name="kelasSelect" style="margin-top:-2px;margin-left:0px;height:32px;" oninput="showKelasRapor()" ';if($level < 95) echo ' disabled '; echo'>';
													$query = $this->db->select('*')
																->from('tb_kelas')
																->get();
													if($query->num_rows() > 0)
													{
														foreach($query->result() as $row)
														{
															$kd_kelas = $row->kd_kelas;
															if($kelas == $kd_kelas)
																echo '<option value="'.$row->kd_kelas.'" selected> '.$row->nama_kelas.'</option>';
															else
																echo '<option value="'.$row->kd_kelas.'"> '.$row->nama_kelas.'</option>';
														}
													}
												echo
												'</select>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-5">
											<div class="form-horizontal">
												<div class="form-group">
													<label class="col-md-4 control-label">Tapel :</label>
													<input type="number" class="col-md-4" style="height:32px;padding-left:8px;" id="tapel" name="tapel" value="'.$tapel.'" oninput="showKelasRapor()">
													<label class="col-md-4 control-label"> - '.($tapel+1).'</label>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-horizontal">
												<div class="form-group">
													<label class="col-md-5 control-label">Semester :</label>
													<select class="col-md-5" id="semester" name="semester" style="margin-top:-2px;margin-left:0px;height:32px;" oninput="showKelasRapor()">
														<option value="1" ';if($semester == 1) echo ' selected '; echo '> Ganjil </option>
														<option value="2" ';if($semester == 2) echo ' selected '; echo '> Genap </option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
									<tr style="background:green;color:yellow;">
                                        <th><center><label class="text-bayang">No.</label></center></th>
										<th><center><label class="text-bayang">Kelas</label></center></th>
                                        <th><center><label class="text-bayang">Induk</label></center></th>
                                        <th><center><label class="text-bayang">Nama Siswa</label></center></th>
                                        <th><center><label class="text-bayang">L/P</label></center></th>
										<th><center><label class="text-bayang">Agm</label></center></th>
										<th><center><label class="text-bayang">PKn</label></center></th>
										<th><center><label class="text-bayang">Indo</label></center></th>
										<th><center><label class="text-bayang">Mat</label></center></th>
										<th><center><label class="text-bayang">Sej</label></center></th>
										<th><center><label class="text-bayang">Ingg</label></center></th>
										<th><center><label class="text-bayang">Seni</label></center></th>
										<th><center><label class="text-bayang">Penj</label></center></th>
										<th><center><label class="text-bayang">PKWU</label></center></th>
                                        <th><center><label class="text-bayang">#</label></center></th>
									</tr>
                                </thead>
                                <tbody>';
									$jmlRec = 0;
									$jml_data = 20;
									$awal = ($mulai - 1) * $jml_data;
									$nomer = $awal;
									
									$this->db->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
										->limit($jml_data, $awal);
									if(! (($kelas == '') or ($kelas == 'x')))
										$this->db->where('tb_kelas.kd_kelas', $kelas);
									$this->db->order_by('tb_siswa.kelas', 'asc')
												->order_by('tb_siswa.nama', 'asc');
									$query = $this->db->get('tb_siswa');
									foreach($query->result() as $row)
									{
										$nomer++;
										$userid     = $row -> no_ujian_smp;
										$nama_siswa = ucwords(strtolower($row -> nama));
										$induk      = $row -> no_induk;
										$gender     = $row -> gender;
										$nama_kelas = $row -> nama_kelas;
										$kd_kelas	= $row -> kelas;
										
										$queri1 = $this->db->select('*')
													->from('tb_ulangan')
													->where('induk', $induk)
													->where('tapel', $tapel)
													->where('semester', $semester)
													->get();
										if($queri1->num_rows() > 0)
										{
											$row1 = $queri1->row();
											$noL	= $row1->no;
											$agama	= $row1->agama_UH1;
											$pkn	= $row1->pkn_UH1;
											$indo	= $row1->indo_UH1;
											$mat	= $row1->mat_UH1;
											$sej	= $row1->sej_UH1;
											$ingg	= $row1->ingg_UH1;
											$seni	= $row1->senbud_UH1;
											$penjas	= $row1->penjas_UH1;
											$pkwu	= $row1->pkwu_UH1;
											$jmlRec++;
										}
										else
										{
											$noL	= 0;
											$agama	= 0;
											$pkn	= 0;
											$indo	= 0;
											$mat	= 0;
											$sej	= 0;
											$ingg	= 0;
											$seni	= 0;
											$penjas	= 0;
											$pkwu	= 0;
										}
										if($noujian == $userid)
											echo '<tr style="background:yellow;color:red;">';
										elseif(fmod($nomer, 2) == 0)
											echo '<tr style="background:lightblue;color:black;">';
										else
											echo '<tr style="background:white;color:black;">';
										if($noL > 0)
										{
											echo
												'<td><center><b>'.$nomer.'</b></center></td>
												<td><center><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$nama_kelas.'</a></center></td>
												<td><center><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$induk.'</a></center></td>
												<td><b><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$nama_siswa.'</a></b></td>
												<td><center><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$gender.'</a></center></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$agama.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$pkn.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$indo.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$mat.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$sej.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$ingg.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$seni.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$penjas.'</a></td>
												<td style="text-align:right;"><a href="#" id="'.$noL.'&nm='.$induk.'&m='.$mulai.'&pl=ulangan&kl='.$kd_kelas.'&tp='.$tapel.'&sm='.$semester.'" onclick="editUlanganHarian(this)">'.$pkwu.'</a></td>
												<td>';
												if($level > 94)
													echo
													'<center>
														<a href="cetakRaporPDF?pl=ulangan&noRec='.$this->m_data->encryptIt($noL).'">
															<img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=20 height=20>
														</a>
														<a href="#" id="'.$noL.'&pl=ulangan" onclick="hapusData(this)">
															<img src="'.base_url().'utama/assists/images/icons/delete.ico" width=20 height=20>
														</a>
													</center>';
												else
													echo '&nbsp;';
												echo
												'</td>';
										}
											else
												echo
												'<td><center><b>'.$nomer.'</b></center></td>
												<td><center>'.$nama_kelas.'</center></td>
												<td><center>'.$induk.'</center></td>
												<td><b>'.$nama_siswa.'</b></td>
												<td><center>'.$gender.'</center></td>
												<td style="text-align:right;">'.$indo.'</td>
												<td style="text-align:right;">'.$pkn.'</td>
												<td style="text-align:right;">'.$indo.'</td>
												<td style="text-align:right;">'.$mat.'</td>
												<td style="text-align:right;">'.$sej.'</td>
												<td style="text-align:right;">'.$ingg.'</td>
												<td style="text-align:right;">'.$seni.'</td>
												<td style="text-align:right;">'.$penjas.'</td>
												<td style="text-align:right;">'.$pkwu.'</td>
												<td>&nbsp;</td>';
											echo
											'</tr>';
									}
									if($nomer == 0)
										echo
											'<tr class="text-bayang" style="background:red;color:yellow;">
												<td colspan="15"><b><center>Tidak ada data</center></b></td>
											</tr>';
									echo
								'</tbody>
							</table>';
							$this->db->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left');
							if(! (($kelas == '') or ($kelas == 'x')))
								$this->db->where('tb_kelas.kd_kelas', $kelas);
							$query = $this->db->get('tb_siswa');
							$rowcounts = $query->num_rows();
							$numpages  = ceil($rowcounts / $jml_data);
							$sisa      = $rowcounts % $jml_data;
							if($sisa > 0) $numpages++;
							$pagenow   = ceil($awal / $jml_data)+1;
							$nextpage  = $pagenow + 1;
							$lastpage  = $pagenow - 1;

							if($nomer > 0)
								echo
								'<b><font color="blue">Tampil <font color="red">'.($awal+1).'</font> sampai <font color="red">'.$nomer.'</font> dari <font color="red">'.$rowcounts.'</font> data</font></b><br/><br/>';
								if($level > 94)
							echo
							'*) Anda dapat mempersiapkan dan mengedit data melalui microsoft Excel. Format file dapat di <a href="dl_contoh?id=ulangan">download disini</a><br />
							*) Rubahlah contoh diatas kemudian simpan dan <a href="#" id="ulangan" onClick="showImportData(this)">import disini.</a>';
							echo
						'</div>
						<center>';
							
							if($rowcounts > $jml_data)
							{
								if($pagenow <= 1)
									echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_start.png" width=24 height=24 style="margin-top:-4px;">
										</button>';
								else
									echo '<a href="#" id="pl=ulangan&m=1&kl='.$kelas.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_start_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								if($pagenow <= 1)
									echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_rewind.png" width=24 height=24 style="margin-top:-4px;">
										</button>';
								else
									echo '<a href="#" id="pl=ulangan&m='.$lastpage.'&kl='.$kelas.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_rewind_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								echo '<button type="button" class="btn btn-primary" disabled>'.$pagenow.'</button>';
								if($numpages > $pagenow)
									echo '<a href="#" id="pl=ulangan&m='.$nextpage.'&kl='.$kelas.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_fastforward_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								else
									echo '<button type="button" class="btn btn-danger" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_fastforward.png" width=16 height=16>
										</button>';
								if($pagenow >= $numpages)
									echo '<button type="button" class="btn btn-danger" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_end.png" width=16 height=16>
										</button>';
								else
									echo '<a href="#" id="pl=ulangan&m='.$numpages.'&kl='.$kelas.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_end_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
							}
								
						echo
						'</center>';
						if($level > 94)
						{
							echo
						'<br />
						<center>
							<a href="#" id="ulangan" class="btn btn-danger" style="border-radius: 8px;" onclick="hapusDataAll(this)">
								<img src="'.base_url().'utama/assists/images/icons/stop.ico" width=24 height=24> Hapus Semua
							</a>
							&nbsp;&nbsp;&nbsp;
							<a href="#" id="ulangan&bg=pdf" class="btn btn-primary" style="border-radius: 8px;" onclick="ctkRaporModal(this)">
								<img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=24 height=24> Cetak
							</a>
							&nbsp;&nbsp;&nbsp;
							<a href="#" id="ulangan&bg=xls" class="btn btn-primary" style="border-radius: 8px;" onclick="ctkRaporModal(this)">
								<img src="'.base_url().'utama/assists/images/icons/file_extension_xls.png" width=24 height=24> Export
							</a>
							&nbsp;&nbsp;&nbsp;
							<a href="#" id="ulangan" class="btn btn-success" style="border-radius: 8px;" onclick="editUlanganHarian(this)">
								<img src="'.base_url().'utama/assists/images/icons/add_card.ico" width=24 height=24> Tambah
							</a>
						</center>
						<br />';
						}
						echo
					'</div>
					<!-- ./panel -->
				</div>
				<!-- ./col -->';
		exit;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	public function ctkRaporModal()
	{
		date_default_timezone_set("Asia/Jakarta");
		if(isset($_GET['pl'])) $pilihM = $this->input->get('pl'); else $pilihM = 'rapor';
		if(isset($_GET['bg'])) $bagian = $this->input->get('bg'); else $bagian = 'xls';
		if(isset($_GET['tp'])) $tapelM = $this->input->get('tp'); else $tapelM = 2017;
		if(isset($_GET['sm'])) $semuaM = $this->input->get('sm'); else $semuaM = 0;
		if(isset($_GET['ss'])) $semesM = $this->input->get('ss'); else $semesM = '';
		if(isset($_GET['kl'])) $kelasM = $this->input->get('kl'); else $kelasM = '';
		if(isset($_GET['sw'])) $siswaM = $this->input->get('sw'); else $siswaM = '';
		
		echo
				'<!-- modal-dialog -->
				<div class="modal-dialog" role="document">
					<!-- modal-content -->
					<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
						<!-- modal header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title" id="tulisPesanLabel" style="margin-bottom:0px;margin-top:0px;color: yellow;text-shadow: 2px 2px 4px black, 0 0 25px white, 0 0 5px darkblue;">';
								if($pilihM == 'rapor')
								{
									if($bagian == 'xls')
										echo '<center><b><img src="'.base_url().'utama/assists/images/icons/file_extension_xls.png" width=32 height=32> Export Rapor</b></center>';
									else
										echo '<center><b><img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=32 height=32> Cetak Rapor</b></center>';
								}
								else
								{
									if($bagian == 'xls')
										echo '<center><b><img src="'.base_url().'utama/assists/images/icons/file_extension_xls.png" width=32 height=32> Export Ulangan Harian</b></center>';
									else
										echo '<center><b><img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=32 height=32> Cetak Ulangan Harian</b></center>';
								}
								echo
							'</h3>
						</div>
						<!-- ./modal header -->';
						
						if($bagian == 'xls') 
							echo '<form id="cetakRaporAllForm" action="exportData" method="POST">';
						else
							echo '<form id="cetakRaporAllForm" action="cetakRaporPDF" method="POST">';
						echo
						'<input type="hidden" name="pl" id="pl" value="'.$pilihM.'">
						<input type="hidden" name="bg" id="bg" value="'.$bagian.'">
						<!-- modal body -->
						<div class="modal-body">
							<div class="row">
								<div class="form-group col-md-12" style="margin-top: -2px;">
									<label class="text-bayang">Pilih : </label>
									&nbsp;&nbsp;&nbsp;
									<input type="radio" id="semuaModal" name="semua" value="0" '; if($semuaM == 0) echo ' checked '; echo ' onclick="rbhCtkRaporPlh()"> Semua
									&nbsp;&nbsp;&nbsp;
									<input type="radio" id="kelasX" name="semua" value="1" onclick="rbhCtkRaporPlh()"> Kelas
									&nbsp;&nbsp;&nbsp;
									<input type="radio" id="siswa" name="semua" value="2" onclick="rbhCtkRaporPlh()"> Siswa
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Tahun Pelajaran :
										</label>
										<input type="number" class="form-control" name="tapelSel" id="tapelSel" value="'.$tapelM.'" oninput="rbhCtkRaporTpl()">
									</div>
								</div>
								<div class="col-md-2" id="tapel1" style="margin-top:32px;margin-left:-20px;margin-right:10px;">
									<b> - '.($tapelM+1).'</b>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Semester :
										</label>
										<select class="form-control" name="semesSel" id="semesSel">
											<option value=""> == Pilih Semester == </option>
											<option value="1" ';if($semesM == 1) echo ' selected '; echo '> Ganjil </option>
											<option value="2" ';if($semesM == 2) echo ' selected '; echo '> Genap </option>
										</select>
									</div>
								</div>
							</div>
							<div class="row" style="margin-top: 4px;">
								<div class="col-md-4 form-group" id="idKelasModal" style="display:none;margin-top: 4px">
									<label class="text-bayang">Kelas : </label>
									&nbsp;&nbsp;&nbsp;
									<select id="kelasPilih" name="kelasPilih" style="height: 32px;width: 100px;" onchange="rbhCtkRaporKls()">';
										$query = $this->db->select('*')
													->from('tb_kelas')
													->get();
										if($query->num_rows() > 0)
										{
											foreach($query->result() as $row)
											{
												$kd_kelas = $row->kd_kelas;
												if($kelasM == $kd_kelas)
													echo '<option value="'.$row->kd_kelas.'" selected> '.$row->nama_kelas.'</option>';
												else
													echo '<option value="'.$row->kd_kelas.'"> '.$row->nama_kelas.'</option>';
											}
										}
									echo
									'</select>
								</div>
								<div class="col-md-8 form-group" id="idSiswaModal" style="display:none;margin-top: 4px;margin-left: -20px;">
									<label class="text-bayang">Siswa : </label>
									&nbsp;&nbsp;&nbsp;
									<select id="siswaSel" name="siswaSel" style="height: 32px;width: 290px;margin-right: 0;">';
									$query = $this->db->select('*')
												->from('tb_siswa')
												->where('kelas', $kelasM)
												->order_by('nama', 'asc')
												->get();
									if($query->num_rows() > 0)
									{
										foreach($query->result() as $row)
										{
											$no_ujian_smp = $row->no_ujian_smp;
											if($no_ujian_smp == $siswaM)
												echo '<option value="'.$row->no_induk.'" selected> '.$row->nama.'</option>';
											else
												echo '<option value="'.$row->no_induk.'"> '.$row->nama.'</option>';
										}
									}
									echo
									'</select>
								</div>
							</div>
						</div>
						<!-- ./modal-body -->
						
						<!-- modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
							</button>
							<button type="button" class="btn btn-primary" style="border-radius:8px;" onclick="cekRaporAll()">
								<img src="'.base_url().'utama/assists/images/icons/Print.ico" width=20 height=20> Cetak
							</button>
						</div>
						<!-- ./modal footer -->
						</form>
						
					</div>
					<!-- ./modal-content -->
				</div>
				<!-- ./ modal-dialog -->';
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	public function cekRaporAll()
	{
		date_default_timezone_set("Asia/Jakarta");
		if(isset($_POST['pilih'])) $pilihM = $this->input->post('pilih'); else $pilihM = 'rapor';
		if(isset($_POST['semua'])) $semuaM = $this->input->post('semua'); else $semuaM = 0;
		if(isset($_POST['tapel'])) $tapelM = $this->input->post('tapel'); else $tapelM = 2017;
		if(isset($_POST['semes'])) $semesM = $this->input->post('semes'); else $semesM = '';
		if(isset($_POST['kelas'])) $kelasM = $this->input->post('kelas'); else $kelasM = '';
		if(isset($_POST['induk'])) $indukM = $this->input->post('induk'); else $indukM = '';
		
		$outp = array();
		
		if($pilihM == 'rapor')
		{
			if($semuaM == 0)
			{
				$query = $this->db->select('*')
							->from('tb_nilai')
							->where('tapel', $tapelM)
							->where('semester', $semesM)
							->get();
				if($query->num_rows() <= 0)
				{
					$outp[0] = 'error';
					$outp[1] = 'Tidak Ada Data';
				}
				else
				{
					$outp[0] = 'sukses';
					$outp[1] = 'Data Rapor Telah Tercetak';
				}
			}
			elseif($semuaM == 1)
			{
				$query = $this->db->select('*')
							->from('tb_nilai')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_nilai.induk')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas')
							->where('tb_nilai.tapel', $tapelM)
							->where('tb_nilai.semester', $semesM)
							->where('tb_kelas.kd_kelas', $kelasM)
							->get();
				if($query->num_rows() <= 0)
				{
					$outp[0] = 'error';
					$outp[1] = 'Tidak Ada Data';
				}
				else
				{
					$outp[0] = 'sukses';
					$outp[1] = 'Data Rapor Telah Tercetak';
				}
			}
			else
			{
				$query = $this->db->select('*')
							->from('tb_nilai')
							->where('tapel', $tapelM)
							->where('semester', $semesM)
							->where('induk', $indukM)
							->get();
				if($query->num_rows() <= 0)
				{
					$outp[0] = 'error';
					$outp[1] = 'Tidak Ada Data';
				}
				else
				{
					$outp[0] = 'sukses';
					$outp[1] = 'Data Rapor Telah Tercetak';
				}
			}
		}
		else
		{
			if($semuaM == 0)
			{
				$query = $this->db->select('*')
							->from('tb_ulangan')
							->where('tapel', $tapelM)
							->where('semester', $semesM)
							->get();
				if($query->num_rows() <= 0)
				{
					$outp[0] = 'error';
					$outp[1] = 'Tidak Ada Data';
				}
				else
				{
					$outp[0] = 'sukses';
					$outp[1] = 'Data UH Telah Tercetak';
				}
			}
			elseif($semuaM == 1)
			{
				$query = $this->db->select('*')
							->from('tb_ulangan')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_ulangan.induk')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas')
							->where('tb_ulangan.tapel', $tapelM)
							->where('tb_ulangan.semester', $semesM)
							->where('tb_kelas.kd_kelas', $kelasM)
							->get();
				if($query->num_rows() <= 0)
				{
					$outp[0] = 'error';
					$outp[1] = 'Tidak Ada Data';
				}
				else
				{
					$outp[0] = 'sukses';
					$outp[1] = 'Data UH Telah Tercetak';
				}
			}
			else
			{
				$query = $this->db->select('*')
							->from('tb_ulangan')
							->where('tapel', $tapelM)
							->where('semester', $semesM)
							->where('induk', $indukM)
							->get();
				if($query->num_rows() <= 0)
				{
					$outp[0] = 'error';
					$outp[1] = 'Tidak Ada Data';
				}
				else
				{
					$outp[0] = 'sukses';
					$outp[1] = 'Data UH Telah Tercetak';
				}
			}
		}
		
		echo json_encode($outp);
		exit;
	}
		
	// ====================================
	// # Fungsi Edit Nilai Ulangan Harian #
	// ====================================
	function showUlanganModal()
	{
		$level    = $this->session->userdata('level');
		$username = $this->session->userdata('username');
		if(isset($_GET['id'])) $noL   = $this->input->get('id'); else $noL   = 0;
		if(isset($_GET['nm'])) $indukM = $this->input->get('nm'); else $indukM = '';
		if(isset($_GET['kl'])) $kelasM = $this->input->get('kl'); else $kelasM = '';
		if(isset($_GET['tp'])) $tapelM = $this->input->get('tp'); else $tapelM = 2017;
		if(isset($_GET['sm'])) $semesM = $this->input->get('sm'); else $semesM = '';
		if(strtolower($noL) == 'ulangan') $noL = 0;
		if($level == 94)
		{
			$query = $this->db->select('*')
					->from('tb_wali')
					->where('kd_guru', $username)
					->get();
			$hasil = $query -> num_rows();
			if($hasil > 0)
			{
				$row = $query->row();
				$kelasM = $row->kelas;
			}
			
		}
		
		$data_mapel = array(array('Agama',				'agama',	0,0,0,0,0,0,0,0,0,0,0,0),
							array('PKn', 				'pkn',		0,0,0,0,0,0,0,0,0,0,0,0),
							array('Bahasa Indonesia',	'indo',		0,0,0,0,0,0,0,0,0,0,0,0),
							array('Matematika',			'mat',		0,0,0,0,0,0,0,0,0,0,0,0),
							array('Sejarah',			'sej',		0,0,0,0,0,0,0,0,0,0,0,0),
							array('Bahasa Inggris',		'ingg',		0,0,0,0,0,0,0,0,0,0,0,0),
							array('Seni Budaya',		'senbud',	0,0,0,0,0,0,0,0,0,0,0,0),
							array('Penjas Orkes',		'penjas',	0,0,0,0,0,0,0,0,0,0,0,0),
							array('PKWU',				'pkwu',		0,0,0,0,0,0,0,0,0,0,0,0),
							array('Fisika / Ekonomi',	'fiseko',	0,0,0,0,0,0,0,0,0,0,0,0),
							array('Kimia / Sosiologi',	'kimsos',	0,0,0,0,0,0,0,0,0,0,0,0),
							array('Biologi / Geografi',	'biogeo',	0,0,0,0,0,0,0,0,0,0,0,0),
							array('Peminatan I', 		'minat1',	0,0,0,0,0,0,0,0,0,0,0,0),
							array('Peminatan II',		'minat2',	0,0,0,0,0,0,0,0,0,0,0,0),
							array('Lintas minat',		'lintas',	0,0,0,0,0,0,0,0,0,0,0,0)
							);
		$i = 0;
		if(($noL > 0) or ($indukM != ''))
		{
			if($noL > 0)
				$queri = $this->db->select('*')
							->from('tb_ulangan')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_ulangan.induk', 'left')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
							->join('tb_lintas', 'tb_lintas.lintas = tb_ulangan.lintas_s', 'left')
							->where('no', $noL)
							->get();
			else
				$queri = $this->db->select('*')
							->from('tb_ulangan')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_ulangan.induk', 'left')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
							->join('tb_lintas', 'tb_lintas.lintas = tb_ulangan.lintas_s', 'left')
							->where('tapel', $tapelM)
							->where('semester', $semesM)
							->where('induk', $indukM)
							->get();
			if($queri->num_rows() > 0)
			{
				$row = $queri->row();
				$indukM = $row->induk;
				$tapelM = $row->tapel;
				$semesM = $row->semester;
				$minat1_s = $row->minat1_s;
				$minat2_s = $row->minat2_s;
				$lintas_s = $row->lintas_s;
				$lintas_nama = $row->nama_lintas;
				$prodiM = $row->kd_prodi;
				
				for($j = 0; $j < count($data_mapel); $j++)
				{
					for($i = 0; $i < 5; $i++)
					{
						$kalim = $data_mapel[$j][1] . '_UH' . ($i + 1);
						$data_mapel[$j][($i + 2)] = number_format($row -> $kalim);
						$kalim = $data_mapel[$j][1] . '_T' . ($i + 1);
						$data_mapel[$j][($i + 7)] = number_format($row -> $kalim);
					}
					$kalim = $data_mapel[$j][1] . '_UTS';
					$data_mapel[$j][12] = number_format($row -> $kalim);
					$kalim = $data_mapel[$j][1] . '_UAS';
					$data_mapel[$j][13] = number_format($row -> $kalim);
				}
				
				$minat1_nama = '';
				$minat2_nama = '';
				$query1 = $this->db->select('*')
							->from('tb_minat')
							->get();
				foreach($query1->result() as $row)
				{
					$minat = $row->minat;
					$nama_minat = $row->nama_minat;
					if($minat == $minat1_s) $minat1_nama = $nama_minat;
					if($minat == $minat2_s) $minat2_nama = $nama_minat;
				}
			}
		}
		
		$jmlRec = 0;
		$queri = $this->db->select('*')
					->from('tb_siswa')
					->where('kelas', $kelasM)
					->get();
		if($queri->num_rows() <= 0) $indukM = '';
		echo
				'<!-- modal-dialog -->
				<div class="modal-dialog modal-lg" role="document">
					<!-- modal-content -->
					<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
						<!-- modal header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title hit-the-floor" id="isianAdminLabel">';
								if(strtolower($noL) == 0)
									echo '<img src="'.base_url().'utama/assists/images/icons/event.ico" width=32 height=32> <b>Tambah Nilai UH</b>';
								else
									echo '<img src="'.base_url().'utama/assists/images/icons/event.ico" width=32 height=32> <b>Edit Nilai UH</b>';
								echo
							'</h3>
						</div>
						<!-- ./modal header -->

						<!-- modal body -->
						<div class="modal-body" id="isianDataUH">
							<!-- Nav tabs -->
							<ul class="nav nav-pills">
								<li class="active"><a href="#dataSiswa" data-toggle="tab"><b>Data Siswa</b></a></li>';
								if(($noL > 0) or (($semesM != '') and ($indukM != '')))
									echo
								'<li><a href="#harian" data-toggle="tab"><b>Harian</b></a></li>
								<li><a href="#tugas" data-toggle="tab"><b>Tugas</b></a></li>
								<li><a href="#uts" data-toggle="tab"><b>UTS/ UAS</b></a></li>';
								echo
							'</ul>
							<hr/>
							
							<!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane fade in active" id="dataSiswa">
									<h4 style="color: yellow;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
										<strong>Data Siswa</strong>
									</h4>
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Tahun Pelajaran :
												</label>
												<input type="number" class="form-control" name="tapelSel" id="tapelSel" value="'.$tapelM.'" ';if($noL > 0) echo ' disabled '; echo ' oninput="rubahUlanganModal()">
											</div>
										</div>
										<div class="col-md-1" style="margin-top:32px;margin-left:-20px;margin-right:10px;">
											<b> - '.($tapelM+1).'</b>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Semester :
												</label>
												<select class="form-control" name="semesSel" id="semesSel" ';if($noL > 0) echo ' disabled '; echo ' oninput="rubahUlanganModal()">
													<option value=""> == Pilih Semester == </option>
													<option value="1" ';if($semesM == 1) echo ' selected '; echo '> Ganjil </option>
													<option value="2" ';if($semesM > 1) echo ' selected '; echo '> Genap </option>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Kelas :
												</label>
												<select class="form-control" name="kelasM" id="kelasM" ';if($noL > 0) echo ' disabled '; echo ' oninput="rubahUlanganModal()">';
													$queri = $this->db->select('*')
																->from('tb_kelas')
																->get();
													foreach($queri->result() as $row)
													{
														$kd_kelas   = $row->kd_kelas;
														$nama_kelas = $row->nama_kelas;
														if($kd_kelas == $kelasM)
															echo
															'<option value="'.$kd_kelas.'" selected> '.$nama_kelas.' </option>';
														else
															echo
															'<option value="'.$kd_kelas.'"> '.$nama_kelas.' </option>';
													}
													echo
												'</select>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Nama Siswa :
												</label>
												<select class="form-control" name="indukSel" id="indukSel" ';if($noL > 0) echo ' disabled '; echo ' oninput="rubahUlanganModal()">
													<option value=""> == Pilih Siswa == </option>';
													$jmlRec = 0;
													$queri = $this->db->select('*')
																->from('tb_siswa')
																->where('kelas', $kelasM)
																->order_by('nama', 'asc')
																->get();
													foreach($queri->result() as $row)
													{
														$namaS   = $row->nama;
														$kd_induk = $row->no_induk;
														if($kd_induk == $indukM)
															echo
															'<option value="'.$kd_induk.'" selected> '.$namaS.' </option>';
														else
															echo
															'<option value="'.$kd_induk.'"> '.$namaS.' </option>';
														$jmlRec++;
													}
													if($jmlRec == 0) $indukM = '';
													echo
												'</select>
											</div>
											<!--
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Test :
												</label>
												<input type="text" class="form-control" name="test" id="test" value="'.$tapelM.' - '.$semesM.' - '.$kelasM.' - '.$indukM.'">
											</div>
											-->
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Peminatan I :
												</label>
												<select class="form-control" name="minat1Sel" id="minat1Sel" onchange="rubahMinat1(this)"></b>';
												$queri = $this->db->select('*')
															->from('tb_minat')
															->where('prodi', $prodiM)
															->get();
												foreach($queri->result() as $row)
												{
													$minat   = $row->minat;
													$nama_minat = $row->nama_minat;
													if($minat == $minat1_s)
														echo
														'<option value="'.$minat.'" selected> '.$nama_minat.' </option>';
													else
														echo
														'<option value="'.$minat.'"> '.$nama_minat.' </option>';
												}
												echo
												'</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Peminatan II :
												</label>
												<select class="form-control" name="minat2Sel" id="minat2Sel" onchange="rubahMinat2(this)">
													<option value="" selected> == Tdk Ada == </option>';
													$queri = $this->db->select('*')
																->from('tb_minat')
																->where('prodi', $prodiM)
																->get();
													foreach($queri->result() as $row)
													{
														$minat   = $row->minat;
														$nama_minat = $row->nama_minat;
														if($minat == $minat2_s)
															echo
															'<option value="'.$minat.'" selected> '.$nama_minat.' </option>';
														else
															echo
															'<option value="'.$minat.'"> '.$nama_minat.' </option>';
													}
													echo
												'</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Lintas Minat :
												</label>
												<select class="form-control" name="lintasSel" id="lintasSel" onchange="rubahLintas(this)">';
													$queri = $this->db->select('*')
																->from('tb_lintas')
																->where('prodi', $prodiM)
																->get();
													foreach($queri->result() as $row)
													{
														$lintas   = $row->lintas;
														$nama_lintas = $row->nama_lintas;
														if($lintas == $lintas_s)
															echo
															'<option value="'.$lintas.'" selected> '.$nama_lintas.' </option>';
														else
															echo
															'<option value="'.$lintas.'"> '.$nama_lintas.' </option>';
													}
													echo
												'</select>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade in" id="harian">
									<h4 style="color: yellow;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
										<strong>Nilai Ulangan Harian</strong>
									</h4>
									<table style="width:100%;background-color: cyan;" class="table table-striped table-bordered table-hover">
										<thead>
											<tr style="background:green;color:yellow;">
												<th width=30%><center>Mata Pelajaran</center></th>
												<th><center>UH 1</center></th>
												<th><center>UH 2</center></th>
												<th><center>UH 3</center></th>
												<th><center>UH 4</center></th>
												<th><center>UH 5</center></th>
											</tr>
										</thead>
										<tbody>';
										for($i = 0; $i < count($data_mapel); $i++)
										{
											if($data_mapel[$i][1] == 'minat2')
											{
												echo '<tr id="minat2UHId" ';if($minat2_s == '') echo 'style="display:none;"'; echo '>';
											}
											else
												echo '<tr>';
											echo
												'<td style="text-align:right"><b>'.$data_mapel[$i][0];
														if($data_mapel[$i][1] == 'minat1') echo '<br/><span id="minat1UHLbl">'.$minat1_nama.'</span>';
													elseif($data_mapel[$i][1] == 'minat2') echo '<br/><span id="minat2UHLbl">'.$minat2_nama.'</span>';
													elseif($data_mapel[$i][1] == 'lintas') echo '<br/><span id="lintasUHLbl">'.$lintas_nama.'</span>';
													echo '</b></td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_UH1" name="'.$data_mapel[$i][1].'_UH1" value="'.$data_mapel[$i][2].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
												</td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_UH2" name="'.$data_mapel[$i][1].'_UH2" value="'.$data_mapel[$i][3].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
												</td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_UH3" name="'.$data_mapel[$i][1].'_UH3" value="'.$data_mapel[$i][4].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
												</td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_UH4" name="'.$data_mapel[$i][1].'_UH4" value="'.$data_mapel[$i][5].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
												</td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_UH5" name="'.$data_mapel[$i][1].'_UH5" value="'.$data_mapel[$i][6].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
												</td>
											</tr>';
										}
										echo
										'</tbody>
									</table>
								</div>
								<div class="tab-pane fade in" id="tugas">
									<h4 style="color: yellow;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
										<strong>Nilai Tugas</strong>
									</h4>
									<table style="width:100%;background-color: #F0E0C0;" class="table table-striped table-bordered table-hover">
										<thead>
											<tr style="background:green;color:yellow;">
												<th width=30%><center>Mata Pelajaran</center></th>
												<th><center>Tugas 1</center></th>
												<th><center>Tugas 2</center></th>
												<th><center>Tugas 3</center></th>
												<th><center>Tugas 4</center></th>
												<th><center>Tugas 5</center></th>
											</tr>
										</thead>
										<tbody>';
										for($i = 0; $i < count($data_mapel); $i++)
										{
											if($data_mapel[$i][1] == 'minat2')
											{
												echo '<tr id="minat2TgsId" ';if($minat2_s == '') echo 'style="display:none;"'; echo '>';
											}
											else
												echo '<tr>';
											echo
												'<td style="text-align:right"><b>'.$data_mapel[$i][0];
														if($data_mapel[$i][1] == 'minat1') echo '<br/><span id="minat1TgsLbl">'.$minat1_nama.'</span>';
													elseif($data_mapel[$i][1] == 'minat2') echo '<br/><span id="minat2TgsLbl">'.$minat2_nama.'</span>';
													elseif($data_mapel[$i][1] == 'lintas') echo '<br/><span id="lintasTgsLbl">'.$lintas_nama.'</span>';
													echo '</b></td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_T1" name="'.$data_mapel[$i][1].'_T1" value="'.$data_mapel[$i][7].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
												</td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_T2" name="'.$data_mapel[$i][1].'_T2" value="'.$data_mapel[$i][8].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
												</td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_T3" name="'.$data_mapel[$i][1].'_T3" value="'.$data_mapel[$i][9].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
												</td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_T4" name="'.$data_mapel[$i][1].'_T4" value="'.$data_mapel[$i][10].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
												</td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_T5" name="'.$data_mapel[$i][1].'_T5" value="'.$data_mapel[$i][11].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
												</td>
											</tr>';
										}
										echo
										'</tbody>
									</table>
								</div>
								<div class="tab-pane fade in" id="uts">
									<h4 style="color: yellow;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
										<strong>Nilai UTS / UAS</strong>
									</h4>
									<table style="width:60%;background-color: #70B070;" class="table table-striped table-bordered table-hover">
										<thead>
											<tr style="background:green;color:yellow;">
												<th style="width:18%;"><center>Mata Pelajaran</center></th>
												<th style="width:4%;"><center>UTS</center></th>
												<th style="width:4%;"><center>UAS</center></th>
											</tr>
										</thead>
										<tbody>';
										for($i = 0; $i < count($data_mapel); $i++)
										{
											if($data_mapel[$i][1] == 'minat2')
											{
												echo '<tr id="minat2UASId" ';if($minat2_s == '') echo 'style="display:none;"'; echo '>';
											}
											else
												echo '<tr>';
											echo
												'<td style="text-align:right"><b>'.$data_mapel[$i][0];
													if($data_mapel[$i][1] == 'minat1') echo '<br/><span id="minat1UASLbl">'.$minat1_nama.'</span>';
													elseif($data_mapel[$i][1] == 'minat2') echo '<br/><span id="minat2UASLbl">'.$minat2_nama.'</span>';
													elseif($data_mapel[$i][1] == 'lintas') echo '<br/><span id="lintasUASLbl">'.$lintas_nama.'</span>';
													echo '</b></td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_UTS" name="'.$data_mapel[$i][1].'_UTS" value="'.$data_mapel[$i][12].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
												</td>
												<td style="text-align:center">
													<input type="number" min="0" max="100" id="'.$data_mapel[$i][1].'_UAS" name="'.$data_mapel[$i][1].'_UAS" value="'.$data_mapel[$i][13].'" style="width:66px;padding-left:6px;" oninput="cekNilai(this)">
												</td>
											</tr>';
										}
										echo
										'</tbody>
									</table>
								</div>
							</div>
							
						</div>
						<!-- ./modal body -->
							
						<!-- modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
							</button>';
							if(($level > 94) and (($noL > 0) or (($semesM != '') and ($indukM != ''))))
								echo
							'<button type="button" class="btn btn-primary" onClick="simpanNilaiUH()" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/save.ico" width=20 height=20> Simpan
							</button>';
							echo
						'</div>
						<!-- ./modal footer -->
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->';
		exit;
	}

	// ======================================
	// # Fungsi simpan Nilai Ulangan Harian #
	// ======================================
	function simpanNilaiUH()
	{
		$nil_mapel = array();
		$dt_mapel  = array("agama", "pkn", "indo", "mat", "sej", "ingg", "senbud", "penjas", 
						"pkwu", "fiseko", "kimsos", "biogeo", "minat1", "minat2", "lintas");
		$nilai = $this->input->post('tapel');
		$nil_mapel['tapel'] = $nilai;
		$nilai = $this->input->post('semes');
		$nil_mapel['semester'] = $nilai;
		$nilai = $this->input->post('induk');
		$nil_mapel['induk'] = $nilai;
		$nilai = $this->input->post('minat1_s');
		$nil_mapel['minat1_s'] = $nilai;
		$nilai = $this->input->post('minat2_s');
		$nil_mapel['minat2_s'] = $nilai;
		$nilai = $this->input->post('lintas_s');
		$nil_mapel['lintas_s'] = $nilai;
		for($i = 0; $i < count($dt_mapel); $i++)
		{
			for($j = 0; $j < 5; $j++)
			{
				$mapel = $dt_mapel[$i] . '_UH' . ($j + 1);
				$nil_mapel[$mapel] = $this->input->post($mapel);
				$mapel = $dt_mapel[$i] . '_T' . ($j + 1);
				$nil_mapel[$mapel] = $this->input->post($mapel);
			}
			$mapel = $dt_mapel[$i] . '_UTS';
			$nil_mapel[$mapel] = $this->input->post($mapel);
			$mapel = $dt_mapel[$i] . '_UAS';
			$nil_mapel[$mapel] = $this->input->post($mapel);
		}
		$tapel = $nil_mapel['tapel'];
		$semes = $nil_mapel['semester'];
		$induk = $nil_mapel['induk'];
		$queri = $this->db->select('*')
					->from('tb_ulangan')
					->where('tapel', $tapel)
					->where('semester', $semes)
					->where('induk', $induk)
					->get();
		if($queri->num_rows() > 0)
			$this->db->where('tapel', $tapel)->where('semester', $semes)->where('induk', $induk)->update('tb_ulangan', $nil_mapel);
		else
			$this->db->insert('tb_ulangan', $nil_mapel);
		$outp = array();
		$outp[0] = 'sukses';
		$outp[1] = 'Data Nilai Harian berhasil disimpan';
		echo json_encode($outp);
		exit;
	}

	// ************************************************************************************************
	// *********************************     Akhir Ulangan Harian      ********************************
	// ************************************************************************************************
	
	// **************************************************************************************
	// *********************************     Awal Pesan     *********************************
	// **************************************************************************************
	function showDataPesan()
	{
		if(isset($_GET['id'])) {$pilih = $_GET['id'];} else {$pilih = '';}
		if(isset($_GET['cr'])) {$cari = $_GET['cr'];} else {$cari = '';}
		if(isset($_GET['m']))  {$mulai = $_GET['m'];} else {$mulai = 1;}
		
		$jml_data = 8;
		$awal = ($mulai - 1) * $jml_data;
		$nomer = $awal;
		
		echo
				'<div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <center><b><i>Daftar Pesan</i></b></center>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
									<tr style="background:green;color:yellow;">
										<th><center>No.</center></th>
										<th><center>Tanggal</center></th>
										<th><center>Nama</center></th>
										<th><center>Telephone</center></th>
										<th><center>Email</center></th>
										<th><center>Pesan</center></th>
										<th><center>Balas</center></th>
										<th><center>Tanggal</center></th>
										<th><center>Status</center></th>
										<th><center> # </center></th>
									</tr>
                                </thead>
                                <tbody>';
								
										$query = $this->db->select('*')
												->from('tb_pesan')
												->limit($jml_data, $awal)
												->order_by('tgl_pesan', 'asc')
												->get();
										foreach($query->result() as $row)
										{
											$nomer++;
											$id_pesan  = $row->urut;
											$tgl_pesan = $row->tgl_pesan;
											$pengirim  = $row->nama;
											$telpon    = $row->telpon;
											$email     = $row->email;
											$isi_pesan = $row->pesan;
											$balas     = $row->balas;
											$tgl_balas = $row->tgl_balas;
											$status    = $row->status;
											if($id_pesan == $pilih)
												echo '<tr style="background:yellow;color:red;">';
											else
												echo '<tr class="gradeA">';
											echo	'<td><center>'.$nomer.'</center></td>
													<td><center><a href="#" id="'.$id_pesan.'&m='.$mulai.'" onclick="bacaPesan(this)">'.$tgl_pesan.'</a></center></td>
													<td><a href="#" id="'.$id_pesan.'&m='.$mulai.'" onclick="bacaPesan(this)">'.$pengirim.'</a></td>
													<td><center><a href="#" id="'.$id_pesan.'&m='.$mulai.'" onclick="bacaPesan(this)">'.$telpon.'</a></center></td>
													<td><center><a href="#" id="'.$id_pesan.'&m='.$mulai.'" onclick="bacaPesan(this)">'.$email.'</a></center></td>
													<td><a href="#" id="'.$id_pesan.'&m='.$mulai.'" onclick="bacaPesan(this)">'.$isi_pesan.'</a></td>
													<td><a href="#" id="'.$id_pesan.'&m='.$mulai.'" onclick="bacaPesan(this)">'.$balas.'</a></td>
													<td><center><a href="#" id="'.$id_pesan.'&m='.$mulai.'" onclick="bacaPesan(this)">'.$tgl_balas.'</a></center></td>
													<td><center><a href="#" id="'.$id_pesan.'&m='.$mulai.'" onclick="bacaPesan(this)">'.$status.'</a></center></td>
													<td><center>
														<a href="#" id="'.$id_pesan.'&pl=pesan" onclick="hapusData(this)">
															<img src="'.base_url().'utama/assists/images/icons/delete.ico" width=20 height=20>
														</a></center>
													</td>
												</tr>';
										}
										if($nomer == 0)
											echo
												'<tr style="background:yellow;color:red;">
													<td colspan="10"><b><center>Tidak Ada Pesan</center></b></td>
												</tr>';
									echo
								'</tbody>
							</table>';
							
							$query = $this->db->select('*')
									->from('tb_pesan')
									->get();
							$rowcounts = $query->num_rows();
							$numpages  = ceil($rowcounts / $jml_data);
							$sisa      = $rowcounts % $jml_data;
							if($sisa > 0) $numpages++;
							$pagenow   = ceil($awal / $jml_data)+1;
							$nextpage  = $pagenow + 1;
							$lastpage  = $pagenow - 1;
							
							if ($nomer > 0)
								echo				
									'<b><font color="blue">Tampil <font color="red">'.($awal+1).'</font> sampai <font color="red">'.$nomer.'</font> dari <font color="red">'.$rowcounts.'</font> data</font></b><br/><br/>';
							echo
						'</div>
						<center>';
							if($rowcounts > $jml_data)
							{
								if($pagenow <= 1)
									echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_start.png" width=24 height=24 style="margin-top:-4px;">
										</button>';
								else
									echo '<a href="#" id="pl=pesan&m=1" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_start_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								if($pagenow <= 1)
									echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_rewind.png" width=24 height=24 style="margin-top:-4px;">
										</button>';
								else
									echo '<a href="#" id="pl=pesan&m='.$lastpage.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_rewind_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								echo '<button type="button" class="btn btn-primary" disabled>'.$pagenow.'</button>';
								if($numpages > $pagenow)
									echo '<a href="#" id="pl=pesan&m='.$nextpage.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_fastforward_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
								else
									echo '<button type="button" class="btn btn-danger" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_fastforward.png" width=16 height=16>
										</button>';
								if($pagenow >= $numpages)
									echo '<button type="button" class="btn btn-danger" disabled>
											<img src="'.base_url().'utama/assists/images/icons/control_end.png" width=16 height=16>
										</button>';
								else
									echo '<a href="#" id="pl=pesan&m='.$numpages.'" class="btn btn-primary" style="height:34px;" onclick="showDataAll(this.id)">
											<img src="'.base_url().'utama/assists/images/icons/control_end_blue.png" width=24 height=24 style="margin-top:-4px;">
										</a>';
							}
						echo
						'</center>';
						if($nomer > 1)
						{
							echo
						'<br />
						<center>
							<a href="#" id="pesan" class="btn btn-danger" onclick="hapusDataAll(this)">
								<img src="'.base_url().'utama/assists/images/icons/stop.ico" width=24 height=24> Hapus Semua Pesan
							</a>
						</center>';
						}
						echo
						'<br />
					</div>
					<!-- ./panel -->
				</div>
				<!-- ./col -->';
		exit;
	}
	
	// ======================================================================================
	// # Fungsi kirim email
	// ======================================================================================
	public function bacaPesan()
	{
		date_default_timezone_set("Asia/Jakarta");
		$urut = $this->input->get('id');
		
		$query = $this->db->select('*')
				->from('tb_pesan')
				->where('urut', $urut)
				->get();
		$row = $query->row();
		$tgl_pesan = $row->tgl_pesan;
		$nama      = $row->nama;
		$telpon    = $row->telpon;
		$email     = $row->email;
		$pesan     = $row->pesan;
		$balas     = $row->balas;
		$tgl_balas = $row->tgl_balas;
		$status    = $row->status;
		$tanggal_p = date('Y-m-d', strtotime($tgl_pesan));
		$waktu_p   = date('H:i:s', strtotime($tgl_pesan));
		
		if(strtolower($status) == 'blm baca')
		{
			$tgl_balas = date("Y-m-d H:i:s");
			$data = array('status' => 'Sdh Baca', 'tgl_balas' => $tgl_balas);
			$this->db->where('urut', $urut)->update('tb_pesan', $data);
		}
		$tanggal_b = date('Y-m-d', strtotime($tgl_balas));
		$waktu_b   = date('H:i:s', strtotime($tgl_balas));
		
		echo
				'<!-- modal-dialog -->
				<div class="modal-dialog modal-lg" role="document">
					<!-- modal-content -->
					<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
						<!-- modal header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title" id="bacaPesanLabel" style="margin-bottom:0px;margin-top:0px;color: yellow;text-shadow: 2px 2px 4px black, 0 0 25px white, 0 0 5px darkblue;">
								<center><b>Baca Pesan</b></center>
							</h3>
						</div>
						<!-- ./modal header -->

						<!-- modal body -->
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label style="color: red;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Tanggal :
												</label>
												<input type="date" class="form-control" name="tanggal_p" id="tanggal_p" value="'.$tanggal_p.'" disabled>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="color: red;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Jam :
												</label>
												<input type="time" class="form-control" name="waktu_p" id="waktu_p" value="'.$waktu_p.'" disabled>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label style="color: red;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Telephone :
										</label>
										<input type="text" class="form-control" name="telpon" id="telpon" value="'.$telpon.'" disabled>
									</div>
									<div class="form-group">
										<label style="color: red;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Pesan :
										</label>
										<textarea class="form-control" name="pesan" id="pesan" rows="3" disabled>'.$pesan.'</textarea>
									</div>
									<div class="form-group">
										<label style="color: red;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Status :
										</label>
										<input type="text" class="form-control" name="status" id="status" value="'.$status.'" disabled>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: red;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Pengirim :
										</label>
										<input type="text" class="form-control" name="nama" id="nama" value="'.$nama.'" disabled>
									</div>
									<div class="form-group">
										<label style="color: red;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											email :
										</label>
										<input type="text" class="form-control" name="email" id="email" value="'.$email.'" disabled>
									</div>
									<div class="form-group">
										<label style="color: yellow;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Balas Pesan :
										</label>
										<textarea class="form-control" name="balas" id="balas" rows="3">'.$balas.'</textarea>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label style="color: red;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Tanggal :
												</label>
												<input type="date" class="form-control" name="tanggal_b" id="tanggal_b" value="'.$tanggal_b.'" disabled>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="color: red;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Jam :
												</label>
												<input type="time" class="form-control" name="waktu_b" id="waktu_b" value="'.$waktu_b.'" disabled>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- ./row -->
						</div>
						<!-- ./modal-body -->
						
						<!-- modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
							</button>
							<button type="button" id="'.$urut.'" class="btn btn-primary" style="border-radius:8px;" onclick="balasPesan(this)">
								<img src="'.base_url().'utama/assists/images/icons/send2.ico" width=20 height=20> Balas
							</button>
						</div>
						<!-- ./modal footer -->
						
					</div>
					<!-- ./modal-content -->
				</div>
				<!-- ./ modal-dialog -->';
		
		exit;
		
	}
	
	// ======================================================================================
	// # Fungsi kirim email
	// ======================================================================================
	public function balasPesan()
	{
		$urut  = $this->input->post('urut');
		$balas = $this->input->post('balas');
		
		$query = $this->db->select('*')
				->from('tb_pesan')
				->where('urut', $urut)
				->get();
		$row = $query->row();
		$email     = $row->email;

		$tgl_balas = date("Y-m-d H:i:s");
		$data = array('balas' => $balas, 'status' => 'Sdh Balas', 'tgl_balas' => $tgl_balas);
		$this->db->where('urut', $urut)->update('tb_pesan', $data);
		
		$outp = array();
		if($this->sendEmail($email, $balas))
		{
			$outp[0] = 'sukses';
			$outp[1] = 'Pesan berhasil dikirim';
		}
		else
		{
			$outp[0] = 'error';
			$outp[1] = 'Pesan gagal dikirim';
		}
		echo json_encode($outp);
		
		exit;
	}

	// ======================================================================================
	// # Fungsi kirim email
	// ======================================================================================
    function sendEmail($to_email, $pesan)
    {
        $from_email = 'your@domain.com';					//change this to yours
        $subject = 'Balas pesan Isian Data Siswa';
        $message = $pesan;
        
        //configure email settings
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.your.domain.com';	//smtp host name
        $config['smtp_port'] = '465';						//smtp port number
        $config['smtp_user'] = $from_email;
        $config['smtp_pass'] = 'Password Anda';				//$from_email password
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n";						//use double quotes
        $this->email->initialize($config);
        
        //send mail
        $this->email->from($from_email);
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();
    }
    
	// ***************************************************************************************
	// *********************************     Akhir Pesan     *********************************
	// ***************************************************************************************





	
}


