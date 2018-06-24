<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller 
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

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url','captcha'));
        $this->load->library(array('form_validation', 'email'));
        //$this->load->library(array('form_validation', 'email'));
        $this->load->database();
        $this->load->model('m_data');
        $this->load->model('m_admin');
        $this->load->model('m_cetak');
	}
	
	function view($page = 'home')
	{
		$alamat_ip = $this->session->userdata('ip');
		if($alamat_ip == '') $this->m_data->cek_pengunjung($page);
		
		// Cek session apakah username sudah ada
		$username = $this->session->userdata('username');
		if($username == "")
		{
			if($page == 'showLogin') $this->m_data->showLogin();				// Tampilan Login Form
			elseif($page == 'cekLogin') $this->m_data->cekLogin();				// Cek Input Login
			elseif( ! file_exists('utama/application/views/pages/'.$page.'.php'))
			{
				redirect('home');
				exit;
			}
			else
			{
				$title = 'Isian Data Siswa';
				$data = array('title' => $title);
				$this->load->view('pages/template/atas');
				$this->load->view('pages/'.$page, $data);
				$this->load->view('pages/template/bawah');
			}
		}
		else
		{
			$level = $this->session->userdata('level');
			if($page == 'logout') 				$this->m_data->logout();
			elseif($page == 'cetakDataPDF') 	$this->m_cetak->cetakDataPDF();
			elseif($page == 'cetakSuketPDF')	$this->m_cetak->cetakSuketPDF();
			elseif($page == 'cetakRaporPDF')	$this->m_cetak->cetakRaporPDF();
			elseif($page == 'cetakPresensiPDF')	$this->m_cetak->cetakPresensiPDF();
			elseif($page == 'cetakLanggarPDF')	$this->m_cetak->cetakLanggarPDF();
			elseif($page == 'getKota')			$this->m_data->pilihKota();			// Kode Kota Kelahiran
			elseif($page == 'getKotaAyah')		$this->m_data->pilihKotaAyah();
			elseif($page == 'getKotaIbu')		$this->m_data->pilihKotaIbu();
			elseif($page == 'getKotaWali')		$this->m_data->pilihKotaWali();
			elseif($page == 'getKota1')			$this->m_data->pilihKota1();		// Kode Kota Alamat
			elseif($page == 'getKotaAyah1')		$this->m_data->pilihKotaAyah1();
			elseif($page == 'getKotaIbu1')		$this->m_data->pilihKotaIbu1();
			elseif($page == 'getKotaWali1')		$this->m_data->pilihKotaWali1();
			elseif($page == 'getCamat')			$this->m_data->pilihCamat();
			elseif($page == 'getLurah')			$this->m_data->pilihLurah();
			elseif($page == 'getSiswa')			$this->m_data->pilihSiswa();
			elseif($page == 'modalEditSiswa')	$this->m_data->modalEditSiswa();
			elseif($page == 'simpanDataSiswa')	$this->m_data->simpanDataSiswa();
			elseif($page == 'showSuketModal')	$this->m_data->showSuketModal();
			elseif($page == 'uploadPicAll')		$this->m_data->uploadPicAll();
			
			elseif($level > 93)					$this->admin_page($page);
			elseif($level >= 90)				$this->siswa_page($page);
			else $this->m_data->logout();
		}
	}

	// ======================================================================================
	// # Page Administrator
	// ======================================================================================
    function admin_page($page)
    {
		if($page == 'showDataAll')				$this->m_admin->showDataAll();
		elseif($page == 'showHeaderAdmin') 		$this->m_admin->showHeaderAdmin();
		elseif($page == 'hapusData')			$this->m_admin->hapusData();
		elseif($page == 'dl_contoh')			$this->m_admin->dl_contoh();
		elseif($page == 'showImportData')		$this->m_admin->showImportData();
		elseif($page == 'hapusDataAll')			$this->m_admin->hapusDataAll();
		elseif($page == 'exportData')			$this->m_cetak->exportData();
		elseif($page == 'importDataAll')		$this->m_cetak->importDataAll();
		
		elseif($page == 'ctkRaporModal')		$this->m_admin->ctkRaporModal();
		elseif($page == 'cekRaporAll')			$this->m_admin->cekRaporAll();
		
		elseif($page == 'showDataSekolah')		$this->m_admin->showDataSekolah();
		elseif($page == 'simpanDataSekolah')	$this->m_admin->simpanDataSekolah();
		elseif($page == 'showDataKKM')			$this->m_admin->showDataKKM();
		elseif($page == 'simpanDataKKM')		$this->m_admin->simpanDataKKM();
		elseif($page == 'showAdminModal')		$this->m_admin->showAdminModal();
		elseif($page == 'simpanDataAdmin')		$this->m_admin->simpanDataAdmin();
		elseif($page == 'showWaliModal')		$this->m_admin->showWaliModal();
		elseif($page == 'simpanDataWali')		$this->m_admin->simpanDataWali();
		elseif($page == 'showLanggarModal')		$this->m_admin->showLanggarModal();
		elseif($page == 'simpanLanggarSiswa')	$this->m_admin->simpanLanggarSiswa();
		elseif($page == 'showRaporModal')		$this->m_admin->showRaporModal();
		elseif($page == 'simpanNilaiRapor')		$this->m_admin->simpanNilaiRapor();
		elseif($page == 'showUlanganModal')		$this->m_admin->showUlanganModal();
		elseif($page == 'simpanNilaiUH')		$this->m_admin->simpanNilaiUH();
		
		elseif($page == 'bacaPesan')			$this->m_admin->bacaPesan();
		elseif($page == 'balasPesan')			$this->m_admin->balasPesan();
		
		elseif($page == 'rubahPresensi')		$this->m_admin->rubahPresensi();
		elseif($page == 'ctkPresensiModal')		$this->m_admin->ctkPresensiModal();
		

		elseif( ! file_exists('utama/application/views/p_admin/'.$page.'.php'))
		{
			redirect('home');
			exit;
		}
		else
		{
			$this->load->view('p_admin/template/header');
			$this->load->view('p_admin/'.$page);
			$this->load->view('p_admin/template/footer');
		}
	}

	// ======================================================================================
	// # Page Administrator
	// ======================================================================================
    function siswa_page($page)
    {
		if($page == 'showHeaderSiswa')			$this->m_data->showHeaderSiswa();
		elseif($page == 'showCetakDoc')			$this->m_data->showCetakDoc();
		elseif($page == 'showSiswaRapor')		$this->m_data->showSiswaRapor();
		elseif($page == 'showSiswaPresensi')	$this->m_data->showSiswaPresensi();
		elseif($page == 'showSiswaLanggar')		$this->m_data->showSiswaLanggar();
		elseif($page == 'cekCetakRapor')		$this->m_data->cekCetakRapor();
		elseif($page == 'raporSiswaPDF')		$this->m_cetak->raporSiswaPDF();
		elseif($page == 'tulisPesan')			$this->m_data->tulisPesan();
		elseif($page == 'kirimPesan')			$this->m_data->kirimPesan();
		elseif( ! file_exists('utama/application/views/p_siswa/'.$page.'.php'))
		{
			redirect('home');
			exit;
		}
		else
		{
			$this->load->view('p_siswa/template/header');
			//$this->load->view('p_siswa/template/nav');
			$this->load->view('p_siswa/'.$page);
			$this->load->view('p_siswa/template/footer');
		}
	}



}
