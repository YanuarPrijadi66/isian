<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data extends CI_Model
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
    }
	
	// ======================================================================================
	// # Fungsi string random
	// ======================================================================================
	function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i)
		{
			$str .= $keyspace[rand(0, $max)];
		}
		return $str;
	}

	// ======================================================================================
	// # Fungsi enskripsi
	// ======================================================================================
	public function encryptIt($string) 
	{
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'Y4nu4r';
		$secret_iv = 'Pr1j4d1';
		// hash
		$key = hash('sha256', $secret_key);
    
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}

	// ======================================================================================
	// # Fungsi deskripsi
	// ======================================================================================
	public function decryptIt($string) 
	{
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'Y4nu4r';
		$secret_iv = 'Pr1j4d1';
		// hash
		$key = hash('sha256', $secret_key);
    
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		return $output;
	}

	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	public function showLogin()
	{
		// Captcha configuration
		$vals = array(
					'word'          => $this->random_str(5, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),
					'img_path'      => 'utama/assists/captcha_images/',
					'img_url'       => 'utama/assists/captcha_images/',
					'font_path'     => 'utama/assets/tiny_editor/php/FreeSerifItalic.ttf',
					'img_width'     => '155',
					'img_height'    => 30,
					'expiration'    => 3600,
					'word_length'   => 8,
					'font_size'     => 24,
					'img_id'        => 'Imageid',
					'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

					// White background and border, black text and red grid
					'colors'        => array(
						'background' => array(255, 255, 255),
						'border' => array(255, 255, 255),
						'text' => array(0, 0, 0),
						'grid' => array(255, 255, 255)
						)
					);

		$captcha = create_captcha($vals);

		// Unset previous captcha and store new captcha word
		$this->session->unset_userdata('captchaCode');
		$this->session->set_userdata('captchaCode',$captcha['word']);
				
		$captchaImg = $captcha['image'];
		
		echo
                '<div id="container_demo" >
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
					
                        <div id="login" class="animate form">
							<!--
							<h2 style="height:16px;margin-left:-10px;margin-top:-8px;color: red;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
							-->
							<h2 class="hit-the-floor">
								<center><b>Isian Data Siswa</b></center>
							</h2>
							<br/>
							<p> 
								<label for="username" class="uname" data-icon="u" > User ID : </label>
								<input type="text" id="username" name="username" placeholder="Your ID" onkeyup="cekInput(this)"/>
							</p>
							<div class="input-group margin">
								<b>Password :</b>
								<input type="password" class="form-control" id="password" name="password" value="" style="height:16px;margin-left:-10px;" onkeyup="cekInput(this)">
								<span class="input-group-btn">
									<button type="button" id="tampil" class="btn btn-success btn-flat" style="margin-left:4px;margin-top:24px;height:38px;border-radius:8px;" onclick="showHidePass()">
										<i class="glyphicon glyphicon-eye-open" id="simbol"></i>
									</button>
								</span>
							</div>
						<div class="form-horizontal">';
		echo $captchaImg;
		echo				'<a href="#" id="refresh" style="margin-left:10px;" onclick="showLogin()">
								<img src="'.base_url().'utama/assists/images/icons/refresh.ico" width=24 height=24>
							</a>
						</div>
						<div class="form-horizontal" style="margin-left:10px;margin-top:2px;">
							<input type="text" name="captcha" id="captcha" value="" style="height:16px;margin-left:-10px;" onkeyup="cekInput(this)">
							<span style="height:16px;margin-left:-10px;color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
								Isikan kode di atas
							</span>
						</div>
							<!--
							<p>
								'.$captchaImg.'
								<input type="text" id="captcha" name="captcha"> 
							</p>
							<p class="keeplogin"> 
								<input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
								<label for="loginkeeping">Keep me logged in</label>
							</p>
							-->
							<p class="login button"> 
								<input type="button" value="Login" onclick="cekLogin()"> 
							</p>
							<p class="change_link">
								<!--
								<a href="#toregister" class="to_login"> Contact Us </a>
								-->
							</p>
                        </div>

						<div id="register" class="animate form">
							<h2 style="height:16px;margin-left:-10px;margin-top:-10px;color:yellow;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
								<center><b>Contact Us</b></center>
							</h2>
							<br/>
							<p> 
								<label for="nama" class="uname" data-icon="u" > Nama Lengkap : </label>
								<input type="text" id="nama" name="nama" placeholder="Your Name"  onkeyup="cekInput(this)">
							</p>
							<p> 
								<label for="telpon" class="uname" > Nomer Telephone : </label>
								<input type="text" id="telpon" name="telpon" placeholder="Your Phone Number" onkeyup="cekInput(this)"> 
							</p>
							<p> 
								<label for="email" class="uname" data-icon="e"> Email : </label>
								<input type="text" id="email" name="email" placeholder="Your@email.com" onkeyup="cekInput(this)"> 
							</p>
							<p> 
								<label for="pesan" class="uname" > Pesan : </label>
								<input type="textarea" id="pesan" name="pesan" placeholder="Type your message" onkeyup="cekInput(this)"> 
							</p>
							<p class="login button"> 
								<input type="button" value="Send" onclick="kirimPesan()"> 
							</p>
							<p class="change_link">
								<a href="#tologin" class="to_login"> Click me to Login </a>
							</p>
                        </div>
						
                    </div>
                </div> ';
		exit;
	}
	
	// ======================================================================================
	// # Fungsi Cek login Admin atau Siswa
	// ======================================================================================
	public function cekLogin() 
	{
		date_default_timezone_set("Asia/Jakarta");

		$username = $this->input->get('id');
		$password = $this->encryptIt($this->input->get('ps'));
		$inputCaptcha = $this->input->get('cc');
		$sessCaptcha = $this->session->userdata('captchaCode');
		if($inputCaptcha == $sessCaptcha)
		{
			$hasil = 0;
			$query = $this->db->select('*')
					->from('tb_admin')
					->where('username', $username)
					->where('password', $password)
					->get();
			$hasil = $query -> num_rows();
			if($hasil > 0)
			{
				$user   = $query->row();
				$username = $user->username;
				$nama   = $user->nama;
				$status = $user->status;
				$login_status = $user->login_status;
			}
			else
			{
				$query = $this->db->select('*')
						->from('tb_siswa')
						->where('no_ujian_smp', $username)
						->where('password', $password)
						->get();
				$hasil = $query -> num_rows();
				if($hasil > 0)
				{
					$row = $query->row();
					$username = $row->no_ujian_smp;
					$nama     = $row->nama;
					$status   = $row->status;
					$login_status = 'N';
				}
				else
				{
					$query = $this->db->select('*')
							->from('tb_wali')
							->where('kd_guru', $username)
							->where('password', $password)
							->get();
					$hasil = $query -> num_rows();
					if($hasil > 0)
					{
						$row = $query->row();
						$username = $row->kd_guru;
						$nama     = $row->nama;
						$status   = 'walikelas';
						$login_status = 'N';
					}
				}
			}
			$password = $this->decryptIt($password);
			if ($hasil == 1) 
			{
				if(strtolower($status) == 'admin')				{$level = 99;} 
				elseif(strtolower($status) == 'administrator')	{$level = 98;}
				elseif(strtolower($status) == 'tu')				{$level = 97;}
				elseif(strtolower($status) == 'walikelas')		{$level = 94;}
				elseif(strtolower($status) == 'siswa')          {$level = 91;}
				else
				{
					$this->session->sess_destroy();
					$page = 'home';
					redirect('home');
					exit;
				}
				//die($username.' - '.$password.' - '.$status.' - '.$level);
				$newdata = array
							('username' => $username,
							'nama' => $nama,
							'tingkat' => $status,
							'level' => $level,
							'logged_in' => TRUE
							);
				$this->session->set_userdata($newdata);
				$ip = $this->input->ip_address();
				$waktu = date('Y-m-d H:i:s');
				$status = 'sukses';
				//if($level > 97) $password = '';
				$data = array('user' => $username,
							'password' => $password,
							'tanggal' => $waktu,
							'ip' => $ip,
							'status' => $status);
				$this->db->insert('tb_login', $data);
				$data = array(
							'login_terakhir' => $waktu,
							'login_status' => 'Y',
							'ip' => $ip
							);
				if($level > 95)
					$this->db->where('username', $username)->update('tb_admin', $data);
				elseif($level == 94)
					$this->db->where('kd_guru', $username)->update('tb_wali', $data);
				echo 'sukses';
				exit;
			}
			else 
			{
				$ip = $this->input->ip_address();
				$waktu = date('Y-m-d H:i:s');
				$status = 'Gagal';
				$data = array('user' => $username,
							'password' => $password,
							'tanggal' => $waktu,
							'ip' => $ip,
							'status' => $status);
				$this->db->insert('tb_login', $data);
				echo 'Username dan Password tidak Ada';
				exit;
			}
		}
		else
		{
			echo 'Kode Tidak Sama';
			exit;
		}
		
	}
	
	// ======================================================================================
	// # Fungsi Logout
	// ======================================================================================
    function logout()
    {
		$username = $this->session->userdata('username');
		$level    = $this->session->userdata('level');
			
		$data = array('login_status' => 'N');
		if($level > 96)
			$this->db->where('username', $username)->update('tb_admin', $data);
		elseif($level == 94)
			$this->db->where('kd_guru', $username)->update('tb_wali', $data);
        $alamat_ip = $this->session->userdata('ip');
		
		session_start();
		// remove all session variables
		session_unset(); 
		// destroy the session 
		session_destroy(); 
		
		$this->session->sess_destroy();
		$this->session->set_userdata('ip', $alamat_ip);
		
		$page = 'home';
		redirect('home');
		exit;
	}
	
    // ======================================================================================
	// # Fungsi Cek Pengunjung
	// ======================================================================================
	public function cek_pengunjung($page)
	{
    	date_default_timezone_set("Asia/Jakarta");

        $alamat_ip = $this->session->userdata('ip');
        if($alamat_ip == '')
        {
            $this->load->library('user_agent');
            if ($this->agent->is_browser())
            {
                $agent = $this->agent->agent_string();
            }
            elseif ($this->agent->is_robot())
            {
                $agent = $this->agent->robot();
            }
            elseif ($this->agent->is_mobile())
            {
                $agent = $this->agent->mobile();
            }
            elseif ($this->agent->is_referral())
            {
                $agent = $this->agent->referrer();
            }
            else
            {
                $agent = 'Unidentified User Agent';
            }
            
			$ip = $this->input->ip_address();
			$waktu = date('Y-m-d H:i:s');
			$data = array('tanggal' => $waktu,
						'ip' => $ip,
						'browser' => $agent,
                        'page' => $page);
			$this->db->insert('tb_pengunjung', $data);
			$this->session->set_userdata('ip', $ip);
        }
	}

	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function showHeaderSiswa()
	{
		$username = $this->session->userdata('username');
		$nama     = $this->session->userdata('nama');
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

				<!-- Header Navbar: style can be found in header.less --
				<nav class="navbar navbar-static-top">
				-->
				<nav class="navbar navbar-static-top" role="navigation" style="height:50px;">
					<!-- Sidebar toggle button--
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					-->
					<a href="#" data-toggle="offcanvas" role="button">
						<img src="'.base_url().'utama/assists/images/icons/application_side_list.png" width=28 height=28 style="margin-top:10px;margin-left:10px;">
						<span class="sr-only">Toggle navigation</span>
					</a>

					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="'.base_url().'utama/assists/photos/home.png" width=24 height=24 class="img-circle" alt="User Image">
									<span class="hidden-xs"><font color="red"><b><i><?php echo $nama;?></i></b></font></span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
										<img src="'.base_url().'utama/assists/photos/home.png" class="img-circle" alt="User Image">
										<p>'.$nama.' - Siswa</p>
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
									<img src="'.base_url().'utama/assists/images/icons/configuration.ico" width=28 height=28 style="margin-top:-6px;">
								</a>
							</li>
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
					<ul class="sidebar-menu">
						<li class="header">MAIN NAVIGATION</li>
						<li>
							<a href="home">
								<img src="'.base_url().'utama/assists/images/icons/house.png" width=24 height=24>
								&nbsp;Beranda
							</a>
						</li>
						<li>
							<a href="#" id="'.$username.'" onclick="editSiswaData(this)">
								<img src="'.base_url().'utama/assists/images/icons/table.ico" width=24 height=24>
								&nbsp;Isian Data
							</a>
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
								<img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=24 height=24>
								<span>Cetak PDF</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li>
									<a href="cetakDataPDF">
										<img src="'.base_url().'utama/assists/images/icons/personal-information.ico" width=24 height=24>
										&nbsp;Cetak Isian
									</a>
								</li>
								<li>
									<a href="#" id="'.$username.'" onclick="showSuketModal(this)">
										<img src="'.base_url().'utama/assists/images/icons/Paste.ico" width=24 height=24>
										&nbsp;Surat Keterangan
									</a>
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
											<a href="#" onclick="showSiswaRapor('."'ulangan'".')">
												<img src="'.base_url().'utama/assists/images/icons/event.ico" width=24 height=24>
												&nbsp;Ulangan Harian
											</a>
										</li>
										<li>
											<a href="#" onclick="showSiswaRapor('."'rapor'".')">
												<img src="'.base_url().'utama/assists/images/icons/property.ico" width=24 height=24>
												&nbsp;Cetak Rapor
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" onclick="tulisPesan()">
								<img src="'.base_url().'utama/assists/images/icons/kontak.ico" width=24 height=24>
								&nbsp;Tulis Pesan
							</a>
						</li>
						<li>
							<a href="logout">
								<img src="'.base_url().'utama/assists/images/icons/exit.png" width=24 height=24>
								&nbsp;Logout
							</a>
						</li>
					</ul>
				</section>
			</aside>';

		exit;
	}
	
	/*	xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
		xx                                        Referensi Master                                                  xx
		xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
	// ======================================================================================
	// # Fungsi Nama Siswa Dalam 1 kelas
	// ======================================================================================
	function array_siswa($kelas)
	{
		$arr_siswa = array();
		$query = $this->db->select('*')
				->from('tb_siswa')
				->where('kelas', $kelas)
				->order_by('nama', 'asc')
				->get();
		foreach($query->result() as $row)
		{
			$id   = $row -> no_induk;
			$nama_siswa = $row -> nama;
			$arr_siswa[$id] = $nama_siswa;
		}
		return $arr_siswa;
	}

	// ======================================================================================
	// # Fungsi Nama Siswa Dalam 1 kelas
	// ======================================================================================
	function pilihSiswa()
	{
		$kelas = $this->input->get('kl');
		echo
			'<div class="col-md-3">
				<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
					Nama Siswa
				</label>
			</div>
			<div class="col-md-8">
				<select id="indukSelect" name="indukSelect" style="height:28px;width:100%;" >';
					foreach($this->array_siswa($kelas) as $x => $x_value)
					{
						echo '<option value="'.$x.'">'.$x_value.'</option>';
					}
					echo
				'</select>
			</div>';
		
		exit;
	}

	// ========================
	// # Fungsi Pilihan Agama #
	// ========================
	public function array_agama()
	{
		$arr_agama = array();
		$query = $this->db->select('*')
				->from('tb_agama')
				->get();
		foreach($query->result() as $row)
		{
			$agama_id = $row -> agama_id;
			$agama    = $row -> nama_agama;
			$arr_agama[$agama_id] = $agama;
		}
		return $arr_agama;
	}
	
	// ===============================
	// # Fungsi Pilihan Transportasi #
	// ===============================
	public function array_transport()
	{
		$arr_transpot = array();
		$query = $this->db->select('*')
				->from('tb_alat_transportasi')
				->get();
		foreach($query->result() as $row)
		{
			$id   = $row -> alat_transportasi_id;
			$nama = $row -> nama_transportasi;
			$arr_transpot[$id] = $nama;
		}
		return $arr_transpot;
	}
	
	// =============================
	// # Fungsi Pilihan Pendidikan #
	// =============================
	public function array_pendidikan()
	{
		$arr_pendidikan = array();
		$query = $this->db->select('*')
				->from('tb_pendidikan')
				->get();
		foreach($query->result() as $row)
		{
			$id   = $row -> pendidikan_id;
			$nama = $row -> nama_pendidikan;
			$arr_pendidikan[$id] = $nama;
		}
		return $arr_pendidikan;
	}
	
	// ===================================
	// # Fungsi Pilihan Kebutuhan Khusus #
	// ===================================
	public function array_kebutuhan()
	{
		$arr_kebutuhan = array();
		$query = $this->db->select('*')
				->from('tb_kebutuhan')
				->get();
		foreach($query->result() as $row)
		{
			$id   = $row -> kebutuhan_id;
			$nama = $row -> nama_kebutuhan;
			$arr_kebutuhan[$id] = $nama;
		}
		return $arr_kebutuhan;
	}
	
	// ============================
	// # Fungsi Pilihan Pekerjaan #
	// ============================
	public function array_pekerjaan()
	{
		$arr_pekerjaan = array();
		$query = $this->db->select('*')
				->from('tb_pekerjaan')
				->get();
		foreach($query->result() as $row)
		{
			$id   = $row -> pekerjaan_id;
			$nama = $row -> nama_pekerjaan;
			$arr_pekerjaan[$id] = $nama;
		}
		return $arr_pekerjaan;
	}
	
	// ==============================
	// # Fungsi Pilihan Penghasilan #
	// ==============================
	public function array_penghasilan()
	{
		$arr_penghasilan = array();
		$query = $this->db->select('*')
				->from('tb_penghasilan')
				->get();
		foreach($query->result() as $row)
		{
			$id   = $row -> penghasilan_id;
			$nama = $row -> nama_penghasilan;
			$arr_penghasilan[$id] = $nama;
		}
		return $arr_penghasilan;
	}
	
	// =================================
	// # Fungsi Pilihan Tempat Tinggal #
	// =================================
	public function array_jenis_tinggal()
	{
		$arr_jenis_tinggal = array();
		$query = $this->db->select('*')
				->from('tb_jenis_tinggal')
				->get();
		foreach($query->result() as $row)
		{
			$id   = $row -> jenis_tinggal_id;
			$nama = $row -> nama_jenis_tinggal;
			$arr_jenis_tinggal[$id] = $nama;
		}
		return $arr_jenis_tinggal;
	}
	
	// =========================
	// # Fungsi Pilihan Negara #
	// =========================
	public function array_negara()
	{
		$arr_negara = array();
		$query = $this->db->select('*')
				->from('tb_negara')
				->get();
		foreach($query->result() as $row)
		{
			$id   = $row -> negara_id;
			$nama = $row -> nama_negara;
			$arr_negara[$id] = $nama;
		}
		return $arr_negara;
	}
	
	// ===========================
	// # Fungsi Pilihan Propinsi #
	// ===========================
	public function array_propinsi()
	{
		$arr_propinsi = array();
		$query = $this->db->select('*')
				->from('tb_mst_wilayah')
				->where('id_level_wilayah', '1')
				->order_by('kode_wilayah', 'asc')
				->get();
		foreach($query->result() as $row)
		{
			$id   = $row -> kode_wilayah;
			$nama = $row -> nama_wilayah;
			$arr_propinsi[$id] = $nama;
		}
		return $arr_propinsi;
	}
	
	// =======================
	// # Fungsi Pilihan Kota #
	// =======================
	public function array_kota($kd_propinsi)
	{
		$arr_kota = array();
		$query = $this->db->select('*')
				->from('tb_mst_wilayah')
				->where('mst_kode_wilayah', $kd_propinsi)
				->order_by('kode_wilayah', 'asc')
				->get();
		foreach($query->result() as $row)
		{
			$id   = $row -> kode_wilayah;
			$nama_kota = $row -> nama_wilayah;
			$arr_kota[$id] = $nama_kota;
		}
		return $arr_kota;
	}
	
	// ============================
	// # Fungsi Pilihan Kecamatan #
	// ============================
	public function array_kecamatan($kd_kota)
	{
		$arr_kecamatan = array();
		$query = $this->db->select('*')
				->from('tb_mst_wilayah')
				->where('mst_kode_wilayah', $kd_kota)
				->order_by('kode_wilayah', 'asc')
				->get();
		foreach($query->result() as $row)
		{
			$id   = $row -> kode_wilayah;
			$nama_kecamatan = $row -> nama_wilayah;
			$arr_kecamatan[$id] = $nama_kecamatan;
		}
		return $arr_kecamatan;
	}
	
	// ============================
	// # Fungsi Pilihan Kelurahan #
	// ============================
	public function array_kelurahan($kd_kecamatan)
	{
		$arr_desa = array();
		$query = $this->db->select('*')
				->from('tb_mst_wilayah')
				->where('mst_kode_wilayah', $kd_kecamatan)
				->order_by('kode_wilayah', 'asc')
				->get();
		foreach($query->result() as $row)
		{
			$id   = $row -> kode_wilayah;
			$nama_kelurahan = $row -> nama_wilayah;
			$arr_desa[$id] = $nama_kelurahan;
		}
		return $arr_desa;
	}
	
	// ===============================
	// # Fungsi Pilihan Kode Wilayah #
	// ===============================
	public function array_kode_wilayah($kode_wilayah)
	{
		$kelurahan = '';
		$kecamatan = '';
		$kota      = '';
		$propinsi  = '';
		$kd_propinsi = '';
		$kd_kota     = '';
		$kd_kecamatan = '';
		$kd_kelurahan = '';
		
		$mst_kode_wilayah = $kode_wilayah;
		$level = 10;
		while($level > 1)
		{
			$query = $this->db->select('*')
					->from('tb_mst_wilayah')
					->where('kode_wilayah', $mst_kode_wilayah)
					->get();
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$kode_wilayah1    = $row -> kode_wilayah;
				$level            = $row -> id_level_wilayah;
				$mst_kode_wilayah = $row -> mst_kode_wilayah;
				$nama_wilayah     = $row -> nama_wilayah;
				if($level == '4') 
				{
					$kelurahan = $nama_wilayah;
					$kd_kelurahan = $kode_wilayah1;
				}
				elseif($level == '3') 
				{
					$kecamatan = $nama_wilayah;
					$kd_kecamatan = $kode_wilayah1;
				}
				elseif($level == '2') 
				{
					$kota = $nama_wilayah;
					$kd_kota = $kode_wilayah1;
				}
				elseif($level == '1') 
				{
					$propinsi = $nama_wilayah;
					$kd_propinsi = $kode_wilayah1;
				}
			}
			else
			{
				$level = 0;
				$kd_propinsi	= '';
				$kd_kota		= '';
				$kd_kecamatan	= '';
				$kd_kelurahan	= '';
			}
		}
		$arr_kode_wilayah = array($kd_propinsi, $propinsi, $kd_kota, $kota, $kd_kecamatan, $kecamatan, $kd_kelurahan, $kelurahan);
		return $arr_kode_wilayah;
	}
	
	// ======================================================================================
	// # Fungsi Pilih Kota / Kabupaten
	// ======================================================================================
	public function pilihKota()
	{
		$kd_propinsi = $this->input->get('id');
		echo
		'<label class="text-bayang">Kota / Kabupaten : </label>
		<select name="kota" id="kota" class="form-control" oninput="showCamat(this.value)">
			<option value="">== Pilih Kota ==</option>';
			foreach($this->array_kota($kd_propinsi) as $x => $x_value)
			{
				echo '<option value="'.$x.'">'.$x_value.'</option>';
			}
			echo
		'</select>';
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi Pilih Kota / Kabupaten Kelahiran
	// ======================================================================================
	public function pilihKota1()
	{
		$kd_propinsi = $this->input->get('id');
		echo
		'<label class="text-bayang">Kota / Kabupaten : </label>
		<select name="kota_lhr" id="kota_lhr" class="form-control" oninput="showWilayah1(this.value)">
			<option value="">== Pilih Kota ==</option>';
			foreach($this->array_kota($kd_propinsi) as $x => $x_value)
			{
				echo '<option value="'.$x.'">'.$x_value.'</option>';
			}
			echo
		'</select>';
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi Pilih Kota / Kabupaten Kelahiran Ayah
	// ======================================================================================
	public function pilihKotaAyah()
	{
		$kd_propinsi = $this->input->get('id');
		echo
			'<label class="text-bayang">Kota / Kabupaten : </label>
			<select name="kota_lhr_ayah" id="kota_lhr_ayah" class="form-control" oninput="showWilayahAyah(this.value)">
				<option value="">== Pilih Kota ==</option>';
				foreach($this->array_kota($kd_propinsi) as $x => $x_value)
				{
					echo '<option value="'.$x.'">'.$x_value.'</option>';
				}
				echo
			'</select>';
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi Pilih Kota / Kabupaten Tempat Tinggal Ayah
	// ======================================================================================
	public function pilihKotaAyah1()
	{
		$kd_propinsi = $this->input->get('id');
		echo
			'<label class="text-bayang">Kota / Kabupaten : </label>
			<select name="kota_alam_ayah" id="kota_alam_ayah" class="form-control" oninput="showWilayahAyah1(this.value)">
				<option value="">== Pilih Kota ==</option>';
				foreach($this->array_kota($kd_propinsi) as $x => $x_value)
				{
					echo '<option value="'.$x.'">'.$x_value.'</option>';
				}
				echo
			'</select>';
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi Pilih Kota / Kabupaten Kelahiran Ibu
	// ======================================================================================
	public function pilihKotaIbu()
	{
		$kd_propinsi = $this->input->get('id');
		echo
			'<label class="text-bayang">Kota / Kabupaten : </label>
			<select name="kota_lhr_ibu" id="kota_lhr_ibu" class="form-control" oninput="showWilayahIbu(this.value)">
				<option value="">== Pilih Kota ==</option>';
				foreach($this->array_kota($kd_propinsi) as $x => $x_value)
				{
					echo '<option value="'.$x.'">'.$x_value.'</option>';
				}
				echo
			'</select>';
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi Pilih Kota / Kabupaten Tempat Tinggal Ibu
	// ======================================================================================
	public function pilihKotaIbu1()
	{
		$kd_propinsi = $this->input->get('id');
		echo
			'<label class="text-bayang">Kota / Kabupaten : </label>
			<select name="kota_alam_ibu" id="kota_alam_ibu" class="form-control" oninput="showWilayahIbu1(this.value)">
				<option value="">== Pilih Kota ==</option>';
				foreach($this->array_kota($kd_propinsi) as $x => $x_value)
				{
					echo '<option value="'.$x.'">'.$x_value.'</option>';
				}
				echo
			'</select>';
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi Pilih Kota / Kabupaten Kelahiran Wali
	// ======================================================================================
	public function pilihKotaWali()
	{
		$kd_propinsi = $this->input->get('id');
		echo
			'<label class="text-bayang">Kota / Kabupaten : </label>
			<select name="kota_lhr_wali" id="kota_lhr_wali" class="form-control" oninput="showWilayahWali(this.value)">
				<option value="">== Pilih Kota ==</option>';
				foreach($this->array_kota($kd_propinsi) as $x => $x_value)
				{
					echo '<option value="'.$x.'">'.$x_value.'</option>';
				}
				echo
			'</select>';
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi Pilih Kota / Kabupaten Tempat Tinggal Wali
	// ======================================================================================
	public function pilihKotaWali1()
	{
		$kd_propinsi = $this->input->get('id');
		echo
			'<label class="text-bayang">Kota / Kabupaten : </label>
			<select name="kota_alam_wali" id="kota_alam_wali" class="form-control" oninput="showWilayahWali1(this.value)">
				<option value="">== Pilih Kota ==</option>';
				foreach($this->array_kota($kd_propinsi) as $x => $x_value)
				{
					echo '<option value="'.$x.'">'.$x_value.'</option>';
				}
				echo
			'</select>';
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi Pilih Kecamatan
	// ======================================================================================
	public function pilihCamat()
	{
		$kd_kota = $this->input->get('id');
		echo
		'<label class="text-bayang">Kecamatan : </label>
		<select name="camat" id="camat" class="form-control" oninput="showLurah(this.value)">
			<option value="">== Pilih Kecamatan ==</option>';
			foreach($this->array_kecamatan($kd_kota) as $x => $x_value)
			{
				echo '<option value="'.$x.'">'.$x_value.'</option>';
			}
			echo
		'</select>';
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi Pilih Kelurahan
	// ======================================================================================
	public function pilihLurah()
	{
		$kd_camat = $this->input->get('id');
		echo
		'<label class="text-bayang">Kelurahan : </label>
		<select name="lurah" id="lurah" class="form-control" oninput="showWilayah(this.value)">
			<option value="">== Pilih Kelurahan ==</option>';
			foreach($this->array_kelurahan($kd_camat) as $x => $x_value)
			{
				echo '<option value="'.$x.'">'.$x_value.'</option>';
			}
			echo
		'</select>';
		
		exit;
	}

	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function ambilDataSiswa($no_ujian_smp)
	{
		$query = $this->db->select('*')
				->from('tb_siswa')
				->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
				->where('no_ujian_smp', $no_ujian_smp)
				->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$no_ujian_smp		= $row -> no_ujian_smp;
			$password			= $this->decryptIt($row -> password);
			$th_ajaran			= $row -> th_ajaran;
			$nisn				= $row -> nisn;
			$nik				= $row -> nik;
			$no_induk			= $row -> no_induk;
			$nama				= $row -> nama;
			$kelas				= $row -> kelas;
			$nama_kelas			= $row -> nama_kelas;
			
			$panggil			= $row -> panggil;
			$gender				= $row -> gender;
			$email				= $row -> email;
			$kd_lahir			= $row -> kd_lahir;
			$tgl_lhr			= $row -> tgl_lhr;
			$akta_lhr			= $row -> akta_lhr;
			$agama				= $row -> agama;
			$warga				= $row -> warga;
			$anak_ke			= $row -> anak_ke;
			$jml_sdr_k			= $row -> jml_sdr_k;
			$jml_sdr_a			= $row -> jml_sdr_a;
			$jml_sdr_t			= $row -> jml_sdr_t;
			$bahasa				= $row -> bahasa;
			$alamat				= $row -> alamat;
			$rt					= $row -> rt;
			$rw					= $row -> rw;
			$kd_alamat			= $row -> kd_alamat;
			$kodepos			= $row -> kodepos;
			$tlp_rmh			= $row -> tlp_rmh;
			$sts_tinggal2		= $row -> sts_tinggal2;
			$sts_tinggal3		= $row -> sts_tinggal3;
			$jarak				= $row -> jarak;
			$waktu				= $row -> waktu;
			$kendaraan			= $row -> kendaraan;
			$gakin				= $row -> gakin;
			$no_gakin			= $row -> no_gakin;
			
			$gol_darah			= $row -> gol_darah;
			$penyakit			= $row -> penyakit;
			$jasmani			= $row -> jasmani;
			$berat				= $row -> berat;
			$tinggi				= $row -> tinggi;
			
			$sklh_smp			= $row -> sklh_smp;
			$no_ijazah			= $row -> no_ijazah;
			$th_ijazah			= $row -> th_ijazah;
			$no_skhun			= $row -> no_skhun;
			$jml_skhun			= $row -> jml_skhun;
			$nil_bin			= $row -> nil_bin;
			$nil_big			= $row -> nil_big;
			$nil_mat			= $row -> nil_mat;
			$nil_ipa			= $row -> nil_ipa;
			$minat				= $row -> minat;
			$asal_sklh			= $row -> asal_sklh;
			$alsn_pindah		= $row -> alsn_pindah;
			$tingkat			= $row -> tingkat;
			$kelompok			= $row -> kelompok;
			$jurusan			= $row -> jurusan;
			$tgl_msk			= $row -> tgl_msk;
			
			$nama_ayah			= $row -> nama_ayah;
			$nik_ayah			= $row -> nik_ayah;
			$alamat_ayah		= $row -> alamat_ayah;
			$kd_alamat_ayah		= $row -> kd_alamat_ayah;
			$kd_lhr_ayah		= $row -> kd_lhr_ayah;
			$tgl_ayah			= $row -> tgl_ayah;
			$agama_ayah			= $row -> agama_ayah;
			$warga_ayah			= $row -> warga_ayah;
			$didik_ayah			= $row -> didik_ayah;
			$kerja_ayah			= $row -> kerja_ayah;
			$hasil_ayah			= $row -> hasil_ayah;
			$tlp_ayah			= $row -> tlp_ayah;
			$hdp_mt_ayah		= $row -> hdp_mt_ayah;
			$mati_ayah			= $row -> mati_ayah;
			
			$nama_ibu			= $row -> nama_ibu;
			$nik_ibu			= $row -> nik_ibu;
			$alamat_ibu			= $row -> alamat_ibu;
			$kd_alamat_ibu		= $row -> kd_alamat_ibu;
			$kd_lhr_ibu			= $row -> kd_lhr_ibu;
			$tgl_ibu			= $row -> tgl_ibu;
			$agama_ibu			= $row -> agama_ibu;
			$warga_ibu			= $row -> warga_ibu;
			$didik_ibu			= $row -> didik_ibu;
			$kerja_ibu			= $row -> kerja_ibu;
			$hasil_ibu			= $row -> hasil_ibu;
			$tlp_ibu			= $row -> tlp_ibu;
			$hdp_mt_ibu			= $row -> hdp_mt_ibu;
			$mati_ibu			= $row -> mati_ibu;
			
			$nama_wali			= $row -> nama_wali;
			$nik_wali			= $row -> nik_wali;
			$alamat_wali		= $row -> alamat_wali;
			$kd_alamat_wali		= $row -> kd_alamat_wali;
			$kd_lhr_wali		= $row -> kd_lhr_wali;
			$tgl_wali			= $row -> tgl_wali;
			$agama_wali			= $row -> agama_wali;
			$warga_wali			= $row -> warga_wali;
			$didik_wali			= $row -> didik_wali;
			$kerja_wali			= $row -> kerja_wali;
			$hasil_wali			= $row -> hasil_wali;
			$tlp_wali			= $row -> tlp_wali;
			$hdp_mt_wali		= $row -> hdp_mt_wali;
			$mati_wali			= $row -> mati_wali;
			
			$seni				= $row -> seni;
			$olahraga			= $row -> olahraga;
			$organisasi			= $row -> organisasi;
			$lain2				= $row -> lain2;
			$cita2				= $row -> cita2;
			$th_ajaran			= $row -> th_ajaran;
			$thn_msk			= $row -> thn_msk;
			$sts_siswa			= $row -> sts_siswa;
			$sts_isi			= $row -> sts_isi;
			$sts_ctk			= $row -> sts_ctk;
			$thn_keluar			= $row -> thn_keluar;
			$sts_keluar			= $row -> sts_keluar;
			$status				= $row -> status;
		}
		else
		{
			$password			= '';
			$th_ajaran			= '';
			$nisn				= '';
			$nik				= '';
			$no_induk			= '';
			$nama				= '';
			$kelas				= '';
			$nama_kelas			= '';
			$panggil			= '';
			$gender				= '';
			$email				= '';
			$kd_lahir			= '';
			$tgl_lhr			= '';
			$akta_lhr			= '';
			$agama				= '';
			$warga				= '';
			$anak_ke			= '';
			$jml_sdr_k			= '';
			$jml_sdr_a			= '';
			$jml_sdr_t			= '';
			$bahasa				= '';
			$alamat				= '';
			$rt					= '';
			$rw					= '';
			$kd_alamat			= '';
			$kodepos			= '';
			$tlp_rmh			= '';
			$sts_tinggal2		= '';
			$sts_tinggal3		= '';
			$jarak				= '';
			$waktu				= '';
			$kendaraan			= '';
			$gakin				= '';
			$no_gakin			= '';
			$gol_darah			= '';
			$penyakit			= '';
			$jasmani			= '';
			$berat				= '';
			$tinggi				= '';
			$sklh_smp			= '';
			$no_ijazah			= '';
			$th_ijazah			= '';
			$no_skhun			= '';
			$jml_skhun			= 0;
			$nil_bin			= 0;
			$nil_big			= 0;
			$nil_mat			= 0;
			$nil_ipa			= 0;
			$asal_sklh			= '';
			$alsn_pindah		= '';
			$tingkat			= '';
			$kelompok			= '';
			$jurusan			= '';
			$tgl_msk			= '';
			
			$nama_ayah			= '';
			$nik_ayah			= '';
			$alamat_ayah		= '';
			$kd_alamat_ayah		= '';
			$kd_lhr_ayah		= '';
			$tgl_ayah			= '';
			$agama_ayah			= '';
			$warga_ayah			= '';
			$didik_ayah			= '';
			$kerja_ayah			= '';
			$hasil_ayah			= '';
			$tlp_ayah			= '';
			$hdp_mt_ayah		= '';
			$mati_ayah			= '';
			
			$nama_ibu			= '';
			$nik_ibu			= '';
			$alamat_ibu			= '';
			$kd_alamat_ibu		= '';
			$kd_lhr_ibu			= '';
			$tgl_ibu			= '';
			$agama_ibu			= '';
			$warga_ibu			= '';
			$didik_ibu			= '';
			$kerja_ibu			= '';
			$hasil_ibu			= '';
			$tlp_ibu			= '';
			$hdp_mt_ibu			= '';
			$mati_ibu			= '';
			
			$nama_wali			= '';
			$nik_wali			= '';
			$alamat_wali		= '';
			$kd_alamat_wali		= '';
			$kd_lhr_wali		= '';
			$tgl_wali			= '';
			$agama_wali			= '';
			$warga_wali			= '';
			$didik_wali			= '';
			$kerja_wali			= '';
			$hasil_wali			= '';
			$tlp_wali			= '';
			$hdp_mt_wali		= '';
			$mati_wali			= '';
			
			$minat				= '';
			$seni				= '';
			$olahraga			= '';
			$organisasi			= '';
			$lain2				= '';
			$cita2				= '';
			$th_ajaran			= '';
			$thn_msk			= '';
			$sts_siswa			= '';
			$sts_isi			= '';
			$sts_ctk			= '';
			$thn_keluar			= '';
			$sts_keluar			= '';
			$status				= '';
		}
		
		$dataSiswaArray = array(
			'no_ujian_smp'		=> $no_ujian_smp,
			'password'			=> $password,
			'nisn'				=> $nisn,
			'nik'				=> $nik,
			'no_induk'			=> $no_induk,
			'nama'				=> $nama,
			'thn_msk'			=> $thn_msk,
			'kelas'				=> $kelas,
			'nama_kelas'		=> $nama_kelas,
			'panggil'			=> $panggil,
			'gender'			=> $gender,
			'email'				=> $email,
			'kd_lahir'			=> $kd_lahir,
			'tgl_lhr'			=> $tgl_lhr,
			'akta_lhr'			=> $akta_lhr,
			'agama'				=> $agama,
			'warga'				=> $warga,
			'anak_ke'			=> $anak_ke,
			'jml_sdr_k'			=> $jml_sdr_k,
			'jml_sdr_a'			=> $jml_sdr_a,
			'jml_sdr_t'			=> $jml_sdr_t,
			'bahasa'			=> $bahasa,
			'alamat'			=> $alamat,
			'rt'				=> $rt,
			'rw'				=> $rw,
			'kd_alamat'			=> $kd_alamat,
			'kodepos'			=> $kodepos,
			'tlp_rmh'			=> $tlp_rmh,
			'sts_tinggal2'		=> $sts_tinggal2,
			'sts_tinggal3'		=> $sts_tinggal3,
			'jarak'				=> $jarak,
			'waktu'				=> $waktu,
			'kendaraan'			=> $kendaraan,
			'gakin'				=> $gakin,
			'no_gakin'			=> $no_gakin,
			'gol_darah'			=> $gol_darah,
			'penyakit'			=> $penyakit,
			'jasmani'			=> $jasmani,
			'berat'				=> $berat,
			'tinggi'			=> $tinggi,
		
			'sklh_smp'			=> $sklh_smp,
			'no_ijazah'			=> $no_ijazah,
			'th_ijazah'			=> $th_ijazah,
			'no_skhun'			=> $no_skhun,
			'jml_skhun'			=> $jml_skhun,
			'nil_bin'			=> $nil_bin,
			'nil_big'			=> $nil_big,
			'nil_mat'			=> $nil_mat,
			'nil_ipa'			=> $nil_ipa,
			'minat'				=> $minat,
		
			'asal_sklh'			=> $asal_sklh,
			'alsn_pindah'		=> $alsn_pindah,
			'tingkat'			=> $tingkat,
			'kelompok'			=> $kelompok,
			'jurusan'			=> $jurusan,
			'tgl_msk'			=> $tgl_msk,
			
			'nama_ayah'			=> $nama_ayah,
			'nik_ayah'			=> $nik_ayah,
			'alamat_ayah'		=> $alamat_ayah,
			'kd_alamat_ayah'	=> $kd_alamat_ayah,
			'kd_lhr_ayah'		=> $kd_lhr_ayah,
			'tgl_ayah'			=> $tgl_ayah,
			'agama_ayah'		=> $agama_ayah,
			'warga_ayah'		=> $warga_ayah,
			'didik_ayah'		=> $didik_ayah,
			'kerja_ayah'		=> $kerja_ayah,
			'hasil_ayah'		=> $hasil_ayah,
			'tlp_ayah'			=> $tlp_ayah,
			'hdp_mt_ayah'		=> $hdp_mt_ayah,
			'mati_ayah'			=> $mati_ayah,
				
			'nama_ibu'			=> $nama_ibu,
			'nik_ibu'			=> $nik_ibu,
			'alamat_ibu'		=> $alamat_ibu,
			'kd_alamat_ibu'		=> $kd_alamat_ibu,
			'kd_lhr_ibu'		=> $kd_lhr_ibu,
			'tgl_ibu'			=> $tgl_ibu,
			'agama_ibu'			=> $agama_ibu,
			'warga_ibu'			=> $warga_ibu,
			'didik_ibu'			=> $didik_ibu,
			'kerja_ibu'			=> $kerja_ibu,
			'hasil_ibu'			=> $hasil_ibu,
			'tlp_ibu'			=> $tlp_ibu,
			'hdp_mt_ibu'		=> $hdp_mt_ibu,
			'mati_ibu'			=> $mati_ibu,
			
			'nama_wali'			=> $nama_wali,
			'nik_wali'			=> $nik_wali,
			'alamat_wali'		=> $alamat_wali,
			'kd_alamat_wali'	=> $kd_alamat_wali,
			'kd_lhr_wali'		=> $kd_lhr_wali,
			'tgl_wali'			=> $tgl_wali,
			'agama_wali'		=> $agama_wali,
			'warga_wali'		=> $warga_wali,
			'didik_wali'		=> $didik_wali,
			'kerja_wali'		=> $kerja_wali,
			'hasil_wali'		=> $hasil_wali,
			'tlp_wali'			=> $tlp_wali,
			'hdp_mt_wali'		=> $hdp_mt_wali,
			'mati_wali'			=> $mati_wali,
			
			'seni'				=> $seni,
			'olahraga'			=> $olahraga,
			'organisasi'		=> $organisasi,
			'lain2'				=> $lain2,
			'cita2'				=> $cita2,
			'th_ajaran'			=> $th_ajaran,
			'sts_siswa'			=> $sts_siswa,
			'thn_keluar'		=> $thn_keluar,
			'sts_keluar'		=> $sts_keluar,
			'sts_isi'			=> $sts_isi,
			'sts_ctk'			=> $sts_ctk,
			'status'			=> 'Siswa'
			);
			
			if(($kd_alamat != '') or ($kd_alamat != '000000'))
			{
				$arr_kd = $this->array_kode_wilayah($kd_alamat);
				$dataSiswaArray['kd_propinsi']  = $arr_kd[0];
				$dataSiswaArray['kd_kota']      = $arr_kd[2];
				$dataSiswaArray['kd_kecamatan'] = $arr_kd[4];
				$dataSiswaArray['kd_kelurahan'] = $arr_kd[6];
			}
			else
			{
				$dataSiswaArray['kd_propinsi']  = '';
				$dataSiswaArray['kd_kota']      = '';
				$dataSiswaArray['kd_kecamatan'] = '';
				$dataSiswaArray['kd_kelurahan'] = '';
			}
			if(($kd_alamat_ayah != '') or ($kd_alamat_ayah != '000000'))
			{
				$arr_kd = $this->array_kode_wilayah($kd_alamat_ayah);
				$dataSiswaArray['prop_alam_ayah']	= $arr_kd[0];
				$dataSiswaArray['kota_alam_ayah']	= $arr_kd[2];
			}
			else
			{
				$dataSiswaArray['prop_alam_ayah']	= '050000';
				$dataSiswaArray['kota_alam_ayah']	= '056000';
			}
			if(($kd_alamat_ibu != '') or ($kd_alamat_ibu != '000000'))
			{
				$arr_kd = $this->array_kode_wilayah($kd_alamat_ibu);
				$dataSiswaArray['prop_alam_ibu']	= $arr_kd[0];
				$dataSiswaArray['kota_alam_ibu']	= $arr_kd[2];
			}
			else
			{
				$dataSiswaArray['prop_alam_ibu']	= '050000';
				$dataSiswaArray['kota_alam_ibu']	= '056000';
			}
			if(($kd_alamat_wali != '') or ($kd_alamat_wali != '000000'))
			{
				$arr_kd = $this->array_kode_wilayah($kd_alamat_wali);
				$dataSiswaArray['prop_alam_wali']	= $arr_kd[0];
				$dataSiswaArray['kota_alam_wali']	= $arr_kd[2];
			}
			else
			{
				$dataSiswaArray['prop_alam_wali']	= '050000';
				$dataSiswaArray['kota_alam_wali']	= '056000';
			}
			if(($kd_lahir != '') or ($kd_lahir != '000000'))
			{
				$arr_kd = $this->array_kode_wilayah($kd_lahir);
				$dataSiswaArray['prop_lhr']		= $arr_kd[0];
				$dataSiswaArray['kota_lhr']		= $arr_kd[2];
			}
			else
			{
				$dataSiswaArray['prop_lhr']		= '050000';
				$dataSiswaArray['kota_lhr']		= '056000';
			}
			if(($kd_lhr_ayah != '') or ($kd_lhr_ayah != '000000'))
			{
				$arr_kd = $this->array_kode_wilayah($kd_lhr_ayah);
				$dataSiswaArray['prop_lhr_ayah']  	= $arr_kd[0];
				$dataSiswaArray['kota_lhr_ayah']	= $arr_kd[2];
			}
			else
			{
				$dataSiswaArray['prop_lhr_ayah']  	= '050000';
				$dataSiswaArray['kota_lhr_ayah']	= '056000';
			}
			if(($kd_lhr_ibu != '') or ($kd_lhr_ibu != '000000'))
			{
				$arr_kd = $this->array_kode_wilayah($kd_lhr_ibu);
				$dataSiswaArray['prop_lhr_ibu']		= $arr_kd[0];
				$dataSiswaArray['kota_lhr_ibu']		= $arr_kd[2];
			}
			else
			{
				$dataSiswaArray['prop_lhr_ibu']		= '050000';
				$dataSiswaArray['kota_lhr_ibu']		= '056000';
			}
			if(($kd_lhr_wali != '') or ($kd_lhr_wali != '000000'))
			{
				$arr_kd = $this->array_kode_wilayah($kd_lhr_wali);
				$dataSiswaArray['prop_lhr_wali']  	= $arr_kd[0];
				$dataSiswaArray['kota_lhr_wali']	= $arr_kd[2];
			}
			else
			{
				$dataSiswaArray['prop_lhr_wali']  	= '050000';
				$dataSiswaArray['kota_lhr_wali']	= '056000';
			}
		
		return $dataSiswaArray;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function modalEditSiswa()
	{
		$level    = $this->session->userdata('level');
		
		if($level > 93) 
			$no_ujian_smp = $this->input->get('id');
		else
			$no_ujian_smp = $this->session->userdata('username');
		
		$dataKu = array();
		$dataKu = $this->ambilDataSiswa($no_ujian_smp);
		
		$kkCek		= false;
		$aktaCek	= false;
		$skhuCek	= false;
		$ktpCek		= false;
		$ijazahCek	= false;
		$photoCek	= false;
		if(file_exists('./utama/assists/photos/'.$no_ujian_smp))
		{
			$nmFile = array('kk', 'akta', 'skhu', 'ktp', 'ijazah', 'photo');
			for($i = 0; $i < count($nmFile); $i++)
			{
				if(file_exists('./utama/assists/photos/'.$no_ujian_smp.'/'.$nmFile[$i].'.png') or 
					file_exists('./utama/assists/photos/'.$no_ujian_smp.'/'.$nmFile[$i].'.jpeg') or 
					file_exists('./utama/assists/photos/'.$no_ujian_smp.'/'.$nmFile[$i].'.jpg') or 
					file_exists('./utama/assists/photos/'.$no_ujian_smp.'/'.$nmFile[$i].'.bmp'))
				{
					if($i == 0) $kkCek = true;
					elseif($i == 1) $aktaCek = true;
					elseif($i == 2) $skhuCek = true;
					elseif($i == 3) $ktpCek = true;
					elseif($i == 4) $ijazahCek = true;
					elseif($i == 5) $photoCek = true;
				}
			}
					
		}
		
		$kd_propinsi  	= $dataKu['kd_propinsi'];
		$kd_kota     	= $dataKu['kd_kota'];
		$kd_kecamatan	= $dataKu['kd_kecamatan'];
		$kd_kelurahan	= $dataKu['kd_kelurahan'];
		$prop_alam_ayah = $dataKu['prop_alam_ayah'];
		$kota_alam_ayah	= $dataKu['kota_alam_ayah'];
		$prop_alam_ibu	= $dataKu['prop_alam_ibu'];
		$kota_alam_ibu	= $dataKu['kota_alam_ibu'];
		$prop_alam_wali = $dataKu['prop_alam_wali'];
		$kota_alam_wali	= $dataKu['kota_alam_wali'];
		$prop_lhr  		= $dataKu['prop_lhr'];
		$kota_lhr		= $dataKu['kota_lhr'];
		$prop_lhr_ayah  = $dataKu['prop_lhr_ayah'];
		$kota_lhr_ayah	= $dataKu['kota_lhr_ayah'];
		$prop_lhr_ibu  	= $dataKu['prop_lhr_ibu'];
		$kota_lhr_ibu	= $dataKu['kota_lhr_ibu'];
		$prop_lhr_wali  = $dataKu['prop_lhr_wali'];
		$kota_lhr_wali	= $dataKu['kota_lhr_wali'];
		
		echo
				'<!-- modal-dialog -->
				<div class="modal-dialog modal-lg" role="document">
					<!-- modal-content -->
					<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
						<!-- modal header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title hit-the-floor" id="isianUserLabel">
								<center><b>
									<img src="'.base_url().'utama/assists/images/icons/personal-information.ico" width=32 height=32> Edit Data Siswa - <font color="yellow">'.ucwords(strtolower($dataKu["nama"])).'</font>
								</b></center>
							</h3>
						</div>
						<!-- ./modal header -->

						<!-- modal body -->
						<div class="modal-body" id="isianDataSiswa">
								
							<!-- Panel -->
							<div class="panel" style="background-color: green;border-radius: 8px;">
								<div class="panel-body" style="background-color: lightgrey;border-radius: 8px;">
								
									<!-- Nav tabs -->
									<ul class="nav nav-pills">
										<li class="active"><a href="#utama" data-toggle="tab"><b>Utama</b></a></li>
										<li><a href="#diri_siswa" data-toggle="tab"><b>Diri Siswa</b></a></li>
										<li><a href="#tempat_tinggal" data-toggle="tab"><b>Tinggal</b></a></li>
										<li><a href="#kesehatan" data-toggle="tab"><b>Kesehatan</b></a></li>
										<li><a href="#pendidikan" data-toggle="tab"><b>Pendidikan</b></a></li>
										<li><a href="#ayah" data-toggle="tab"><b>Ayah K</b></a></li>
										<li><a href="#ibu" data-toggle="tab"><b>Ibu K</b></a></li>
										<li><a href="#wali" data-toggle="tab"><b>Wali</b></a></li>
										<li><a href="#lain" data-toggle="tab"><b>Lain-lain</b></a></li>';
										if($level != 94)
											echo
										'<li><a href="#photo" data-toggle="tab"><b>Photo</b></a></li>';
										echo
									'</ul>
									<!-- /. Nav tabs -->
									<hr/>

									<!-- Tab panes -->
									<div class="tab-content">
											
										<!-- Bagian Utama -->
										<div class="tab-pane fade in active" id="utama">
											<div class="row">
												<!-- col Kiri -->
												<div class="col-md-6">
													<div class="form-group">
														<label class="text-bayang">Nama Lengkap Siswa : </label>
														<input type="text" name="nama" id="nama" class="form-control" value="'.ucwords(strtolower($dataKu['nama'])).'" ';if($level == 94) echo ' disabled '; echo '>
													</div>';
													if($level > 95)
														echo									
													'<div class="col-md-5">
														<div class="form-group" style="margin-left: -12px;">
															<label class="text-bayang">Nomer Induk : </label>
															<input type="text" name="no_induk" id="no_induk" class="form-control" value="'.$dataKu['no_induk'].'"> 
														</div>
													</div>
													<div class="col-md-7">
														<div class="form-group">
															<label class="text-bayang">Tahun Pelajaran : </label><br/>
															<input type="number" name="th_ajaran" id="th_ajaran" min="2016" max="2025" value="'.$dataKu['th_ajaran'].'" style="height: 34px;width: 80px;text-align: center;" oninput="rbhDtSiswaTA()">
															&nbsp;&nbsp;&nbsp;&nbsp;<span id="dtSiswaTapel"><b> -&nbsp;&nbsp;&nbsp;&nbsp; '.($dataKu['th_ajaran'] + 1).'</b></span>
														</div>
													</div>';
													else
														echo
													'<div class="col-md-5">
														<div class="form-group" style="margin-left: -12px;">
															<label class="text-bayang">Nomer Induk : </label>
															<input type="text" name="no_induk" id="no_induk" class="form-control" value="'.$dataKu['no_induk'].'" disabled> 
														</div>
													</div>
													<div class="col-md-7">
														<div class="form-group">
															<label class="text-bayang">Tahun Pelajaran : </label><br/>
															<input type="number" name="th_ajaran" id="th_ajaran" min="2016" max="2025" value="'.$dataKu['th_ajaran'].'" style="height: 34px;width: 80px;text-align: center;" disabled>
															&nbsp;&nbsp;&nbsp;&nbsp;<span id="dtSiswaTapel"><b> -&nbsp;&nbsp;&nbsp;&nbsp; '.($dataKu['th_ajaran'] + 1).'</b></span>
														</div>
													</div>';
													echo
													'
												</div>
												<!-- ./col Kiri -->
												<!-- col Kanan -->
												<div class="col-md-6">
													<div class="col-md-12">
														<div class="form-group">
															<label class="text-bayang">Nomer Induk Siswa Nasional (NISN) : </label>
															<input type="text" name="nisn" id="nisn" class="form-control" value="'.$dataKu['nisn'].'" ';if($level == 94) echo ' disabled '; echo '>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="text-bayang">Kelas : </label>
															<select class="form-control" id="kelas" name="kelas" ';if($level < 95) echo ' disabled '; echo'>';
															$query = $this->db->select('*')
																		->from('tb_kelas')
																		->get();
															if($query->num_rows() > 0)
															{
																foreach($query->result() as $row)
																{
																	$kd_kelas = $row->kd_kelas;
																	if($dataKu['kelas'] == $kd_kelas)
																		echo '<option value="'.$row->kd_kelas.'" selected> '.$row->nama_kelas.'</option>';
																	else
																		echo '<option value="'.$row->kd_kelas.'"> '.$row->nama_kelas.'</option>';
																}
															}
															echo
															'</select>
														</div>
													</div>
													<div class="col-md-8">
														<div class="input-group">
															<label class="text-bayang">Password : </label>
															<input type="password" class="form-control" id="password" name="password" value="'.$dataKu['password'].'" ';if($level == 94) echo ' disabled '; echo '>
															<span class="input-group-btn">
																<button type="button" id="tampil" class="btn btn-warning btn-flat" style="margin-top: 25px;" onclick="showHidePass()" ';if($level == 94) echo ' disabled '; echo '>
																	<i class="glyphicon glyphicon-eye-open" id="simbol"></i>
																</button>
															</span>
														</div>
													</div>
												</div>
												<!-- col Kanan -->
											</div>
											<!-- ./row -->
										</div>
										<!-- ./Bagian Utama -->
												
										<!-- Bagian Data Diri Siswa -->
										<div class="tab-pane fade" id="diri_siswa">
											<div class="row">
												<!-- col Kiri -->
												<div class="col-md-6">
													<div class="form-group">
														<label class="text-bayang">Nomer Induk Kependudukan : </label>
														<input type="text" name="nik" id="nik" class="form-control" value="'.$dataKu['nik'].'" ';if($level == 94) echo ' disabled '; echo '>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Nama Panggilan : </label>
																<input type="text" name="panggil" id="panggil" class="form-control" value="'.ucwords(strtolower($dataKu['panggil'])).'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">email : </label>
																<input type="email" name="email" id="email" class="form-control" value="'.$dataKu['email'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Tanggal Lahir : </label>
																<input type="date" name="tgl_lhr" id="tgl_lhr" class="form-control" value="'.$dataKu['tgl_lhr'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Nomer Akta Kelahiran : </label>
																<input type="text" name="akta_lhr" id="akta_lhr" class="form-control" value="'.$dataKu['akta_lhr'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															<label class="hit-the-floor">Kota Kelahiran : </label>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Propinsi : </label>
																<select name="prop_lhr" id="prop_lhr" class="form-control" oninput="showKota1(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Propinsi ==</option>';
																	foreach($this->array_propinsi() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $prop_lhr) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group" id="pilihKotaLahir">
																<label class="text-bayang">Kota / Kabupaten : </label>
																<select name="kota_lhr" id="kota_lhr" class="form-control" oninput="showWilayah1(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Kota ==</option>';
																	foreach($this->array_kota($prop_lhr) as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $kota_lhr) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
															<input type="hidden" name="kd_lahir" id="kd_lahir" value="'.$dataKu['kd_lahir'].'" ';if($level == 94) echo ' disabled '; echo '>
														</div>
													</div>
												</div>
												<!-- ./col Kiri -->
												<!-- col Kanan -->
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Agama : </label>
																<select class="form-control" name="agama" id="agama" ';if($level == 94) echo ' disabled '; echo '>';
																	foreach($this->array_agama() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['agama']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Kewarganegaraan : </label>
																<select class="form-control" name="warga" id="warga" ';if($level == 94) echo ' disabled '; echo '>';
																	foreach($this->array_negara() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['warga']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="text-bayang">Jenis Kelamin : &nbsp;&nbsp;&nbsp;</label>
														<label class="radio-inline">
															<input type="radio" name="gender" id="gender1" value="P" ';
															if($dataKu['gender'] == 'P') echo "checked"; echo ' > <div class="text-bayang">Perempuan</div>
														</label>
														&nbsp;&nbsp;&nbsp;
														<label class="radio-inline">
															<input type="radio" name="gender" id="gender2" value="L" ';
															if($dataKu['gender'] == 'L') echo "checked"; echo ' > <div class="text-bayang">Laki-laki</div>
														</label>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Anak Ke : </label>
																<input type="number" name="anak_ke" id="anak_ke" class="form-control" value="'.$dataKu['anak_ke'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Jumlah Saudara Kandung : </label>
																<input type="number" name="jml_sdr_k" id="jml_sdr_k" class="form-control" value="'.$dataKu['jml_sdr_k'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Jumlah Saudara Tiri : </label>
																<input type="number" name="jml_sdr_t" id="jml_sdr_t" class="form-control" value="'.$dataKu['jml_sdr_t'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Jumlah Saudara Angkat : </label>
																<input type="number" name="jml_sdr_a" id="jml_sdr_a" class="form-control" value="'.$dataKu['jml_sdr_a'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="text-bayang">Bahasa sehari-hari di rumah : </label>
														<input type="text" name="bahasa" id="bahasa" class="form-control" value="'.$dataKu['bahasa'].'" ';if($level == 94) echo ' disabled '; echo '>
													</div>
												</div>
												<!-- col Kanan -->
											</div>
											<!-- ./row -->
										</div>
										<!-- ./Bagian Data Diri Siswa -->
												
										<!-- Bagian Tempat Tinggal -->
										<div class="tab-pane fade" id="tempat_tinggal">
											<div class="row">
												<!-- col Kiri -->
												<div class="col-md-6">
													<div class="form-group">
														<label class="text-bayang">Alamat Rumah : (Tanpa Kota / Kab.)</label>
														<input type="text" name="alamat" id="alamat" class="form-control" value="'.ucwords(strtolower($dataKu['alamat'])).'" ';if($level == 94) echo ' disabled '; echo '>
													</div>
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label class="text-bayang">RT : </label>
																<input type="text" name="rt" id="rt" class="form-control" value="'.$dataKu['rt'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="text-bayang">RW : </label>
																<input type="text" name="rw" id="rw" class="form-control" value="'.$dataKu['rw'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="text-bayang">Kodepos : </label>
																<input type="text" name="kodepos" id="kodepos" class="form-control" value="'.$dataKu['kodepos'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group" id="pilihLurah">
																<label class="text-bayang">Kelurahan : </label>
																	<select name="lurah" id="lurah" class="form-control" oninput="showWilayah(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																		<option value="">== Pilih Kelurahan ==</option>';
																		foreach($this->array_kelurahan($kd_kecamatan) as $x => $x_value)
																		{
																			echo '<option value="'.$x.','.$x_value.'" ';
																			if($x == $kd_kelurahan) echo ' selected ' ;
																			echo' >'.$x_value.'</option>';
																		}
																		echo
																	'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group" id="pilihCamat">
																<label class="text-bayang">Kecamatan : </label>
																<select name="camat" id="camat" class="form-control" oninput="showLurah(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Kecamatan ==</option>';
																	foreach($this->array_kecamatan($kd_kota) as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $kd_kecamatan) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group" id="pilihKota">
																<label class="text-bayang">Kabupaten / Kotamadya : </label>
																<select name="kota" id="kota" class="form-control" oninput="showCamat(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Kota ==</option>';
																	foreach($this->array_kota($kd_propinsi) as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $kd_kota) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Propinsi : </label>
																<select name="propinsi" id="propinsi" class="form-control" oninput="showKota(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Propinsi ==</option>';
																	foreach($this->array_propinsi() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $kd_propinsi) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
																<input type="hidden" id="kd_alamat" name="kd_alamat" value="'.$dataKu['kd_alamat'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>
												</div>
												<!-- ./col Kiri -->
												<!-- col Kanan -->
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Telp. Rumah / HP Rumah : </label>
																<input type="text" name="tlp_rmh" id="tlp_rmh" class="form-control" value="'.$dataKu['tlp_rmh'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Jenis Tempat Tinggal : </label>
																<select class="form-control" name="sts_tinggal2" id="sts_tinggal2" ';if($level == 94) echo ' disabled '; echo '>';
																	foreach($this->array_jenis_tinggal() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['sts_tinggal2']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="text-bayang">Transportasi ke Sekolah : </label>
														<select class="form-control" name="kendaraan" id="kendaraan" ';if($level == 94) echo ' disabled '; echo '>';
															foreach($this->array_transport() as $x => $x_value)
															{
																echo '<option value="'.$x.'"'; if($x == $dataKu['kendaraan']) echo ' selected ' ; echo' >'.$x_value.'</option>';
															}
															echo
														'</select>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Jarak Sekolah dari Rumah : </label>
																<select class="form-control" name="jarak" id="jarak" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> -- Pilih salah satu -- </option>
																	<option value="1" ';if($dataKu['jarak']=="1") echo ' selected ' ; echo ' >Kurang dari 1 Km</option>
																	<option value="2" ';if($dataKu['jarak']=="2") echo ' selected ' ; echo ' >Lebih dari 1 Km</option>
																</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Waktu Tempuh ke Sekolah : </label>
																<select class="form-control" name="waktu" id="waktu" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> -- Pilih -- </option>
																	<option value="1" ';if($dataKu['waktu']=="1") echo ' selected ' ; echo ' >Kurang dari 30 menit</option>
																	<option value="2" ';if($dataKu['waktu']=="2") echo ' selected ' ; echo ' >30 - 60 menit</option>
																	<option value="3" ';if($dataKu['waktu']=="3") echo ' selected ' ; echo ' >lebih dari 60 menit</option>
																</select>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="text-bayang">Dari Keluarga Tidak mampu ?</label>
														&nbsp;&nbsp;&nbsp;&nbsp;
														<label class="text-bayang">
															<input type="radio" name="sts_tinggal3" id="tdkMampu" value="Y" ';if($dataKu['sts_tinggal3']=="Y") echo 'checked'; echo ' onclick="cekGakin()" ';if($level == 94) echo ' disabled '; echo '> Ya
														</label>
														&nbsp;&nbsp;&nbsp;&nbsp;
														<label class="text-bayang">
															<input type="radio" name="sts_tinggal3" id="mampu" value="T" ';if($dataKu['sts_tinggal3']=="T") echo 'checked'; echo ' onclick="cekGakin()" ';if($level == 94) echo ' disabled '; echo '> Tidak
														</label>
													</div>
													<div class="form-group" id="stsTinggal3" ';if($dataKu['sts_tinggal3'] == "T") echo ' style="display: none;" '; echo '>
														<label class="text-bayang">Penerima KPS/ KIP/ SKTM/ GAKIN ?</label>
														&nbsp;&nbsp;&nbsp;&nbsp;
														<label class="text-bayang">
															<input type="radio" name="gakin" id="gakin1" value="Y" ';if($dataKu['gakin']=="Y") echo 'checked'; echo ' > Ya
														</label>
														&nbsp;&nbsp;&nbsp;&nbsp;
														<label class="text-bayang">
															<input type="radio" name="gakin" id="gakin2" value="T" ';if($dataKu['gakin']=="T") echo 'checked'; echo ' > Tidak
														</label>
													</div>
													<div class="form-group" id="noGakin" ';if($dataKu['sts_tinggal3'] == "T") echo ' style="display: none;" '; echo '>
														<label class="text-bayang">Nomer Kartu / Surat : </label>
														<input type="text" name="no_gakin" id="no_gakin" class="form-control" value="'.$dataKu['no_gakin'].'">
													</div>
												</div>
												<!-- col Kanan -->
											</div>
											<!-- ./row -->
										</div>
										<!-- ./Bagian Tempat Tinggal -->
												
										<!-- Bagian Kesehatan Siswa -->
										<div class="tab-pane fade" id="kesehatan">
											<div class="row">
												<!-- col Kiri -->
												<div class="col-md-6">
													<div class="form-group">
														<label class="text-bayang">Golongan Darah : </label>
														<select class="form-control" name="gol_darah" id="gol_darah" ';if($level == 94) echo ' disabled '; echo '>
															<option value=""> -- Pilih -- </option>
															<option value="0" ';if($dataKu['gol_darah'] == "0") echo 'selected '; echo '> O </option>
															<option value="1" ';if($dataKu['gol_darah'] == "1") echo 'selected '; echo '> A </option>
															<option value="2" ';if($dataKu['gol_darah'] == "2") echo 'selected '; echo '> B </option>
															<option value="3" ';if($dataKu['gol_darah'] == "3") echo 'selected '; echo '> AB </option>
														</select>
													</div>
													<div class="form-group">
														<label class="text-bayang">Penyakit yang pernah diderita : </label>
														<input type="text" name="penyakit" id="penyakit" class="form-control" value="'.$dataKu['penyakit'].'" ';if($level == 94) echo ' disabled '; echo '>
													</div>
													<div class="form-group">
														<label class="text-bayang">Kebutuhan Khusus : </label>
														<select class="form-control" name="jasmani" id="jasmani" ';if($level == 94) echo ' disabled '; echo '>
															<option value=""> == Tidak Ada == </option>';
															foreach($this->array_kebutuhan() as $x => $x_value)
															{
																echo '<option value="'.$x.'"'; 
																if($x == $dataKu['jasmani']) echo ' selected ' ; 
																echo' >'.$x_value.'</option>';
															}
															echo
														'</select>
													</div>
												</div>
												<!-- ./col Kiri -->
												<!-- col Kanan -->
												<div class="col-md-6">
													<div class="form-group">
														<label class="text-bayang">Berat : (Kg)</label>
														<input type="number" name="tinggi" id="tinggi" class="form-control" value="'.$dataKu['tinggi'].'" ';if($level == 94) echo ' disabled '; echo '>
													</div>
													<div class="form-group">
														<label class="text-bayang">Tinggi : (Cm)</label>
														<input type="number" name="berat" id="berat" class="form-control" value="'.$dataKu['berat'].'" ';if($level == 94) echo ' disabled '; echo '>
													</div>
												</div>
												<!-- col Kanan -->
											</div>
											<!-- ./row -->
										</div>
										<!-- ./Bagian Kesehatan Siswa -->

										<!-- Bagian Pendidikan Siswa -->
										<div class="tab-pane fade" id="pendidikan">
											<div class="row">
												<!-- col Kiri -->
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-12">
															<center><h4 class="hit-the-floor" style="color:green;">Asal SMP</h4></center>
														</div>
													</div>
													<div class="row">
														<div class="col-md-7">
															<div class="form-group">
																<label class="text-bayang">Lulusan dari SMP : </label>
																<input type="text" name="sklh_smp" id="sklh_smp" class="form-control" value="'.$dataKu['sklh_smp'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-5">
															<div class="form-group">
																<label class="text-bayang">Nomer Ujian SMP : </label>';
																if($level > 95)
																	echo '<input type="text" name="no_ujian_smp" id="no_ujian_smp" class="form-control" value="'.$dataKu['no_ujian_smp'].'">';
																else
																	echo '<input type="text" name="no_ujian_smp" id="no_ujian_smp" class="form-control" value="'.$dataKu['no_ujian_smp'].'" disabled>';
																echo
															'</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Nomer Ijazah SMP : </label>
																<input type="text" name="no_ijazah" id="no_ijazah" class="form-control" value="'.$dataKu['no_ijazah'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Tahun Ijazah SMP : </label>
																<input type="number" name="th_ijazah" id="th_ijazah" class="form-control" value="'.$dataKu['th_ijazah'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Nomer SKHUN SMP : </label>
																<input type="text" name="no_skhun" id="no_skhun" class="form-control" value="'.$dataKu['no_skhun'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Jumlah Nilai SKHUN SMP : </label>
																<input type="number" step="any" name="jml_skhun" id="jml_skhun" class="form-control" value="'.$dataKu['jml_skhun'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>';
													if($level <= 95)
													{
														echo
													'<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Nilai UN Bahasa Indonesia : </label>
																<input type="number" step="any" name="nil_bin" id="nil_bin" min="0" max="100" class="form-control" value="'.$dataKu['nil_bin'].'" ';if($dataKu['nil_bin'] > 0) echo ' disabled '; echo ' oninput="rubahNilaiUN()">
															</div>
															<div class="form-group">
																<label class="text-bayang">Nilai UN Bahasa Inggris : </label>
																<input type="number" step="any" name="nil_big" id="nil_big" min="0" max="100" class="form-control" value="'.$dataKu['nil_big'].'"';if($dataKu['nil_big'] > 0) echo ' disabled '; echo ' oninput="rubahNilaiUN()">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Nilai UN Matematika : </label>
																<input type="number" step="any" name="nil_mat" id="nil_mat" min="0" max="100" class="form-control" value="'.$dataKu['nil_mat'].'"';if($dataKu['nil_mat'] > 0) echo ' disabled '; echo ' oninput="rubahNilaiUN()">
															</div>
															<div class="form-group">
																<label class="text-bayang">Nilai UN IPA : </label>
																<input type="number" step="any" name="nil_ipa" id="nil_ipa" min="0" max="100" class="form-control" value="'.$dataKu['nil_ipa'].'"';if($dataKu['nil_ipa'] > 0) echo ' disabled '; echo ' oninput="rubahNilaiUN()">
															</div>
														</div>
													</div>';
													}
													else
													{
														echo
													'<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Nilai UN Bahasa Indonesia : </label>
																<input type="number" step="any" name="nil_bin" id="nil_bin" min="0" max="100" class="form-control" value="'.$dataKu['nil_bin'].'">
															</div>
															<div class="form-group">
																<label class="text-bayang">Nilai UN Bahasa Inggris : </label>
																<input type="number" step="any" name="nil_big" id="nil_big" min="0" max="100" class="form-control" value="'.$dataKu['nil_big'].'">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Nilai UN Matematika : </label>
																<input type="number" step="any" name="nil_mat" id="nil_mat" min="0" max="100" class="form-control" value="'.$dataKu['nil_mat'].'">
															</div>
															<div class="form-group">
																<label class="text-bayang">Nilai UN IPA : </label>
																<input type="number" step="any" name="nil_ipa" id="nil_ipa" min="0" max="100" class="form-control" value="'.$dataKu['nil_ipa'].'">
															</div>
														</div>
													</div>';
													}
													echo
												'</div>
												<!-- ./col Kiri -->
												<!-- col Kanan -->
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-12">
															<center><h4 class="hit-the-floor">Siswa Pindahan</h4></center>
														</div>
													</div>
													<div class="form-group">
														<label class="text-bayang">Asal Sekolah : </label>
														<input type="text" name="asal_sklh" id="asal_sklh" class="form-control" value="'.$dataKu['asal_sklh'].'" ';if($level == 94) echo ' disabled '; echo '>
													</div>
													<div class="form-group">
														<label class="text-bayang">Alasan Pindah : </label>
														<input type="text" name="alsn_pindah" id="alsn_pindah" class="form-control" value="'.$dataKu['alsn_pindah'].'" ';if($level == 94) echo ' disabled '; echo '>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Kelas : </label>
																<select class="form-control" name="tingkat" id="tingkat" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> -- Pilih -- </option>
																	<option value="10" ';if($dataKu['tingkat']=="10") echo ' selected ' ; echo ' >X </option>
																	<option value="11" ';if($dataKu['tingkat']=="11") echo ' selected ' ; echo ' >XI</option>
																	<option value="12" ';if($dataKu['tingkat']=="12") echo ' selected ' ; echo ' >XII</option>
																</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Kelompok : </label>
																<input type="text" name="kelompok" id="kelompok" class="form-control" value="'.$dataKu['kelompok'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Jurusan : </label>
																<select class="form-control" name="jurusan" id="jurusan" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> -- Pilih -- </option>
																	<option value="1" ';if($dataKu['jurusan']=="1") echo ' selected ' ; echo ' >IPA</option>
																	<option value="2" ';if($dataKu['jurusan']=="2") echo ' selected ' ; echo ' >IPS</option>
																	<option value="3" ';if($dataKu['jurusan']=="3") echo ' selected ' ; echo ' >BAHASA</option>
																</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Tanggal Masuk : </label>
																<input type="date" name="tgl_msk" id="tgl_msk" class="form-control" value="'.$dataKu['tgl_msk'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>';
													if($level <= 93)
														echo
													'<div class="row">
														<div class="col-md-12">
															<label class="text-bayang"><font color="yellow"><b>*)Harus diperhatikan. Pengisian nilai UN hanya dapat dilakukan 1x saja. Anda tidak dapat merubah nilai UN setelah tombol <button type="button" class="btn btn-primary" style="border-radius:8px;">
																<img src="'.base_url().'utama/assists/images/icons/save.ico" width=20 height=20> Simpan
															</button> anda tekan.</b></font></label>
														</div>
													</div>';
													echo
												'</div>
												<!-- col Kanan -->
											</div>
											<!-- ./row -->
										</div>
										<!-- ./Bagian Pendidikan Siswa -->

										<!-- Bagian Ayah Kandung -->
										<div class="tab-pane fade" id="ayah">
											<div class="row">
												<!-- col Kiri -->
												<div class="col-md-6">
													<div class="form-group">
														<label class="text-bayang">Nama Ayah Kandung : <font color="#FFA0A0">(tanpa Title)</font></label>
														<input type="text" name="nama_ayah" id="nama_ayah" class="form-control" value="'.ucwords(strtolower($dataKu['nama_ayah'])).'" ';if($level == 94) echo ' disabled '; echo '>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">NIK Ayah : </label>
																<input type="text" name="nik_ayah" id="nik_ayah" class="form-control" value="'.$dataKu['nik_ayah'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Tanggal Lahir Ayah : </label>
																<input type="date" name=tgl_ayah"" id="tgl_ayah" class="form-control" value="'.$dataKu['tgl_ayah'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															<label class="hit-the-floor">Tempat Lahir Ayah : </label>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Propinsi : </label>
																<select name="prop_lhr_ayah" id="prop_lhr_ayah" class="form-control" oninput="showKotaAyah(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Propinsi ==</option>';
																	foreach($this->array_propinsi() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $prop_lhr_ayah) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group" id="kotaLahirAyah">
																<label class="text-bayang">Kota / Kabupaten : </label>
																<select name="kota_lhr_ayah" id="kota_lhr_ayah" class="form-control" oninput="showWilayahAyah(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Kota ==</option>';
																	foreach($this->array_kota($prop_lhr_ayah) as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $kota_lhr_ayah) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
															<input type="hidden" name="kd_lhr_ayah" id="kd_lhr_ayah" value="'.$dataKu['kd_lhr_ayah'].'" ';if($level == 94) echo ' disabled '; echo '>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Agama : </label>
																<select class="form-control" name="agama_ayah" id="agama_ayah" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> == Pilih Agama == </option>';
																	foreach($this->array_agama() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['agama_ayah']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Kewarganegaraan Ayah : </label>
																<select class="form-control" name="warga_ayah" id="warga_ayah" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> == Pilih Kewarganegaraan == </option>';
																	foreach($this->array_negara() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['warga_ayah']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
													</div>
												</div>
												<!-- ./col Kiri -->
												<!-- col Kanan -->
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Telephone Ayah : </label>
																<input type="text" name="tlp_ayah" id="tlp_ayah" class="form-control" value="'.$dataKu['tlp_ayah'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Pendidikan Ayah : </label>
																<select class="form-control" name="didik_ayah" id="didik_ayah" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> == Pilih Pendidikan == </option>';
																	foreach($this->array_pendidikan() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['didik_ayah']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Pekerjaan Ayah : </label>
																<select class="form-control" name="kerja_ayah" id="kerja_ayah" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> == Pilih Pekerjaan == </option>';
																	foreach($this->array_pekerjaan() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['kerja_ayah']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Penghasilan Per Bulan : </label>
																<select class="form-control" name="hasil_ayah" id="hasil_ayah" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> == Pilih Penghasilan == </option>';
																	foreach($this->array_penghasilan() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['hasil_ayah']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="hit-the-floor">Alamat Rumah : </label>
														<input type="text" name="alamat_ayah" id="alamat_ayah" class="form-control" value="'.ucwords(strtolower($dataKu['alamat_ayah'])).'" ';if($level == 94) echo ' disabled '; echo '>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Propinsi : </label>
																<select name="prop_alam_ayah" id="prop_alam_ayah" class="form-control" oninput="showKotaAyah1(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Propinsi ==</option>';
																	foreach($this->array_propinsi() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $prop_alam_ayah) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group" id="kotaAlamAyah">
																<label class="text-bayang">Kota / Kabupaten : </label>
																<select name="kota_alam_ayah" id="kota_alam_ayah" class="form-control" oninput="showWilayahAyah1(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Kota ==</option>';
																	foreach($this->array_kota($prop_alam_ayah) as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $kota_alam_ayah) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
															<input type="hidden" name="kd_alamat_ayah" id="kd_alamat_ayah" value="'.$dataKu['kd_alamat_ayah'].'" ';if($level == 94) echo ' disabled '; echo '>
														</div>
													</div>
													<div class="form-group">
														<label class="text-bayang">Masih Hidup / Meninggal Dunia ?</label>
														<br/>
														<label class="text-bayang">
															<input type="radio" name="hdp_mt_ayah" id="hdpAyah" value="Y" ';if($dataKu['hdp_mt_ayah']=="Y") echo 'checked'; echo ' onclick="cekAyah()" ';if($level == 94) echo ' disabled '; echo '> Masih Hidup
														</label>
														&nbsp;&nbsp;&nbsp;&nbsp;
														<label class="text-bayang">
															<input type="radio" name="hdp_mt_ayah" id="matiAyah" value="T" ';if($dataKu['hdp_mt_ayah']=="T") echo 'checked'; echo ' onclick="cekAyah()" ';if($level == 94) echo ' disabled '; echo '> Sudah Meninggal
														</label>
													</div>
													<div class="form-group" id="ayahHidup" ';if($dataKu['hdp_mt_ayah']=="Y") echo ' style="display: none;" '; echo ' >
														<label class="text-bayang">Tahun meninggal : </label>
														<input type="number" name="mati_ayah" id="mati_ayah" class="form-control" value="'.$dataKu['mati_ayah'].'" ';if($level == 94) echo ' disabled '; echo ' >
													</div>
												</div>
												<!-- col Kanan -->
											</div>
											<!-- ./row -->
										</div>
										<!-- ./Bagian Ayah Kandung -->
												
										<!-- Bagian Ibu Kandung -->
										<div class="tab-pane fade" id="ibu">
											<div class="row">
												<!-- col Kiri -->
												<div class="col-md-6">
													<div class="form-group">
														<label class="text-bayang">Nama Ibu Kandung : <font color="#FFA0A0">(tanpa Title)</font></label>
														<input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="'.ucwords(strtolower($dataKu['nama_ibu'])).'" ';if($level == 94) echo ' disabled '; echo '>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">NIK Ibu : </label>
																<input type="text" name="nik_ibu" id="nik_ibu" class="form-control" value="'.$dataKu['nik_ibu'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Tanggal Lahir Ibu : </label>
																<input type="date" name="tgl_ibu" id="tgl_ibu" class="form-control" value="'.$dataKu['tgl_ibu'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="hit-the-floor">Tempat Lahir Ibu : </label>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Propinsi : </label>
																<select name="prop_lhr_ibu" id="prop_lhr_ibu" class="form-control" oninput="showKotaIbu(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Propinsi ==</option>';
																	foreach($this->array_propinsi() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $prop_lhr_ibu) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div id="kotaLahirIbu">
																<label class="text-bayang">Kota / Kabupaten : </label>
																<select name="kota_lhr_ibu" id="kota_lhr_ibu" class="form-control" oninput="showWilayahIbu(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Kota ==</option>';
																	foreach($this->array_kota($prop_lhr_ibu) as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $kota_lhr_ibu) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
															<input type="hidden" name="kd_lhr_ibu" id="kd_lhr_ibu" value="'.$dataKu['kd_lhr_ibu'].'">
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Agama : </label>
																<select class="form-control" name="agama_ibu" id="agama_ibu" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> == Pilih Agama == </option>';
																	foreach($this->array_agama() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';if($x == $dataKu['agama_ibu']) echo ' selected ' ;echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Kewarganegaraan Ibu : </label>
																<select class="form-control" name="warga_ibu" id="warga_ibu" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> == Pilih Kewarganegaraan == </option>';
																	foreach($this->array_negara() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['warga_ibu']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
													</div>
												</div>
												<!-- ./col Kiri -->
												<!-- col Kanan -->
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Telephone Ibu : </label>
																<input type="text" name="tlp_ibu" id="tlp_ibu" class="form-control" value="'.$dataKu['tlp_ibu'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Pendidikan Ibu : </label>
																<select class="form-control" name="didik_ibu" id="didik_ibu" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> == Pilih Pendidikan == </option>';
																	foreach($this->array_pendidikan() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['didik_ibu']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Pekerjaan Ibu : </label>
																<select class="form-control" name="kerja_ibu" id="kerja_ibu" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> == Pilih Pekerjaan == </option>';
																	foreach($this->array_pekerjaan() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['kerja_ibu']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Penghasilan Per Bulan : </label>
																<select class="form-control" name="hasil_ibu" id="hasil_ibu" ';if($level == 94) echo ' disabled '; echo '>
																	<option value=""> == Pilih Penghasilan == </option>';
																	foreach($this->array_penghasilan() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['hasil_ibu']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="hit-the-floor">Alamat Rumah : </label>
														<input type="text" name="alamat_ibu" id="alamat_ibu" class="form-control" value="'.ucwords(strtolower($dataKu['alamat_ibu'])).'" ';if($level == 94) echo ' disabled '; echo '>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Propinsi : </label>
																<select name="prop_alam_ibu" id="prop_alam_ibu" class="form-control" oninput="showKotaIbu1(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Propinsi ==</option>';
																	foreach($this->array_propinsi() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $prop_alam_ibu) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group" id="kotaAlamIbu">
																<label class="text-bayang">Kota / Kabupaten : </label>
																<select name="kota_alam_ibu" id="kota_alam_ibu" class="form-control" oninput="showWilayahIbu1(this.value)" ';if($level == 94) echo ' disabled '; echo '>
																	<option value="">== Pilih Kota ==</option>';
																	foreach($this->array_kota($prop_alam_ibu) as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $kota_alam_ibu) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
															<input type="hidden" name="kd_alamat_ibu" id="kd_alamat_ibu" value="'.$dataKu['kd_alamat_ibu'].'">
														</div>
													</div>
													<div class="form-group">
														<label class="text-bayang">Masih Hidup / Meninggal Dunia ?</label>
														<br/>
														<label class="text-bayang">
															<input type="radio" name="hdp_mt_ibu" id="hdpIbu" value="Y" ';if($dataKu['hdp_mt_ibu']=="Y") echo 'checked'; echo ' onclick="cekIbu()" ';if($level == 94) echo ' disabled '; echo '> Masih Hidup
														</label>
														&nbsp;&nbsp;&nbsp;&nbsp;
														<label class="text-bayang">
															<input type="radio" name="hdp_mt_ibu" id="matiIbu" value="T" ';if($dataKu['hdp_mt_ibu']=="T") echo 'checked'; echo ' onclick="cekIbu()" ';if($level == 94) echo ' disabled '; echo '> Sudah Meninggal
														</label>
													</div>
													<div class="form-group" id="ibuHidup" ';if($dataKu['hdp_mt_ibu'] == "Y") echo ' style="display: none;" '; echo ' >
														<label class="text-bayang">Tahun meninggal : </label>
														<input type="number" name="mati_ibu" id="mati_ibu" class="form-control" value="'.$dataKu['mati_ibu'].'" ';if($level == 94) echo ' disabled '; echo ' >
													</div>
												</div>
												<!-- col Kanan -->
											</div>
											<!-- ./row -->
										</div>
										<!-- ./Bagian Ibu Kandung -->
												
										<!-- Bagian Wali -->
										<div class="tab-pane fade" id="wali">
											<div class="row">
												<!-- col Kiri -->
												<div class="col-md-6">
													<div class="form-group">
														<label class="text-bayang">Nama Wali : <font color="#FFA0A0">(tanpa Title)</font></label>
														<input type="text" name="nama_wali" id="nama_wali" class="form-control" value="'.$dataKu['nama_wali'].'">
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">NIK Wali : </label>
																<input type="text" name="nik_wali" id="nik_wali" class="form-control" value="'.$dataKu['nik_wali'].'">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Tanggal Lahir Wali : </label>
																<input type="date" name="tgl_wali" id="tgl_wali" class="form-control" value="'.$dataKu['tgl_wali'].'">
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															<label class="hit-the-floor">Tempat Lahir Wali : </label>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Propinsi : </label>
																<select name="prop_lhr_wali" id="prop_lhr_wali" class="form-control" oninput="showKotaWali(this.value)">
																	<option value="">== Pilih Propinsi ==</option>';
																	foreach($this->array_propinsi() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $prop_lhr_wali) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group" id="kotaLahirWali">
																<label class="text-bayang">Kota / Kabupaten : </label>
																<select name="kota_lhr_wali" id="kota_lhr_wali" class="form-control" oninput="showWilayahWali(this.value)">
																	<option value="">== Pilih Kota ==</option>';
																	foreach($this->array_kota($prop_lhr_wali) as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"';
																		if($x == $kota_lhr_wali) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
															<input type="hidden" name="kd_lhr_wali" id="kd_lhr_wali" value="'.$dataKu['kd_lhr_wali'].'">
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Agama : </label>
																<select class="form-control" name="agama_wali" id="agama_wali">
																	<option value=""> == Pilih Agama == </option>';
																	foreach($this->array_agama() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['agama_wali']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Kewarganegaraan Wali : </label>
																<select class="form-control" name="warga_wali" id="warga_wali">
																	<option value=""> == Pilih Kewarganegaraan == </option>';
																	foreach($this->array_negara() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['warga_wali']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
													</div>
												</div>
												<!-- ./col Kiri -->
												<!-- col Kanan -->
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Telephone Wali : </label>
																<input type="text" name="tlp_wali" id="tlp_wali" class="form-control" value="'.$dataKu['tlp_wali'].'">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Pendidikan Wali : </label>
																<select class="form-control" name="didik_wali" id="didik_wali">
																	<option value=""> == Pilih Pendidikan == </option>';
																	foreach($this->array_pendidikan() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['didik_wali']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Pekerjaan Wali : </label>
																<select class="form-control" name="kerja_wali" id="kerja_wali">
																	<option value=""> == Pilih Pekerjaan == </option>';
																	foreach($this->array_pekerjaan() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['kerja_wali']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Penghasilan Per Bulan : </label>
																<select class="form-control" name="hasil_wali" id="hasil_wali">
																	<option value=""> == Pilih Penghasilan == </option>';
																	foreach($this->array_penghasilan() as $x => $x_value)
																	{
																		echo '<option value="'.$x.'"'; if($x == $dataKu['hasil_wali']) echo ' selected ' ; echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="hit-the-floor">Alamat Rumah : </label>
														<input type="text" name="alamat_wali" id="alamat_wali" class="form-control" value="'.$dataKu['alamat_wali'].'">
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Propinsi : </label>
																<select name="prop_alam_wali" id="prop_alam_wali" class="form-control" oninput="showKotaWali1(this.value)">
																	<option value="">== Pilih Propinsi ==</option>';
																	foreach($this->array_propinsi() as $x => $x_value)
																	{
																		echo '<option value="'.$dataKu['x'].'"';
																		if($x == $prop_alam_wali) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group" id="kotaAlamWali">
																<label class="text-bayang">Kota / Kabupaten : </label>
																<select name="kota_alam_wali" id="kota_alam_wali" class="form-control" oninput="showWilayahWali1(this.value)">
																	<option value="">== Pilih Kota ==</option>';
																	foreach($this->array_kota($prop_alam_wali) as $x => $x_value)
																	{
																		echo '<option value="'.$dataKu['x'].'"';
																		if($x == $kota_alam_wali) echo ' selected ' ;
																		echo' >'.$x_value.'</option>';
																	}
																	echo
																'</select>
															</div>
															<input type="hidden" name="kd_alamat_wali" id="kd_alamat_wali" value="'.$dataKu['kd_alamat_wali'].'">
														</div>
													</div>
													<div class="form-group" ';if($dataKu['hdp_mt_wali'] == "Y") echo ' style="display: none;" '; echo ' >
														<label class="text-bayang">Masih Hidup / Meninggal Dunia ?</label>
														<br/>
														<label class="text-bayang">
															<input type="radio" name="hdp_mt_wali" id="hdpWali" value="Y" ';if($dataKu['hdp_mt_wali']=="Y") echo 'checked'; echo ' onclick="cekWali()"> Masih Hidup
														</label>
														&nbsp;&nbsp;&nbsp;&nbsp;
														<label class="text-bayang">
															<input type="radio" name="hdp_mt_wali" id="matiWali" value="T" ';if($dataKu['hdp_mt_wali']=="T") echo 'checked'; echo ' onclick="cekWali()"> Sudah Meninggal
														</label>
													</div>';
													if($dataKu['nama_wali']=="")
														echo
														'<div class="form-group" id="waliHidup" style="display:none;">';
													else
														echo
														'<div class="form-group" id="waliHidup">';
													echo
														'<label class="text-bayang">Tahun meninggal : </label>
														<input type="number" name="mati_wali" id="mati_wali" class="form-control" value="'.$dataKu['mati_wali'].'" >
													</div>
												</div>
												<!-- col Kanan -->
											</div>
											<!-- ./row -->
										</div>
										<!-- ./Bagian Wali -->
												
										<!-- Bagian Lain-lain -->
										<div class="tab-pane fade" id="lain">
											<div class="row">
												<!-- col Kiri -->
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-12">
															<center><h4 class="hit-the-floor" style="color: green;">Kegemaran</h4></center>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Kesenian : </label>
																<input type="text" name="seni" id="seni" class="form-control" value="'.$dataKu['seni'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Olah Raga : </label>
																<input type="text" name="olahraga" id="olahraga" class="form-control" value="'.$dataKu['olahraga'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Kemasyarakatan / Organisasi : </label>
																<input type="text" name="organisasi" id="organisasi" class="form-control" value="'.$dataKu['organisasi'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Cita-cita : </label>
																<input type="text" name="cita2" id="cita2" class="form-control" value="'.$dataKu['cita2'].'" ';if($level == 94) echo ' disabled '; echo '>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="text-bayang">Lain-lain : </label>
														<input type="text" name="lain2" id="lain2" class="form-control" value="'.$dataKu['lain2'].'" ';if($level == 94) echo ' disabled '; echo '>
													</div>';
													if($level <= 93)
														echo
													'<div class="row">
														<div class="col-md-12">
															<label class="text-bayang"><font color="yellow"><b>*)Harus diperhatikan. Peminatan penjurusan hanya dapat dilakukan maksimal 1x saja. Anda tidak dapat merubah Peminatan Penjurusan setelah tombol <button type="button" class="btn btn-primary" style="border-radius:8px;">
																<img src="'.base_url().'utama/assists/images/icons/save.ico" width=20 height=20> Simpan
															</button> anda tekan.<br/>Peminatan dibatasi oleh kouta yang disedikan dan nilai UN Matematika serta nilai UN IPA</b></font></label>
														</div>
													</div>';
													echo
												'</div>
												<!-- ./col Kiri -->
												<!-- col Kanan -->
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-12">
															<center><h4 class="hit-the-floor" style="color: darkblue;">Lain-lain</h4></center>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Tahun Masuk : </label>
																<input type="number" name="thn_msk" id="thn_msk" class="form-control" value="'.$dataKu['thn_msk'].'" ';if($level <= 95)echo 'disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Jalur Masuk Siswa : </label>
																<select class="form-control" name="sts_siswa" id="sts_siswa" ';if($level <= 95) echo 'disabled '; echo '>
																	<option value=""> -- Pilih -- </option>
																	<option value="1" ';if($dataKu['sts_siswa']=="1") echo ' selected ' ; echo ' > Prestasi </option>
																	<option value="2" ';if($dataKu['sts_siswa']=="2") echo ' selected ' ; echo ' > Mitra Warga </option>
																	<option value="3" ';if($dataKu['sts_siswa']=="3") echo ' selected ' ; echo ' > Umum </option>
																	<option value="4" ';if($dataKu['sts_siswa']=="4") echo ' selected ' ; echo ' > Pindahan </option>
																	<option value="5" ';if($dataKu['sts_siswa']=="5") echo ' selected ' ; echo ' > Pemenuhan Pagu </option>
																</select>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
														<div class="form-group">
															<label class="text-bayang">Peminatan Penjurusan : <font color="yellow">(maksimal 1x pengisian)</font></label>';
															if($level > 95)
															{
																echo
															'<select class="form-control" name="minat" id="minat">
																<option value=""> -- Pilih -- </option>';
																$query = $this->db->select('*')
																			->from('tb_prodi')
																			->get();
																foreach($query->result() as $row)
																{
																	$prodi = $row->prodi;
																	$nama_prodi = $row->nama_prodi;
																	echo
																	'<option value="'.$prodi.'" ';if($prodi == $dataKu["minat"]) echo ' selected '; echo '> '.$nama_prodi.' </option>';
																}
															}
															else
															{
																if(($dataKu['minat'] != '') or 
																	($dataKu['nil_bin'] == 0) or 
																	($dataKu['nil_big'] == 0) or 
																	($dataKu['nil_mat'] == 0) or 
																	($dataKu['nil_ipa'] == 0))
																	echo
																	'<select class="form-control" name="minat" id="minat" disabled>
																		<option value=""> -- Isikan semua Nilai UN -- </option>';
																else
																{
																	if(($dataKu['nil_ipa'] >= 75) and ($dataKu['nil_mat'] >= 75))
																		echo
																		'<select class="form-control" name="minat" id="minat">
																			<option value=""> -- Pilih Peminatan -- </option>';
																	else
																	{
																		$dataKu['minat'] = 'IPS';
																		echo
																		'<select class="form-control" name="minat" id="minat" disabled>
																			<option value=""> -- Pilih Peminatan -- </option>';
																	}
																		
																}
																$query = $this->db->select('*')
																			->from('tb_prodi')
																			->order_by('prodi', 'desc')
																			->get();
																foreach($query->result() as $row)
																{
																	$minatM = $row->prodi;
																	$nama_minat = $row->nama_prodi;
																	echo
																	'<option value="'.$minatM.'" ';
																		if($dataKu['minat'] == $minatM) echo ' selected ';
																		echo '> '.$nama_minat.' </option>';
																}
															}
																echo
															'</select>
														</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Tahun Keluar : </label>
																<input type="number" name="thn_keluar" id="thn_keluar" class="form-control" value="'.$dataKu['thn_keluar'].'" ';if($level <= 95)echo 'disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Alasan Keluar : </label>
																<select class="form-control" name="sts_keluar" id="sts_keluar" ';if($level <= 95) echo 'disabled '; echo '>
																	<option value=""> == Alasan Keluar == </option>
																	<option value="1" ';if($dataKu['sts_keluar']=="1") echo ' selected ' ; echo ' > Lulus </option>
																	<option value="2" ';if($dataKu['sts_keluar']=="2") echo ' selected ' ; echo ' > Pindah </option>
																	<option value="3" ';if($dataKu['sts_keluar']=="3") echo ' selected ' ; echo ' > Meninggal </option>
																	<option value="4" ';if($dataKu['sts_keluar']=="99") echo ' selected ' ; echo ' > Lainnya </option>
																</select>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Jumlah Pengisian : </label>
																<input type="number" name="sts_isi" id="sts_isi" class="form-control" value="'.$dataKu['sts_isi'].'" ';if($level <= 95)echo 'disabled '; echo '>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="text-bayang">Jumlah Pencetakan : </label>
																<input type="number" name="sts_ctk" id="sts_ctk" class="form-control" value="'.$dataKu['sts_ctk'].'" ';if($level <= 95)echo 'disabled '; echo '>
															</div>
														</div>
													</div>';
													if($level <= 93)
														echo
													'<div class="row">
														<div class="col-md-12">
															<label class="text-bayang"><font color="yellow"><b>*) Hasil Penjurusan ditentukan berdasarkan ranking dari : Nilai TPA, nilai UN Matematika, nilai UN IPA, hasil psikotes dan pilihan peminatan.</b></font></label>
														</div>
													</div>';
													echo
												'</div>
												<!-- col Kanan -->
											</div>
											<!-- ./row -->
										</div>
										<!-- /.Bagian Lain-lain -->
												
										<!-- Bagian Upload Dokumen Penunjang -->
										<div class="tab-pane fade" id="photo">
											<form action="uploadPicAll" method="post" enctype="multipart/form-data">
											<input type="hidden" name="noujian" id="noujian" value="'.$no_ujian_smp.'">
											<div class="row">
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-4">
															<label class="text-bayang">Pas Photo</label>
														</div>
														<div class="col-md-1">
															<input type="checkbox" id="photoCek" name="photoCek" style="height:24px;width:24px;margin-top:0px;" ';if($photoCek) echo ' checked '; echo ' disabled>
														</div>
														<div class="col-md-7">
															<input type="file" id="userFiles[5]" name="userFiles[5]" accept="image/*" >
														</div>
													</div>
													<div class="row">
														<div class="col-md-4">
															<label class="text-bayang">SKHUN SMP</label>
														</div>
														<div class="col-md-1">
															<input type="checkbox" id="skhuCek" name="skhuCek" style="height:24px;width:24px;margin-top:0px;" ';if($skhuCek) echo ' checked '; echo ' disabled>
														</div>
														<div class="col-md-7">
															<input type="file" id="userFiles[2]" name="userFiles[2]" accept="image/*">
														</div>
													</div>
													<div class="row">
														<div class="col-md-4">
															<label class="text-bayang">KTP / K Anak</label>
														</div>
														<div class="col-md-1">
															<input type="checkbox" id="ktpCek" name="ktpCek" style="height:24px;width:24px;margin-top:0px;" ';if($ktpCek) echo ' checked '; echo ' disabled>
														</div>
														<div class="col-md-7">
															<input type="file" id="userFiles[3]" name="userFiles[3]" accept="image/*" >
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-4">
															<label class="text-bayang">Akta Lahir</label>
														</div>
														<div class="col-md-1">
															<input type="checkbox" id="aktaCek" name="aktaCek" style="height:24px;width:24px;margin-top:0px;" ';if($aktaCek) echo ' checked '; echo ' disabled>
														</div>
														<div class="col-md-7">
															<input type="file" id="userFiles[1]" name="userFiles[1]" accept="image/*" >
														</div>
													</div>
													<div class="row">
														<div class="col-md-4">
															<label class="text-bayang">Ijazah SMP</label>
														</div>
														<div class="col-md-1">
															<input type="checkbox" id="ijazahCek" name="ijazahCek" style="height:24px;width:24px;margin-top:0px;" ';if($ijazahCek) echo ' checked '; echo ' disabled>
														</div>
														<div class="col-md-7">
															<input type="file" id="userFiles[4]" name="userFiles[4]" accept="image/*">
														</div>
													</div>
													<div class="row">
														<div class="col-md-4">
															<label class="text-bayang">Kartu Keluarga</label>
														</div>
														<div class="col-md-1">
															<input type="checkbox" id="kkCek" name="kkCek" style="height:24px;width:24px;margin-top:0px;" ';if($kkCek) echo ' checked '; echo ' disabled>
														</div>
														<div class="col-md-7">
															<input type="file" id="userFiles[0]" name="userFiles[0]" accept="image/*" >
														</div>
													</div>
												</div>
											</div>
											<hr/>
											<center>
												<!--
												<button name="fileSubmit" type="submit" class="btn btn-primary" value="UPLOAD" />
												-->
												<button name="fileSubmit" class="btn btn-primary" value="UPLOAD" onclick="uploadPicAll()">
													<img src="'.base_url().'utama/assists/images/icons/picture_go.png" width=20 height=20> Upload
												</button>
												<br/>
												<label class="text-bayang"><font color="red">*) Simpan data isian terlebih dahulu sebelum upload photo</font></label>
											</center>
											</form>
										</div>
										<!-- ./Bagian Photo -->

									</div>
									<!-- /. Tab panes -->
											
								</div>
								<!-- /. Panel Body -->
										
							</div>
							<!-- /. Panel -->
									
						</div>
						<!-- ./modal body -->
							
						<!-- modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
							</button>';
							if($level != 94)
								echo
							'<button type="button" class="btn btn-primary" onClick="simpanDataSiswa()" style="border-radius:8px;">
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
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function simpanDataSiswa()
	{
		$outp = array();
		$dt_isian = array("no_ujian_smp", "password", "nisn", "nik", "no_induk", "nama", "thn_msk", "kelas",
						"panggil", "gender", "email", "kd_lahir", "tgl_lhr", "akta_lhr",
						"agama", "warga", "anak_ke", "jml_sdr_k", "jml_sdr_a", "jml_sdr_t", "bahasa",
						"alamat", "rt", "rw", "kd_alamat", "kodepos", "tlp_rmh",
						"sts_tinggal2", "sts_tinggal3", "jarak", "waktu", "kendaraan", "gakin", "no_gakin",
						"gol_darah", "penyakit", "jasmani", "tinggi", "berat",
						"sklh_smp", "no_ijazah", "th_ijazah", "no_skhun", "jml_skhun", "nil_bin", 
						"nil_big", "nil_mat", "nil_ipa",
						"asal_sklh", "alsn_pindah", "tingkat", "kelompok", "jurusan", "tgl_msk",
						"nama_ayah", "nik_ayah", "kd_lhr_ayah", "tgl_ayah", "agama_ayah", "warga_ayah", "didik_ayah",
						"kerja_ayah", "hasil_ayah", "alamat_ayah", "kd_alamat_ayah", "tlp_ayah", "hdp_mt_ayah", "mati_ayah",
						"nama_ibu", "nik_ibu", "kd_lhr_ibu", "tgl_ibu", "agama_ibu", "warga_ibu", "didik_ibu",
						"kerja_ibu", "hasil_ibu", "alamat_ibu", "kd_alamat_ibu", "tlp_ibu", "hdp_mt_ibu", "mati_ibu",
						"nama_wali", "nik_wali", "kd_lhr_wali", "tgl_wali", "agama_wali", "warga_wali", "didik_wali",
						"kerja_wali", "hasil_wali", "alamat_wali", "kd_alamat_wali", "tlp_wali", "hdp_mt_wali", "mati_wali",
						"seni", "olahraga", "organisasi", "cita2", "lain2", "sts_siswa", "thn_keluar",
						"sts_keluar", "sts_isi", "sts_ctk", "th_ajaran", "minat"
						);
		$nil_isian = array();
		for($i = 0; $i < count($dt_isian); $i++)
		{
			$isian_dt = $dt_isian[$i];
			if($isian_dt == 'password')
				$nil_isian[$isian_dt] = $this->encryptIt($this->input->post($isian_dt));
			else
				$nil_isian[$isian_dt] = $this->input->post($isian_dt);
		}
		$no_ujian_smp = $nil_isian["no_ujian_smp"];
		$sts_isi = $nil_isian["sts_isi"];
		$sts_isi++;
		$nil_isian["sts_isi"] = $sts_isi;
		$minat = $nil_isian["minat"];
		
		if($minat != '')
		{
			$query = $this->db->select('*')
						->from('tb_siswa')
						->join('tb_prodi', 'tb_prodi.prodi = tb_siswa.minat', 'left')
						->where('tingkat', '10')
						->where('tb_prodi.prodi', $minat)
						->get();
			$jmlSiswa = $query->num_rows();
			
			$query = $this->db->select('*')
						->from('tb_kelas')
						->select_sum('maksi', 'jmlMaksi')
						->where('tingkat', '10')
						->where('kd_prodi', $minat)
						->get();
			$row = $query->row();
			$maksi = $row->jmlMaksi;
		} 
		else
		{
			$jmlSiswa = 0;
			$maksi    = 100;
		}
		if($jmlSiswa < $maksi)
		{
			$query = $this->db->select('*')
						->from('tb_siswa')
						->where('no_ujian_smp', $no_ujian_smp)
						->get();
			$rowcounts = $query->num_rows();
			if($rowcounts > 0)
			{
				$this->db->where('no_ujian_smp', $no_ujian_smp)->update('tb_siswa', $nil_isian);
				$outp[1] = 'Sukses merubah data siswa';
				//$outp[1] = 'maksi = ' .$maksi. ' jmlSiswa = ' . $jmlSiswa;
			}
			else
			{
				$this->db->insert('tb_siswa', $nil_isian);
				$outp[1] = 'Sukses menambah data siswa';
			}
			$outp[0] = 'sukses';
		}
		else
		{
			$outp[0] = 'error';
			$outp[1] = 'Sudah melebihi batas peminatan';
		}
			
		echo json_encode($outp);
		exit;
	}

	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function uploadPicAll()
	{
		$this->load->helper("file");
		$no_ujian_smp = $this->input->post('noujian');
		$jml_gagal = 0;
		$jml_sukses = 0;
		$dt_photo = array('KK', 'Akta', 'Skhu', 'Ktp', 'Ijazah', 'Photo');
		if(! file_exists('./utama/assists/photos/'.$no_ujian_smp))
			mkdir('./utama/assists/photos/'.$no_ujian_smp, 0777, true);
		$uploadpath = './utama/assists/photos/'.$no_ujian_smp;
		for($i = 0; $i < count($dt_photo); $i++)
		{
			if($_FILES['userFiles']['name'][$i] != '')
			{
				$_FILES['userFile']['name']     = $_FILES['userFiles']['name'][$i];
				$_FILES['userFile']['type']     = $_FILES['userFiles']['type'][$i];
				$_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
				$_FILES['userFile']['error']    = $_FILES['userFiles']['error'][$i];
				$_FILES['userFile']['size']     = $_FILES['userFiles']['size'][$i];

				$config['upload_path'] = $uploadpath;
				$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
				$config['max_size'] = '1024';
				$config['overwrite'] = TRUE;
				$config['file_name'] = strtolower($dt_photo[$i]);
                
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if($this->upload->do_upload('userFile'))
					$jml_sukses++;
				else
					$jml_gagal++;
			}
		}
		
		redirect('home');
		exit;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	public function showSuketModal()
	{
		date_default_timezone_set("Asia/Jakarta");

		$level = $this->session->userdata('level');
		if($level > 95) 
			$no_ujian_smp = $this->input->get('id');
		else
			$no_ujian_smp = $this->session->userdata('username');
		
		echo
				'<!-- modal-dialog -->
				<div class="modal-dialog" role="document">
					<!-- modal-content -->
					<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
						<form action="cetakSuketPDF" method="GET">
						<input type="hidden" id="id" name="id" value="'.$no_ujian_smp.'">
						<!-- modal header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title" id="tulisPesanLabel" style="margin-bottom:0px;margin-top:0px;color: yellow;text-shadow: 2px 2px 4px black, 0 0 25px white, 0 0 5px darkblue;">
								<center>
									<img src="'.base_url().'utama/assists/images/icons/document_editing.png" width=36 height=36> <b>Surat Keterangan</b>
								</center>
							</h3>
						</div>
						<!-- ./modal header -->

						<!-- modal body -->
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Untuk keperluan :
										</label>
										<input type="text" class="form-control" name="perlu" id="perlu">
									</div>
								</div>
							</div>
						</div>
						<!-- ./modal-body -->
						
						<!-- modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
							</button>
							<button type="submit" id="'.$no_ujian_smp.'" class="btn btn-primary" style="border-radius:8px;">
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
	public function showSiswaRapor()
	{
		date_default_timezone_set("Asia/Jakarta");
		$no_ujian_smp = $this->session->userdata('username');
		if(isset($_GET['pl'])) $pilih  = $this->input->get('pl'); else $pilih = 'rapor';
		if(isset($_GET['tp'])) $tapelM = $this->input->get('tp'); else $tapelM = 2017;
		if(isset($_GET['sm'])) $semesM = $this->input->get('sm'); else $semesM = '';
		
		$query = $this->db->select('*')
					->from('tb_siswa')
					->where('no_ujian_smp', $no_ujian_smp)
					->get();
		$row = $query->row();
		$induk = $row->no_induk;
		
		$outp = array();
		if($pilih == 'rapor')
			$query = $this->db->select('*')
						->from('tb_nilai')
						->where('tapel', $tapelM)
						->where('semester', $semesM)
						->where('induk', $induk)
						->get();
		else
			$query = $this->db->select('*')
						->from('tb_ulangan')
						->where('tapel', $tapelM)
						->where('semester', $semesM)
						->where('induk', $induk)
						->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$noRec = $row->no;
		}
		else $noRec = '';
		
		echo
				'<!-- modal-dialog -->
				<div class="modal-dialog" role="document">
					<!-- modal-content -->
					<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
						<!-- modal header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title" id="tulisPesanLabel" style="margin-bottom:0px;margin-top:0px;color: yellow;text-shadow: 2px 2px 4px black, 0 0 25px white, 0 0 5px darkblue;">';
								if($pilih == 'rapor')
									echo '<center><b>
											<img src="'.base_url().'utama/assists/images/icons/property.ico" width=32 height=32> Cetak Rapor
										</b></center>';
								else
									echo '<center><b>
											<img src="'.base_url().'utama/assists/images/icons/event.ico" width=32 height=32> Cetak Ulangan Harian
										</b></center>';
								echo
							'</h3>
						</div>
						<!-- ./modal header -->

						<form id="cetakRaporForm" action="cetakRaporPDF" method="GET">
						<input type="hidden" name="noRec" id="noRec" value="'.$this->encryptIt($noRec).'">
						<input type="hidden" name="pl" id="pl" value="'.$pilih.'">
						<!-- modal body -->
						<div class="modal-body">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Tahun Pelajaran :
										</label>
										<input type="number" class="form-control" name="tapelSel" id="tapelSel" value="'.$tapelM.'" oninput="rubahTapelS()">
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
										<select class="form-control" name="semesSel" id="semesSel" oninput="rubahTapelS()">
											<option value=""> == Pilih Semester == </option>
											<option value="1" ';if($semesM == 1) echo ' selected '; echo '> Ganjil </option>
											<option value="2" ';if($semesM == 2) echo ' selected '; echo '> Genap </option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<!-- ./modal-body -->
						
						<!-- modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
							</button>
							<button type="button" class="btn btn-primary" style="border-radius:8px;" onclick="cekCetakRapor()">
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
	
	// =====================================================================================
	// # Fungsi cek cetak Rapor
	// ======================================================================================
	public function cekCetakRapor()
	{
		$pilih = $this->input->post('pilih');
		$tapel = $this->input->post('tapelSel');
		$semes = $this->input->post('semesSel');
		$no_ujian_smp = $this->session->userdata('username');
		
		$query = $this->db->select('*')
					->from('tb_siswa')
					->where('no_ujian_smp', $no_ujian_smp)
					->get();
		$row = $query->row();
		$induk = $row->no_induk;
		
		$outp = array();
		if($pilih == 'rapor')
			$query = $this->db->select('*')
						->from('tb_nilai')
						->where('tapel', $tapel)
						->where('semester', $semes)
						->where('induk', $induk)
						->get();
		else
			$query = $this->db->select('*')
						->from('tb_ulangan')
						->where('tapel', $tapel)
						->where('semester', $semes)
						->where('induk', $induk)
						->get();
		if($query->num_rows() > 0)
		{
			$outp[0] = 'sukses';
			if($pilih == 'rapor')
				$outp[1] = 'Rapor telah tercetak';
			else
				$outp[1] = 'Ulangan Harian telah tercetak';
		}
		else
		{
			$outp[0] = 'error';
			if($pilih == 'rapor')
				$outp[1] = 'Rapor gagal dicetak';
			else
				$outp[1] = 'Ulangan Harian gagal dicetak';
		}

		echo json_encode($outp);
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	public function showSiswaPresensi()
	{
		date_default_timezone_set("Asia/Jakarta");
		$no_ujian_smp = $this->session->userdata('username');
		
		if(isset($_GET['m']))  $mulai    = $this->input->get('m');  else $mulai = 1;
		if(isset($_GET['t1'])) $tglAwal  = $this->input->get('t1'); else $tglAwal = date('Y-m-d');
		if(isset($_GET['t2'])) $tglAkhir = $this->input->get('t2'); else $tglAkhir = date('Y-m-d');
		
		$query = $this->db->select('*')
					->from('tb_siswa')
					->where('no_ujian_smp', $no_ujian_smp)
					->get();
		$row = $query->row();
		$induk = $row->no_induk;
		
		echo
		'<div class="col-md-12">
			<input type="hidden" id="mulai" value="'.$mulai.'">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<center><b><i>Daftar Kehadiran</i></b></center>
				</div>
				<!-- /.panel-heading -->
				<form action="cetakPresensiPDF" method="POST">
				<input type="hidden" id="induk" name="induk" value="'.$induk.'">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
						<div class="form-horizontal">
							<div class="form-group">
								<label for="inputCetak" class="col-md-2 control-label">Tanggal :</label>
								<div class="col-md-4" style="margin-top:4px;margin-left:0px;">
									<input type="date" id="tglAwal" name="tglAwal" value="'.$tglAwal.'" oninput="ubahSiswaPresensi(this)">
								</div>
								<div class="col-md-1" style="margin-top:6px;margin-left:-20px;">
									<center><b>s/d</b></center>
								</div>
								<div class="col-md-4" style="margin-top:4px;margin-left:-10px;">
									<input type="date" id="tglAkhir" name="tglAkhir" value="'.$tglAkhir.'" oninput="ubahSiswaPresensi(this)">
								</div>
							</div>
						</div>
						</div>
					</div>
					<div class="row">';
						$jml_data = 60;
						$data_tengah = 20;
						if($mulai == 0)
							$awal = 0;
						else
							$awal = ($mulai - 1) * $jml_data;
						$nomer = $awal;
						for($i = 0; $i < 3; $i++)
						{
							echo
							'<div class="col-md-4">
								<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr style="background:green;color:yellow;">
											<th><center>No.</center></th>
											<th><center>Tanggal</center></th>
											<th><center>Jenis</center></th>
										</tr>
									</thead>
									<tbody>';
										$query = $this->db->select('*')
													->from('tb_presensi')
													->where('induk', $induk)
													->where('tanggal >=', $tglAwal)
													->where('tanggal <=', $tglAkhir)
													->limit($jml_data, $awal)
													->order_by('tanggal', 'asc')
													->get();
										foreach($query->result() as $row)
										{
											$nomer++;
											$tanggal = $row->tanggal;
											$jns   = $row->jenis;
											if(strtolower($jns) == 's') $jenis = 'Sakit';
											elseif(strtolower($jns) == 's') $jenis = 'Sakit';
											elseif(strtolower($jns) == 'i') $jenis = 'Ijin';
											elseif(strtolower($jns) == 'a') $jenis = 'Alpha';
											elseif(strtolower($jns) == 't') $jenis = 'Terlambat';
											echo
											'<tr class="gradeA">
												<td><center>'.$nomer.'</center></td>
												<td><center>'.$tanggal.'</center></td>
												<td><center>'.$jenis.'</center></td>
											</tr>';
										}
										if($nomer == 0)
											echo
											'<tr style="background:red;color:yellow;">
												<td colspan="3"><b><center>Tidak ada data</center></b></td>
											</tr>
											<tr>
												<td colspan="3"><b>*) Siswa tidak pernah Sakit, Ijin, Terlambat dan Tanpa Keterangan (Alpha) selama periode ini</b></td>
											</tr>';
											/*
											echo
											'<tr style="background:red;color:yellow;">
												<td><center>'.$nomer.'</center></td>
												<td><center>'.$tglAwal.'</center></td>
												<td><center>'.$tglAkhir.'</center></td>
											</tr>';
											*/
										echo
									'</tbody>
								</table>
							</div>';
							if($nomer < $data_tengah)
								$i = 5;
							else $awal += $data_tengah;
						}
						echo
					'</div>';
					if($nomer > 0)
					{
						echo 
						'<center>';
						$query = $this->db->select('*')
									->from('tb_presensi')
									->where('induk', $induk)
									->where('tanggal >=', $tglAwal)
									->where('tanggal <=', $tglAkhir)
									->get();
						$rowcounts = $query->num_rows();
						$numpages  = ceil($rowcounts / $jml_data);
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
								echo '<a href="#" id="1" class="btn btn-primary" style="height:34px;" oninput="ubahSiswaPresensi(this)">
										<img src="'.base_url().'utama/assists/images/icons/control_start_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
							if($pagenow <= 1)
								echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
										<img src="'.base_url().'utama/assists/images/icons/control_rewind.png" width=24 height=24 style="margin-top:-4px;">
									</button>';
							else
								echo '<a href="#" id="'.$lastpage.'" class="btn btn-primary" style="height:34px;" oninput="ubahSiswaPresensi(this)">
										<img src="'.base_url().'utama/assists/images/icons/control_rewind_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
							echo '<button type="button" class="btn btn-primary" disabled>'.$pagenow.'</button>';
							if($numpages > $pagenow)
								echo '<a href="#" id="'.$nextpage.'" class="btn btn-primary" style="height:34px;" oninput="ubahSiswaPresensi(this)">
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
								echo '<a href="#" id="'.$numpages.'" class="btn btn-primary" style="height:34px;" oninput="ubahSiswaPresensi(this)">
										<img src="'.base_url().'utama/assists/images/icons/control_end_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
						}
						echo
						'<br />
							<button type="submit" class="btn btn-primary" style="border-radius: 8px;">
								<img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=24 height=24> Cetak Semua Data
							</button>
						</center>
						<br />';
					}
					echo
				'</div>
				<!-- /.panel-body -->
				</form>
			</div>
			<!-- /.panel -->
		</div>';
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	public function showSiswaLanggar()
	{
		date_default_timezone_set("Asia/Jakarta");
		$no_ujian_smp = $this->session->userdata('username');
		
		if(isset($_GET['m']))  $mulai    = $this->input->get('m');  else $mulai = 1;
		if(isset($_GET['t1'])) $tglAwal  = $this->input->get('t1'); else $tglAwal = date('Y-m-d');
		if(isset($_GET['t2'])) $tglAkhir = $this->input->get('t2'); else $tglAkhir = date('Y-m-d');
		
		$query = $this->db->select('*')
					->from('tb_siswa')
					->where('no_ujian_smp', $no_ujian_smp)
					->get();
		$row = $query->row();
		$induk = $row->no_induk;
		
		echo
		'<div class="col-md-12">
			<input type="hidden" id="mulai" value="'.$mulai.'">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<center><b><i>Daftar Pelanggaran</i></b></center>
				</div>
				<!-- /.panel-heading -->
				<form action="cetakLanggarPDF" method="POST">
				<input type="hidden" id="induk" name="induk" value="'.$induk.'">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
						<div class="form-horizontal">
							<div class="form-group">
								<label for="inputCetak" class="col-md-2 control-label">Tanggal :</label>
								<div class="col-md-4" style="margin-top:4px;margin-left:0px;">
									<input type="date" id="tglAwal" name="tglAwal" value="'.$tglAwal.'" oninput="ubahSiswaLanggar(this)">
								</div>
								<div class="col-md-1" style="margin-top:6px;margin-left:-20px;">
									<center><b>s/d</b></center>
								</div>
								<div class="col-md-4" style="margin-top:4px;margin-left:-10px;">
									<input type="date" id="tglAkhir" name="tglAkhir" value="'.$tglAkhir.'" oninput="ubahSiswaLanggar(this)">
								</div>
							</div>
						</div>
						</div>
					</div>
					<div class="row">';
						$jml_data = 20;
						$data_tengah = 10;
						if($mulai == 0)
							$awal = 0;
						else
							$awal = ($mulai - 1) * $jml_data;
						$nomer = $awal;
						for($i = 0; $i < 2; $i++)
						{
							echo
							'<div class="col-md-6">
								<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr style="background:green;color:yellow;">
											<th width=5%><center>No.</center></th>
											<th width=30%><center>Tanggal</center></th>
											<th><center>Masalah</center></th>
											<th width=15%><center>Status</center></th>
										</tr>
									</thead>
									<tbody>';
										$query = $this->db->select('*')
													->from('tb_langgar')
													->where('induk', $induk)
													->where('tanggal >=', $tglAwal)
													->where('tanggal <=', $tglAkhir)
													->limit($jml_data, $awal)
													->order_by('tanggal', 'asc')
													->get();
										foreach($query->result() as $row)
										{
											$nomer++;
											$tanggal = $row->tanggal;
											$mslh    = $row->masalah;
											$sts     = $row->statusL;
											if(strtolower($sts) == 'b') $status = 'Belum';
											elseif(strtolower($sts) == 's') $status = 'Sudah';
											elseif(strtolower($sts) == 'p') $status = 'Proses';
											echo
											'<tr class="gradeA">
												<td width=5%><center>'.$nomer.'</center></td>
												<td><center><b>'.$tanggal.'</b></center></td>
												<td><center><b>'.$mslh.'</b></center></td>
												<td><center><b>'.$status.'</b></center></td>
											</tr>';
										}
										if($nomer == 0)
											echo
											'<tr style="background:red;color:yellow;">
												<td colspan="4"><b><center>Tidak ada data</center></b></td>
											</tr>
											<tr>
												<td colspan="4"><b>*) Siswa tidak pernah melakukan pelanggaran selama periode ini</b></td>
											</tr>';
											/*
											echo
											'<tr style="background:red;color:yellow;">
												<td><center>'.$nomer.'</center></td>
												<td><center>'.$tglAwal.'</center></td>
												<td><center>'.$tglAkhir.'</center></td>
											</tr>';
											*/
										echo
									'</tbody>
								</table>
							</div>';
							if($nomer < $data_tengah)
								$i = 5;
							else $awal += $data_tengah;
						}
						echo
					'</div>';
					if($nomer > 0)
					{
						echo 
						'<center>';
						$query = $this->db->select('*')
									->from('tb_langgar')
									->where('induk', $induk)
									->where('tanggal >=', $tglAwal)
									->where('tanggal <=', $tglAkhir)
									->get();
						$rowcounts = $query->num_rows();
						$numpages  = ceil($rowcounts / $jml_data);
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
								echo '<a href="#" id="1" class="btn btn-primary" style="height:34px;" oninput="ubahSiswaLanggar(this)">
										<img src="'.base_url().'utama/assists/images/icons/control_start_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
							if($pagenow <= 1)
								echo '<button type="button" class="btn btn-danger" style="height:34px;" disabled>
										<img src="'.base_url().'utama/assists/images/icons/control_rewind.png" width=24 height=24 style="margin-top:-4px;">
									</button>';
							else
								echo '<a href="#" id="'.$lastpage.'" class="btn btn-primary" style="height:34px;" oninput="ubahSiswaLanggar(this)">
										<img src="'.base_url().'utama/assists/images/icons/control_rewind_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
							echo '<button type="button" class="btn btn-primary" disabled>'.$pagenow.'</button>';
							if($numpages > $pagenow)
								echo '<a href="#" id="'.$nextpage.'" class="btn btn-primary" style="height:34px;" oninput="ubahSiswaLanggar(this)">
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
								echo '<a href="#" id="'.$numpages.'" class="btn btn-primary" style="height:34px;" oninput="ubahSiswaLanggar(this)">
										<img src="'.base_url().'utama/assists/images/icons/control_end_blue.png" width=24 height=24 style="margin-top:-4px;">
									</a>';
						}
						echo
						'<br />
							<button type="submit" class="btn btn-primary" style="border-radius: 8px;">
								<img src="'.base_url().'utama/assists/images/icons/file_extension_pdf.png" width=24 height=24> Cetak Semua Data
							</button>
						</center>
						<br />';
					}
					echo
				'</div>
				<!-- /.panel-body -->
				</form>
			</div>
			<!-- /.panel -->
		</div>';
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi Tulis Pesan
	// ======================================================================================
	public function tulisPesan()
	{
		date_default_timezone_set("Asia/Jakarta");
		
		$no_ujian_smp = $this->session->userdata('username');
		$nama    = $this->session->userdata('nama');
		
		$email = '';
		$tanggal = date("j-n-Y");
		$waktu   = date("H:i:s");
		echo
				'<!-- modal-dialog -->
				<div class="modal-dialog" role="document">
					<!-- modal-content -->
					<div class="modal-content" style="background: linear-gradient(blue, yellow, green);border-radius: 15px;">
						<!-- modal header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title" id="tulisPesanLabel" style="margin-bottom:0px;margin-top:0px;color: yellow;text-shadow: 2px 2px 4px black, 0 0 25px white, 0 0 5px darkblue;">
								<center><b>Tulis Pesan</b></center>
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
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Tanggal :
												</label>
												<input type="text" class="form-control" name="tanggal_p" id="tanggal_p" value="'.$tanggal.'" disabled>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
													Jam :
												</label>
												<input type="text" class="form-control" name="waktu_p" id="waktu_p" value="'.$waktu.'" disabled>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Telephone :
										</label>
										<input type="text" class="form-control" name="telpon" id="telpon" onkeyup="cekInput(this)">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Pengirim :
										</label>
											<input type="text" class="form-control" name="nama" id="nama" value="'.$nama.'" disabled>
									</div>
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											email :
										</label>
										<input type="text" class="form-control" name="email" id="email" value="'.$email.'" onkeyup="cekInput(this)">
									</div>
								</div>
							</div>
							<!-- ./row -->
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label style="color: white;text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">
											Pesan :
										</label>
										<textarea class="form-control" name="pesan" id="pesan" rows="3" onkeyup="cekInput(this)"></textarea>
									</div>
								</div>
							</div>
						</div>
						<!-- ./modal-body -->
						
						<!-- modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-warning pull-left" data-dismiss="modal" style="border-radius:8px;">
								<img src="'.base_url().'utama/assists/images/icons/cross.png" width=20 height=20> Close 
							</button>
							<button type="button" class="btn btn-primary" style="border-radius:8px;" onclick="kirimPesan(this)">
								<img src="'.base_url().'utama/assists/images/icons/send2.ico" width=20 height=20> Kirim
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
	// # Fungsi 
	// ======================================================================================
	public function kirimPesan()
	{
		date_default_timezone_set("Asia/Jakarta");
		
		$nama   = $this->input->post('nama');
		$telpon = $this->input->post('telpon');
		$email  = $this->input->post('email');
		$pesan  = $this->input->post('pesan');
		
		$tgl_pesan = date("Y-m-d H:i:s");
		
		$data = array(
					'tgl_pesan' => $tgl_pesan,
					'nama' => $nama,
					'telpon' => $telpon,
					'email' => $email,
					'pesan' => $pesan,
					'tgl_balas' => $tgl_pesan,
					'status' => 'Blm Baca'
					);

		$this->db->insert('tb_pesan', $data);
		
		$outp = array();
		$outp[0] = 'sukses';
		$outp[1] = 'Pesan sukses dikirim';
		echo json_encode($outp);
		
		exit;
	}
	




	
}


