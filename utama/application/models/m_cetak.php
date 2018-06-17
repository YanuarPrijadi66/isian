<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cetak extends CI_Model
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
	
	// ======================================================================================
	// # Fungsi cetak QRCode
	// ======================================================================================
	function cetakQRCode($no_ujian_smp, $nama)
	{
		// Panggil Library QRCode
		$this->load->library('ciqrcode');
		$config['cacheable']	= true;						//boolean, the default is true
		$config['cachedir']		= '';						//string, the default is application/cache/
		$config['errorlog']		= '';						//string, the default is application/logs/
		$config['quality']		= true;						//boolean, the default is true
		$config['size']			= '';						//interger, the default is 1024
		$config['black']		= array(224,255,255);		// array, default is array(255,255,255)
		$config['white']		= array(70,130,180);		// array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);
		
		header("Content-Type: image/png");
		$params['data'] = $no_ujian_smp.' - '.$nama;
		$params['level'] = 'H';
		$params['size'] = 2;
		$params['savename'] = './utama/assists/files/qrcode/'.$no_ujian_smp.'.png';
		$this->ciqrcode->generate($params);
		return;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function ambilDataRapor($noRec)
	{
		$data4 = array();
		$mapel = array();
		$data_nilai = array(
							array('Agama',				'agama',	0,'',0,''),
							array('PKn', 				'pkn',		0,'',0,''),
							array('Bahasa Indonesia',	'indo',		0,'',0,''),
							array('Matematika',			'matwaj',	0,'',0,''),
							array('Sejarah',			'sejind',	0,'',0,''),
							array('Bahasa Inggris',		'inggris',	0,'',0,''),
							array('Seni Budaya',		'senbud',	0,'',0,''),
							array('Penjas Orkes',		'penjas',	0,'',0,''),
							array('PKWU',				'pkwu',		0,'',0,''),
							array('Peminatan I', 		'minat1',	0,'',0,''),
							array('Biologi / Geografi',	'biogeo',	0,'',0,''),
							array('Fisika / Ekonomi',	'fiseko',	0,'',0,''),
							array('Kimia / Sosiologi',	'kimsos',	0,'',0,''),
							array('Lintas minat',		'lintas',	0,'',0,''),
							array('Peminatan II',		'minat2',	0,'',0,'')
						);

		$query = $this->db->select('*')
					->from('tb_nilai')
					->join('tb_siswa', 'tb_siswa.no_induk = tb_nilai.induk', 'left')
					->join('tb_kelas', 'tb_siswa.kelas = tb_kelas.kd_kelas', 'left')
					->join('tb_lintas', 'tb_lintas.lintas = tb_nilai.lintas_s', 'left')
					->join('tb_agama', 'tb_siswa.agama = tb_agama.agama_id', 'left')
					->where('tb_nilai.no', $noRec)
					->get();
		$row = $query->row();
		
		$data4['no_induk']		= $row->induk;
		$data4['tapelS']		= $row->tapel;
		$data4['semes']			= $row->semester;
		$data4['minat_s1']		= $row->minat_s1;
		$data4['minat_s2']		= $row->minat_s2;
		$data4['lintas_s']		= $row->lintas_s;
		$data4['prodi']			= $row->kd_prodi;
		$data4['lintas']		= $row->nama_lintas;
		$data4['no_ujian_smp']	= $row->no_ujian_smp;
		$data4['nama']			= $row->nama;
		$data4['nisn']			= $row->nisn;
		$data4['kelas']			= $row->kelas;
		$data4['nama_kelas']	= $row->nama_kelas;
		$data4['alamat']		= $row->alamat;
		$data4['tgl_lhr']		= $row->tgl_lhr;
		$data4['kd_lahir']		= $row->kd_lahir;
		$data4['kd_alamat']		= $row->kd_alamat;
		$data4['agama']			= $row->nama_agama;
		$data4['ekstra1_s']		= $row->ekstra1_s;
		$data4['ekstra1_n']		= $row->ekstra1_n;
		$data4['ekstra1_d']		= $row->ekstra1_d;
		$data4['ekstra2_s']		= $row->ekstra2_s;
		$data4['ekstra2_n']		= $row->ekstra2_n;
		$data4['ekstra2_d']		= $row->ekstra2_d;
		$data4['spiritual_p']	= $row->spiritual_p;
		$data4['spiritual_d']	= $row->spiritual_d;
		$data4['sosial_p']		= $row->sosial_p;
		$data4['sosial_d']		= $row->sosial_d;
		$data4['prestasi1_j']	= $row->prestasi1_j;
		$data4['prestasi1_k']	= $row->prestasi1_k;
		$data4['prestasi2_j']	= $row->prestasi2_j;
		$data4['prestasi2_k']	= $row->prestasi2_k;
		$data4['komen_wali']	= $row->komen_wali;
		$data4['komen_ortu']	= $row->komen_ortu;
		$data4['naikK']			= $row->naik;
			
		for($j = 0; $j < count($data_nilai); $j++)
		{
			$kalim = $data_nilai[$j][1] . '_bn';
			$data_nilai[$j][2] = number_format($row -> $kalim);
			$kalim = $data_nilai[$j][1] . '_bd';
			$data_nilai[$j][3] = $row -> $kalim;
			$kalim = $data_nilai[$j][1] . '_cn';;
			$data_nilai[$j][4] = number_format($row -> $kalim);
			$kalim = $data_nilai[$j][1] . '_cd';
			$data_nilai[$j][5] = $row -> $kalim;
		}
	
		if($data4['semes'] == 1)
		{
			$tgl_awal  = $data4['tapelS'].'-07-01';
			$tgl_akhir = ($data4['tapelS']+1).'-01-01';
		}
		else
		{
			$tgl_awal  = ($data4['tapelS'] + 1).'-01-01';
			$tgl_akhir = ($data4['tapelS'] + 1).'-07-01';
		}
			
		$jml_skt = 0;
		$jml_ijn = 0;
		$jml_alp = 0;
		$jml_lmb = 0;
		$query = $this->db->select('*')
					->from('tb_presensi')
					->where('induk', $data4['no_induk'])
					->where('tanggal >=', $tgl_awal)
					->where('tanggal <', $tgl_akhir)
					->get();
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$jenis = $row->jenis;
				if(strtolower($jenis) == 's') $jml_skt++;
				elseif(strtolower($jenis) == 'i') $jml_ijn++;
				elseif(strtolower($jenis) == 'a') $jml_alp++;
				elseif(strtolower($jenis) == 't') $jml_lmb++;
			}
		}
		$data4['jml_skt'] = $jml_skt;
		$data4['jml_ijn'] = $jml_ijn;
		$data4['jml_alp'] = $jml_alp;
		$data4['jml_lmb'] = $jml_lmb;

		$minat1 = '';
		$minat2 = '';
		$query = $this->db->select('*')
					->from('tb_minat')
					->get();
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$minat = $row->minat;
				$nama_minat = $row->nama_minat;
				if($minat == $data4['minat_s1']) $minat1 = $nama_minat;
				if($minat == $data4['minat_s2']) $minat2 = $nama_minat;
			}
		}
		$data4['minat1'] = $minat1;
		$data4['minat2'] = $minat2;
		
		if(strtolower($data4['prodi']) == 'mipa')
			$mapel 		= array("Pendidikan Agama ".$data4['agama']." dan Budi Pekerti",
								"Pendidikan Pancasila dan Kewarganegaraan",
								"Bahasa Indonesia",
								"Matematika (Umum)",
								"Sejarah Indonesia",
								"Bahasa Inggris",
								"Seni Budaya",
								"Pendidikan Jasmani, Olahraga dan Kesehatan",
								"Prakarya dan Kewirausahaan",
								"Matematika (Peminatan)",
								"Biologi",
								"Fisika",
								"Kimia",
								"Sosiologi",
								"Geografi"
							);
		elseif(strtolower($data4['prodi']) == 'ips')
			$mapel 		= array("Pendidikan Agama ".$data4['agama']." dan Budi Pekerti",
								"Pendidikan Pancasila dan Kewarganegaraan",
								"Bahasa Indonesia",
								"Matematika (Umum)",
								"Sejarah Indonesia",
								"Bahasa Inggris",
								"Seni Budaya",
								"Pendidikan Jasmani, Olahraga dan Kesehatan",
								"Prakarya dan Kewirausahaan",
								"Sosiologi (Peminatan)",
								"Geografi",
								"Ekonomi",
								"Sosiologi",
								"Fisika",
								"Biologi"
							);

		return [$data_nilai, $mapel, $data4];
	}

	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function ambilDataUlangan($noRec)
	{
		$data_nilai = array();
		$mapel = array();
		$data4 = array();
		$query = $this->db->select('*')
					->from('tb_ulangan')
					->join('tb_siswa', 'tb_siswa.no_induk = tb_ulangan.induk', 'left')
					->join('tb_kelas', 'tb_siswa.kelas = tb_kelas.kd_kelas', 'left')
					->join('tb_agama', 'tb_siswa.agama = tb_agama.agama_id', 'left')
					->join('tb_lintas', 'tb_lintas.lintas = tb_ulangan.lintas_s', 'left')
					->where('tb_ulangan.no', $noRec)
					->get();
		$row = $query->row();
		$data4['no_induk']		= $row -> no_induk;
		$data4['tapelS']		= $row -> tapel;
		$data4['semes']			= $row -> semester;
		$data4['no_ujian_smp']	= $row -> no_ujian_smp;
		$data4['nama']			= $row -> nama;
		$data4['nisn']			= $row -> nisn;
		$data4['kelas']			= $row -> kelas;
		$data4['prodi']			= $row -> kd_prodi;
		$data4['nama_kelas']	= $row -> nama_kelas;
		$data4['alamat']		= $row -> alamat;
		$data4['agama']			= $row -> nama_agama;
		$data4['minat1_s']		= $row -> minat1_s;
		$data4['minat2_s']		= $row -> minat2_s;
		$data4['lintas']		= $row -> nama_lintas;
		
		$query1 = $this->db->select('*')
					->from('tb_minat')
					->get();
		foreach($query1->result() as $row1)
		{
			$minat = $row1->minat;
			$nama  = $row1->nama_minat;
			if($minat == $data4['minat1_s']) $data4['minat1_nama'] = $nama;
			if($minat == $data4['minat2_s']) $data4['minat2_nama'] = $nama;
		}
		
		$data_nilai = array(
							array('Agama',				'agama',	0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('PKn', 				'pkn',		0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('Bahasa Indonesia',	'indo',		0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('Matematika',			'mat',		0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('Sejarah',			'sej',		0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('Bahasa Inggris',		'ingg', 	0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('Seni Budaya',		'senbud',	0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('Penjas Orkes',		'penjas',	0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('PKWU',				'pkwu',		0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('Peminatan I', 		'minat1',	0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('Biologi / Geografi',	'biogeo',	0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('Fisika / Ekonomi',	'fiseko',	0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('Kimia / Sosiologi',	'kimsos',	0,0,0,0,0, 0,0,0,0,0, 0,0),
							array('Lintas minat',		'lintas',	0,0,0,0,0, 0,0,0,0,0, 0,0)
						);

		$minat = array('Peminatan II', 'minat2', 0,0,0,0,0, 0,0,0,0,0, 0,0);
		if($data4['minat2_s'] != '')
		{
			$pnd = array();
			$data_nilai1 = array();
			$data_nilai1 = array_slice($data_nilai, 0, 10);
			array_push($data_nilai1, $minat);
			for($i = 10; $i < count($data_nilai); $i++)
			{
				$pnd = $data_nilai[$i];
				array_push($data_nilai1, $pnd);
			}
			$data_nilai = $data_nilai1;
		}

		//die(print_r($data_nilai));
		
		for($j = 0; $j < count($data_nilai); $j++)
		{
			for($i = 0; $i < 5; $i++)
			{
				$kalim = $data_nilai[$j][1] . '_UH' . ($i + 1);
				$data_nilai[$j][($i + 2)] = number_format($row -> $kalim);
				$kalim = $data_nilai[$j][1] . '_T' . ($i + 1);
				$data_nilai[$j][($i + 7)] = number_format($row -> $kalim);
			}
			$kalim = $data_nilai[$j][1] . '_UTS';
			$data_nilai[$j][12] = number_format($row -> $kalim);
			$kalim = $data_nilai[$j][1] . '_UAS';
			$data_nilai[$j][13] = number_format($row -> $kalim);
		}
			
		if(strtolower($data4['prodi']) == 'mipa')
			$mapel 		= array("Pendidikan Agama ".$data4['agama']." dan Budi Pekerti",
							"Pendidikan Pancasila dan Kewarganegaraan",
							"Bahasa Indonesia",
							"Matematika (Umum)",
							"Sejarah Indonesia",
							"Bahasa Inggris",
							"Seni Budaya",
							"Pendidikan Jasmani, Olahraga dan Kesehatan",
							"Prakarya dan Kewirausahaan",
							$data4['minat1_nama'].' (Peminatan)',
							"Biologi",
							"Fisika",
							"Kimia",
							$data4['lintas'].' (Lintas Minat)'
						);
		elseif(strtolower($data4['prodi']) == 'ips')
			$mapel 		= array("Pendidikan Agama ".$data4['agama']." dan Budi Pekerti",
							"Pendidikan Pancasila dan Kewarganegaraan",
							"Bahasa Indonesia",
							"Matematika (Umum)",
							"Sejarah Indonesia",
							"Bahasa Inggris",
							"Seni Budaya",
							"Pendidikan Jasmani, Olahraga dan Kesehatan",
							"Prakarya dan Kewirausahaan",
							$data4['minat1_nama'].' (Peminatan)',
							"Geografi",
							"Ekonomi",
							"Sosiologi",
							$data4['lintas'].' (Lintas Minat)'
						);
		
		if($data4['minat2_s'] != '')
		{
			$minat = $data4['minat2_nama']. ' (Peminatan)';
			array_splice($mapel, 10, 0, $minat);
		}
		
		return [$data_nilai, $mapel, $data4];
		
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function ambilCSSPdf()
	{
		// ============= Style =================
		$strhtml = '<style>';
		$strhtml .= 	'.coret {text-decoration: line-through;background-color: #C0C0C0;display: inline;}';
		$strhtml .= 	'.grsBwh {border-bottom: 2px dotted black;}';
		$strhtml .= 	'div.font12 {font-size: 12px;}';
		$strhtml .= 	'div.gbQrc {position: absolute; top: 980px; left: 60px; width: 100px; height: 120px;}';
		$strhtml .= 	'table.rapor {width: 100%; border-collapse: collapse; font-size:12px; }';
		$strhtml .= 	'tr.bgClr {background-color:#D8D8D8; border: 1px solid black;}';
		$strhtml .= 	'tr.polos {border: 1px solid black;}';
		$strhtml .= 	'td.bgClr {background-color:#D8D8D8; border: 1px solid black;}';
		$strhtml .= 	'td.kiri1 {text-align: left; padding: 6px 10px; horizontal-align:middle; border: 1px solid black;}';
		$strhtml .= 	'td.kiri2 {text-align: left; padding: 4px 20px; horizontal-align:middle;}';
		$strhtml .= 	'td.kiri70 {height: 70px; text-align: left; padding: 4px 10px; horizontal-align:top; border: 1px solid black;}';
		$strhtml .= 	'td.kiri140 {height: 140px; text-align: left; padding: 4px 10px;horizontal-align:top; border: 1px solid black;}';
		$strhtml .= 	'td.tengah1 {text-align: center; padding: 8px 0; horizontal-align:middle; border: 1px solid black;}';
		$strhtml .= 	'td.tengah2 {text-align: center; padding: 8px 10px; horizontal-align:middle; border: 1px solid black;}';
		$strhtml .= 	'td.tengah70 {height: 70px; text-align: center; padding: 4px 0; horizontal-align:middle; border: 1px solid black;}';
		$strhtml .= 	'td.tengah140 {height: 140px; text-align: center; padding: 4px 0;horizontal-align:middle; border: 1px solid black;}';
		$strhtml .= '</style>';
		return $strhtml;
	}

	// ======================================================================================
	// # Fungsi cetak Header Rapor
	// ======================================================================================
	function headerRaporPDF($nama_kelas, $semester, $nama, $tapel, $no_induk, $nisn)
	{
		$query = $this->db->select('*')
					->from('tb_sekolah')
					->get();
		$row = $query->row();
		$sekolah = $row->nama_sekolah;
		$kota    = $row->kota;
		$alamat  = $row->alamat;
		$strhtml  = '';
		$strhtml .= '<table width=100% style="font-size:14px;">';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=21%>Nama Sekolah</td>';
		$strhtml .= 		'<td align="center" width=10px>:</td>';
		$strhtml .= 		'<td width=40%><b>'.$sekolah.'&nbsp;&nbsp;'.$kota.'</b></td>';
		$strhtml .= 		'<td width=10px>&nbsp;</td>';
		$strhtml .= 		'<td width=17%>Kelas</td>';
		$strhtml .= 		'<td align="center" width=10px>:</td>';
		$strhtml .= 		'<td width=18%><b>'.$nama_kelas.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>Alamat</td>';
		$strhtml .= 		'<td align="center">:</td>';
		$strhtml .= 		'<td><b>'.$alamat.'</b></td>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td>Semester</td>';
		$strhtml .= 		'<td align="center">:</td>';
		$strhtml .= 		'<td><b>'.$semester.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>Nama Peserta Didik</td>';
		$strhtml .= 		'<td align="center">:</td>';
		if(strtolower($no_induk) == 'all')
			$strhtml .= 		'<td><b> - </b></td>';
		else
			$strhtml .= 		'<td><b>'.$nama.'</b></td>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td>Tahun Pelajaran</td>';
		$strhtml .= 		'<td align="center">:</td>';
		$strhtml .= 		'<td><b>'.$tapel.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>Nomer Induk / NISN</td>';
		$strhtml .= 		'<td align="center">:</td>';
		if(strtolower($no_induk) == 'all')
			$strhtml .= 		'<td><b> - </b></td>';
		else
			$strhtml .= 		'<td><b>'.$no_induk.' / '.$nisn.'</b></td>';
		$strhtml .= 		'<td colspan="4">&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<hr/>';
		return $strhtml;
	}
	
	// ======================================================================================
	// # Fungsi cetak Wali Kelas
	// ======================================================================================
	function walikelasRaporPDF($no_ujian_smp, $tgl_surat, $kelas)
	{
		$query = $this->db->select('*')
					->from('tb_wali')
					->where('kelas', $kelas)
					->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$nama = $row->nama;
			$nip  = $row->nip;
		}
		else
		{
			$nama = '';
			$nip  = '';
		}
		$spasi = '&nbsp;';
		if($nama == '')
		{
			for($i = 0; $i < 36; $i++)
			{
				$nama .= $spasi;
			}
		}
		$strhtml  = '';
		$strhtml .= '<table width=100% style="font-size:14px;">';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=70%>&nbsp;</td>';
		$strhtml .= 		'<td width=30%>'.$tgl_surat.'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td>Wali Kelas,</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr><td colspan="2">&nbsp;</td></tr>';
		$strhtml .= 	'<tr><td colspan="2">&nbsp;</td></tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td> <u><b>'.$nama.'</b></u> </td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td> NIP. '.$nip.' </td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<div class="gbQrc">';
		$strhtml .=		'<img src="'.base_url().'utama/assists/files/qrcode/'.$no_ujian_smp.'.png">';
		$strhtml .= '</div>';
		
		return $strhtml;
	}

	// ======================================================================================
	// # Fungsi cetak Kop Surat
	// ======================================================================================
	function kopSuratPDF()
	{
		$query = $this->db->select('*')
					->from('tb_sekolah')
					->get();
		$row = $query->row();
		$sklh    =  strtoupper($row->nama_sekolah);
		$alamat  = $row->alamat;
		$kota    = strtoupper($row->kota);
		$prop    = strtoupper($row->propinsi);
		$telepon = $row->telepon;
		$fax     = $row->fax;
		$kodepos = $row->kodepos;
		$sekolah = strtoupper(str_replace('SMA ', '', $sklh));
		
		$strhtml  = '';
		$strhtml .= '<table width=100% style="font-size:14px;">';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=5%>&nbsp;</td>';
		$strhtml .= 		'<td width=12%>';
		$strhtml .= 			'<IMG class="displayed" src="'.base_url().'utama/assists/images/jatim2_bw.png" alt="" width=12% height=15%>';
		$strhtml .= 		'</td>';
		$strhtml .= 		'<td align="center" width=58%>';
		$strhtml .= 			'<p><h3>PEMERINTAH PROPINSI '.$prop.'</h2></p>';
		$strhtml .= 			'<p><h3>DINAS PENDIDIKAN</h3></p>';
		$strhtml .= 			'<p><h2>SEKOLAH MENENGAH ATAS '.$sekolah.'</h2></p>';
		$strhtml .= 			'<p><h2>'.$kota.'</h2></p>';
		$strhtml .= 			'<p><h5>'.$alamat.' Telp. '.$telepon.' - Fax. '.$fax.'</h5></p>';
		$strhtml .= 			'<p><h3>'.$kota.'&nbsp;&nbsp;'.$kodepos.'</h3></p>';
		$strhtml .= 		'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		return $strhtml;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function hal1Rapor($spiritual_p, $spiritual_d, $sosial_p, $sosial_d)
	{
		$strhtml = '';
		$strhtml .= '<div style="text-align:center;">';
		$strhtml .= 	'<h2>CAPAIAN HASIL BELAJAR</h2>';
		$strhtml .= '</div>';
		$strhtml .= '<br />';
		$strhtml .= '<br />';
		$strhtml .= '<b>A. SIKAP</b><br/>';
		$strhtml .= '<br />';
		$strhtml .= '<b>1. Sikap Spiritual</b><br/>';
		$strhtml .= '<table class="rapor">';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1" width=12%><b>Predikat</b></td>';
		$strhtml .= 		'<td class="tengah1" width=85%><b>Diskripsi</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="tengah140">'.$spiritual_p.'</td>';
		$strhtml .= 		'<td class="kiri140">'.$spiritual_d.'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		$strhtml .= '<br/>';
		$strhtml .= '<b>2. Sikap Sosial</b><br/>';
		$strhtml .= '<table class="rapor">';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1" width=12%><b>Predikat</b></td>';
		$strhtml .= 		'<td class="tengah1" width=85%><b>Diskripsi</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="tengah140">'.$sosial_p.'</td>';
		$strhtml .= 		'<td class="kiri140">'.$sosial_d.'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		
		return $strhtml;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function hal2Rapor($data_kkm, $data_nilai, $mapel, $lintas)
	{
		$strhtml = '';
		$strhtml .= '<div class="font12">';
		$strhtml .= '<b>B. PENGETAHUAN</b><br/>';
		$strhtml .= '<b>Kriteria Ketuntasan Minimal = '.$data_kkm['kkm'].'</b><br/>';
		$strhtml .= '</div>';
		$strhtml .= '<table class="rapor">';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1" rowspan="2" width=4%><b>No</b></td>';
		$strhtml .= 		'<td class="tengah1" rowspan="2" width=20%><b>Mata Pelajaran</b></td>';
		$strhtml .= 		'<td class="tengah1" colspan="3" ><b>Pengetahuan</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1" width=6%><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1" width=8%><b>Predikat</b></td>';
		$strhtml .= 		'<td class="tengah1" width=55%><b>Diskripsi</b></td>';
		$strhtml .= 	'</tr>';
		for($i = 0; $i < count($mapel); $i++)
		{
			if($i == 0)
			{
				//$strhtml .= '<tr style="border: 1px solid black;">';
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="5"><b>Kelompok A (Umum)</b></td>';
				$strhtml .= '</tr>';
			}
			elseif($i == 6)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="5"><b>Kelompok B (Umum) </b></td>';
				$strhtml .= '</tr>';
			}
			elseif($i == 9)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="5"><b>Kelompok C (Peminatan)</b></td>';
				$strhtml .= '</tr>';
			}
			$strhtml .= '<tr class="polos">';
			$strhtml .= 	'<td class="tengah1"><b>'.($i + 1).'</b></td>';
			$strhtml .= 	'<td class="kiri1"><b>'.$mapel[$i].'</b></td>';
			if($i > 12)
				$j = count($data_nilai)-2;
			else
				$j = $i;
			if(($data_nilai[$j][2] == '') or ($data_nilai[$j][2] == 0))
			{
				$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
				$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
				$strhtml .= 	'<td class="kiri1"><b>&nbsp;</b></td>';
			}
			else
			{
				if(($i > 12) and (strtolower($mapel[$i]) != strtolower($lintas)))
				{
					$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
					$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
					$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
				}
				else
				{
					if($i > 12)
					{
						$j = count($data_nilai)-2;
						$strhtml .= 	'<td class="tengah1"><b>'.$data_nilai[$j][2].'</b></td>';
						if(($data_nilai[$j][2] >= $data_kkm['pred1_bawah']) and ($data_nilai[$j][2] < $data_kkm['pred1_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred1_nama'].'</b></td>';
						elseif(($data_nilai[$j][2] >= $data_kkm['pred2_bawah']) and ($data_nilai[$j][2] < $data_kkm['pred2_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred2_nama'].'</b></td>';
						elseif(($data_nilai[$j][2] >= $data_kkm['pred3_bawah']) and ($data_nilai[$j][2] < $data_kkm['pred3_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred3_nama'].'</b></td>';
						elseif(($data_nilai[$j][2] >= $data_kkm['pred4_bawah']) and ($data_nilai[$j][2] < $data_kkm['pred4_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred4_nama'].'</b></td>';
						elseif(($data_nilai[$j][2] >= $data_kkm['pred5_bawah']) and ($data_nilai[$j][2] < $data_kkm['pred5_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred5_nama'].'</b></td>';
						$strhtml .= 	'<td class="kiri2">'.$data_nilai[$j][3].'</td>';
					}
					else
					{
						$strhtml .= 	'<td class="tengah1"><b>'.$data_nilai[$i][2].'</b></td>';
						if(($data_nilai[$i][2] >= $data_kkm['pred1_bawah']) and ($data_nilai[$i][2] < $data_kkm['pred1_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred1_nama'].'</b></td>';
						elseif(($data_nilai[$i][2] >= $data_kkm['pred2_bawah']) and ($data_nilai[$i][2] < $data_kkm['pred2_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred2_nama'].'</b></td>';
						elseif(($data_nilai[$i][2] >= $data_kkm['pred3_bawah']) and ($data_nilai[$i][2] < $data_kkm['pred3_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred3_nama'].'</b></td>';
						elseif(($data_nilai[$i][2] >= $data_kkm['pred4_bawah']) and ($data_nilai[$i][2] < $data_kkm['pred4_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred4_nama'].'</b></td>';
						elseif(($data_nilai[$i][2] >= $data_kkm['pred5_bawah']) and ($data_nilai[$i][2] < $data_kkm['pred5_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred5_nama'].'</b></td>';
						$strhtml .= 	'<td class="kiri2">'.$data_nilai[$i][3].'</td>';
					}
				}
			}
			$strhtml .= '</tr>';
		}
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		
		return $strhtml;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function hal3Rapor($data_kkm, $data_nilai, $mapel, $lintas)
	{
		$strhtml = '';
		$strhtml .= '<div class="font12">';
		$strhtml .= '<b>C. KETRAMPILAN</b><br/>';
		$strhtml .= '<b>Kriteria Ketuntasan Minimal = '.$data_kkm['kkm'].'</b><br/>';
		$strhtml .= '</div>';
		$strhtml .= '<table class="rapor">';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1" rowspan="2" width=4%><b>No</b></td>';
		$strhtml .= 		'<td class="tengah1" rowspan="2" width=20%><b>Mata Pelajaran</b></td>';
		$strhtml .= 		'<td class="tengah1" colspan="3" ><b>Pengetahuan</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1" width=6%><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1" width=8%><b>Predikat</b></td>';
		$strhtml .= 		'<td class="tengah1" width=55%><b>Diskripsi</b></td>';
		$strhtml .= 	'</tr>';
		for($i = 0; $i < count($mapel); $i++)
		{
			if($i == 0)
			{
				//$strhtml .= '<tr style="border: 1px solid black;">';
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="5"><b>Kelompok A (Umum)</b></td>';
				$strhtml .= '</tr>';
			}
			elseif($i == 6)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="5"><b>Kelompok B (Umum)</b></td>';
				$strhtml .= '</tr>';
			}
			elseif($i == 9)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="5"><b>Kelompok C (Peminatan)</b></td>';
				$strhtml .= '</tr>';
			}
			$strhtml .= '<tr class="polos">';
			$strhtml .= 	'<td class="tengah1"><b>'.($i + 1).'</b></td>';
			$strhtml .= 	'<td class="kiri1"><b>'.$mapel[$i].'</b></td>';
			if($i > 12)
				$j = count($data_nilai)-2;
			else
				$j = $i;
			if(($data_nilai[$j][4] == '') or ($data_nilai[$j][4] == 0))
			{
				$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
				$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
				$strhtml .= 	'<td class="kiri1"><b>&nbsp;</b></td>';
			}
			else
			{
				if(($i > 12) and (strtolower($mapel[$i]) != strtolower($lintas)))
				{
					$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
					$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
					$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
				}
				else
				{
					if($i > 12)
					{
						$j = count($data_nilai)-2;
						$strhtml .= 	'<td class="tengah1"><b>'.$data_nilai[$j][4].'</b></td>';
						if(($data_nilai[$j][4] >= $data_kkm['pred1_bawah']) and ($data_nilai[$j][4] < $data_kkm['pred1_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred1_nama'].'</b></td>';
						elseif(($data_nilai[$j][4] >= $data_kkm['pred2_bawah']) and ($data_nilai[$j][4] < $data_kkm['pred2_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred2_nama'].'</b></td>';
						elseif(($data_nilai[$j][4] >= $data_kkm['pred3_bawah']) and ($data_nilai[$j][4] < $data_kkm['pred3_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred3_nama'].'</b></td>';
						elseif(($data_nilai[$j][4] >= $data_kkm['pred4_bawah']) and ($data_nilai[$j][4] < $data_kkm['pred4_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred4_nama'].'</b></td>';
						elseif(($data_nilai[$j][4] >= $data_kkm['pred5_bawah']) and ($data_nilai[$j][4] < $data_kkm['pred5_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred5_nama'].'</b></td>';
						$strhtml .= 	'<td class="kiri2">'.$data_nilai[$j][5].'</td>';
					}
					else
					{
						$strhtml .= 	'<td class="tengah1"><b>'.$data_nilai[$i][4].'</b></td>';
						if(($data_nilai[$i][4] >= $data_kkm['pred1_bawah']) and ($data_nilai[$i][4] < $data_kkm['pred1_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred1_nama'].'</b></td>';
						elseif(($data_nilai[$i][4] >= $data_kkm['pred2_bawah']) and ($data_nilai[$i][4] < $data_kkm['pred2_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred2_nama'].'</b></td>';
						elseif(($data_nilai[$i][4] >= $data_kkm['pred3_bawah']) and ($data_nilai[$i][4] < $data_kkm['pred3_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred3_nama'].'</b></td>';
						elseif(($data_nilai[$i][4] >= $data_kkm['pred4_bawah']) and ($data_nilai[$i][4] < $data_kkm['pred4_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred4_nama'].'</b></td>';
						elseif(($data_nilai[$i][4] >= $data_kkm['pred5_bawah']) and ($data_nilai[$i][4] < $data_kkm['pred5_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred5_nama'].'</b></td>';
						$strhtml .= 	'<td class="kiri2">'.$data_nilai[$i][5].'</td>';
					}
				}
			}
			$strhtml .= '</tr>';
		}
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		
		return $strhtml;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function hal4Rapor($data4)
	{
		$strhtml = '';
		$strhtml .= '<br/>';
		$strhtml .= '<br/>';
		$strhtml .= '<div class="font12">';
		$strhtml .= 	'<b>D. EKSTRAKURIKULER</b><br/>';
		$strhtml .= '</div>';
		$strhtml .= '<table class="rapor">';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1" width=5%><b>No</b></td>';
		$strhtml .= 		'<td class="tengah1" width=35%><b>Kegiatan Ekstrakurikuler</b></td>';
		$strhtml .= 		'<td class="tengah1" width=12%><b>Predikat</b></td>';
		$strhtml .= 		'<td class="tengah1" width=50%><b>Keterangan</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="tengah1"><b>1</b></td>';
		$strhtml .= 		'<td class="tengah1">'.$data4['ekstra1_s'].'</td>';
		$strhtml .= 		'<td class="tengah1">'.$data4['ekstra1_n'].'</td>';
		$strhtml .= 		'<td class="tengah1">'.$data4['ekstra1_d'].'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="tengah1"><b>2</b></td>';
		$strhtml .= 		'<td class="tengah1">'.$data4['ekstra2_s'].'</td>';
		$strhtml .= 		'<td class="tengah1">'.$data4['ekstra2_n'].'</td>';
		$strhtml .= 		'<td class="tengah1">'.$data4['ekstra2_d'].'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		$strhtml .= '<div class="font12">';
		$strhtml .= 	'<b>E. PRESTASI</b><br/>';
		$strhtml .= '</div>';
		$strhtml .= '<table class="rapor">';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1" width=5%><b>No</b></td>';
		$strhtml .= 		'<td class="tengah1" width=30%><b>Jenis Kegiatan</b></td>';
		$strhtml .= 		'<td class="tengah1" width=65%><b>Keterangan</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="tengah1"><b>1</b></td>';
		$strhtml .= 		'<td class="tengah1">'.$data4['prestasi1_j'].'</td>';
		$strhtml .= 		'<td class="tengah1">'.$data4['prestasi1_k'].'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="tengah1"><b>2</b></td>';
		$strhtml .= 		'<td class="tengah1">'.$data4['prestasi2_j'].'</td>';
		$strhtml .= 		'<td class="tengah1">'.$data4['prestasi2_k'].'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		$strhtml .= '<div class="font12">';
		$strhtml .= 	'<b>F. KETIDAKHADIRAN</b><br/>';
		$strhtml .= '</div>';
		$strhtml .= '<table class="rapor" style="width:60%;">';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="kiri2"><b>Sakit</b></td>';
		$strhtml .= 		'<td class="kiri2">:  '.$data4['jml_skt'].'  Hari</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="kiri2"><b>Ijin</b></td>';
		$strhtml .= 		'<td class="kiri2">:  '.$data4['jml_ijn'].'  Hari</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="kiri2"><b>Terlambat</b></td>';
		$strhtml .= 		'<td class="kiri2">:  '.$data4['jml_lmb'].'  Hari</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="kiri2"><b>Tanpa Keterangan</b></td>';
		$strhtml .= 		'<td class="kiri2">:  '.$data4['jml_alp'].'  Hari</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		$strhtml .= '<div class="font12">';
		$strhtml .= 	'<b>G. CATATAN WALI KELAS</b><br/>';
		$strhtml .= '</div>';
		$strhtml .= '<table class="rapor">';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="kiri70">'.$data4['komen_wali'].'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		$strhtml .= '<div class="font12">';
		$strhtml .= 	'<b>H. TANGGAPAN ORANG TUA</b><br/>';
		$strhtml .= '</div>';
		$strhtml .= '<table class="rapor">';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="kiri70">'.$data4['komen_ortu'].'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		$strhtml .= '<table class="rapor">';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="tengah1" style="text-align:center;padding: 10px 0;">';
		$kls = '';
		$klsNext = '';
		if(substr($data4['kelas'], 0, 2) == '10') 
		{			
			$kls = '&nbsp;&nbsp;&nbsp;XI&nbsp;&nbsp;&nbsp;';
			$klsNext = '&nbsp;&nbsp;Sebelas&nbsp;&nbsp;';
		}
		elseif(substr($data4['kelas'], 0, 2) == '11') 
		{			
			$kls = '&nbsp;&nbsp;&nbsp;XII&nbsp;&nbsp;&nbsp;';
			$klsNext = '&nbsp;&nbsp;Duabelas&nbsp;&nbsp;';
		}
		elseif(substr($data4['kelas'], 0, 2) == '12')
		{			
			$kls = '';
			$klsNext = '&nbsp;&nbsp;&nbsp;Lulus&nbsp;&nbsp;&nbsp;';
		}
		if($data4['naikK'] == 1)
			$strhtml .=			'<b>Keterangan Kenaikan Kelas : Naik / <span class="coret">Tidak Naik</span> ke kelas *) <span class="grsBwh">  '.$kls.' </span> (<span class="grsBwh"> '.$klsNext.' </span>)</b>';
		elseif($data4['naikK'] == 2)
			$strhtml .=			'<b>Keterangan Kenaikan Kelas : <span class="coret">Naik</span> / Tidak Naik ke kelas *) <span class="grsBwh">  '.$kls.' </span> (<span class="grsBwh"> '.$klsNext.' </span>)</b>';
		else
			$strhtml .=			'<b>Keterangan Kenaikan Kelas : Naik / Tidak Naik ke kelas *)  ................ ( .......................... )</b>';
		$strhtml .= 		'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		
		return $strhtml;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function halKepsekRapor($nama_kepsek, $nip_kepsek)
	{
		$strhtml  = '';
		$strhtml .= '<table width=100% style="font-size:14px;">';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=40%>&nbsp;</td>';
		$strhtml .= 		'<td width=40%>Mengetahui</td>';
		$strhtml .= 		'<td width=20%>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td>Kepala Sekolah</td>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr><td colspan="3">&nbsp;</td></tr>';
		$strhtml .= 	'<tr><td colspan="3">&nbsp;</td></tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td> <u><b>'.$nama_kepsek.'</b></u> </td>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td> NIP. '.$nip_kepsek.' </td>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		
		return $strhtml;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function hal1Ulangan($data_kkm, $mapel, $data_nilai, $tapel, $semester)
	{
		$strhtml = '<div style="text-align: center">';
		$strhtml .= 	'<h3>NILAI ULANGAN HARIAN</h3><br/>';
		$strhtml .= 	'<h4 style="margin-top:-34px;">Tahun Pelajaran : '.$tapel.' - Semester : '.$semester.'</h4><br/>';
		$strhtml .= '</div>';
		$strhtml .= '<br />';
		$strhtml .= '<br />';
		$strhtml .= '<div class="font12" style="margin-top:-58px;">';
		$strhtml .= 	'<b>A. ULANGAN HARIAN</b><br/>';
		$strhtml .= 	'<b>Kriteria Ketuntasan Minimal = '.$data_kkm['kkm'].'</b><br/>';
		$strhtml .= '</div>';
		$strhtml .= '<table class="rapor">';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td rowspan="2" class="tengah1" width=5%><b>No</b></td>';
		$strhtml .= 		'<td rowspan="2" class="tengah1" width=35%><b>Mata Pelajaran</b></td>';
		$strhtml .= 		'<td colspan="2" class="tengah1" width=12%><b>UH 1</b></td>';
		$strhtml .= 		'<td colspan="2" class="tengah1" width=12%><b>UH 2</b></td>';
		$strhtml .= 		'<td colspan="2" class="tengah1" width=12%><b>UH 3</b></td>';
		$strhtml .= 		'<td colspan="2" class="tengah1" width=12%><b>UH 4</b></td>';
		$strhtml .= 		'<td colspan="2" class="tengah1" width=12%><b>UH 5</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1"><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Pred.</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Pred.</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Pred.</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Pred.</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Pred.</b></td>';
		$strhtml .= 	'</tr>';
			
		for($i = 0; $i < count($mapel); $i++)
		{
			if($i == 0)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="12"><b>Kelompok A (Umum)</b></td>';
				$strhtml .= '</tr>';
			}
			elseif($i == 6)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="12"><b>Kelompok B (Umum)</b></td>';
				$strhtml .= '</tr>';
			}
			elseif($i == 9)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="12"><b>Kelompok C (Peminatan)</b></td>';
				$strhtml .= '</tr>';
			}
			$strhtml .= '<tr class="polos">';
			$strhtml .= 	'<td class="tengah1"><b>'.($i + 1).'</b></td>';
			$strhtml .= 	'<td class="kiri1"><b>'.$mapel[$i].'</b></td>';
			for($k = 0; $k < 5; $k++)
			{
				if(($data_nilai[$i][($k + 2)] == '') or ($data_nilai[$i][($k + 2)] == 0))
				{
					$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
					$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
				}
				else
				{
					if($data_nilai[$i][($k + 2)] < $data_kkm['kkm'])
						$strhtml .= '<td class="tengah1 bgClr"><b>'.$data_nilai[$i][($k + 2)].'</b></td>';
					else
						$strhtml .= '<td class="tengah1"><b>'.$data_nilai[$i][($k + 2)].'</b></td>';
					if(($data_nilai[$i][($k + 2)] >= $data_kkm['pred1_bawah']) and ($data_nilai[$i][($k + 2)] < $data_kkm['pred1_atas']))
						$strhtml .= '<td class="tengah1 bgClr"><b>'.$data_kkm['pred1_nama'].'</b></td>';
					elseif(($data_nilai[$i][($k + 2)] >= $data_kkm['pred2_bawah']) and ($data_nilai[$i][($k + 2)] < $data_kkm['pred2_atas']))
							$strhtml .= '<td class="tengah1"><b>'.$data_kkm['pred2_nama'].'</b></td>';
					elseif(($data_nilai[$i][($k + 2)] >= $data_kkm['pred3_bawah']) and ($data_nilai[$i][($k + 2)] < $data_kkm['pred3_atas']))
						$strhtml .= '<td class="tengah1"><b>'.$data_kkm['pred3_nama'].'</b></td>';
					elseif(($data_nilai[$i][($k + 2)] >= $data_kkm['pred4_bawah']) and ($data_nilai[$i][($k + 2)] < $data_kkm['pred4_atas']))
						$strhtml .= '<td class="tengah1"><b>'.$data_kkm['pred4_nama'].'</b></td>';
					elseif(($data_nilai[$i][($k + 2)] >= $data_kkm['pred5_bawah']) and ($data_nilai[$i][($k + 2)] < $data_kkm['pred5_atas']))
						$strhtml .= '<td class="tengah1"><b>'.$data_kkm['pred5_nama'].'</b></td>';
				}
			}
			$strhtml .= '</tr>';
		}
		
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		$strhtml .= '<br/>';
		return $strhtml;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function hal2Ulangan($data_kkm, $mapel, $data_nilai, $tapel, $semester)
	{
		$strhtml = '<div class="font12">';
		$strhtml .= '<b>B. NILAI TUGAS</b><br/>';
		$strhtml .= '<b>Kriteria Ketuntasan Minimal = '.$data_kkm['kkm'].'</b><br/>';
		$strhtml .= '</div>';
		$strhtml .= '<table class="rapor">';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td rowspan="2" class="tengah1" width=5%><b>No</b></td>';
		$strhtml .= 		'<td rowspan="2" class="tengah1" width=35%><b>Mata Pelajaran</b></td>';
		$strhtml .= 		'<td colspan="2" class="tengah1" width=12%><b>Tugas 1</b></td>';
		$strhtml .= 		'<td colspan="2" class="tengah1" width=12%><b>Tugas 2</b></td>';
		$strhtml .= 		'<td colspan="2" class="tengah1" width=12%><b>Tugas 3</b></td>';
		$strhtml .= 		'<td colspan="2" class="tengah1" width=12%><b>Tugas 4</b></td>';
		$strhtml .= 		'<td colspan="2" class="tengah1" width=12%><b>Tugas 5</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1"><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Pred.</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Pred.</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Pred.</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Pred.</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Pred.</b></td>';
		$strhtml .= 	'</tr>';

		for($i = 0; $i < count($mapel); $i++)
		{
			if($i == 0)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="12"><b>Kelompok A (Umum)</b></td>';
				$strhtml .= '</tr>';
			}
			elseif($i == 6)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="12"><b>Kelompok B (Umum)</b></td>';
				$strhtml .= '</tr>';
			}
			elseif($i == 9)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="12"><b>Kelompok C (Peminatan)</b></td>';
				$strhtml .= '</tr>';
			}
			$strhtml .= '<tr class="polos">';
			$strhtml .= 	'<td class="tengah1"><b>'.($i + 1).'</b></td>';
			$strhtml .= 	'<td class="kiri1"><b>'.$mapel[$i].'</b></td>';
			for($k = 0; $k < 5; $k++)
			{
				if(($data_nilai[$i][($k + 7)] == '') or ($data_nilai[$i][($k + 7)] == 0))
				{
					$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
					$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
				}
				else
				{
					if($data_nilai[$i][($k + 7)] < $data_kkm['kkm'])
						$strhtml .= 	'<td class="tengah1 bgClr"><b>'.$data_nilai[$i][($k + 7)].'</b></td>';
					else
						$strhtml .= 	'<td class="tengah1"><b>'.$data_nilai[$i][($k + 7)].'</b></td>';
					if(($data_nilai[$i][($k + 7)] >= $data_kkm['pred1_bawah']) and ($data_nilai[$i][($k + 7)] < $data_kkm['pred1_atas']))
						$strhtml .= 	'<td class="tengah1 bgClr"><b>'.$data_kkm['pred1_nama'].'</b></td>';
					elseif(($data_nilai[$i][($k + 7)] >= $data_kkm['pred2_bawah']) and ($data_nilai[$i][($k + 7)] < $data_kkm['pred2_atas']))
							$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred2_nama'].'</b></td>';
					elseif(($data_nilai[$i][($k + 7)] >= $data_kkm['pred3_bawah']) and ($data_nilai[$i][($k + 7)] < $data_kkm['pred3_atas']))
						$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred3_nama'].'</b></td>';
					elseif(($data_nilai[$i][($k + 7)] >= $data_kkm['pred4_bawah']) and ($data_nilai[$i][($k + 7)] < $data_kkm['pred4_atas']))
						$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred4_nama'].'</b></td>';
					elseif(($data_nilai[$i][($k + 7)] >= $data_kkm['pred5_bawah']) and ($data_nilai[$i][($k + 7)] < $data_kkm['pred5_atas']))
						$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred5_nama'].'</b></td>';
				}
			}
			$strhtml .= '</tr>';
		}
			
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		$strhtml .= '<br/>';
		return $strhtml;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function hal3Ulangan($data_kkm, $mapel, $data_nilai, $tapel, $semester)
	{
		$strhtml = '<div class="font12">';
		$strhtml .= '<b>B. NILAI UTS dam UAS</b><br/>';
		$strhtml .= '<b>Kriteria Ketuntasan Minimal = '.$data_kkm['kkm'].'</b><br/>';
		$strhtml .= '</div>';
		$strhtml .= '<table class="rapor" style="width: 70%;">';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td rowspan="2" class="tengah1" width=5%><b>No</b></td>';
		$strhtml .= 		'<td rowspan="2" class="tengah1" width=50%><b>Mata Pelajaran</b></td>';
		$strhtml .= 		'<td colspan="2" class="tengah1" width=22%><b>UTS</b></td>';
		$strhtml .= 		'<td colspan="2" class="tengah1" width=22%><b>UAS</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1"><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Pred.</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Nilai</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>Pred.</b></td>';
		$strhtml .= 	'</tr>';

		for($i = 0; $i < count($mapel); $i++)
		{
			if($i == 0)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="6"><b>Kelompok A (Umum)</b></td>';
				$strhtml .= '</tr>';
			}
			elseif($i == 6)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="6"><b>Kelompok B (Umum)</b></td>';
				$strhtml .= '</tr>';
			}
			elseif($i == 9)
			{
				$strhtml .= '<tr class="polos">';
				$strhtml .= 	'<td class="kiri1" colspan="6"><b>Kelompok C (Peminatan)</b></td>';
				$strhtml .= '</tr>';
			}
			$strhtml .= '<tr class="polos">';
			$strhtml .= 	'<td class="tengah1"><b>'.($i + 1).'</b></td>';
			$strhtml .= 	'<td class="kiri1"><b>'.$mapel[$i].'</b></td>';
			if(($data_nilai[$i][12] == '') or ($data_nilai[$i][12] == 0))
			{
				$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
				$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
			}
			else
			{
				if($data_nilai[$i][($k + 12)] < $data_kkm['kkm'])
					$strhtml .= 	'<td class="tengah1 bgClr"><b>'.$data_nilai[$i][($k + 12)].'</b></td>';
				else
					$strhtml .= 	'<td class="tengah1"><b>'.$data_nilai[$i][($k + 12)].'</b></td>';
				if(($data_nilai[$i][($k + 12)] >= $data_kkm['pred1_bawah']) and ($data_nilai[$i][($k + 12)] < $data_kkm['pred1_atas']))
					$strhtml .= 	'<td class="tengah1 bgClr"><b>'.$data_kkm['pred1_nama'].'</b></td>';
				elseif(($data_nilai[$i][12] >= $data_kkm['pred2_bawah']) and ($data_nilai[$i][12] < $data_kkm['pred2_atas']))
					$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred2_nama'].'</b></td>';
				elseif(($data_nilai[$i][12] >= $data_kkm['pred3_bawah']) and ($data_nilai[$i][12] < $data_kkm['pred3_atas']))
					$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred3_nama'].'</b></td>';
				elseif(($data_nilai[$i][12] >= $data_kkm['pred4_bawah']) and ($data_nilai[$i][12] < $data_kkm['pred4_atas']))
					$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred4_nama'].'</b></td>';
				elseif(($data_nilai[$i][12] >= $data_kkm['pred5_bawah']) and ($data_nilai[$i][12] < $data_kkm['pred5_atas']))
					$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred5_nama'].'</b></td>';
			}
			if(($data_nilai[$i][13] == '') or ($data_nilai[$i][13] == 0))
			{
				$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
				$strhtml .= 	'<td class="tengah1"><b>&nbsp;</b></td>';
			}
			else
			{
				if($data_nilai[$i][($k + 13)] < $data_kkm['kkm'])
					$strhtml .= 	'<td class="tengah1 bgClr"><b>'.$data_nilai[$i][($k + 13)].'</b></td>';
				else
					$strhtml .= 	'<td class="tengah1"><b>'.$data_nilai[$i][($k + 13)].'</b></td>';
				if(($data_nilai[$i][($k + 13)] >= $data_kkm['pred1_bawah']) and ($data_nilai[$i][($k + 13)] < $data_kkm['pred1_atas']))
					$strhtml .= 	'<td class="tengah1 bgClr"><b>'.$data_kkm['pred1_nama'].'</b></td>';
				elseif(($data_nilai[$i][13] >= $data_kkm['pred2_bawah']) and ($data_nilai[$i][13] < $data_kkm['pred2_atas']))
						$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred2_nama'].'</b></td>';
				elseif(($data_nilai[$i][13] >= $data_kkm['pred3_bawah']) and ($data_nilai[$i][13] < $data_kkm['pred3_atas']))
					$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred3_nama'].'</b></td>';
				elseif(($data_nilai[$i][13] >= $data_kkm['pred4_bawah']) and ($data_nilai[$i][13] < $data_kkm['pred4_atas']))
					$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred4_nama'].'</b></td>';
				elseif(($data_nilai[$i][13] >= $data_kkm['pred5_bawah']) and ($data_nilai[$i][13] < $data_kkm['pred5_atas']))
					$strhtml .= 	'<td class="tengah1"><b>'.$data_kkm['pred5_nama'].'</b></td>';
			}
			$strhtml .= '</tr>';
		}
		
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		$strhtml .= '<div class="a" style="text-align: center;">';
		$strhtml .= 	'<b>Tabel interval predikat berdasarkan KKM</b>';
		$strhtml .= '</div>';
		$strhtml .= '<table class="rapor" align="center" style="width:80%;">';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1" rowspan="2" width=10%><b>KKM</b></td>';
		if(($data_kkm['pred5_bawah'] > 0) or ($data_kkm['pred5_atas'] > 0))
			$strhtml .= 		'<td class="tengah1" colspan="5" width=90%><b>Predikat</b></td>';
		else
			$strhtml .= 		'<td class="tengah1" colspan="4" width=90%><b>Predikat</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="bgClr">';
		$strhtml .= 		'<td class="tengah1"><b>'.$data_kkm['pred1_nama'].'</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>'.$data_kkm['pred2_nama'].'</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>'.$data_kkm['pred3_nama'].'</b></td>';
		$strhtml .= 		'<td class="tengah1"><b>'.$data_kkm['pred4_nama'].'</b></td>';
		if(($data_kkm['pred5_bawah'] > 0) or ($data_kkm['pred5_atas'] > 0))
			$strhtml .= 		'<td class="tengah1"><b>'.$data_kkm['pred5_nama'].'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr class="polos">';
		$strhtml .= 		'<td class="tengah2"><b>'.$data_kkm['kkm'].'</b></td>';
		$strhtml .= 		'<td class="tengah2"><b>Nilai < '.$data_kkm['pred1_atas'].'</b></td>';
		$strhtml .= 		'<td class="tengah2"><b>'.$data_kkm['pred2_bawah'].' <= Nilai < '.$data_kkm['pred2_atas'].'</b></td>';
		$strhtml .= 		'<td class="tengah2"><b>'.$data_kkm['pred3_bawah'].' <= Nilai < '.$data_kkm['pred3_atas'].'</b></td>';
		if($data_kkm['pred4_atas'] == 100)
			$strhtml .= 		'<td class="tengah2"><b>Nilai >= '.$data_kkm['pred4_bawah'].'</b></td>';
		else
			$strhtml .= 		'<td class="tengah2"><b>'.$data_kkm['pred4_bawah'].' <= Nilai < '.$data_kkm['pred4_atas'].'</b></td>';
		if(($data_kkm['pred5_bawah'] > 0) or ($data_kkm['pred5_atas'] > 0))
		{
			if($data_kkm['pred5_atas'] == 100)
				$strhtml .= 		'<td class="tengah2"><b>Nilai >= '.$data_kkm['pred5_bawah'].'</b></td>';
			else
				$strhtml .= 		'<td class="tengah2"><b>'.$data_kkm['pred5_bawah'].' <= Nilai < '.$data_kkm['pred5_atas'].'</b></td>';
		}
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		return $strhtml;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function halKepsekUlangan($nama_kepsek, $nip_kepsek)
	{
		$strhtml = '<table width=100% style="font-size:14px;margin-top: -70px;">';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=30%>&nbsp;</td>';
		$strhtml .= 		'<td width=40%>Mengetahui</td>';
		$strhtml .= 		'<td width=30%>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td>Kepala Sekolah</td>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr><td colspan="3">&nbsp;</td></tr>';
		$strhtml .= 	'<tr><td colspan="3">&nbsp;</td></tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td> <u><b>'.$nama_kepsek.'</b></u> </td>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td> NIP. '.$nip_kepsek.' </td>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		
		return $strhtml;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	function importDataAll()
	{
		if(isset($_POST['pilih'])) $pilih = $_POST['pilih']; else $pilih = '';
		if(isset($_POST['file']))  $file  = $_POST['file'];  else $file  = '';
		if(isset($_POST['drop']))  $drop  = $_POST['drop'];  else $drop  = '';
		
		$fileName = $_FILES['file']['name'];
		$fileType = $_FILES['file']['type'];
		$fileErr  = $_FILES['file']['error'];
		
		// nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
		$sukses	= 0;
		$gagal	= 0;
		$baris	= '';

		$target1 = './utama/assists/files/excel/upload/'.$fileName;
		$target  = './utama/assists/files/excel/upload/'.$fileName;
		move_uploaded_file($_FILES['file']['tmp_name'], $target);
		
		// mengambil nama Fields
		$kueri1 = '(';
		if(strtolower($pilih) == 'rapor')
			$query = $this->db->select('*')
					->from("tb_nilai")
					->get();
		elseif(strtolower($pilih) == 'admin')
			$query = $this->db->select('*')
					->from("tb_admin")
					->get();
		elseif(strtolower($pilih) == 'siswa')
			$query = $this->db->select('*')
					->from("tb_siswa")
					->get();
		elseif(strtolower($pilih) == 'ulangan')
			$query = $this->db->select('*')
					->from("tb_ulangan")
					->get();
		elseif(strtolower($pilih) == 'wali')
			$query = $this->db->select('*')
					->from("tb_wali")
					->get();
		$field_arr = $query->list_fields();								// Array Nama Fields
		$jml_fields = $query->num_fields();
		//$fieldsName = '(' . implode(", ", $field_arr) . ')';			// Nama Fields
		/*
		for($i=0; $i < $jml_fields; $i++)
		{
			$kueri1 .= $field_arr[$i];
			if($i < ($jml_fields-1))
				$kueri1 .= ', ';
		}
		$kueri1 .= ')';
		*/
		
		//memanggil file excel_reader
		$this->load->library('excel');
		$objReader =PHPExcel_IOFactory::createReader('Excel5');    		// For excel 2003 
		//$objReader= PHPExcel_IOFactory::createReader('Excel2007');	// For excel 2007 	  
		//Set to read only
		$objReader->setReadDataOnly(true);
	
		//Load excel file
		$objPHPExcel=$objReader->load($target1);		 
		$objWorksheet=$objPHPExcel->setActiveSheetIndex(0);                
		$totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();	//Count Number of rows avalable in excel      	 

		// cek kosongkan data
		if($drop = 1)
		{
			// kosongkan tabel Data terlebih dahulu
			if(strtolower($pilih) == 'siswa')
				$truncate = "TRUNCATE TABLE tb_siswa";
			elseif(strtolower($pilih) == 'admin')
				$truncate = "TRUNCATE TABLE tb_admin";
			elseif(strtolower($pilih) == 'rapor')
				$truncate = "TRUNCATE TABLE tb_nilai";
			elseif(strtolower($pilih) == 'ulangan')
				$truncate = "TRUNCATE TABLE tb_ulangan";
			elseif(strtolower($pilih) == 'wali')
				$truncate = "TRUNCATE TABLE tb_wali";
			$sql = $this->db->query($truncate);
		}
		
		//print_r($field_arr);
		//print_r($fieldsName);
		//loop from first data untill last data
		$mulai = 3;
		for($i = $mulai; $i <= $totalrows; $i++)
		{
			$dataImport = array();
			for ($j=0; $j < $jml_fields; $j++)
			{
				$dataIn = $this->db->escape_str($objWorksheet->getCellByColumnAndRow($j,$i)->getValue());
				if($dataIn == NULL) $dataIn = '';
				$dataImport[$field_arr[$j]] = $dataIn;		// Menampung data excel pada array dataImport
			}
			//print_r($dataImport);
			if(strtolower($pilih) == 'siswa')
			{
				if($dataImport["no_ujian_smp"] != '')
				{
					$dataImport["password"] = $this->m_data->encryptIt($dataImport["password"]);
					$this->db->insert('tb_siswa', $dataImport);
					$sukses++;
				}
				else
					$gagal++;
			}
			elseif(strtolower($pilih) == 'admin')
			{
				if($dataImport["username"] != '')
				{
					$dataImport["password"] = $this->m_data->encryptIt($dataImport["password"]);
					$this->db->insert('tb_admin', $dataImport);
					$sukses++;
				}
				else
					$gagal++;
			}
			elseif(strtolower($pilih) == 'rapor')
			{
				if($dataImport["induk"] != '')
				{
					//$dataImport  = array_diff($dataImport, '');		// Menghapus Array yang bernilai kosong
					$dataImport["no"] = '';
					$induk = $dataImport["induk"];
					$tapel = $dataImport["tapel"];
					$semes = $dataImport["semester"];
					$queri = $this->db->select('*')
								->from('tb_nilai')
								->where('induk', $induk)
								->where('tapel', $tapel)
								->where('semester', $semes)
								->get();
					if($queri->num_rows() <= 0)
						$this->db->insert('tb_nilai', $dataImport);
					else
						$this->where('induk', $induk)
							->where('tapel', $tapel)
							->where('semester', $semes)
							->update('tb_nilai', $dataImport);
					$sukses++;
				}
				else
					$gagal++;
			}
			elseif(strtolower($pilih) == 'ulangan')
			{
				if($dataImport["induk"] != '')
				{
					//$dataImport  = array_diff($dataImport, '');
					$dataImport["no"] = '';
					$induk = $dataImport["induk"];
					$tapel = $dataImport["tapel"];
					$semes = $dataImport["semester"];
					$queri = $this->db->select('*')
								->from('tb_ulangan')
								->where('induk', $induk)
								->where('tapel', $tapel)
								->where('semester', $semes)
								->get();
					if($queri->num_rows() <= 0)
						$this->db->insert('tb_ulangan', $dataImport);
					else
						$this->where('induk', $induk)
							->where('tapel', $tapel)
							->where('semester', $semes)
							->update('tb_ulangan', $dataImport);
					$sukses++;
				}
				else
					$gagal++;
			}
			elseif(strtolower($pilih) == 'wali')
			{
				if($dataImport["kd_guru"] != '')
				{
					$dataImport  = array_diff($dataImport, '');
					$queri = $this->db->select('*')
								->from('tb_wali')
								->where('kd_guru', $dataImport["kd_guru"])
								->get();
					if($queri->num_rows() <= 0)
						$this->db->insert('tb_wali', $dataImport);
					else
						$this->where('kd_guru', $dataImport["kd_guru"])->update('tb_wali', $dataImport);
					$sukses++;
				}
				else
					$gagal++;
			}
		}
		
		unlink($target);		//File Deleted After uploading in database
		
		$outp = array();
		$outp[0] = 'sukses';
		$outp[1] = 'Data berhasil diimport : '.$sukses.', gagal : '.$gagal;
		$outp[2] = $baris;
		echo json_encode($outp);
		
		exit;
	}
	
	// ======================================================================================
	// # Fungsi
	// ======================================================================================
	public function exportData()
	{
		date_default_timezone_set("Asia/Jakarta");
		if(isset($_GET['pl'])) 
			$bagian = $this->input->get('pl'); 
		else
			$bagian = $this->input->post('pl');
	
		$bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
						'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
		if(strtolower($bagian) == 'datasiswa') $jdlSheet = 'Data Siswa';
		elseif(strtolower($bagian) == 'presensi') $jdlSheet = 'Presensi';
		elseif(strtolower($bagian) == 'langgar') $jdlSheet = 'Pelanggaran';
		elseif(strtolower($bagian) == 'ulangan') $jdlSheet = 'UH';
		elseif(strtolower($bagian) == 'rapor') $jdlSheet = 'Rapor';
		else $jdlSheet = 'Worksheet';
		
		$namaFile = 'CetakXls.xls';

		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
	
		$styleThickBlackBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
						'color' => array('argb' => 'FF000000'),
									),
				'inside' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('argb' => 'FF000000'),
									),
								),
							);
		$styleThinBlackBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('argb' => 'FF000000'),
									),
				'inside' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('argb' => 'FF000000'),
									),
								),
							);
			
		// Set properties
		$objPHPExcel->getProperties()->setCreator("Yanuar Prijadi")
			->setLastModifiedBy("Yanuar Prijadi")
			->setTitle('SMA Negeri 4 Surabaya')
			->setSubject('Isian Data Siswa')
			->setDescription('Isian Data Siswa')
			->setKeywords("office 2003 openxml php")
			->setCategory("Data result file");
	

		if(strtolower($bagian) == 'datasiswa')					// ================== Bagian Data Siswa =========================
		{
			// ================= Export Data Siswa to Excel =======================
			$objWorkSheet = $objPHPExcel->createSheet(3);
			$objWorkSheet->setTitle("$jdlSheet 2");
			$objWorkSheet = $objPHPExcel->createSheet(4);
			$objWorkSheet->setTitle("$jdlSheet 3");
			$objPHPExcel->getActiveSheet()->setTitle("$jdlSheet 1");
			$objPHPExcel->setActiveSheetIndex(0);
		
			$namaFile  = 'data_siswa_isian.xls';
			$namaTabel = 'tb_siswa';
			$judul = "Data Siswa Isian Data Siswa";
			$kolom = array('No', 'No Ujian SMP', 'Password', 'NISN', 'NIK', 'No. Induk', 'Nama Siswa', 'Th Masuk', 'Kelas', 'Nama Panggilan', 'L/P', 'email', 
						'Kd Tempat Lahir', 'Tgl Lahir', 'Akta', 'indo', 'Kewarganegaraan', 'Anak Ke', 'Jml Sdr Kandung', 'Jml Sdr Tiri', 'Jml Sdr Angkat',
						'Bhs Sehari-hari', 'Alamat', 'RT', 'RW', 'Kode Alamat', 'Kodepos', 'Tlp Rumah', 'Jns Tinggal', 'Gakin', 'Jarak', 'Waktu', 'Kendaraan',
						'Penerima Gakin', 'No. Gakin',
						'Telp HP', 'Gol. Darah', 'Penyakit', 'Kebutuhan Khusus', 'Berat', 'Tinggi', 'Asal SMP', 'No Ijazah', 'Th. Ijazah', 'No. SKHUN',
						'Jml SKHUN', 'Nilai BIN', 'Nilai BIG', 'Nilai MAT', 'Nilai IPA', 'Asal Sekolah', 'Alasan Pindah', 'Tingkat', 'Kelompok', 'Jurusan', 'Tgl Masuk',
						'Nama Ayah', 'NIK', 'Alamat', 'Kode Kota', 'Kd Kota Kelahiran', 'Tgl Lahir', 'indo', 'Kewarganegaraan', 'Pendidikan', 'Pekerjaan', 'Penghasilan',
						'Telp.', 'Msh Hidup', 'Th Meninggal', 
						'Nama Ibu', 'NIK', 'Alamat', 'Kode Kota', 'Kd Kota Kelahiran', 'Tgl Lahir', 'indo', 'Kewarganegaraan', 'Pendidikan', 'Pekerjaan', 'Penghasilan',
						'Telp.', 'Msh Hidup', 'Th Meninggal', 
						'Nama Wali', 'NIK', 'Alamat', 'Kode Kota', 'Kd Kota Kelahiran', 'Tgl Lahir', 'indo', 'Kewarganegaraan', 'Pendidikan', 'Pekerjaan', 'Penghasilan',
						'Telp.', 'Msh Hidup', 'Th Meninggal', 
						'Kesenian', 'Olahraga', 'Organisasi', 'Lain-lain', 'Cita-cita', 'Th Pelajaran', 'Jalur Masuk', 'Th Keluar', 'Alasan Keluar', 'Isi', 'Cetak', 'Status');
			$objPHPExcel->getActiveSheet()->mergeCells('A1:DF1');

			$objPHPExcel->getActiveSheet()->setCellValue('A1', $judul);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
			// Menyusun Nama Field
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Field :');

			$query = $this->db->get($namaTabel);
			$nm_field = $query->list_fields();
			$jml_fields = $query->num_fields();
			for($i=0; $i < $jml_fields; $i++)
			{
				$i1 = $i + 1;
				if($i1 >= 26)
				{
					$kolom1 = chr(ord('A') + floor($i1/26) - 1) . chr(ord('A')+fmod($i1,26)) . '2';
					$objPHPExcel->getActiveSheet()->setCellValue($kolom1, $nm_field[$i]);
				}
				else
					$objPHPExcel->getActiveSheet()->setCellValue(chr(ord('A')+$i1).'2', $nm_field[$i]);
			}
			// Menyusun Header
			$jml_klm = count($kolom);
			for($i=0; $i < $jml_klm; $i++)
			{
				if($i >= 26)
				{
					$kolom1 = chr(ord('A') + floor($i/26) - 1) . chr(ord('A')+fmod($i,26)) . '3';
					$objPHPExcel->getActiveSheet()->setCellValue($kolom1, $kolom[$i]);
				}
				else
					$objPHPExcel->getActiveSheet()->setCellValue(chr(ord('A')+$i).'3', $kolom[$i]);
		
			}
			if($jml_fields >= 26)
			{
				$objPHPExcel->getActiveSheet()->getStyle('A2:'.chr(ord('A')+floor($jml_fields/26)-1).chr(ord('A')+fmod($jml_fields,26)).'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:'.chr(ord('A')+floor($jml_fields/26)-1).chr(ord('A')+fmod($jml_fields,26)).'3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2:'.chr(ord('A')+floor($jml_fields/26)-1).chr(ord('A')+fmod($jml_fields,26)).'3')->applyFromArray($styleThickBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle('A2:'.chr(ord('A')+floor($jml_fields/26)-1).chr(ord('A')+fmod($jml_fields,26)).'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
			}
			else
			{
				$objPHPExcel->getActiveSheet()->getStyle('A2:'.chr(ord('A')+$jml_fields).'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:'.chr(ord('A')+$jml_fields).'3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2:'.chr(ord('A')+$jml_fields).'3')->applyFromArray($styleThickBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle('A2:'.chr(ord('A')+$jml_fields).'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
			}
		
			$xlsRow = 4;
			$nomer = 1;
		
			// Menyusun data dari table
			$this->db->order_by('kelas', 'asc');
			$this->db->order_by('nama', 'asc');
			$query = $this->db->get($namaTabel);
			foreach($query->result_array() as $data)
			{
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $nomer);
				for($i=0; $i < $jml_fields; $i++)
				{
					if($i == 1)
						$objPHPExcel->getActiveSheet()->setCellValue(chr(ord('B')+$i).$xlsRow, $this->m_data->decryptIt($data[($nm_field[$i])]));
					elseif($i >= 25)
						$objPHPExcel->getActiveSheet()->setCellValue(chr(ord('A')+floor(($i+1)/26)-1).chr(ord('A')+fmod(($i+1),26)).$xlsRow, $data[($nm_field[$i])]);
					else
						$objPHPExcel->getActiveSheet()->setCellValue(chr(ord('B')+$i).$xlsRow, $data[($nm_field[$i])]);
				}
				if($jml_fields >= 26)
					$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':'.chr(ord('A')+floor($jml_fields/26)-1).chr(ord('A')+fmod($jml_fields, 26)).$xlsRow)->applyFromArray($styleThinBlackBorderOutline);
				else
					$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':'.chr(ord('A')+$jml_fields).$xlsRow)->applyFromArray($styleThinBlackBorderOutline);
				$nomer++;
				$xlsRow++;
			}
		
			$xlsRow++;
			$xlsRow++;
			for($i=0; $i < $jml_fields; $i++)
			{
				if($i >= 26)
					$objPHPExcel->getActiveSheet()->getColumnDimension(chr(ord('A')+floor($i/26)-1).chr(ord('A')+fmod($i, 26)))->setAutoSize(true);
				else
					$objPHPExcel->getActiveSheet()->getColumnDimension(chr(ord('A')+$i))->setAutoSize(true);
			}
	
		}
		elseif(strtolower($bagian) == 'presensi')					// ================== Presensi =========================
		{
			// =================== Export Presensi to Excel =====================
			$objWorkSheet = $objPHPExcel->createSheet(3);
			$objWorkSheet->setTitle("$jdlSheet 2");
			$objWorkSheet = $objPHPExcel->createSheet(4);
			$objWorkSheet->setTitle("$jdlSheet 3");
			$objPHPExcel->getActiveSheet()->setTitle("$jdlSheet 1");
			$objPHPExcel->setActiveSheetIndex(0);
		
			$semua		= $this->input->get('semua');		// 0 - semua, 1 - kelasPilih, 2 - Siswa
			$kelas		= $this->input->get('kelasPilih');	// '' = semua
			$tglAwal	= $this->input->get('tglCetak1');
			$tglAkhir	= $this->input->get('tglCetak2');
			$detail		= $this->input->get('rekap');		// 0 - list, 1 - rekap
			$induk		= $this->input->get('siswaSel');
			$tglInd		= date("j", strtotime($tglAwal)) . ' ' . $bulan[(date("n", strtotime($tglAwal))-1)] . ' ' . date("Y", strtotime($tglAwal));
			$tglInd1	= date("j", strtotime($tglAkhir)) . ' ' . $bulan[(date("n", strtotime($tglAkhir))-1)] . ' ' . date("Y", strtotime($tglAkhir));
		
			$namaTabel = 'tb_presensi';
			$judul = 'Presensi Siswa - tanggal : '.$tglInd.' s/d '.$tglInd1;
		
			if($semua == 1)
			{
				$query = $this->db->select('*')
							->from('tb_kelas')
							->where('kd_kelas', $kelas)
							->get();
				if($query->num_rows() > 0)
				{
					$row = $query->row();
					$nama_kelas = $row->nama_kelas;
				}
				$nama_siswa = '';
				$namaFile  = 'presensi_'.$kelas.'.xls';
			}
			elseif($semua == 2)
			{
				$query = $this->db->select('*')
							->from('tb_siswa')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
							->where('tb_siswa.no_induk', $induk)
							->get();
				if($query->num_rows() > 0)
				{
					$row = $query->row();
					$nama_siswa = $row->nama;
					$nama_kelas = $row->nama_kelas;
				}
				$namaFile  = 'presensi_'.$induk.'.xls';
			}
			else
			{
				$nama_kelas = '';
				$nama_siswa = '';
				$namaFile  = 'presensi_All.xls';
			}
		
			if($detail == 0)
			{
				$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
				$objPHPExcel->getActiveSheet()->setCellValue('A1', $judul.' (List)');
			}
			else
			{
				$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
				$objPHPExcel->getActiveSheet()->setCellValue('A1', $judul.' (Rekap)');
			}
		
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$xlsRow = 2;
		
			// Menyusun data dari table
			$tanggal = '';
			if($detail == 0)
			{
				// ================== Cetak List =============================
				if($semua == 0)
					$query = $this->db->select('*')
								->from('tb_presensi')
								->join('tb_siswa', 'tb_siswa.no_induk = tb_presensi.induk', 'left')
								->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
								->where('tb_presensi.tanggal >=', $tglAwal)
								->where('tb_presensi.tanggal <=', $tglAkhir)
								->order_by('tb_presensi.tanggal', 'asc')
								->order_by('tb_kelas.kd_kelas', 'asc')
								->order_by('tb_siswa.nama', 'asc')
								->get();
				elseif($semua == 1)
					$query = $this->db->select('*')
								->from('tb_presensi')
								->join('tb_siswa', 'tb_siswa.no_induk = tb_presensi.induk', 'left')
								->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
								->where('tb_presensi.tanggal >=', $tglAwal)
								->where('tb_presensi.tanggal <=', $tglAkhir)
								->where('tb_siswa.kelas', $kelas)
								->order_by('tb_presensi.tanggal', 'asc')
								->order_by('tb_kelas.kd_kelas', 'asc')
								->order_by('tb_siswa.nama', 'asc')
								->get();
				else
					$query = $this->db->select('*')
								->from('tb_presensi')
								->join('tb_siswa', 'tb_siswa.no_induk = tb_presensi.induk', 'left')
								->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
								->where('tb_presensi.tanggal >=', $tglAwal)
								->where('tb_presensi.tanggal <=', $tglAkhir)
								->where('tb_siswa.no_induk', $induk)
								->order_by('tb_presensi.tanggal', 'asc')
								->get();
				$rowcounts = $query->num_rows();
				if($rowcounts > 0)
				{
					foreach($query->result() as $data)
					{
						$tgl = $data->tanggal;
						$nama_siswa = $data->nama;
						if($tgl != $tanggal)
						{
							if($tanggal != '')
								$objPHPExcel->getActiveSheet()->getStyle('A'.$klmAwal.':F'.($xlsRow-1))->applyFromArray($styleThickBlackBorderOutline);
							$tglInd	= date("j", strtotime($tgl)) . ' ' . $bulan[(date("n", strtotime($tgl))-1)] . ' ' . date("Y", strtotime($tgl));
							$xlsRow++;
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, 'Tanggal :');
							$objPHPExcel->getActiveSheet()->mergeCells('A'.$xlsRow.':B'.$xlsRow);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $tglInd);
							if($semua == 0)
								$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, '(Semua Kelas)');
							elseif($semua == 1)
								$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, '('.$nama_kelas.')');
							elseif($semua == 2)
								$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, '('.$nama_siswa.')');
							$objPHPExcel->getActiveSheet()->mergeCells('D'.$xlsRow.':E'.$xlsRow);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':D'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':D'.$xlsRow)->getFont()->setBold(true);
							$xlsRow++;
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, 'No');
							$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, 'Jam');
							$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, 'Kelas');
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, 'Induk');
							$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, 'Nama');
							$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, 'Jenis');
							$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':F'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':F'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':F'.$xlsRow)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':F'.$xlsRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
							$xlsRow++;
							$klmAwal = $xlsRow;
							$nomer = 1;
							$tanggal = $tgl;
						}
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $nomer);
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $data->jam);
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $data->nama_kelas);
						$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $data->induk);
						$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $data->nama);
						$jns = $data->jenis;
						if(strtolower($jns) == 's') $jenis = 'Sakit';
						elseif(strtolower($jns) == 'i') $jenis = 'Ijin';
						elseif(strtolower($jns) == 'a') $jenis = 'Alpha';
						elseif(strtolower($jns) == 't') $jenis = 'Terlambat';
						$objPHPExcel->getActiveSheet()->getStyle('F'.$xlsRow)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $jenis);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':D'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('F'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':F'.$xlsRow)->applyFromArray($styleThinBlackBorderOutline);
						$nomer++;
						$xlsRow++;
					}		
					$objPHPExcel->getActiveSheet()->getStyle('A'.$klmAwal.':F'.($xlsRow-1))->applyFromArray($styleThickBlackBorderOutline);
				}
			}
			else
			{
				// ================== Cetak Rekap =============================
				$nomer = 1;
				if($semua == 0)
					$query = $this->db->select('*')
								->from('tb_presensi')
								->join('tb_siswa', 'tb_siswa.no_induk = tb_presensi.induk', 'left')
								->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
								->where('tb_presensi.tanggal >=', $tglAwal)
								->where('tb_presensi.tanggal <=', $tglAkhir)
								->group_by('tb_presensi.induk')
								->order_by('tb_kelas.kd_kelas', 'asc')
								->order_by('tb_siswa.nama', 'asc')
								->get();
				elseif($semua == 1)
					$query = $this->db->select('*')
								->from('tb_presensi')
								->join('tb_siswa', 'tb_siswa.no_induk = tb_presensi.induk', 'left')
								->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
								->where('tb_presensi.tanggal >=', $tglAwal)
								->where('tb_presensi.tanggal <=', $tglAkhir)
								->where('tb_siswa.kelas', $kelas)
								->group_by('tb_presensi.induk')
								->order_by('tb_kelas.kd_kelas', 'asc')
								->order_by('tb_siswa.nama', 'asc')
								->get();
				elseif($semua == 2)
					$query = $this->db->select('*')
								->from('tb_presensi')
								->join('tb_siswa', 'tb_siswa.no_induk = tb_presensi.induk', 'left')
								->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
								->where('tb_presensi.tanggal >=', $tglAwal)
								->where('tb_presensi.tanggal <=', $tglAkhir)
								->where('tb_siswa.no_induk', $induk)
								->group_by('tb_presensi.induk')
								->get();
				$rowcounts = $query->num_rows();
				if($rowcounts > 0)
				{
					if($semua == 0)
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, '(Semua Kelas)');
					elseif($semua == 1)
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, 'Kelas : '.$nama_kelas);
					elseif($semua == 2)
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, 'Kelas : '.$nama_siswa);
					$objPHPExcel->getActiveSheet()->mergeCells('A'.$xlsRow.':C'.$xlsRow);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow)->getFont()->setBold(true);
					$xlsRow++;
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, 'No');
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, 'Kelas');
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, 'Induk');
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, 'Nama');
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, 'S');
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, 'I');
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, 'A');
					$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, 'T');
					$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':H'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':H'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':H'.$xlsRow)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':H'.$xlsRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
					$xlsRow++;
					$klmAwal = $xlsRow;
					foreach($query->result() as $row)
					{
						$indukPilih = $row->induk;
						$nama       = $row->nama;
						$kelas      = $row->nama_kelas;
						$query1 = $this->db->select('*')
									->from('tb_presensi')
									->where('tanggal >=', $tglAwal)
									->where('tanggal <=', $tglAkhir)
									->where('induk', $indukPilih)
									->get();
						$jmlS = 0;
						$jmlI = 0;
						$jmlA = 0;
						$jmlT = 0;
						foreach($query1->result() as $row1)
						{
							$jns = $row1->jenis;
							if(strtolower($jns) == 's') $jmlS++;
							elseif(strtolower($jns) == 'i') $jmlI++;
							elseif(strtolower($jns) == 'a') $jmlA++;
							elseif(strtolower($jns) == 't') $jmlT++;
						}
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $nomer);
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $kelas);
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $indukPilih);
						$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $nama);
						$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $jmlS);
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $jmlI);
						$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $jmlA);
						$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $jmlT);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':C'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('E'.$xlsRow.':H'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
						$xlsRow++;
						$nomer++;
					}
					$objPHPExcel->getActiveSheet()->getStyle('A'.$klmAwal.':H'.($xlsRow-1))->applyFromArray($styleThickBlackBorderOutline);
				}
			}
			$xlsRow++;
			$xlsRow++;
			for($i=0; $i < 8; $i++)
			{
				$objPHPExcel->getActiveSheet()->getColumnDimension(chr(ord('A')+$i))->setAutoSize(true);
			}
		}
		elseif(strtolower($bagian) == 'langgar')					// ================== Bagian Pelanggaran =========================
		{
			// =================== Export Pelanggaran to Excel =====================
			$objWorkSheet = $objPHPExcel->createSheet(3);
			$objWorkSheet->setTitle("$jdlSheet 2");
			$objWorkSheet = $objPHPExcel->createSheet(4);
			$objWorkSheet->setTitle("$jdlSheet 3");
			$objPHPExcel->getActiveSheet()->setTitle("$jdlSheet 1");
			$objPHPExcel->setActiveSheetIndex(0);
		
			$semua		= $this->input->get('semua');		// 0 - semua, 1 - kelasPilih
			$rekap		= $this->input->get('rekap');
			$kelas		= $this->input->get('kelasPilih');	// '' = semua
			$tglAwal	= $this->input->get('tglCetak1');
			$tglAkhir	= $this->input->get('tglCetak2');
			$siswaSel	= $this->input->get('siswaSel');
			$jenis		= $this->input->get('jenis');		// 0 - semua, 1 - Belum, 2 - Sudah, 3 - Proses
			$tglInd		= date("j", strtotime($tglAwal)) . ' ' . $bulan[(date("n", strtotime($tglAwal))-1)] . ' ' . date("Y", strtotime($tglAwal));
			$tglInd1	= date("j", strtotime($tglAkhir)) . ' ' . $bulan[(date("n", strtotime($tglAkhir))-1)] . ' ' . date("Y", strtotime($tglAkhir));
			if($jenis == 1) $jenisP = 'B';
			elseif($jenis == 2) $jenisP = 'S';
			elseif($jenis == 3) $jenisP = 'P';
		
			if($semua > 0)
			{
				$query = $this->db->select('*')
							->from('tb_kelas')
							->where('kd_kelas', $kelas)
							->get();
				$row = $query->row();
				$nama_kelas = $row->nama_kelas;
			}
			else $nama_kelas = '';
		
			$namaFile  = 'data_pelanggaran_siswa.xls';
			$namaTabel = 'tb_langgar';
			if($semua > 0)
				$judul = 'Pelanggaran Siswa - tanggal : '.$tglInd.'  s/d  '.$tglInd1.' ('.$nama_kelas.')';
			else
				$judul = 'Pelanggaran Siswa - tanggal : '.$tglInd.'  s/d  '.$tglInd1.' (Semua Kelas)';
		
			$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1', $judul);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$xlsRow = 2;
		
			$this->db->join('tb_siswa', 'tb_siswa.no_induk = tb_langgar.induk', 'left')
					->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
					->where('tb_langgar.tanggal >=', $tglAwal)
					->where('tb_langgar.tanggal <=', $tglAkhir);
			if($semua > 0)	$this->db->where('tb_kelas.kd_kelas', $kelas);
			if($jenis > 0) $this->db->where('tb_langgar.statusL', $jenisP);
			$this->db->order_by('tb_langgar.tanggal', 'asc')
					->order_by('tb_kelas.kd_kelas', 'asc')
					->order_by('tb_siswa.nama', 'asc');
			$query = $this->db->get('tb_langgar');
			$rowcounts = $query->num_rows();
			if($rowcounts > 0)
			{
				$tanggal = '';
				foreach($query->result() as $data)
				{
					$tgl = $data->tanggal;
					if($tgl != $tanggal)
					{
						if($tanggal != '')
							$objPHPExcel->getActiveSheet()->getStyle('A'.$klmAwal.':J'.($xlsRow-1))->applyFromArray($styleThickBlackBorderOutline);
						$tglInd = date("j", strtotime($tgl)) . ' ' . $bulan[(date("n", strtotime($tgl))-1)] . ' ' . date("Y", strtotime($tgl));
						$xlsRow++;
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, 'Tanggal :');
						$objPHPExcel->getActiveSheet()->mergeCells('A'.$xlsRow.':B'.$xlsRow);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $tglInd);
						if($jenis == 0)
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, '(Semua Pelanggaran)');
						elseif($jenis == 1)
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, '(Belum ditangani)');
						elseif($jenis == 2)
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, '(Sudah ditangani)');
						elseif($jenis == 3)
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, '(Proses penanganan)');
						$objPHPExcel->getActiveSheet()->mergeCells('D'.$xlsRow.':E'.$xlsRow);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':D'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':D'.$xlsRow)->getFont()->setBold(true);
						$xlsRow++;
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, 'No');
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, 'Tanggal');
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, 'Kelas');
						$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, 'Induk');
						$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, 'Nama');
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, 'Pelanggaran');
						$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, 'Tgl Penanganan');
						$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, 'Oleh');
						$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, 'Penanganan');
						$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, 'Status');
						$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':J'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':J'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':J'.$xlsRow)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':J'.$xlsRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
						$xlsRow++;
						$klmAwal = $xlsRow;
						$nomer = 1;
						$tanggal = $tgl;
					}
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $nomer);
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $data->tanggal);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $data->nama_kelas);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $data->induk);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $data->nama);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $data->masalah);
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $data->tangani);
					$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $data->oleh);
					$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $data->solusi);
					$jns = $data->statusL;
					if(strtolower($jns) == 'b') $jenis = 'Belum';
					elseif(strtolower($jns) == 's') $jenis = 'Sudah';
					elseif(strtolower($jns) == 'p') $jenis = 'Proses';
					$objPHPExcel->getActiveSheet()->getStyle('J'.$xlsRow)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $jenis);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':D'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('K'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$xlsRow.':J'.$xlsRow)->applyFromArray($styleThinBlackBorderOutline);
					$nomer++;
					$xlsRow++;
				}		
				$objPHPExcel->getActiveSheet()->getStyle('A'.$klmAwal.':J'.($xlsRow-1))->applyFromArray($styleThickBlackBorderOutline);
			}
			$xlsRow++;
			$xlsRow++;
			for($i=0; $i < 10; $i++)
			{
				$objPHPExcel->getActiveSheet()->getColumnDimension(chr(ord('A')+$i))->setAutoSize(true);
			}
		}
		elseif(strtolower($bagian) == 'rapor')						// ================== Bagian Rapor =========================
		{
			// =================== Export Nilai Rapor to Excel =====================
			$objWorkSheet = $objPHPExcel->createSheet(3);
			$objWorkSheet->setTitle("Rapor 2");
			$objWorkSheet = $objPHPExcel->createSheet(4);
			$objWorkSheet->setTitle("Rapor 3");
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setTitle("Rapor 1");
			
			$semua    = $this->input->post('semua');
			$tapel    = $this->input->post('tapelSel');
			$semes    = $this->input->post('semesSel');
			$kelas    = $this->input->post('kelasPilih');
			$induk    = $this->input->post('siswaSel');
			
			$namaFile  = 'data_rapor_siswa.xls';
			$namaTabel = 'tb_nilai';
			$judul = "Nilai Rapor";
			
			$objPHPExcel->getActiveSheet()->mergeCells('A1:CH1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1', $judul);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
			// ================ Menyusun Header =====================
			$kolom = array('No', 'Tapel', 'Semester', 'Kelas', 'Induk', 'Nama');
			$jml_klm = count($kolom);
			for($i=0; $i < count($kolom); $i++)
			{
				$objPHPExcel->getActiveSheet()->setCellValue(chr(ord('A')+$i).'2', $kolom[$i]);
				$objPHPExcel->getActiveSheet()->mergeCells(chr(ord('A')+$i).'2:'.chr(ord('A')+$i).'3');
				$objPHPExcel->getActiveSheet()->getStyle(chr(ord('A')+$i).'2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle(chr(ord('A')+$i).'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle(chr(ord('A')+$i).'2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle(chr(ord('A')+$i).'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
				$objPHPExcel->getActiveSheet()->getStyle(chr(ord('A')+$i).'2:'.chr(ord('A')+$i).'3')->applyFromArray($styleThickBlackBorderOutline);
			}
			$kolom = array('Pendidikan Agama dan Budi Pekerti', 'Pendidikan Pancasila dan Kewarganegaraan', 'Bahasa Indonesia',
							'Matematika (Umum)', 'Sejarah Indonesia', 'Bahasa Inggris', 'Seni Budaya',
							'Pendidikan Jasmani, Olahraga dan Kesehatan', 'Prakarya dan Kewirausahaan', 
							'Biologi / Geografi', 'Fisika / Ekonomi', 'Kimia / Sosiologi');
			for($i = $jml_klm; $i < (count($kolom) + $jml_klm); $i++)
			{
				$k = ($i - $jml_klm) * 4 + $jml_klm;
				for($l = 0; $l < 4; $l++)
				{
					$j = $k + $l;
					if($j >= 26)
						$kolom1 = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
					else
						$kolom1 = chr(ord('A')+$j);
					if($l == 0)
					{
						$objPHPExcel->getActiveSheet()->setCellValue($kolom1.'2', $kolom[($i-$jml_klm)]);
						$objPHPExcel->getActiveSheet()->setCellValue($kolom1.'3', 'Nilai Pengetahuan');
					}
					elseif($l == 2)
						$objPHPExcel->getActiveSheet()->setCellValue($kolom1.'3', 'Nilai Ketrampilan');
					else
						$objPHPExcel->getActiveSheet()->setCellValue($kolom1.'3', 'Diskripsi');
				}
				if($k >= 26)
					$kolom1 = chr(ord('A') + floor($k/26) - 1) . chr(ord('A')+fmod($k, 26));
				else
					$kolom1 = chr(ord('A') + $k);
				if(($k + 3) >= 26)
					$kolom2 = chr(ord('A') + floor(($k + 3)/26) - 1) . chr(ord('A')+fmod(($k + 3), 26));
				else
					$kolom2 = chr(ord('A') + $k + 3);
				$objPHPExcel->getActiveSheet()->mergeCells($kolom1.'2:'.$kolom2.'2');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2:'.$kolom2.'2')->applyFromArray($styleThickBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->applyFromArray($styleThickBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			$jml_klm += count($kolom) * 4;
			$kolom = array('Peminatan I', 'Peminatan II', 'Lintas Minat');
			for($i = $jml_klm; $i < (count($kolom) + $jml_klm); $i++)
			{
				$k = ($i - $jml_klm) * 5 + $jml_klm;
				for($l = 0; $l < 5; $l++)
				{
					$j = $k + $l;
					if($j >= 26)
						$kolom1 = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
					else
						$kolom1 = chr(ord('A')+$j);
					if($l == 0)
					{
						$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'2'), $kolom[($i-$jml_klm)]);
						$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'3'), 'Mapel');
					}
					elseif($l == 1)
						$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'3'), 'Nilai Pengetahuan');
					elseif($l == 3)
						$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'3'), 'Nilai Ketrampilan');
					else
						$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'3'), 'Diskripsi');
				}
				if($k >= 26)
					$kolom1 = chr(ord('A') + floor($k/26) - 1) . chr(ord('A')+fmod($k, 26));
				else
					$kolom1 = chr(ord('A') + $k);
				if(($k + 4) >= 26)
					$kolom2 = chr(ord('A') + floor(($k + 4)/26) - 1) . chr(ord('A')+fmod(($k + 4), 26));
				else
					$kolom2 = chr(ord('A') + $k + 4);
				$objPHPExcel->getActiveSheet()->mergeCells($kolom1.'2:'.$kolom2.'2');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2:'.$kolom2.'2')->applyFromArray($styleThickBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->applyFromArray($styleThickBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			$jml_klm += count($kolom) * 5;
			$kolom = array('Ekstrakurikuler I', 'Ekstrakurikuler II');
			for($i = $jml_klm; $i < (count($kolom) + $jml_klm); $i++)
			{
				$k = ($i - $jml_klm) * 3 + $jml_klm;
				for($l = 0; $l < 3; $l++)
				{
					$j = $k + $l;
					if($j >= 26)
						$kolom1 = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
					else
						$kolom1 = chr(ord('A')+$j);
					if($l == 0)
					{
						$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'2'), $kolom[($i-$jml_klm)]);
						$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'3'), 'Nama');
					}
					elseif($l == 1)
							$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'3'), 'Nilai');
					else
						$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'3'), 'Diskripsi');
				}
				if($k >= 26)
					$kolom1 = chr(ord('A') + floor($k/26) - 1) . chr(ord('A')+fmod($k, 26));
				else
					$kolom1 = chr(ord('A') + $k);
				if(($k + 2) >= 26)
					$kolom2 = chr(ord('A') + floor(($k + 2)/26) - 1) . chr(ord('A')+fmod(($k + 2), 26));
				else
					$kolom2 = chr(ord('A') + $k + 2);
				$objPHPExcel->getActiveSheet()->mergeCells($kolom1.'2:'.$kolom2.'2');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2:'.$kolom2.'2')->applyFromArray($styleThickBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->applyFromArray($styleThickBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			$jml_klm += count($kolom) * 3;
			$kolom = array('Spiritual', 'Sosial', 'Prestasi I', 'Prestasi II');
			for($i = $jml_klm; $i < (count($kolom) + $jml_klm); $i++)
			{
				$k = ($i - $jml_klm) * 2 + $jml_klm;
				for($l = 0; $l < 2; $l++)
				{
					$j = $k + $l;
					if($j >= 26)
						$kolom1 = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
					else
						$kolom1 = chr(ord('A')+$j);
					if($l == 0)
					{
						$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'2'), $kolom[($i-$jml_klm)]);
						if($i < ($jml_klm + 2))
							$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'3'), 'Predikat');
						else
							$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'3'), 'Jenis');
					}
					else
					{
						if($i < ($jml_klm + 2))
							$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'3'), 'Diskripsi');
						else
							$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'3'), 'Kegiatan');
					}
				}
				if($k >= 26)
					$kolom1 = chr(ord('A') + floor($k/26) - 1) . chr(ord('A')+fmod($k, 26));
				else
					$kolom1 = chr(ord('A') + $k);
				if(($k + 1) >= 26)
					$kolom2 = chr(ord('A') + floor(($k + 1)/26) - 1) . chr(ord('A')+fmod(($k + 1), 26));
				else
					$kolom2 = chr(ord('A') + $k + 1);
				$objPHPExcel->getActiveSheet()->mergeCells($kolom1.'2:'.$kolom2.'2');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2:'.$kolom2.'2')->applyFromArray($styleThickBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->applyFromArray($styleThickBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'3:'.$kolom2.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			$jml_klm += count($kolom) * 2;
			$urut = 0;
			$kolom = array('Catatan Walikelas', 'Tanggapan Orang Tua', 'Naik Kelas');
			for($i = $jml_klm; $i < (count($kolom) + $jml_klm); $i++)
			{
				$j = $i + $urut;
				if($j >= 26)
					$kolom1 = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
				else
					$kolom1 = chr(ord('A')+$j);
				$objPHPExcel->getActiveSheet()->setCellValue(($kolom1.'2'), $kolom[($i-$jml_klm)]);
				$objPHPExcel->getActiveSheet()->mergeCells($kolom1.'2:'.$kolom1.'3');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($kolom1.'2:'.$kolom1.'3')->applyFromArray($styleThickBlackBorderOutline);
			}
			
			$jml_klm += count($kolom);
			$xlsRow = 4;
			$nomer  = 1;
			if($semua == 0)
				$query = $this->db->select('*')
							->from('tb_nilai')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_nilai.induk', 'left')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
							->where('tapel', $tapel)
							->where('semester', $semes)
							->order_by('tapel', 'asc')
							->order_by('semester', 'asc')
							->order_by('tb_kelas.kd_kelas', 'asc')
							->order_by('tb_siswa.nama', 'asc')
							->get();
			elseif($semua == 1)
				$query = $this->db->select('*')
							->from('tb_nilai')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_nilai.induk', 'left')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
							->where('tapel', $tapel)
							->where('semester', $semes)
							->where('tb_kelas.kd_kelas', $kelas)
							->order_by('tapel', 'asc')
							->order_by('semester', 'asc')
							->order_by('tb_siswa.nama', 'asc')
							->get();
			else
				$query = $this->db->select('*')
							->from('tb_nilai')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_nilai.induk', 'left')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
							->where('tapel', $tapel)
							->where('semester', $semes)
							->where('induk', $induk)
							->order_by('tapel', 'asc')
							->order_by('semester', 'asc')
							->get();
			foreach($query->result() as $row)
			{
				$noRec = $row->no;
				$data_nilai = array();
				$mapel = array();
				$data4 = array();
				list($data_nilai, $mapel, $data4) = $this->ambilDataRapor($noRec);
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $nomer);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $data4['tapelS']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $data4['semes']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $data4['nama_kelas']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $data4['no_induk']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $data4['nama']);
				// ============= Cetak Nilai Umum ===========
				$data1 = array('agama', 'pkn', 'indo', 'matwaj', 'sejind', 'inggris', 'senbud',
								'penjas', 'pkwu', 'biogeo', 'fiseko', 'kimsos', 'minat1', 'minat2', 'lintas');
				$kolomKe = 6;
				for($i = 0; $i < count($data1); $i++)
				{
					$nama1 = $data1[$i];
					$key = array_search($nama1, array_column($data_nilai, '1'));
					if($kolomKe >= 26)
						$kolom1 = chr(ord('A') + floor($kolomKe/26) - 1) . chr(ord('A')+fmod($kolomKe,26));
					else
						$kolom1 = chr(ord('A')+$kolomKe);
					$klmAwal = $kolom1;
					for($j = 0; $j < 4; $j++)
					{
						if(($j == 0) and ($i > 11))
						{
							if($kolomKe >= 26)
								$kolom1 = chr(ord('A') + floor($kolomKe/26) - 1) . chr(ord('A')+fmod($kolomKe,26));
							else
								$kolom1 = chr(ord('A')+$kolomKe);
							$objPHPExcel->getActiveSheet()->setCellValue($kolom1.$xlsRow, $data4[$nama1]);
							$kolomKe++;
						}
						if($kolomKe >= 26)
							$kolom1 = chr(ord('A') + floor($kolomKe/26) - 1) . chr(ord('A')+fmod($kolomKe,26));
						else
							$kolom1 = chr(ord('A')+$kolomKe);
						$objPHPExcel->getActiveSheet()->setCellValue($kolom1.$xlsRow, $data_nilai[$key][($j + 2)]);
						$kolomKe++;
					}
				}
				// ============= Cetak Nilai Khusus ===========
				$data2 = array(
								'ekstra1_s', 'ekstra1_n', 'ekstra1_d', 
								'ekstra2_s', 'ekstra2_n', 'ekstra2_d', 
								'spiritual_p', 'spiritual_d', 
								'sosial_p', 'sosial_d',
								'prestasi1_j', 'prestasi1_k',
								'prestasi2_j', 'prestasi2_k'
							);
				for($i = 0; $i < count($data2); $i++)
				{
					$nama1 = $data2[$i];
					if($kolomKe >= 26)
						$kolom1 = chr(ord('A') + floor($kolomKe/26) - 1) . chr(ord('A')+fmod($kolomKe,26));
					else
						$kolom1 = chr(ord('A')+$kolomKe);
					$objPHPExcel->getActiveSheet()->setCellValue($kolom1.$xlsRow, $data4[$nama1]);
					$kolomKe++;
				}
				
				// ============= Cetak Nilai Khusus ===========
				$data3 = array('komen_wali', 'komen_ortu', 'naikK');
				for($i = 0; $i < count($data3); $i++)
				{
					$nama1 = $data3[$i];
					if($kolomKe >= 26)
						$kolom1 = chr(ord('A') + floor($kolomKe/26) - 1) . chr(ord('A')+fmod($kolomKe,26));
					else
						$kolom1 = chr(ord('A')+$kolomKe);
					$objPHPExcel->getActiveSheet()->setCellValue($kolom1.$xlsRow, $data4[$nama1]);
					$kolomKe++;
				}
				
				$xlsRow++;
				$nomer++;
			}
			
			$xlsRow--;
			// ============ Format Cell Nilai Umum ==============================
			for($i = 0; $i < count($data1); $i++)
			{
				if($i > 11)
				{
					$j = $i * 5 - 6;
					if($j >= 26)
						$klmAwal = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
					else
						$klmAwal = chr(ord('A')+$j);
					$j += 4;
					if($j >= 26)
						$klmAkhir = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
					else
						$klmAkhir = chr(ord('A')+$j);
				}
				else
				{
					$j = $i * 4 + 6;
					if($j >= 26)
						$klmAwal = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
					else
						$klmAwal = chr(ord('A')+$j);
					$j += 3;
					if($j >= 26)
						$klmAkhir = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
					else
						$klmAkhir = chr(ord('A')+$j);
				}
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAkhir.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
				if(fmod($i , 2) == 0)
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAkhir.$xlsRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('20C0E0');
				if($i > 11)
				{
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAwal.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAwal.$xlsRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAwal.$xlsRow)->getFont()->setBold(true);
				}
			}
			// ============ Format Cell Nilai Khusus ==============================
			$kolomKe = count($data1) * 4 + 9;		// 6 dari nomer - nama, 3 dari nama Peminatan dan Lintas Minat
			for($i = 0; $i < 6; $i++)
			{
				$klmAwal = chr(ord('A') + floor($kolomKe/26) - 1) . chr(ord('A')+fmod($kolomKe,26));
				if($i < 2)
					$j = $kolomKe + 2;
				else
					$j = $kolomKe + 1;
				$klmAkhir =  chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
				$kolomKe = $j + 1;
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAkhir.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
				if(fmod($i , 2) == 1)
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAkhir.$xlsRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('20C0E0');
				if($i < 2)
				{
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAwal.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAwal.$xlsRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAwal.$xlsRow)->getFont()->setBold(true);
				}
			}
			// ============ Format Cell Catatan Khusus ==============================
			$kolomKe = count($data1) * 4 + count($data2) * 2 - 5;
			for($i = 0; $i < 3; $i++)
			{
				$klmAwal = chr(ord('A') + floor($kolomKe/26) - 1) . chr(ord('A')+fmod($kolomKe,26));
				$klmAkhir =  $klmAwal;
				$kolomKe++;
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAkhir.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
				if(fmod($i , 2) == 1)
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAkhir.$xlsRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('20C0E0');
				if($i < 2)
				{
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAwal.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAwal.$xlsRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAwal.$xlsRow)->getFont()->setBold(true);
				}
			}

			$objPHPExcel->getActiveSheet()->getStyle('A4:A'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
			$objPHPExcel->getActiveSheet()->getStyle('B4:B'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
			$objPHPExcel->getActiveSheet()->getStyle('C4:C'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
			$objPHPExcel->getActiveSheet()->getStyle('D4:D'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
			$objPHPExcel->getActiveSheet()->getStyle('E4:E'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
			$objPHPExcel->getActiveSheet()->getStyle('F4:F'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
			$objPHPExcel->getActiveSheet()->getStyle('A4:E'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A4:F'.$xlsRow)->getFont()->setBold(true);
			
		}
		elseif(strtolower($bagian) == 'ulangan')						// ================== Bagian Ulangan Harian =========================
		{
			// =================== Export Nilai UH to Excel =====================
			$objWorkSheet = $objPHPExcel->createSheet(3);
			$objWorkSheet->setTitle("Ulangan 2");
			$objWorkSheet = $objPHPExcel->createSheet(4);
			$objWorkSheet->setTitle("Ulangan 3");
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setTitle("Ulangan 1");
			
			$semua    = $this->input->post('semua');
			$tapel    = $this->input->post('tapelSel');
			$semes    = $this->input->post('semesSel');
			$kelas    = $this->input->post('kelasPilih');
			$induk    = $this->input->post('siswaSel');
			
			$namaFile  = 'data_ulangan_siswa.xls';
			$namaTabel = 'tb_ulangan';
			$judul = "Nilai Ulangan Harian, Tugas, UTS dan UAS";
			
			$objPHPExcel->getActiveSheet()->mergeCells('A1:GD1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1', $judul);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
			// ================ Menyusun Header =====================
			$kolom = array('No', 'Tapel', 'Semester', 'Kelas', 'Induk', 'Nama');
			$jml_klm = count($kolom);
			for($i=0; $i < count($kolom); $i++)
			{
				$objPHPExcel->getActiveSheet()->setCellValue(chr(ord('A')+$i).'2', $kolom[$i]);
				$objPHPExcel->getActiveSheet()->mergeCells(chr(ord('A')+$i).'2:'.chr(ord('A')+$i).'3');
				$objPHPExcel->getActiveSheet()->getStyle(chr(ord('A')+$i).'2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle(chr(ord('A')+$i).'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle(chr(ord('A')+$i).'2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle(chr(ord('A')+$i).'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
				$objPHPExcel->getActiveSheet()->getStyle(chr(ord('A')+$i).'2:'.chr(ord('A')+$i).'3')->applyFromArray($styleThickBlackBorderOutline);
			}
			$mapel1 = array('Pendidikan Agama dan Budi Pekerti', 'Pendidikan Pancasila dan Kewarganegaraan', 'Bahasa Indonesia',
							'Matematika (Umum)', 'Sejarah Indonesia', 'Bahasa Inggris', 'Seni Budaya',
							'Pendidikan Jasmani, Olahraga dan Kesehatan', 'Prakarya dan Kewirausahaan', 
							'Biologi / Geografi', 'Fisika / Ekonomi', 'Kimia / Sosiologi',
							'Peminatan I', 'Peminatan II', 'Lintas Minat');
			$kolomKe = 6;
			for($i = 0; $i < count($mapel1); $i++)
			{
				$j = $i * 12 + 6;
				if($j >= 26)
					$klmAwal = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
				else
					$klmAwal = chr(ord('A')+$j);
				$j = ($i + 1) * 12 + 5;
				if($j >= 26)
					$klmAkhir = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
				else
					$klmAkhir = chr(ord('A')+$j);
				// ==== Cetak Header Mata Pelajaran ======
				$objPHPExcel->getActiveSheet()->setCellValue($klmAwal.'2', $mapel1[$i]);
				$objPHPExcel->getActiveSheet()->mergeCells($klmAwal.'2:'.$klmAkhir.'2');
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				if(fmod($i, 2) == 1)
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'2:'.$klmAkhir.'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
				else
					$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'2:'.$klmAkhir.'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('20C0E0');
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'2:'.$klmAkhir.'2')->applyFromArray($styleThickBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'3:'.$klmAkhir.'3')->applyFromArray($styleThickBlackBorderOutline);
				// ==== Cetak Header UH, Tugas, UTS dan UAS ======
				for($k = 0; $k < 3; $k++)
				{
					for($l = 0; $l < 5; $l++)
					{
						if(($k < 2) or (($k == 2) and ($l < 2)))
						{
							if($kolomKe >= 26)
								$klmAwal = chr(ord('A') + floor($kolomKe/26) - 1) . chr(ord('A')+fmod($kolomKe,26));
							else
								$klmAwal = chr(ord('A')+$kolomKe);
							$kolomKe++;
							if($k == 0)
								$objPHPExcel->getActiveSheet()->setCellValue($klmAwal.'3', 'UH '.($l+1));
							elseif($k == 1)
								$objPHPExcel->getActiveSheet()->setCellValue($klmAwal.'3', 'TGS '.($l+1));
							else
							{
								if($l == 0)
									$objPHPExcel->getActiveSheet()->setCellValue($klmAwal.'3', 'UTS');
								else
									$objPHPExcel->getActiveSheet()->setCellValue($klmAwal.'3', 'UAS');
							}
							$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'3')->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						}
					}
				}
				// ============== UH ==============
				$j = $i * 12 + 6;
				if($j >= 26)
					$klmAwal = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
				else
					$klmAwal = chr(ord('A')+$j);
				$j = $i * 12 + 10;
				if($j >= 26)
					$klmAkhir = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
				else
					$klmAkhir = chr(ord('A')+$j);
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'3:'.$klmAkhir.'3')->applyFromArray($styleThickBlackBorderOutline);
				//=============== Tugas ====================
				$j = $i * 12 + 11;
				if($j >= 26)
					$klmAwal = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
				else
					$klmAwal = chr(ord('A')+$j);
				$j = ($i + 1) * 12 + 3;
				if($j >= 26)
					$klmAkhir = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
				else
					$klmAkhir = chr(ord('A')+$j);
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'3:'.$klmAkhir.'3')->applyFromArray($styleThickBlackBorderOutline);
				//========================
				$j = ($i + 1) * 12 + 4;
				if($j >= 26)
					$klmAwal = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
				else
					$klmAwal = chr(ord('A')+$j);
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'3:'.$klmAwal.'3')->applyFromArray($styleThickBlackBorderOutline);
				$j ++;
				if($j >= 26)
					$klmAwal = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
				else
					$klmAwal = chr(ord('A')+$j);
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'3:'.$klmAwal.'3')->applyFromArray($styleThickBlackBorderOutline);
			}
				// ===================== Cetak Data Nilai Ulangan Harian ===========================
			$xlsRow = 4;
			$nomer  = 1;
			if($semua == 0)
				$query = $this->db->select('*')
							->from('tb_ulangan')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_ulangan.induk', 'left')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
							->where('tapel', $tapel)
							->where('semester', $semes)
							->order_by('tapel', 'asc')
							->order_by('semester', 'asc')
							->order_by('tb_kelas.kd_kelas', 'asc')
							->order_by('tb_siswa.nama', 'asc')
							->get();
			elseif($semua == 1)
				$query = $this->db->select('*')
							->from('tb_ulangan')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_ulangan.induk', 'left')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
							->where('tapel', $tapel)
							->where('semester', $semes)
							->where('tb_kelas.kd_kelas', $kelas)
							->order_by('tapel', 'asc')
							->order_by('semester', 'asc')
							->order_by('tb_siswa.nama', 'asc')
							->get();
			else
				$query = $this->db->select('*')
							->from('tb_ulangan')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_ulangan.induk', 'left')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
							->where('tapel', $tapel)
							->where('semester', $semes)
							->where('induk', $induk)
							->order_by('tapel', 'asc')
							->order_by('semester', 'asc')
							->get();
			foreach($query->result() as $row)
			{
				$noRec = $row->no;
				$data_nilai = array();
				$mapel = array();
				$data4 = array();
				list($data_nilai, $mapel, $data4) = $this->ambilDataUlangan($noRec);
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $nomer);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $data4['tapelS']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $data4['semes']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $data4['nama_kelas']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $data4['no_induk']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $data4['nama']);
				
				$data1 = array('agama',	'pkn', 'indo', 'mat', 'sej','ingg', 'senbud','penjas', 
								'pkwu', 'biogeo', 'fiseko', 'kimsos', 'minat1', 'lintas');
				if($data4['minat2_s'] != '')
				{
					$minat = 'minat2';
					array_splice($data1, 13, 0, $minat);
				}
				$kolomKe = 6;
				for($i = 0; $i < count($data1); $i++)
				{
					$nama1 = $data1[$i];
					$key = array_search($nama1, array_column($data_nilai, '1'));
					$nilaiKe = 2;
					for($k = 0; $k < 3; $k++)
					{
						for($l = 0; $l < 5; $l++)
						{
							if(($k < 2) or (($k == 2) and ($l < 2)))
							{
								if($kolomKe >= 26)
									$klmAwal = chr(ord('A') + floor($kolomKe/26) - 1) . chr(ord('A')+fmod($kolomKe,26));
								else
									$klmAwal = chr(ord('A')+$kolomKe);
								if($data_nilai[$key][$nilaiKe] > 0)
									$objPHPExcel->getActiveSheet()->setCellValue($klmAwal.$xlsRow, $data_nilai[$key][$nilaiKe]);
								$objPHPExcel->getActiveSheet()->getStyle($klmAwal.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								$kolomKe++;
								$nilaiKe++;
							}
						}
					}
				}
				$nomer++;
				$xlsRow++;
			}
		}
		$xlsRow--;
		$kolomKe = 6;
		for($i = 0; $i < count($data1); $i++)
		{
			for($j = 0; $j < 2; $j++)
			{
				if($kolomKe >= 26)
					$klmAwal = chr(ord('A') + floor($kolomKe/26) - 1) . chr(ord('A')+fmod($kolomKe,26));
				else
					$klmAwal = chr(ord('A')+$kolomKe);
				$kolomKe += 4;
				if($kolomKe >= 26)
					$klmAkhir = chr(ord('A') + floor($kolomKe/26) - 1) . chr(ord('A')+fmod($kolomKe,26));
				else
					$klmAkhir = chr(ord('A')+$kolomKe);
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAkhir.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
				$kolomKe++;
			}
			for($j = 0; $j < 2; $j++)
			{
				if($kolomKe >= 26)
					$klmAwal = chr(ord('A') + floor($kolomKe/26) - 1) . chr(ord('A')+fmod($kolomKe,26));
				else
					$klmAwal = chr(ord('A')+$kolomKe);
				$klmAkhir = $klmAwal;
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAkhir.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
				$kolomKe++;
			}
			$j = $i * 12 + 6;
			if($j >= 26)
				$klmAwal = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
			else
				$klmAwal = chr(ord('A')+$j);
			$j = ($i + 1) * 12 + 5;
			if($j >= 26)
				$klmAkhir = chr(ord('A') + floor($j/26) - 1) . chr(ord('A')+fmod($j,26));
			else
				$klmAkhir = chr(ord('A')+$j);
			if(fmod($i, 2) == 0)
				$objPHPExcel->getActiveSheet()->getStyle($klmAwal.'4:'.$klmAkhir.$xlsRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('20C0E0');
		}
	
		$objPHPExcel->getActiveSheet()->getStyle('A4:A'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('B4:B'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('C4:C'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('D4:D'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('E4:E'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('F4:F'.$xlsRow)->applyFromArray($styleThickBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('A4:E'.$xlsRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A4:F'.$xlsRow)->getFont()->setBold(true);
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename='.$namaFile);
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');	
		
		exit;
	}
	// ======================================================================================
	// # Fungsi cetak Data Siswa PDF
	// ======================================================================================
	public function cetakDataPDF()
	{
		date_default_timezone_set("Asia/Jakarta");
		
		$level    = $this->session->userdata('level');
		$dataKu = array();
		if($level > 95) 
			$no_ujian_smp = $this->m_data->decryptIt($this->input->get('id'));
		else
		{
			$no_ujian_smp = $this->session->userdata('username');
			$query = $this->db->select('*')
						->from('tb_siswa')
						->where('no_ujian_smp', $no_ujian_smp)
						->get();
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$sts_ctk = $row -> sts_ctk;
				$dataKu['sts_ctk'] = $sts_ctk + 1;
				$this->db->where('no_ujian_smp', $no_ujian_smp)->update('tb_siswa', $dataKu);
			}
		}
		
		$dataKu = $this->m_data->ambilDataSiswa($no_ujian_smp);
		
		$kd_lahir		= $dataKu['kd_lahir'];
		$kd_alamat		= $dataKu['kd_alamat'];
		$kd_alamat_ayah	= $dataKu['kd_alamat_ayah'];
		$kd_lhr_ayah	= $dataKu['kd_lhr_ayah'];
		$kd_alamat_ibu	= $dataKu['kd_alamat_ibu'];
		$kd_lhr_ibu		= $dataKu['kd_lhr_ibu'];
		$kd_alamat_wali	= $dataKu['kd_alamat_wali'];
		$kd_lhr_wali	= $dataKu['kd_lhr_wali'];
		
		$arr_kd = $this->m_data->array_kode_wilayah($kd_lahir);
			$kota_lahir		= $arr_kd[3];
		$arr_kd = $this->m_data->array_kode_wilayah($kd_alamat);
			$prop_alamat	= $arr_kd[1];
			$kota_alamat	= $arr_kd[3];
			$camat_alamat	= $arr_kd[5];
			$lurah_alamat	= $arr_kd[7];
		$arr_kd = $this->m_data->array_kode_wilayah($kd_lhr_ayah);
			$kota_lhr_ayah	= $arr_kd[3] . ' - ' . $arr_kd[1];
		$arr_kd = $this->m_data->array_kode_wilayah($kd_alamat_ayah);
			$kota_alam_ayah	= $arr_kd[3] . ' - ' . $arr_kd[1];
		$arr_kd = $this->m_data->array_kode_wilayah($kd_lhr_ibu);
			$kota_lhr_ibu	= $arr_kd[3] . ' - ' . $arr_kd[1];
		$arr_kd = $this->m_data->array_kode_wilayah($kd_alamat_ibu);
			$kota_alam_ibu	= $arr_kd[3] . ' - ' . $arr_kd[1];
		$arr_kd = $this->m_data->array_kode_wilayah($kd_lhr_wali);
			$kota_lhr_wali	= $arr_kd[3] . ' - ' . $arr_kd[1];
		$arr_kd = $this->m_data->array_kode_wilayah($kd_alamat_wali);
			$kota_alam_wali	= $arr_kd[3] . ' - ' . $arr_kd[1];
		
		$arr_kd = $this->m_data->array_transport();
			$kendaraan = $arr_kd[$dataKu["kendaraan"]];
		$arr_kd = $this->m_data->array_kebutuhan();
			$jasmani = $arr_kd[$dataKu["jasmani"]];
		$arr_kd = $this->m_data->array_jenis_tinggal();
			$sts_tinggal2 = $arr_kd[$dataKu["sts_tinggal2"]];
		$arr_kd = $this->m_data->array_agama();
			$agama = $arr_kd[$dataKu["agama"]];
			$agama_ayah = $arr_kd[$dataKu["agama_ayah"]];
			$agama_ibu  = $arr_kd[$dataKu["agama_ibu"]];
			$agama_wali = $arr_kd[$dataKu["agama_wali"]];
		$arr_kd = $this->m_data->array_pendidikan();
			$didik_ayah = $arr_kd[$dataKu["didik_ayah"]];
			$didik_ibu  = $arr_kd[$dataKu["didik_ibu"]];
			$didik_wali = $arr_kd[$dataKu["didik_wali"]];
		$arr_kd = $this->m_data->array_pekerjaan();
			$kerja_ayah = $arr_kd[$dataKu["kerja_ayah"]];
			$kerja_ibu  = $arr_kd[$dataKu["kerja_ibu"]];
			$kerja_wali = $arr_kd[$dataKu["kerja_wali"]];
		$arr_kd = $this->m_data->array_penghasilan();
			$hasil_ayah = $arr_kd[$dataKu["hasil_ayah"]];
			$hasil_ibu  = $arr_kd[$dataKu["hasil_ibu"]];
			$hasil_wali = $arr_kd[$dataKu["hasil_wali"]];
		$arr_kd = $this->m_data->array_negara();
			$warga = $arr_kd[$dataKu["warga"]];
			$warga_ayah = $arr_kd[$dataKu["warga_ayah"]];
			$warga_ibu  = $arr_kd[$dataKu["warga_ibu"]];
			$warga_wali = $arr_kd[$dataKu["warga_wali"]];
		if($dataKu["gender"] == 'L') $jenkel = 'Laki-laki';else $jenkel = 'Perempuan';
		if($dataKu["sts_tinggal3"] == 'Y') $sts_tinggal3 = 'Ya';else $sts_tinggal3 = 'Tidak';
		if($dataKu["gakin"] == 'Y') $gakin = 'Ya';else $gakin = 'Tidak';
		if($dataKu["hdp_mt_ayah"] == 'Y') $hdp_mt_ayah = 'Masih Hidup'; else $hdp_mt_ayah = 'Sudah Meninggal';
		if($dataKu["hdp_mt_ibu"]  == 'Y') $hdp_mt_ibu  = 'Masih Hidup'; else $hdp_mt_ibu  = 'Sudah Meninggal';
		if($dataKu["hdp_mt_wali"] == 'Y') $hdp_mt_wali = 'Masih Hidup'; elseif($dataKu["hdp_mt_wali"] == 'T') $hdp_mt_wali = 'Sudah Meninggal';else $hdp_mt_wali = '';
		if($dataKu["sts_siswa"] == 0) $sts_siswa = '';elseif($dataKu["sts_siswa"] == 1) $sts_siswa = 'Prestasi';elseif($dataKu["sts_siswa"] == 2) $sts_siswa = 'Mitra Warga';elseif($dataKu["sts_siswa"] == 3) $sts_siswa = 'Umum';elseif($dataKu["sts_siswa"] == 4) $sts_siswa = 'Pindahan';elseif($dataKu["sts_siswa"] == 5) $sts_siswa = 'Pemenuhan Pagu';else $sts_siswa = 'Lainnya';
		if($dataKu["gol_darah"] == 0) $gol_darah = 'O';elseif($dataKu["gol_darah"] == 1) $gol_darah = 'A';elseif($dataKu["gol_darah"] == 2) $gol_darah = 'B';elseif($dataKu["gol_darah"] == 3) $gol_darah = 'AB';else $gol_darah = '';
		if($dataKu["jarak"] == 1) $jarak = 'Kurang dari 1 Km';elseif($dataKu["jarak"] == 2) $jarak = 'Lebih dari 1 Km'; else $jarak = '';
		if($dataKu["waktu"] == 1) $waktu = 'Kurang dari 30 Menit';elseif($dataKu["waktu"] == 2) $waktu = '30 - 60 Menit'; elseif($dataKu["waktu"] == 3) $waktu = 'Lebih dari 60 Menit';  else $waktu = '';

		$spasi = '&nbsp;';
		$query = $this->db->select('*')
					->from('tb_sekolah')
					->get();
		$row = $query->row();
		$kota        = ucwords(strtolower($row->kota));
		$sekolah     = $row->nama_sekolah;
		$nama_kepsek = $row->kepsek;
		$nip_kepsek  = $row->nip;
		$sekolah     = $row->nama_sekolah;
		$website     = $row->website;
		$email       = $row->email;
		
		$tapel       = $dataKu['th_ajaran'] . ' - ' . ($dataKu['th_ajaran']+1);
		//$noSurat     = '422/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/101.6.1.6/2018';
		$bulan		 = array("Januari", "Februari", "Maret", "April",
						 "Mei", "Juni", "Juli", "Agustus",
						 "September", "Oktober", "nopember", "Desember");
		$tgl = date("j", strtotime($dataKu["tgl_lhr"])) . ' ' . $bulan[(date("n", strtotime($dataKu["tgl_lhr"]))-1)] . ' ' . date("Y", strtotime($dataKu["tgl_lhr"]));
		$tmp_lhr   = $kota_lahir . ', ' . $tgl;
		$tgl_ayah = date("j", strtotime($dataKu["tgl_ayah"])) . ' ' . $bulan[(date("n", strtotime($dataKu["tgl_ayah"]))-1)] . ' ' . date("Y", strtotime($dataKu["tgl_ayah"]));
		$tgl_ibu  = date("j", strtotime($dataKu["tgl_ibu"]))  . ' ' . $bulan[(date("n", strtotime($dataKu["tgl_ibu"]))-1)]  . ' ' . date("Y", strtotime($dataKu["tgl_ibu"]));
		if(($dataKu["tgl_wali"] == '') or ($dataKu["tgl_wali"] == 0))
			$tgl_wali = '';
		else
			$tgl_wali = date("j", strtotime($dataKu["tgl_wali"])) . ' ' . $bulan[(date("n", strtotime($dataKu["tgl_wali"]))-1)] . ' ' . date("Y", strtotime($dataKu["tgl_wali"]));
		$tgl_skrg  = 'Surabaya, '.date("j").' '.$bulan[(date("n")-1)].' '.date("Y");
		if($dataKu["nama_wali"] == '')
		{
			$dataKu["nama_wali"]	= ' -';
			$dataKu["nik_wali"]		= ' -';
			$kota_lhr_wali			= ' -';
			$tgl_wali				= ' -';
			$agama_wali				= ' -';
			$warga_wali				= ' -';
			$didik_wali				= ' -';
			$kerja_wali				= ' -';
			$hasil_wali				= ' -';
			$dataKu["alamat_wali"]	= ' -';
			$kota_alam_wali			= ' -';
			$dataKu["tlp_wali"]		= ' -';
			$hdp_mt_wali			= ' -';
			$dataKu["mati_wali"]	= ' -';
		}
		
		$this->cetakQRCode($no_ujian_smp, $dataKu['nama']);

		//$strhtml  = '<link href="./utama/assets/css/style.css" rel="stylesheet">';
		$strhtml  = '';
		$strhtml .= $this->kopSuratPDF();
		$strhtml .= '<br/>';

		$strhtml .= '<table width=100% style="font-size:14px;">';
		$strhtml .= '<tr><td colspan="4" style="background-color: grey;color: white;height: 30px;border-radius: 8px;"><b> I. KETERANGAN TENTANG DIRI SISWA</b></td></tr>';
		$strhtml .= '<tr>';
		$strhtml .= 	'<td width=40%><b>Nama Siswa</b></td>';
		$strhtml .= 	'<td width=6%><center>:</center></td>';
		$strhtml .= 	'<td width=40%><b> '.$dataKu["nama"].'</b></td>';
		$strhtml .=		'<td rowspan="5" width=12%><img src="'.base_url().'utama/assists/files/qrcode/'.$no_ujian_smp.'.png"></td>';
		$strhtml .= '</tr>';
		$strhtml .= '<tr>';
		$strhtml .= 	'<td><b>No. Induk Siswa Nasional (NISN)</b></td>	<td><center>:</center></td>	<td>'.$dataKu["nisn"].'</td></tr>';
		$strhtml .= '<tr><td><b>No. Induk Kependudukan (NIK)</b></td>		<td><center>:</center></td>	<td>'.$dataKu["nik"].'</td></tr>';
		$strhtml .= '<tr><td><b>No. Induk Sekolah</b></td>					<td><center>:</center></td>	<td>'.$dataKu["no_induk"].'</td></tr>';
		$strhtml .= '<tr><td><b>kelas</b></td>								<td><center>:</center></td>	<td>'.$dataKu["nama_kelas"].'</td></tr>';
		$strhtml .= '<tr><td><b>Tahun Pelajaran</b></td>					<td><center>:</center></td>	<td>'.$tapel.'</td></tr>';
		$strhtml .= '<tr><td><b>Alamat Email</b></td>						<td><center>:</center></td>	<td>'.$dataKu["email"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Nama Panggilan</b></td>						<td><center>:</center></td>	<td>'.$dataKu["panggil"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Jenis Kelamin</b></td>						<td><center>:</center></td>	<td>'.$jenkel.'</td>					<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Tempat & Tanggal Lahir</b></td>				<td><center>:</center></td>	<td>'.$tmp_lhr.'</td>					<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>No. Akta Kelahiran</b></td>					<td><center>:</center></td>	<td>'.$dataKu["akta_lhr"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Agama</b></td>								<td><center>:</center></td>	<td>'.$agama.'</td>						<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Kewarganegaraan</b></td>					<td><center>:</center></td>	<td>'.$warga.'</td>						<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Anak Ke</b></td>							<td><center>:</center></td>	<td>'.$dataKu["anak_ke"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Jumlah Sdr Kandung</b></td>					<td><center>:</center></td>	<td>'.$dataKu["jml_sdr_k"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Jumlah Sdr Tiri</b></td>					<td><center>:</center></td>	<td>'.$dataKu["jml_sdr_t"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Jumlah Sdr Angkat</b></td>					<td><center>:</center></td>	<td>'.$dataKu["jml_sdr_a"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Bahasa Sehari-hari di rumah</b></td>		<td><center>:</center></td>	<td>'.$dataKu["bahasa"].'</td>			<td>&nbsp;</td></tr>';

		$strhtml .= '<tr><td colspan="4">&nbsp;</td></tr>';
		$strhtml .= '<tr><td colspan="4" style="background-color: grey;color: white;height: 30px;border-radius: 8px;"><b> II. KETERANGAN TENTANG TEMPAT TINGGAL</b></td></tr>';
		$strhtml .= '<tr><td><b>Alamat Rumah</b></td>						<td><center>:</center></td>	<td>'.$dataKu["alamat"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>RT / RW / Kelurahan</b></td>				<td><center>:</center></td>	<td>'.$dataKu["rt"].' / '.$dataKu["rw"].' / '.$lurah_alamat.'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Kecamatan</b></td>							<td><center>:</center></td>	<td>'.$camat_alamat.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>kota</b></td>								<td><center>:</center></td>	<td>'.$kota_alamat.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Propinsi</b></td>							<td><center>:</center></td>	<td>'.$prop_alamat.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Kode Pos</b></td>							<td><center>:</center></td>	<td>'.$dataKu["kodepos"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>No. Telp. Rumah</b></td>					<td><center>:</center></td>	<td>'.$dataKu["tlp_rmh"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Status Tempat Tinggal</b></td>				<td><center>:</center></td>	<td>'.$sts_tinggal2.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Jarak Sekolah dr Rumah</b></td>				<td><center>:</center></td>	<td>'.$jarak.'</td>						<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Transportasi ke Sekolah</b></td>			<td><center>:</center></td>	<td>'.$kendaraan.'</td>					<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Waktu Tempuh ke Sekolah</b></td>			<td><center>:</center></td>	<td>'.$waktu.'</td>						<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Dari Keluarga Tidak Mampu</b></td>			<td><center>:</center></td>	<td>'.$sts_tinggal3.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Penerima KPS/ KIP/ SKTM/ GAKIN</b></td>		<td><center>:</center></td>	<td>'.$gakin.'</td>						<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>No. Kartu / Surat GAKIN</b></td>			<td><center>:</center></td>	<td>'.$dataKu["no_gakin"].'</td>		<td>&nbsp;</td></tr>';

		$strhtml .= '<tr><td colspan="4">&nbsp;</td></tr>';
		$strhtml .= '<tr><td colspan="4" style="background-color: grey;color: white;height: 30px;border-radius: 8px;"><b> III. KETERANGAN TENTANG KESEHATAN</b></td></tr>';
		$strhtml .= '<tr><td><b>Golongan Darah</b></td>						<td><center>:</center></td>	<td>'.$gol_darah.'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Penyakit yng pernah diderita</b></td>		<td><center>:</center></td>	<td>'.$dataKu["penyakit"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Kebutuhan Khusus</b></td>					<td><center>:</center></td>	<td>'.$jasmani.'</td>					<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Tinggi Badan</b></td>						<td><center>:</center></td>	<td>'.$dataKu["tinggi"].' Cm</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Berat Badan</b></td>						<td><center>:</center></td>	<td>'.$dataKu["berat"].' Kg</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '</table>';
		$strhtml .= '<page_break>';

		//$strhtml .= '<tr><td colspan="4">&nbsp;</td></tr>';
		$strhtml .= '<table width=100% style="font-size:14px;">';
		$strhtml .= '<tr><td colspan="4" style="background-color: grey;color: white;height: 30px;border-radius: 8px;"><b> IV.a. KETERANGAN TENTANG PENDIDIKAN</b></td></tr>';
		$strhtml .= '<tr>';
		$strhtml .= 	'<td width=40%><b>Lulusan Dari SMP</b></td>';
		$strhtml .= 	'<td width=6%><center>:</center></td>';
		$strhtml .= 	'<td>'.$dataKu["sklh_smp"].'</td>';
		$strhtml .=		'<td rowspan="5" width=12%><img src="'.base_url().'utama/assists/files/qrcode/'.$no_ujian_smp.'.png"></td>';
		$strhtml .= '</tr>';
		$strhtml .= '<tr><td><b>No. Ujian SMP</b></td>						<td><center>:</center></td>	<td>'.$dataKu["no_ujian_smp"].'</td></tr>';
		$strhtml .= '<tr><td><b>No. Ijazah SMP</b></td>						<td><center>:</center></td>	<td>'.$dataKu["no_ijazah"].'</td></tr>';
		$strhtml .= '<tr><td><b>Tahun Ijazah SMP</b></td>					<td><center>:</center></td>	<td>'.$dataKu["th_ijazah"].'</td></tr>';
		$strhtml .= '<tr><td><b>Nomer SKHUN</b></td>						<td><center>:</center></td>	<td>'.$dataKu["no_skhun"].'</td></tr>';
		$strhtml .= '<tr><td><b>Jumlah SKHUN</b></td>						<td><center>:</center></td>	<td>'.$dataKu["jml_skhun"].'</td></tr>';
		$strhtml .= '<tr><td><b>&nbsp;&nbsp;&nbsp;&nbsp;Nilai UN Bahasa Indonesia</b></td>	<td><center>:</center></td>	<td>'.$dataKu["nil_bin"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>&nbsp;&nbsp;&nbsp;&nbsp;Nilai UN Bahasa Inggris</b></td>	<td><center>:</center></td>	<td>'.$dataKu["nil_big"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>&nbsp;&nbsp;&nbsp;&nbsp;Nilai UN Matematika</b></td>		<td><center>:</center></td>	<td>'.$dataKu["nil_mat"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>&nbsp;&nbsp;&nbsp;&nbsp;Nilai UN IPA</b></td>				<td><center>:</center></td>	<td>'.$dataKu["nil_ipa"].'</td>		<td>&nbsp;</td></tr>';

		//$strhtml .= '<tr><td colspan="4">&nbsp;</td></tr>';
		$strhtml .= '<tr><td colspan="4" style="background-color: grey;color: white;height: 30px;border-radius: 8px;"><b> IV.b. SISWA PINDAHAN</b></td></tr>';
		$strhtml .= '<tr><td><b>Asal Sekolah</b></td>						<td><center>:</center></td>	<td>'.$dataKu["asal_sklh"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Alasan Kepindahan</b></td>					<td><center>:</center></td>	<td>'.$dataKu["alsn_pindah"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Diterima Tingkat / Kelas</b></td>			<td><center>:</center></td>	<td>'.$dataKu["tingkat"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Kelompok</b></td>							<td><center>:</center></td>	<td>'.$dataKu["kelompok"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Jurusan</b></td>							<td><center>:</center></td>	<td>'.$dataKu["jurusan"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Tanggal Masuk</b></td>						<td><center>:</center></td>	<td>'.$dataKu["tgl_msk"].'</td>			<td>&nbsp;</td></tr>';

		$strhtml .= '<tr><td colspan="4">&nbsp;</td></tr>';
		$strhtml .= '<tr><td colspan="4" style="background-color: grey;color: white;height: 30px;border-radius: 8px;"><b> V. KETERANGAN TENTANG AYAH KANDUNG</b></td></tr>';
		$strhtml .= '<tr><td><b>Nama Ayah Kandung</b></td>					<td><center>:</center></td>	<td><b>'.$dataKu["nama_ayah"].'</b></td>	<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>NIK Ayah</b></td>							<td><center>:</center></td>	<td>'.$dataKu["nik_ayah"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Tempat Lahir</b></td>						<td><center>:</center></td>	<td>'.$kota_lhr_ayah.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Tanggal Lahir</b></td>						<td><center>:</center></td>	<td>'.$tgl_ayah.'</td>					<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Agama</b></td>								<td><center>:</center></td>	<td>'.$agama_ayah.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Kewarganegaraan</b></td>					<td><center>:</center></td>	<td>'.$warga_ayah.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Pendidikan</b></td>							<td><center>:</center></td>	<td>'.$didik_ayah.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Pekerjaan</b></td>							<td><center>:</center></td>	<td>'.$kerja_ayah.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Penghasilan per Bulan</b></td>				<td><center>:</center></td>	<td>'.$hasil_ayah.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Alamat Rumah</b></td>						<td><center>:</center></td>	<td>'.$dataKu["alamat_ayah"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td>&nbsp;</td>									<td>&nbsp;</td>				<td>'.$kota_alam_ayah.'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>No. Telp. Rumah / HP</b></td>				<td><center>:</center></td>	<td>'.$dataKu["tlp_ayah"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Masih Hidup / Sdh Meninggal Dunia</b></td>	<td><center>:</center></td>	<td>'.$hdp_mt_ayah.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Apabila sdh meninggal, Tahun</b></td>		<td><center>:</center></td>	<td>'.$dataKu["mati_ayah"].'</td>		<td>&nbsp;</td></tr>';
	
		$strhtml .= '<tr><td colspan="4">&nbsp;</td></tr>';
		$strhtml .= '<tr><td colspan="4" style="background-color: grey;color: white;height: 30px;border-radius: 8px;"><b> VI. KETERANGAN TENTANG IBU KANDUNG</b></td></tr>';
		$strhtml .= '<tr><td><b>Nama Ibu Kandung</b></td>					<td><center>:</center></td>	<td><b>'.$dataKu["nama_ibu"].'</b></td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>NIK Ibu</b></td>							<td><center>:</center></td>	<td>'.$dataKu["nik_ibu"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Tempat Lahir</b></td>						<td><center>:</center></td>	<td>'.$kota_lhr_ibu.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Tanggal Lahir</b></td>						<td><center>:</center></td>	<td>'.$tgl_ibu.'</td>					<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Agama</b></td>								<td><center>:</center></td>	<td>'.$agama_ibu.'</td>					<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Kewarganegaraan</b></td>					<td><center>:</center></td>	<td>'.$warga_ibu.'</td>					<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Pendidikan</b></td>							<td><center>:</center></td>	<td>'.$didik_ibu.'</td>					<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Pekerjaan</b></td>							<td><center>:</center></td>	<td>'.$kerja_ibu.'</td>					<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Penghasilan per Bulan</b></td>				<td><center>:</center></td>	<td>'.$hasil_ibu.'</td>					<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Alamat Rumah</b></td>						<td><center>:</center></td>	<td>'.$dataKu["alamat_ibu"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td>&nbsp;</td>									<td>&nbsp;</td>				<td>'.$kota_alam_ibu.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>No. Telp. Rumah / HP</b></td>				<td><center>:</center></td>	<td>'.$dataKu["tlp_ibu"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Masih Hidup / Sdh Meninggal Dunia</b></td>	<td><center>:</center></td>	<td>'.$hdp_mt_ibu.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Apabila sdh meninggal, Tahun</b></td>		<td><center>:</center></td>	<td>'.$dataKu["mati_ibu"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '</table>';
		$strhtml .= '<page_break>';

		//$strhtml .= '<tr><td colspan="4">&nbsp;</td></tr>';
		$strhtml .= '<table width=100% style="font-size:14px;">';
		$strhtml .= '<tr><td colspan="4" style="background-color: grey;color: white;height: 30px;border-radius: 8px;"><b> VII. KETERANGAN TENTANG WALI</b></td></tr>';
		$strhtml .= '<tr>';
		$strhtml .= 	'<td width=40%><b>Nama Wali</b></td>';
		$strhtml .= 	'<td width=6%><center>:</center></td>';
		$strhtml .= 	'<td>'.$dataKu["nama_wali"].'</td>';
		$strhtml .=		'<td rowspan="5" width=12%><img src="'.base_url().'utama/assists/files/qrcode/'.$no_ujian_smp.'.png"></td>';
		$strhtml .= '</tr>';
		$strhtml .= '<tr><td><b>NIK Wali</b></td>							<td><center>:</center></td>	<td>'.$dataKu["nik_wali"].'</td></tr>';
		$strhtml .= '<tr><td><b>Tempat Lahir</b></td>						<td><center>:</center></td>	<td>'.$kota_lhr_wali.'</td></tr>';
		$strhtml .= '<tr><td><b>Tanggal Lahir</b></td>						<td><center>:</center></td>	<td>'.$tgl_wali.'</td></tr>';
		$strhtml .= '<tr><td><b>Agama</b></td>								<td><center>:</center></td>	<td>'.$agama_wali.'</td></tr>';
		$strhtml .= '<tr><td><b>Kewarganegaraan</b></td>					<td><center>:</center></td>	<td>'.$warga_wali.'</td></tr>';
		$strhtml .= '<tr><td><b>Pendidikan</b></td>							<td><center>:</center></td>	<td>'.$didik_wali.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Pekerjaan</b></td>							<td><center>:</center></td>	<td>'.$kerja_wali.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Penghasilan per Bulan</b></td>				<td><center>:</center></td>	<td>'.$hasil_wali.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Alamat Rumah</b></td>						<td><center>:</center></td>	<td>'.$dataKu["alamat_wali"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td>&nbsp;</td>									<td>&nbsp;</td>				<td>'.$kota_alam_wali.'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>No. Telp. Rumah / HP</b></td>				<td><center>:</center></td>	<td>'.$dataKu["tlp_wali"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Masih Hidup / Sdh Meninggal Dunia</b></td>	<td><center>:</center></td>	<td>'.$hdp_mt_wali.'</td>				<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Apabila sdh meninggal, Tahun</b></td>		<td><center>:</center></td>	<td>'.$dataKu["mati_wali"].'</td>		<td>&nbsp;</td></tr>';
	
		$strhtml .= '<tr><td colspan="4">&nbsp;</td></tr>';
		$strhtml .= '<tr><td colspan="4" style="background-color: grey;color: white;height: 30px;border-radius: 8px;"><b> VIII. KEGEMARAN SISWA</b></td></tr>';
		$strhtml .= '<tr><td><b>Kesenian</b></td>							<td><center>:</center></td>	<td>'.$dataKu["seni"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Olah Raga</b></td>							<td><center>:</center></td>	<td>'.$dataKu["olahraga"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Kemasyarakatan / Organisasi</b></td>		<td><center>:</center></td>	<td>'.$dataKu["organisasi"].'</td>		<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Cita-cita</b></td>							<td><center>:</center></td>	<td>'.$dataKu["cita2"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Lain-lain</b></td>							<td><center>:</center></td>	<td>'.$dataKu["lain2"].'</td>			<td>&nbsp;</td></tr>';

		$strhtml .= '<tr><td colspan="4">&nbsp;</td></tr>';
		$strhtml .= '<tr><td colspan="4" style="background-color: grey;color: white;height: 30px;border-radius: 8px;"><b> IX. KETERANGAN JALUR MASUK SISWA</b></td></tr>';
		$strhtml .= '<tr><td><b>Siswa Berasal dari Jalur</b></td>			<td><center>:</center></td>	<td>'.$sts_siswa.'</td>					<td>&nbsp;</td></tr>';
		$strhtml .= '<tr><td><b>Tahun masuk Siswa</b></td>					<td><center>:</center></td>	<td>'.$dataKu["thn_msk"].'</td>			<td>&nbsp;</td></tr>';
		$strhtml .= '</table>';

		$strhtml .= '<p>Keterangan ini Kami buat dengan yang sebenar-benarnya,';
		$strhtml .= '<br>apabila terdapat <b><i>kekeliruhan data yang Kami sengaja, Kami siap menanggung akibatnya.</i></b></br></p>';

		$strhtml .= '<table style="font-size:14px;">';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=30%>&nbsp;</td>';
		$strhtml .= 		'<td width=38%>&nbsp;</td>';
		$strhtml .= 		'<td width=30%>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td><center>'.$tgl_skrg.'<center></td>';
		$strhtml .= 		'<td rowspan="6" style="text-align:right;">';
		$strhtml .= 			'<img style="float: right; margin: 40px 0px 15px 0px;" src="'.base_url().'utama/assists/images/photo_3x4.png" alt="" width=18% height=18%>';
		$strhtml .= 		'</td>';
		$strhtml .= 		'<td><center>Mengetahui,<center></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr><td><center>Orang Tua / Wali Murid</center></td><td><center>Kepala Sekolah</center></td></tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 	'	<td>&nbsp;</td>';
		$strhtml .= 	'	<td>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 	'	<td>&nbsp;</td>';
		$strhtml .= 	'	<td>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 	'	<td>&nbsp;</td>';
		$strhtml .= 	'	<td>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 	'	<td>&nbsp;</td>';
		$strhtml .= 	'	<td>&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr><td><center>(___________________________)</center></td><td>&nbsp;</td><td><center>(&nbsp;<u>'.$nama_kepsek.'</u>&nbsp;)</center></td></tr>';
		$strhtml .= 	'<tr><td><i><center>Nama Lengkap</center></i></td><td>&nbsp;</td><td><center>NIP. '.$nip_kepsek.'</center></td></tr>';
		$strhtml .= '</table>';

		$strhtml .= '<p />';
		$strhtml .= '<p>*) Lampirkan materai Rp 6.000 di sebelah kiri tanda tangan Orang Tua / Wali';
		
		$NamaFile   = 'Data_Siswa-'.$no_ujian_smp.'.pdf';

		$this->load->library('mpdf');
		$mpdf = new mPDF('utf-8', 'Folio', 0, '', 20, 20, 15, 20, 10, 10, '');		// ---- Cetak Potrait
		$mpdf->SetHeader('Data Isian Siswa||Hal. : {PAGENO} dari {nb}');
		$mpdf->WriteHTML($strhtml);
		$mpdf->WriteHTML($stylesheet,1);
		$mpdf->Output($NamaFile,'D');
		
		exit;
		
	}

	// ======================================================================================
	// # Fungsi cetak Surat Keterangan PDF
	// ======================================================================================
	public function cetakSuketPDF()
	{
		date_default_timezone_set("Asia/Jakarta");

		$perlu	= $this->input->get('perlu');
		$no_ujian_smp = $this->input->get('id');
		
		$tapel       = '2017 - 2018';
		$noSurat     = '422 /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 101.6.1.6 / 2018';
		$bulan		 = array("Januari", "Februari", "Maret", "April",
						 "Mei", "Juni", "Juli", "Agustus",
						 "September", "Oktober", "nopember", "Desember");

		$tgl_surat  = 'Surabaya, '.date("j").' '.$bulan[(date("n")-1)].' '.date("Y");
		
		$dataKu = array();
		$dataKu = $this->m_data->ambilDataSiswa($no_ujian_smp);
		
		$no_induk		= $dataKu['no_induk'];
		$nama			= $dataKu['nama'];
		$nama_kelas		= $dataKu['nama_kelas'];
		$alamat			= $dataKu['alamat'];
		$nama_ayah		= $dataKu['nama_ayah'];
		$kd_lahir		= $dataKu['kd_lahir'];
		$kd_alamat		= $dataKu['kd_alamat'];
		$arr_kd = $this->m_data->array_kode_wilayah($kd_lahir);
		$kota_lahir		= $arr_kd[3];
		$kota_lahir		= str_replace('Kota ', '', $kota_lahir);
		$kota_lahir		= str_replace('Kabupaten ', '', $kota_lahir);
		$kota_lahir		= str_replace('Kab. ', '', $kota_lahir);
		$arr_kd = $this->m_data->array_kode_wilayah($kd_alamat);
		$kota_alamat	= $arr_kd[3];
		$kota_alamat	= str_replace('Kota ', '', $kota_alamat);
		$kota_alamat	= str_replace('Kabupaten ', '', $kota_alamat);
		$kota_alamat	= str_replace('Kab. ', '', $kota_alamat);
		if($dataKu["gender"] == 'L') $jenkel = 'Laki-laki';else $jenkel = 'Perempuan';
		$tgl = date("j", strtotime($dataKu["tgl_lhr"])) . ' ' . $bulan[(date("n", strtotime($dataKu["tgl_lhr"]))-1)] . ' ' . date("Y", strtotime($dataKu["tgl_lhr"]));
		$tmp_lhr	= $kota_lahir . ', ' . $tgl;
		$alamat		.= '  ' . $kota_alamat;

		$query = $this->db->select('*')
					->from('tb_sekolah')
					->get();
		$row = $query->row();
		$nama_kepsek = $row->kepsek;
		$nip_kepsek  = $row->nip;
		$pangkat     = $row->pangkat;
		$golongan    = $row->golongan;
		$kota        = ucwords(strtolower($row->kota));
		$sekolah     = $row->nama_sekolah;
		$website     = $row->website;
		$email       = $row->email;

		$this->cetakQRCode($no_ujian_smp, $nama);

		$strhtml  = '';
		$strhtml .= $this->kopSuratPDF();
		$strhtml .= '<table class="table1" width=100% style="font-size:12px;">';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=10%>';
		$strhtml .= 			'&nbsp;';
		$strhtml .= 		'</td>';
		$strhtml .= 		'<td align="center" width=78%>';
		$strhtml .= 			'<p><h2 style="text-decoration: underline;"><b>SURAT KETERANGAN</b></h2></p>';
		$strhtml .= 			'<p><h4><b>Nomor : '.$noSurat.'</b></h4></p>';
		$strhtml .= 		'</td>';
		$strhtml .= 		'<td width=10%>';
		$strhtml .=				'<img src="'.base_url().'utama/assists/files/qrcode/'.$no_ujian_smp.'.png">';
		$strhtml .= 			'&nbsp;';
		$strhtml .= 		'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<table class="table1" width=100% style="font-size:14px;">';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=1%>&nbsp;</td>';
		$strhtml .= 		'<td width=4%>&nbsp;</td>';
		$strhtml .= 		'<td width=20%>&nbsp;</td>';
		$strhtml .= 		'<td style="width:8px;margin-left:-10px;">&nbsp;</td>';
		$strhtml .= 		'<td style="width:40%;margin-left:-10px;">&nbsp;</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td colspan="4">Yang bertanda tangan di bawah ini :</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>N a m a</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>'.$nama_kepsek.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>N I P</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>'.$nip_kepsek.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>Pangkat</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>'.$pangkat.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>Golongan</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>'.$golongan.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>Jabatan</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>Kepala Sekolah</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>Unit Kerja</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>'.$sekolah.'&nbsp;&nbsp;'.$kota.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr><td colspan="5">&nbsp;</td></tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td>&nbsp;</td>';
		$strhtml .= 		'<td colspan="4">Menerangkan dengan sebenarnya, bahwa :</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>N a m a</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>'.strtoupper($nama).'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>Jenis Kelamin</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>'.$jenkel.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>Tempat dan tanggal lahir</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>'.$tmp_lhr.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>Nomer Induk Sekolah</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>'.$no_induk.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>Kelas</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>'.$nama_kelas.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>Alamat tinggal sekarang</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>'.$alamat.'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="2">&nbsp;</td>';
		$strhtml .= 		'<td>Nama Orang Tua</td>';
		$strhtml .= 		'<td><center>:</center></td>';
		$strhtml .= 		'<td><b>'.strtoupper($nama_ayah).'</b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr><td colspan="5">&nbsp;</td></tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="5">Adalah benar-benar siswa '.$sekolah.'&nbsp;&nbsp;'.$kota.', siswa tersebut masih aktif mengikuti proses</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="5">belajar mengajar Tahun Pelajaran 2017 - 2018 di sekolah kami.</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td colspan="5">Demikian Surat Keterangan ini dibuat untuk <b><i>'.$perlu.'.</i></b></td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		$strhtml .= '<br/>';
		$strhtml .= '<br/>';
		$strhtml .= '<table class="table1" width=100% style="font-size:14px;">';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=58%>&nbsp;</td>';
		$strhtml .= 		'<td width=40%>'.$tgl_surat.'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=78%>&nbsp;</td>';
		$strhtml .= 		'<td width=20%>Kepala '.$sekolah.'&nbsp;&nbsp;'.$kota.'</td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr><td colspan="2">&nbsp;</td></tr>';
		$strhtml .= 	'<tr><td colspan="2">&nbsp;</td></tr>';
		$strhtml .= 	'<tr><td colspan="2">&nbsp;</td></tr>';
		$strhtml .= 	'<tr><td colspan="2">&nbsp;</td></tr>';
		$strhtml .= 	'<tr><td colspan="2">&nbsp;</td></tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=78%>&nbsp;</td>';
		$strhtml .= 		'<td width=20%> <u><b>'.$nama_kepsek.'</b></u> </td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=78%>&nbsp;</td>';
		$strhtml .= 		'<td width=20%> '.$pangkat.' </td>';
		$strhtml .= 	'</tr>';
		$strhtml .= 	'<tr>';
		$strhtml .= 		'<td width=78%>&nbsp;</td>';
		$strhtml .= 		'<td width=20%> NIP. '.$nip_kepsek.' </td>';
		$strhtml .= 	'</tr>';
		$strhtml .= '</table>';
		
		$NamaFile   = 'Suket-'.$no_ujian_smp.'.pdf';

		
		// Panggil Library mPdf
		$this->load->library('mpdf');
		//$mpdf = new mPDF('utf-8', 'Folio-L', 0, '', $kiri, $kanan, $atas, $bawah, $hdr, $ftr, 'L');	// ---- Cetak landscape
		$mpdf = new mPDF('utf-8', 'Folio', 0, '', 20, 20, 15, 20, 10, 10, '');		// ---- Cetak Potrait
		$mpdf->SetFooter('http://'.$website.'|'.$sekolah.' '.$kota.'|e-mail : '.$email);
		
		$mpdf->WriteHTML($strhtml);
		$mpdf->WriteHTML($stylesheet,1);
		$mpdf->Output($NamaFile,'D');
		
		exit;
		
	}

	// ======================================================================================
	// # Fungsi cetak Rapor PDF
	// ======================================================================================
	public function cetakRaporPDF()
	{
		$pilih = $this->input->get('pl');
		if(isset($_GET['noRec']))
		{
			$noRec = $this->m_data->decryptIt($this->input->get('noRec'));
			$indukM = '';
			$semua = 2;
		}
		else
		{
			$pilih  = $this->input->post('pl');
			$semua  = $this->input->post('semua');
			$tapelM = $this->input->post('tapelSel');
			$semesM = $this->input->post('semesSel');
			$kelasM = $this->input->post('kelasPilih');
			$indukM = $this->input->post('siswaSel');
			$noRec = '';
		}
		
		if($semua == 2)
		{
			if($indukM != '')
			{
				if($pilih == 'ulangan')
					$query = $this->db->select('*')
								->from('tb_ulangan')
								->join('tb_siswa', 'tb_siswa.no_induk = tb_ulangan.induk', 'left')
								->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
								->where('tb_ulangan.tapel', $tapelM)
								->where('tb_ulangan.semester', $semesM)
								->where('tb_ulangan.induk', $indukM)
								->get();
				else
					$query = $this->db->select('*')
								->from('tb_nilai')
								->join('tb_siswa', 'tb_siswa.no_induk = tb_nilai.induk', 'left')
								->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
								->where('tb_nilai.tapel', $tapelM)
								->where('tb_nilai.semester', $semesM)
								->where('tb_nilai.induk', $indukM)
								->get();
				if($query->num_rows() > 0)
				{
					$row = $query->row();
					$noRec = $row->no;
				}
				else redirect('home');
			}
			if($pilih == 'rapor')
				$query = $this->db->select('*')
							->from('tb_nilai')
							->where('no', $noRec)
							->get();
			else
				$query = $this->db->select('*')
							->from('tb_ulangan')
							->where('no', $noRec)
							->get();
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$tapelM = $row->tapel;
				$semesM = $row->semester;
				if($pilih == 'rapor')
					$this->isiRaporPDF($noRec, $semua , $tapelM, $semesM, '');
				else
					$this->isiUlanganPDF($noRec, $semua , $tapelM, $semesM, '');
			}
		}
		else
		{
			if($pilih == 'rapor')
			{
				if($semua == 0)
					$this->isiRaporPDF('', $semua , $tapelM, $semesM, '');
				elseif($semua == 1)
					$this->isiRaporPDF('', $semua , $tapelM, $semesM, $kelasM);
			}
			else
			{
				if($semua == 0)
					$this->isiUlanganPDF('', $semua , $tapelM, $semesM, '');
				elseif($semua == 1)
					$this->isiUlanganPDF('', $semua , $tapelM, $semesM, $kelasM);
			}
			redirect('home');
		}
		exit;
		
	}
	
	// ======================================================================================
	// # Fungsi cetak Rapor PDF
	// ======================================================================================
	public function isiRaporPDF($noRec, $semua, $tapelM, $semesM, $kelasM)
	{
		date_default_timezone_set("Asia/Jakarta");

		$query = $this->db->select('*')
					->from('tb_sekolah')
					->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$nama_kepsek = $row->kepsek;
			$nip_kepsek  = $row->nip;
			$website     = $row->website;
			$email       = $row->email;
			$kota        = ucwords(strtolower($row->kota));
			$sekolah     = $row->nama_sekolah;
		}
		else
		{
			$kota		 = '';
			$sekolah	 = '';
			$nama_kepsek = '';
			$nip_kepsek  = '';
			$website     = '';
			$email       = '';
		}
			
		$nama_walikelas = '';
		$nip_walikelas  = '';
		$spasi = '&nbsp;';
		for($i = 0; $i < 50; $i++)
		{
			$nama_walikelas .= $spasi;
		}
		$pangkat		= 'Pembina Tk. I';
		$golongan		= 'IV/b';
		
		$data_kkm = array();
		$query = $this->db->select('*')
					->from('tb_kkm')
					->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$data_kkm['kkm'] = $row->kkm;
			$data_kkm['pred1_nama']  = $row->pred1_nama;
			$data_kkm['pred1_bawah'] = $row->pred1_bawah;
			$data_kkm['pred1_atas']  = $row->pred1_atas;
			$data_kkm['pred2_nama']  = $row->pred2_nama;
			$data_kkm['pred2_bawah'] = $row->pred2_bawah;
			$data_kkm['pred2_atas']  = $row->pred2_atas;
			$data_kkm['pred3_nama']  = $row->pred3_nama;
			$data_kkm['pred3_bawah'] = $row->pred3_bawah;
			$data_kkm['pred3_atas']  = $row->pred3_atas;
			$data_kkm['pred4_nama']  = $row->pred4_nama;
			$data_kkm['pred4_bawah'] = $row->pred4_bawah;
			$data_kkm['pred4_atas']  = $row->pred4_atas;
			$data_kkm['pred5_nama']  = $row->pred5_nama;
			$data_kkm['pred5_bawah'] = $row->pred5_bawah;
			$data_kkm['pred5_atas']  = $row->pred5_atas;
		}
		else
		{
			$data_kkm['kkm'] = 80;
			$data_kkm['pred1_nama']  = 'D';
			$data_kkm['pred1_bawah'] = 0;
			$data_kkm['pred1_atas']  = 79;
			$data_kkm['pred2_nama']  = 'C';
			$data_kkm['pred2_bawah'] = 80;
			$data_kkm['pred2_atas']  = 86;
			$data_kkm['pred3_nama']  = 'B';
			$data_kkm['pred3_bawah'] = 87;
			$data_kkm['pred3_atas']  = 93;
			$data_kkm['pred4_nama']  = 'A';
			$data_kkm['pred4_bawah'] = 94;
			$data_kkm['pred4_atas']  = 100;
			$data_kkm['pred5_nama']  = '';
			$data_kkm['pred5_bawah'] = 0;
			$data_kkm['pred5_atas']  = 0;
		}
		
		$bulan		= array("Januari", "Februari", "Maret", "April",
							"Mei", "Juni", "Juli", "Agustus",
							"September", "Oktober", "nopember", "Desember");
		$noSurat    = '422 /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 101.6.1.6 / 2018';
		$tgl_surat  = 'Surabaya, '.date("j").' '.$bulan[(date("n")-1)].' '.date("Y");
							
		// Panggil Library mPdf
		$this->load->library('mpdf');
		//$mpdf = new mPDF('utf-8', 'Folio-L', 0, '', $kiri, $kanan, $atas, $bawah, $hdr, $ftr, 'L');	// ---- Cetak landscape
		$mpdf = new mPDF('utf-8', 'Folio', 0, '', 20, 20, 10, 10, 5, 5, '');		// ---- Cetak Potrait
		$mpdf->SetFooter('http://'.$website.'|'.$sekolah.' '.$kota.'|e-mail : '.$email);
		$strhtml = $this->ambilCSSPdf();
		$mpdf->WriteHTML($strhtml);
		$strhtml = '';
		
		if($semua == 2)
		{
			$data_nilai = array();
			$data4 = array();
			list($data_nilai, $mapel, $data4) = $this->ambilDataRapor($noRec);
			
			$arr_kd = $this->m_data->array_kode_wilayah($data4['kd_lahir']);
			$kota_lahir		= $arr_kd[3];
			$kota_lahir		= str_replace('Kota ', '', $kota_lahir);
			$kota_lahir		= str_replace('Kabupaten ', '', $kota_lahir);
			$kota_lahir		= str_replace('Kab. ', '', $kota_lahir);
			$arr_kd = $this->m_data->array_kode_wilayah($data4['kd_alamat']);
			$kota_alamat	= $arr_kd[3];
			$kota_alamat	= str_replace('Kota ', '', $kota_alamat);
			$kota_alamat	= str_replace('Kabupaten ', '', $kota_alamat);
			$kota_alamat	= str_replace('Kab. ', '', $kota_alamat);
			
			$tgl = date("j", strtotime($data4['tgl_lhr'])) . ' ' . $bulan[(date("n", strtotime($data4['tgl_lhr']))-1)] . ' ' . date("Y", strtotime($data4['tgl_lhr']));
			$tmp_lhr	= $kota_lahir . ', ' . $tgl;
			$alamat		= $data4['alamat'].'  '.$kota_alamat;

			if($data4['semes'] == 1) $semester = 'Ganjil'; else $semester	= 'Genap';
			$tapel      = $data4['tapelS'] . ' - ' . ($data4['tapelS'] + 1);
		
			$no_ujian_smp = $data4['no_ujian_smp'];
			$nama = $data4['nama'];
			$this->cetakQRCode($no_ujian_smp, $nama);

			// ===================== Halaman 1 =============================
			$strhtml  = $this->headerRaporPDF($data4['nama_kelas'], $semester, $nama, $tapel, $data4['no_induk'], $data4['nisn']);
			$strhtml .= $this->hal1Rapor($data4['spiritual_p'], $data4['spiritual_d'], $data4['sosial_p'], $data4['sosial_d']);
			$strhtml .= $this->walikelasRaporPDF($no_ujian_smp, $tgl_surat, $data4['kelas']);
			$mpdf->WriteHTML($strhtml);
			$mpdf->AddPage();
			$strhtml  = '';
			
			// ===================== Halaman 2 =============================
			$strhtml  = $this->headerRaporPDF($data4['nama_kelas'], $semester, $nama, $tapel, $data4['no_induk'], $data4['nisn']);
			$strhtml .= $this->hal2Rapor($data_kkm, $data_nilai, $mapel, $data4['lintas']);
			$strhtml .= $this->walikelasRaporPDF($no_ujian_smp, $tgl_surat, $data4['kelas']);
			$mpdf->WriteHTML($strhtml);
			$mpdf->AddPage();
			$strhtml  = '';

			// ===================== Halaman 3 =============================
			$strhtml  = $this->headerRaporPDF($data4['nama_kelas'], $semester, $nama, $tapel, $data4['no_induk'], $data4['nisn']);
			$strhtml .= $this->hal3Rapor($data_kkm, $data_nilai, $mapel, $data4['lintas']);
			$strhtml .= $this->walikelasRaporPDF($no_ujian_smp, $tgl_surat, $data4['kelas']);
			$mpdf->WriteHTML($strhtml);
			$mpdf->AddPage();
			$strhtml  = '';

			// ===================== Halaman 4 =============================
			$strhtml  = $this->headerRaporPDF($data4['nama_kelas'], $semester, $nama, $tapel, $data4['no_induk'], $data4['nisn']);
			$strhtml .= $this->hal4Rapor($data4);
			$strhtml .= $this->walikelasRaporPDF($no_ujian_smp, $tgl_surat, $data4['kelas']);
			$strhtml .= $this->halKepsekRapor($nama_kepsek, $nip_kepsek);
			$mpdf->WriteHTML($strhtml);
		}
		else
		{
			if($semua == 0)
				$query = $this->db->select('*')
							->from('tb_nilai')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_nilai.induk', 'left')
							->join('tb_kelas', 'tb_siswa.kelas = tb_kelas.kd_kelas', 'left')
							->where('tb_nilai.tapel', $tapelM)
							->where('tb_nilai.semester', $semesM)
							->order_by('tb_kelas.kd_kelas', 'asc')
							->order_by('tb_siswa.nama', 'asc')
							->get();
			else
				$query = $this->db->select('*')
							->from('tb_nilai')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_nilai.induk', 'left')
							->join('tb_kelas', 'tb_siswa.kelas = tb_kelas.kd_kelas', 'left')
							->where('tb_nilai.tapel', $tapelM)
							->where('tb_nilai.semester', $semesM)
							->where('tb_kelas.kd_kelas', $kelasM)
							->order_by('tb_siswa.nama', 'asc')
							->get();
			$rowcounts = $query->num_rows();
			if($rowcounts > 0)
			{
				$nomer = 0;
				foreach($query->result() as $row)
				{
					$noRec = $row->no;
					//================= cetak per siswa ==========================
					$data_nilai = array();
					$data4 = array();
					$mapel = array();
					list($data_nilai, $mapel, $data4) = $this->ambilDataRapor($noRec);
					
					if($data4['semes'] == 1) $semester = 'Ganjil'; else $semester	= 'Genap';
					$tapel      = $data4['tapelS'] . ' - ' . ($data4['tapelS'] + 1);
					
					$no_ujian_smp = $data4['no_ujian_smp'];
					$nama = $data4['nama'];
					$this->cetakQRCode($no_ujian_smp, $nama);

					// ===================== Halaman 1 =============================
					$strhtml  = $this->headerRaporPDF($data4['nama_kelas'], $semester, $nama, $tapel, $data4['no_induk'], $data4['nisn']);
					$strhtml .= $this->hal1Rapor($data4['spiritual_p'], $data4['spiritual_d'], $data4['sosial_p'], $data4['sosial_d']);
					$strhtml .= $this->walikelasRaporPDF($no_ujian_smp, $tgl_surat, $data4['kelas']);
					$mpdf->WriteHTML($strhtml);
					$mpdf->AddPage();
					$strhtml  = '';
			
					// ===================== Halaman 2 =============================
					$strhtml  = $this->headerRaporPDF($data4['nama_kelas'], $semester, $nama, $tapel, $data4['no_induk'], $data4['nisn']);
					$strhtml .= $this->hal2Rapor($data_kkm, $data_nilai, $mapel, $data4['lintas']);
					$strhtml .= $this->walikelasRaporPDF($no_ujian_smp, $tgl_surat, $data4['kelas']);
					$mpdf->WriteHTML($strhtml);
					$mpdf->AddPage();
					$strhtml  = '';

					// ===================== Halaman 3 =============================
					$strhtml  = $this->headerRaporPDF($data4['nama_kelas'], $semester, $nama, $tapel, $data4['no_induk'], $data4['nisn']);
					$strhtml .= $this->hal3Rapor($data_kkm, $data_nilai, $mapel, $data4['lintas']);
					$strhtml .= $this->walikelasRaporPDF($no_ujian_smp, $tgl_surat, $data4['kelas']);
					$mpdf->WriteHTML($strhtml);
					$mpdf->AddPage();
					$strhtml  = '';

					// ===================== Halaman 4 =============================
					$strhtml  = $this->headerRaporPDF($data4['nama_kelas'], $semester, $nama, $tapel, $data4['no_induk'], $data4['nisn']);
					$strhtml .= $this->hal4Rapor($data4);
					$strhtml .= $this->walikelasRaporPDF($no_ujian_smp, $tgl_surat, $data4['kelas']);
					$strhtml .= $this->halKepsekRapor($nama_kepsek, $nip_kepsek);
					$mpdf->WriteHTML($strhtml);
					
					$nomer++;
					if($nomer < $rowcounts)
					{
						$mpdf->AddPage();
						$strhtml  = '';
					}
				}
			}
		}
		
		if($semua == 2)
			$NamaFile   = 'Rapor-'.$no_ujian_smp.'.pdf';
		elseif($semua == 1)
			$NamaFile   = 'Rapor-'.$kelasM.'.pdf';
		else
			$NamaFile   = 'Rapor-All.pdf';
		$mpdf->WriteHTML($stylesheet,1);
		$mpdf->Output($NamaFile,'D');

		return;
	}
	
	// ======================================================================================
	// # Fungsi cetak Ulangan Harian PDF
	// ======================================================================================
	public function isiUlanganPDF($noRec, $semua, $tapelM, $semesM, $kelasM)
	{
		date_default_timezone_set("Asia/Jakarta");

		$query = $this->db->select('*')
					->from('tb_sekolah')
					->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$nama_kepsek = $row->kepsek;
			$nip_kepsek  = $row->nip;
			$website     = $row->website;
			$email       = $row->email;
			$kota        = ucwords(strtolower($row->kota));
			$sekolah     = $row->nama_sekolah;
		}
		else
		{
			$kota		 = '';
			$sekolah	 = '';
			$nama_kepsek = '';
			$nip_kepsek  = '';
			$website     = '';
			$email       = '';
		}
		
		$data_kkm = array();
		$query = $this->db->select('*')
					->from('tb_kkm')
					->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$data_kkm['kkm'] = $row->kkm;
			$data_kkm['pred1_nama']  = $row->pred1_nama;
			$data_kkm['pred1_bawah'] = $row->pred1_bawah;
			$data_kkm['pred1_atas']  = $row->pred1_atas;
			$data_kkm['pred2_nama']  = $row->pred2_nama;
			$data_kkm['pred2_bawah'] = $row->pred2_bawah;
			$data_kkm['pred2_atas']  = $row->pred2_atas;
			$data_kkm['pred3_nama']  = $row->pred3_nama;
			$data_kkm['pred3_bawah'] = $row->pred3_bawah;
			$data_kkm['pred3_atas']  = $row->pred3_atas;
			$data_kkm['pred4_nama']  = $row->pred4_nama;
			$data_kkm['pred4_bawah'] = $row->pred4_bawah;
			$data_kkm['pred4_atas']  = $row->pred4_atas;
			$data_kkm['pred5_nama']  = $row->pred5_nama;
			$data_kkm['pred5_bawah'] = $row->pred5_bawah;
			$data_kkm['pred5_atas']  = $row->pred5_atas;
		}
		else
		{
			$data_kkm['kkm'] = 80;
			$data_kkm['pred1_nama']  = 'D';
			$data_kkm['pred1_bawah'] = 0;
			$data_kkm['pred1_atas']  = 79;
			$data_kkm['pred2_nama']  = 'C';
			$data_kkm['pred2_bawah'] = 80;
			$data_kkm['pred2_atas']  = 86;
			$data_kkm['pred3_nama']  = 'B';
			$data_kkm['pred3_bawah'] = 87;
			$data_kkm['pred3_atas']  = 93;
			$data_kkm['pred4_nama']  = 'A';
			$data_kkm['pred4_bawah'] = 94;
			$data_kkm['pred4_atas']  = 100;
			$data_kkm['pred5_nama']  = '';
			$data_kkm['pred5_bawah'] = 0;
			$data_kkm['pred5_atas']  = 0;
		}
			
		$bulan		= array("Januari", "Februari", "Maret", "April",
							"Mei", "Juni", "Juli", "Agustus",
							"September", "Oktober", "nopember", "Desember");
							
		$noSurat    = '422 /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 101.6.1.6 / 2018';
		$tgl_surat  = 'Surabaya, '.date("j").' '.$bulan[(date("n")-1)].' '.date("Y");
			
		// Panggil Library mPdf
		$this->load->library('mpdf');
		//$mpdf = new mPDF('utf-8', 'Folio-L', 0, '', $kiri, $kanan, $atas, $bawah, $hdr, $ftr, 'L');	// ---- Cetak landscape
		$mpdf = new mPDF('utf-8', 'Folio', 0, '', 10, 10, 10, 10, 5, 15, '');		// ---- Cetak Potrait
		$mpdf->SetHeader('Ulangan Harian||Hal. : {PAGENO}');
		$mpdf->SetFooter('http://'.$website.'|'.$sekolah.' '.$kota.'|e-mail : '.$email);
		
		// ============= Style =================
		$strhtml = $this->ambilCSSPdf();
		$mpdf->WriteHTML($strhtml);
		$strhtml = '';

		if($semua == 2)
		{
			$data4 = array();
			$data_nilai = array();
			$mapel = array();
			list($data_nilai, $mapel, $data4) = $this->ambilDataUlangan($noRec);
	
			if($data4['semes'] == 1) $semester = 'Ganjil'; else $semester = 'Genap';
			$tapel = $data4['tapelS'] . ' - ' . ($data4['tapelS'] + 1);
			
			$no_ujian_smp = $data4['no_ujian_smp'];
			$nama = $data4['nama'];
			$this->cetakQRCode($no_ujian_smp, $nama);

			// ===================== Halaman 1 =============================
			$strhtml .= $this->headerRaporPDF($data4['nama_kelas'], $semester, $data4['nama'], $tapel, $data4['no_induk'], $data4['nisn']);
			$strhtml .= $this->hal1Ulangan($data_kkm, $mapel, $data_nilai, $tapel, $semester);
			$strhtml .= $this->walikelasRaporPDF($data4['no_ujian_smp'], $tgl_surat, $data4['kelas']);
			$mpdf->WriteHTML($strhtml);
			$mpdf->AddPage();
			$strhtml  = '';
		
			// ===================== Halaman 2 =============================
			$strhtml .= $this->headerRaporPDF($data4['nama_kelas'], $semester, $data4['nama'], $tapel, $data4['no_induk'], $data4['nisn']);
			$strhtml .= $this->hal2Ulangan($data_kkm, $mapel, $data_nilai, $tapel, $semester);
			$strhtml .= $this->walikelasRaporPDF($data4['no_ujian_smp'], $tgl_surat, $data4['kelas']);
			$mpdf->WriteHTML($strhtml);
			$mpdf->AddPage();
			$strhtml  = '';
		
			// ===================== Halaman 3 =============================
			$strhtml .= $this->headerRaporPDF($data4['nama_kelas'], $semester, $data4['nama'], $tapel, $data4['no_induk'], $data4['nisn']);
			$strhtml .= $this->hal3Ulangan($data_kkm, $mapel, $data_nilai, $tapel, $semester);
			$strhtml .= $this->walikelasRaporPDF($data4['no_ujian_smp'], $tgl_surat, $data4['kelas']);
			$strhtml .= $this->halKepsekUlangan($nama_kepsek, $nip_kepsek);
			$mpdf->WriteHTML($strhtml);
		}
		else
		{
			if($semua == 0)
				$query = $this->db->select('*')
							->from('tb_ulangan')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_ulangan.induk', 'left')
							->join('tb_kelas', 'tb_siswa.kelas = tb_kelas.kd_kelas', 'left')
							->where('tb_ulangan.tapel', $tapelM)
							->where('tb_ulangan.semester', $semesM)
							->order_by('tb_kelas.kd_kelas', 'asc')
							->order_by('tb_siswa.nama', 'asc')
							->get();
			else
				$query = $this->db->select('*')
							->from('tb_ulangan')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_ulangan.induk', 'left')
							->join('tb_kelas', 'tb_siswa.kelas = tb_kelas.kd_kelas', 'left')
							->where('tb_ulangan.tapel', $tapelM)
							->where('tb_ulangan.semester', $semesM)
							->where('tb_kelas.kd_kelas', $kelasM)
							->order_by('tb_siswa.nama', 'asc')
							->get();
			$rowcounts = $query->num_rows();
			if($rowcounts > 0)
			{
				$nomer = 0;
				foreach($query->result() as $row)
				{
					$noRec = $row->no;
					
					$data4 = array();
					$data_nilai = array();
					$mapel = array();
					list($data_nilai, $mapel, $data4) = $this->ambilDataUlangan($noRec);
	
					if($data4['semes'] == 1) $semester = 'Ganjil'; else $semester = 'Genap';
					$tapel = $data4['tapelS'] . ' - ' . ($data4['tapelS'] + 1);
			
					$no_ujian_smp = $data4['no_ujian_smp'];
					$nama = $data4['nama'];
					$this->cetakQRCode($no_ujian_smp, $nama);

					// ===================== Halaman 1 =============================
					$strhtml .= $this->headerRaporPDF($data4['nama_kelas'], $semester, $data4['nama'], $tapel, $data4['no_induk'], $data4['nisn']);
					$strhtml .= $this->hal1Ulangan($data_kkm, $mapel, $data_nilai, $tapel, $semester);
					$strhtml .= $this->walikelasRaporPDF($data4['no_ujian_smp'], $tgl_surat, $data4['kelas']);
					$mpdf->WriteHTML($strhtml);
					$mpdf->AddPage();
					$strhtml  = '';
		
					// ===================== Halaman 2 =============================
					$strhtml .= $this->headerRaporPDF($data4['nama_kelas'], $semester, $data4['nama'], $tapel, $data4['no_induk'], $data4['nisn']);
					$strhtml .= $this->hal2Ulangan($data_kkm, $mapel, $data_nilai, $tapel, $semester);
					$strhtml .= $this->walikelasRaporPDF($data4['no_ujian_smp'], $tgl_surat, $data4['kelas']);
					$mpdf->WriteHTML($strhtml);
					$mpdf->AddPage();
					$strhtml  = '';
		
					// ===================== Halaman 3 =============================
					$strhtml .= $this->headerRaporPDF($data4['nama_kelas'], $semester, $data4['nama'], $tapel, $data4['no_induk'], $data4['nisn']);
					$strhtml .= $this->hal3Ulangan($data_kkm, $mapel, $data_nilai, $tapel, $semester);
					$strhtml .= $this->walikelasRaporPDF($data4['no_ujian_smp'], $tgl_surat, $data4['kelas']);
					$strhtml .= $this->halKepsekUlangan($nama_kepsek, $nip_kepsek);
					$mpdf->WriteHTML($strhtml);
					$nomer++;
					if($nomer < $rowcounts)
					{
						$mpdf->WriteHTML('<pagebreak resetpagenum="1" suppress="off" />');
						$strhtml  = '';
					}
				}
			}
		}
		
		if($semua == 2)
			$NamaFile   = 'UH-'.$no_ujian_smp.'.pdf';
		elseif($semua == 1)
			$NamaFile   = 'UH-'.$kelasM.'.pdf';
		else
			$NamaFile   = 'UH-All.pdf';
		
		$mpdf->WriteHTML($stylesheet,1);
		$mpdf->Output($NamaFile,'D');
			
		return;
	}
	
	// ======================================================================================
	// # Fungsi cetak Presensi PDF
	// ======================================================================================
	function cetakPresensiPDF()
	{
		date_default_timezone_set("Asia/Jakarta");
		$level    = $this->session->userdata('level');
		
		if($level < 95)
		{
			$induk    = $this->input->post('induk');
			$tglAwal  = $this->input->post('tglAwal');
			$tglAkhir = $this->input->post('tglAkhir');
			$semua    = 2;
		}
		else
		{
			$semua    = $this->input->post('semua');
			$rekap    = $this->input->post('rekap');
			$tglAwal  = $this->input->post('tglCetak1');
			$tglAkhir = $this->input->post('tglCetak2');
			$kelas    = $this->input->post('kelasPilih');
			$induk    = $this->input->post('siswaSel');
			if($semua == 1)
			{
				$query = $this->db->select('*')
							->from('tb_kelas')
							->where('kd_kelas', $kelas)
							->get();
				if($query->num_rows() > 0)
				{
					$row = $query->row();
					$nama_kelas = $row->nama_kelas;
				}
				$induk = 'all';
			}
		}
		
		$query = $this->db->select('*')
					->from('tb_sekolah')
					->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$kota        = ucwords(strtolower($row->kota));
			$sekolah     = $row->nama_sekolah;
			$nama_kepsek = $row->kepsek;
			$nip_kepsek  = $row->nip;
			$website     = $row->website;
			$email       = $row->email;
			$tapelS		 = $row->tapel;
			$semes		 = $row->semester;
		}
		else
		{
			$kota		 = '';
			$sekolah	 = '';
			$nama_kepsek = '';
			$nip_kepsek  = '';
			$website     = '';
			$email       = '';
			$tapel		 = '';
			$semes		 = '';
		}
			
		$bulan		= array("Januari", "Februari", "Maret", "April",
							"Mei", "Juni", "Juli", "Agustus",
							"September", "Oktober", "nopember", "Desember");
								
		$tgl_awal = date("j", strtotime($tglAwal)) . ' ' . $bulan[(date("n", strtotime($tglAwal))-1)] . ' ' . date("Y", strtotime($tglAwal));
		$tgl_akhir = date("j", strtotime($tglAkhir)) . ' ' . $bulan[(date("n", strtotime($tglAkhir))-1)] . ' ' . date("Y", strtotime($tglAkhir));

		if($semes == 1) $semester = 'Ganjil'; else $semester	= 'Genap';
		$tapel      = $tapelS . ' - ' . ($tapelS + 1);
		
		// Panggil Library mPdf
		$this->load->library('mpdf');
		//$mpdf = new mPDF('utf-8', 'Folio-L', 0, '', $kiri, $kanan, $atas, $bawah, $hdr, $ftr, 'L');	// ---- Cetak landscape
		$mpdf = new mPDF('utf-8', 'Folio', 0, '', 10, 10, 10, 10, 5, 15, '');		// ---- Cetak Potrait
		$mpdf->SetHeader('Presensi Siswa||Hal. : {PAGENO} dari {nb}');
		$mpdf->SetFooter('http://'.$website.'|'.$sekolah.' '.$kota.'|e-mail : '.$email);
		
		// ============= Style =================
		$strhtml = $this->ambilCSSPdf();
		$mpdf->WriteHTML($strhtml);
		$strhtml = '';

		if($semua == 2)
		{
			$query = $this->db->select('*')
						->from('tb_siswa')
						->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
						->where('tb_siswa.no_induk', $induk)
						->get();
			$row = $query->row();
			$no_induk		= $row -> no_induk;
			$no_ujian_smp	= $row -> no_ujian_smp;
			$nama			= $row -> nama;
			$nisn			= $row -> nisn;
			$kelas			= $row -> kelas;
			$nama_kelas		= $row -> nama_kelas;

			$jml_skt = 0;
			$jml_ijn = 0;
			$jml_alp = 0;
			$jml_lmb = 0;
			$query = $this->db->select('*')
						->from('tb_presensi')
						->where('induk', $induk)
						->where('tanggal >=', $tglAwal)
						->where('tanggal <', $tglAkhir)
						->get();
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					$jenis = $row->jenis;
					if(strtolower($jenis) == 's') $jml_skt++;
					elseif(strtolower($jenis) == 'i') $jml_ijn++;
					elseif(strtolower($jenis) == 'a') $jml_alp++;
					elseif(strtolower($jenis) == 't') $jml_lmb++;
				}
			}
			//$this->cetakQRCode($no_ujian_smp, $nama);

			$nomer = 0;
			$query = $this->db->select('*')
						->from('tb_presensi')
						->where('induk', $induk)
						->where('tanggal >=', $tglAwal)
						->where('tanggal <=', $tglAkhir)
						->order_by('tanggal', 'asc')
						->get();
			$rowcounts = $query->num_rows();
			$perKolom = ceil($rowcounts / 3);
			
			$strhtml .= $this->headerRaporPDF($nama_kelas, $semester, $nama, $tapel, $induk, $nisn);
			$strhtml .= '<div style="text-align: center">';
			$strhtml .= 	'<h3>DAFTAR HADIR SISWA</h3><br/>';
			$strhtml .= 	'<h4 style="margin-top:-34px;">Tanggal : '.$tgl_awal.' s/d '.$tgl_akhir.'</h4><br/>';
			$strhtml .= '</div>';
			$strhtml .=	'<table class="rapor" style="margin-top: -15px;">';
			$strhtml .= 	'<tr>';
			$strhtml .= 		'<td class="bgClr tengah2" style="width: 6%;">No</td>';			// Tabel 1
			$strhtml .= 		'<td class="bgClr tengah2" style="width: 13%;">Tanggal</td>';
			$strhtml .= 		'<td class="bgClr tengah2" style="width: 13%;">Jenis</td>';
			if($rowcounts > 1)
			{
				$strhtml .= 	'<td style="width: 10px;">&nbsp;</td>';							// Pembatas Kolom
				$strhtml .= 	'<td class="bgClr tengah2" style="width: 6%;">No</td>';			// Tabel (Kolom) 2
				$strhtml .= 	'<td class="bgClr tengah2" style="width: 13%;">Tanggal</td>';
				$strhtml .= 	'<td class="bgClr tengah2" style="width: 13%;">Jenis</td>';
			}
			if($rowcounts > 2)
			{
				$strhtml .= 	'<td style="width: 10px;">&nbsp;</td>';							// Pembatas Kolom
				$strhtml .= 	'<td class="bgClr tengah2" style="width: 6%;">No</td>';			// Tabel (Kolom) 3
				$strhtml .= 	'<td class="bgClr tengah2" style="width: 13%;">Tanggal</td>';
				$strhtml .= 	'<td class="bgClr tengah2" style="width: 13%;">Jenis</td>';
			}
			$strhtml .= 	'</tr>';
		
			for($i = 0; $i < $perKolom; $i++)
			{
				$strhtml .= '<tr>';
					$row1 = $query->row($i);
					$tgl  = date("d-m-Y", strtotime($row1->tanggal));
					$jns  = $row1->jenis;
					if(strtolower($jns) == 's') $jenis = 'Sakit';
					elseif(strtolower($jns) == 'i') $jenis = 'Ijin';
					elseif(strtolower($jns) == 't') $jenis = 'Terlambat';
					elseif(strtolower($jns) == 'a') $jenis = 'Alpha';
				$strhtml .= 	'<td class="tengah2">'.($i+1).'</td>';
				$strhtml .= 	'<td class="tengah2">'.$tgl.'</td>';
				$strhtml .= 	'<td class="tengah2">'.$jenis.'</td>';
				$strhtml .= 	'<td>&nbsp;</td>';												// Pembatas Kolom
				if(($i + $perKolom) < $rowcounts)
				{
					$row1 = $query->row($i + $perKolom);
					$tgl  = date("d-m-Y", strtotime($row1->tanggal));
					$jns = $row1->jenis;
					if(strtolower($jns) == 's') $jenis = 'Sakit';
					elseif(strtolower($jns) == 'i') $jenis = 'Ijin';
					elseif(strtolower($jns) == 't') $jenis = 'Terlambat';
					elseif(strtolower($jns) == 'a') $jenis = 'Alpha';
					$strhtml .= '<td class="tengah2">'.($i + $perKolom + 1).'</td>';
					$strhtml .= '<td class="tengah2">'.$tgl.'</td>';
					$strhtml .= '<td class="tengah2">'.$jenis.'</td>';
				}
				else 
				{
					$strhtml .= '<td>&nbsp;</td>';
					$strhtml .= '<td>&nbsp;</td>';
					$strhtml .= '<td>&nbsp;</td>';
				}
				$strhtml .= 	'<td>&nbsp;</td>';												// Pembatas Kolom
				if(($perKolom * 2 + $i) < $rowcounts)
				{
						$row1 = $query->row($perKolom * 2 + $i);
						$tgl  = date("d-m-Y", strtotime($row1->tanggal));
						$jns = $row1->jenis;
						if(strtolower($jns) == 's') $jenis = 'Sakit';
						elseif(strtolower($jns) == 'i') $jenis = 'Ijin';
						elseif(strtolower($jns) == 't') $jenis = 'Terlambat';
						elseif(strtolower($jns) == 'a') $jenis = 'Alpha';
					$strhtml .= '<td class="tengah2">'.($perKolom * 2 + $i + 1).'</td>';
					$strhtml .= '<td class="tengah2">'.$tgl.'</td>';
					$strhtml .= '<td class="tengah2">'.$jenis.'</td>';
				}
				else
				{
					$strhtml .= '<td>&nbsp;</td>';
					$strhtml .= '<td>&nbsp;</td>';
					$strhtml .= '<td>&nbsp;</td>';
				}
				$strhtml .= '</tr>';
				$nomer++;
			}
			$strhtml .= '</table>';
			$mpdf->WriteHTML($strhtml);
			$strhtml = '';
		}
		elseif($semua == 1)
		{
			$strhtml .= $this->headerRaporPDF($nama_kelas, $semester, $nama, $tapel, $induk, $nisn);
			$strhtml .= '<div style="text-align: center">';
			$strhtml .= 	'<h3>DAFTAR HADIR SISWA</h3><br/>';
			$strhtml .= 	'<h4 style="margin-top:-34px;">Tanggal : '.$tgl_awal.' s/d '.$tgl_akhir.'</h4><br/>';
			$strhtml .= '</div>';
			$strhtml .= $this->ctkPresensiKelas($kelas, $tglAwal, $tglAkhir, $nama_kelas);
			$mpdf->WriteHTML($strhtml);
			$strhtml = '';
		}
		else
		{
			$urut = 0;
			$query1 = $this->db->select('*')
						->from('tb_presensi')
						->join('tb_siswa', 'tb_siswa.no_induk = tb_presensi.induk', 'left')
						->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
						->where('tb_presensi.tanggal >=', $tglAwal)
						->where('tb_presensi.tanggal <=', $tglAkhir)
						->group_by('tb_kelas.kd_kelas')
						->get();
			$jmlKls = $query1->num_rows();
			$query = $this->db->select('*')
						->from('tb_kelas')
						->get();
			foreach($query->result() as $row)
			{
				$klsPlh = $row->kd_kelas;
				$query1 = $this->db->select('*')
							->from('tb_presensi')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_presensi.induk', 'left')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
							->where('tb_presensi.tanggal >=', $tglAwal)
							->where('tb_presensi.tanggal <=', $tglAkhir)
							->where('tb_kelas.kd_kelas', $klsPlh)
							->get();
				if($query1->num_rows() > 0)
				{
					$row1 = $query1->row();
					$nama_kelas = $row1->nama_kelas;
					$kelas = $row1->kd_kelas;
					$induk = 'all';
					$strhtml .= $this->headerRaporPDF($nama_kelas, $semester, $nama, $tapel, $induk, $nisn);
					$strhtml .= '<div style="text-align: center">';
					$strhtml .= 	'<h3>DAFTAR HADIR SISWA</h3><br/>';
					$strhtml .= 	'<h4 style="margin-top:-34px;">Tanggal : '.$tgl_awal.' s/d '.$tgl_akhir.'</h4><br/>';
					$strhtml .= '</div>';
					$strhtml .= $this->ctkPresensiKelas($kelas, $tglAwal, $tglAkhir, $nama_kelas);
					$mpdf->WriteHTML($strhtml);
					$urut++;
					if($urut < $jmlKls)
						$mpdf->AddPage();
					$strhtml = '';
				}
			}
		}
		
		if($semua == 2)
			$NamaFile   = 'Presensi-'.$no_ujian_smp.'.pdf';
		elseif($semua == 1)
			$NamaFile   = 'Presensi-'.$kelas.'.pdf';
		elseif($semua == 0)
			$NamaFile   = 'Presensi-All.pdf';
		
		$mpdf->WriteHTML($stylesheet,1);
		$mpdf->Output($NamaFile,'D');
			
		exit;
	}

	function ctkPresensiKelas($kelas, $tglAwal, $tglAkhir, $nama_kelas)
	{
		$strhtml = '';
		$query1 = $this->db->select('*')
					->from('tb_presensi')
					->join('tb_siswa', 'tb_siswa.no_induk = tb_presensi.induk', 'left')
					->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
					->where('tanggal >=', $tglAwal)
					->where('tanggal <=', $tglAkhir)
					->where('tb_kelas.kd_kelas', $kelas)
					->get();
		$rowcounts = $query1->num_rows();
		if($rowcounts > 0)
		{
			$row1 = $query1->row();
			$nama_kelas	= $row1 -> nama_kelas;
			$perHal = 60;
			$jmlHal = ceil($rowcounts / $perHal);
			for($j = 0; $j < $jmlHal; $j++)
			{
				$awal = $j * $perHal;
				$query1 = $this->db->select('*')
						->from('tb_presensi')
						->join('tb_siswa', 'tb_siswa.no_induk = tb_presensi.induk', 'left')
						->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
						->where('tanggal >=', $tglAwal)
						->where('tanggal <=', $tglAkhir)
						->limit($perHal, $awal)
						->where('tb_kelas.kd_kelas', $kelas)
						->order_by('tb_siswa.nama', 'asc')
						->order_by('tb_presensi.tanggal', 'asc')
						->get();
				$rowcounts1 = $query1->num_rows();
				$perKolom = ceil($rowcounts1 / 2);
				$strhtml .= '<div class="font12" style="margin-top:-28px;">';
				if($j == 0)
					$strhtml .= 	'<b>Kelas : '.$nama_kelas.'</b><br/>';
				else
					$strhtml .= 	'<b>Kelas : '.$nama_kelas.' <i>(lanjutan)</i></b><br/>';
				$strhtml .= '</div>';
				$strhtml .=	'<table class="rapor">';
				$strhtml .= 	'<tr>';
				$strhtml .= 		'<td class="bgClr tengah2" style="width: 6%;">No</td>';			// Tabel 1
				$strhtml .= 		'<td class="bgClr tengah2" style="width: 23%;">Nama</td>';
				$strhtml .= 		'<td class="bgClr tengah2" style="width: 13%;">Tanggal</td>';
				$strhtml .= 		'<td class="bgClr tengah2" style="width: 8%;">Jenis</td>';
				if($rowcounts1 > 1)
				{
					$strhtml .= 	'<td style="width: 10px;">&nbsp;</td>';							// Pembatas Kolom
					$strhtml .= 	'<td class="bgClr tengah2" style="width: 6%;">No</td>';			// Tabel (Kolom) 2
					$strhtml .= 	'<td class="bgClr tengah2" style="width: 23%;">Nama</td>';
					$strhtml .= 	'<td class="bgClr tengah2" style="width: 13%;">Tanggal</td>';
					$strhtml .= 	'<td class="bgClr tengah2" style="width: 8%;">Jenis</td>';
				}
				$strhtml .= 	'</tr>';
				$nomer = 0;
				for($i = 0; $i < $perKolom; $i++)
				{
					$strhtml .= '<tr>';
					$row1 = $query1->row($i);
					$tgl  = date("d-m-Y", strtotime($row1->tanggal));
					$nama = $row1->nama;
					$jns  = $row1->jenis;
					if(strtolower($jns) == 's') $jenis = 'Sakit';
					elseif(strtolower($jns) == 'i') $jenis = 'Ijin';
					elseif(strtolower($jns) == 't') $jenis = 'Terlambat';
					elseif(strtolower($jns) == 'a') $jenis = 'Alpha';
					$strhtml .= 	'<td class="tengah2">'.($i+1).'</td>';
					$strhtml .= 	'<td class="tengah2">'.$nama.'</td>';
					$strhtml .= 	'<td class="tengah2">'.$tgl.'</td>';
					$strhtml .= 	'<td class="tengah2">'.$jenis.'</td>';
					$strhtml .= 	'<td>&nbsp;</td>';												// Pembatas Kolom
					if(($i + $perKolom) < $rowcounts1)
					{
						$row1 = $query1->row($i + $perKolom);
						$tgl  = date("d-m-Y", strtotime($row1->tanggal));
						$nama = $row1->nama;
						$jns  = $row1->jenis;
						if(strtolower($jns) == 's') $jenis = 'Sakit';
						elseif(strtolower($jns) == 'i') $jenis = 'Ijin';
						elseif(strtolower($jns) == 't') $jenis = 'Terlambat';
						elseif(strtolower($jns) == 'a') $jenis = 'Alpha';
						$strhtml .= '<td class="tengah2">'.($i + $perKolom + 1).'</td>';
						$strhtml .= '<td class="tengah2">'.$nama.'</td>';
						$strhtml .= '<td class="tengah2">'.$tgl.'</td>';
						$strhtml .= '<td class="tengah2">'.$jenis.'</td>';
					}
					else 
					{
						$strhtml .= '<td>&nbsp;</td>';
						$strhtml .= '<td>&nbsp;</td>';
						$strhtml .= '<td>&nbsp;</td>';
						$strhtml .= '<td>&nbsp;</td>';
					}
					$strhtml .= '</tr>';
					$nomer++;
				}
			}
			$strhtml .= '</table>';
		}
		return $strhtml;
	}
	
	// ======================================================================================
	// # Fungsi cetak Pelanggaran PDF
	// ======================================================================================
	function cetakLanggarPDF()
	{
		date_default_timezone_set("Asia/Jakarta");
		$level    = $this->session->userdata('level');
		
		if($level < 95)
		{
			$induk    = $this->input->post('induk');
			$tglAwal  = $this->input->post('tglAwal');
			$tglAkhir = $this->input->post('tglAkhir');
			$semua    = 2;
		}
		else
		{
			$semua    = $this->input->post('semua');
			$rekap    = $this->input->post('rekap');
			$tglAwal  = $this->input->post('tglCetak1');
			$tglAkhir = $this->input->post('tglCetak2');
			$kelas    = $this->input->post('kelasPilih');
			$induk    = $this->input->post('siswaSel');
			if($semua == 1)
			{
				$query = $this->db->select('*')
							->from('tb_kelas')
							->where('kd_kelas', $kelas)
							->get();
				if($query->num_rows() > 0)
				{
					$row = $query->row();
					$nama_kelas = $row->nama_kelas;
				}
				$induk = 'all';
			}
		}
		$NamaFile   = 'Pelanggaran-All.pdf';
		
		$query = $this->db->select('*')
					->from('tb_sekolah')
					->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$kota        = ucwords(strtolower($row->kota));
			$sekolah     = $row->nama_sekolah;
			$nama_kepsek = $row->kepsek;
			$nip_kepsek  = $row->nip;
			$website     = $row->website;
			$email       = $row->email;
			$tapelS		 = $row->tapel;
			$semes		 = $row->semester;
		}
		else
		{
			$kota		 = '';
			$sekolah	 = '';
			$nama_kepsek = '';
			$nip_kepsek  = '';
			$website     = '';
			$email       = '';
			$tapel		 = '';
			$semes		 = '';
		}
			
		$bulan		= array("Januari", "Februari", "Maret", "April",
							"Mei", "Juni", "Juli", "Agustus",
							"September", "Oktober", "nopember", "Desember");
								
		$tgl_awal = date("j", strtotime($tglAwal)) . ' ' . $bulan[(date("n", strtotime($tglAwal))-1)] . ' ' . date("Y", strtotime($tglAwal));
		$tgl_akhir = date("j", strtotime($tglAkhir)) . ' ' . $bulan[(date("n", strtotime($tglAkhir))-1)] . ' ' . date("Y", strtotime($tglAkhir));

		if($semes == 1) $semester = 'Ganjil'; else $semester	= 'Genap';
		$tapel      = $tapelS . ' - ' . ($tapelS + 1);

		if($semua == 2)
		{
			// Panggil Library mPdf
			$this->load->library('mpdf');
			//$mpdf = new mPDF('utf-8', 'Folio-L', 0, '', $kiri, $kanan, $atas, $bawah, $hdr, $ftr, 'L');	// ---- Cetak landscape
			$mpdf = new mPDF('utf-8', 'Folio', 0, '', 10, 10, 10, 10, 5, 15, '');		// ---- Cetak Potrait
			$mpdf->SetHeader('Pelanggaran Siswa||Hal. : {PAGENO} dari {nb}');
			$mpdf->SetFooter('http://'.$website.'|'.$sekolah.' '.$kota.'|e-mail : '.$email);
		
			// ============= Style =================
			$strhtml = $this->ambilCSSPdf();
			$mpdf->WriteHTML($strhtml);
			$strhtml = '';

			$query = $this->db->select('*')
						->from('tb_siswa')
						->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
						->where('tb_siswa.no_induk', $induk)
						->get();
			$row = $query->row();
			$no_induk		= $row -> no_induk;
			$no_ujian_smp	= $row -> no_ujian_smp;
			$nama			= $row -> nama;
			$nisn			= $row -> nisn;
			$kelas			= $row -> kelas;
			$nama_kelas		= $row -> nama_kelas;
			$tgl_lhr		= $row -> tgl_lhr;
		
			$this->cetakQRCode($no_ujian_smp, $nama);

			// ===================== Halaman 1 =============================
			$strhtml .= $this->headerRaporPDF($nama_kelas, $semester, $nama, $tapel, $no_induk, $nisn);
			$strhtml .= '<div style="text-align: center">';
			$strhtml .= 	'<h3>DAFTAR PELANGGARAN SISWA</h3><br/>';
			$strhtml .= 	'<h4 style="margin-top:-34px;">Tanggal : '.$tgl_awal.' s/d '.$tgl_akhir.'</h4><br/>';
			$strhtml .= '</div>';
		
			$nomer = 0;
			$strhtml .=	'<table class="rapor">';
			$strhtml .= 	'<tr class="bgClr">';
			$strhtml .= 		'<td class="tengah2" rowspan="2" style="width: 5%;font-weight: bold;">No</td>';
			$strhtml .= 		'<td class="tengah2" colspan="2" style="font-weight: bold;">Pelanggaran</td>';
			$strhtml .= 		'<td class="tengah2" colspan="4" style="font-weight: bold;">Penanganan</td>';
			$strhtml .= 	'</tr>';
			$strhtml .= 	'<tr class="bgClr">';
			$strhtml .= 		'<td class="tengah2" style="width:10%;font-weight: bold;">Tanggal</td>';
			$strhtml .= 		'<td class="tengah2" style="width:27%;font-weight: bold;">Macam</td>';
			$strhtml .= 		'<td class="tengah2" style="width:10%;font-weight: bold;">Tanggal</td>';
			$strhtml .= 		'<td class="tengah2" style="width:15%;font-weight: bold;">Oleh</td>';
			$strhtml .= 		'<td class="tengah2" style="width:27%;font-weight: bold;">Solusi</td>';
			$strhtml .= 		'<td class="tengah2" style="width: 6%;font-weight: bold;">Status</td>';
			$strhtml .= 	'</tr>';
		
			$nomer = 0;
			$query = $this->db->select('*')
						->from('tb_langgar')
						->where('induk', $induk)
						->where('tanggal >=', $tglAwal)
						->where('tanggal <=', $tglAkhir)
						->order_by('tanggal', 'asc')
						->get();
			foreach($query->result() as $row)
			{
				$nomer++;
				$tanggal = $row->tanggal;
				$masalah = $row->masalah;
				$tangani = $row->tangani;
				$oleh    = $row->oleh;
				$solusi  = $row->solusi;
				$sts     = $row->statusL;
				if(strtolower($sts) == 's') $status = 'Sudah';
				elseif(strtolower($sts) == 'b') $status = 'Belum';
				elseif(strtolower($sts) == 'p') $status = 'Proses';
				$strhtml .=		'<tr class="polos">';
				$strhtml .= 		'<td class="tengah2">'.$nomer.'</td>';
				$strhtml .= 		'<td class="tengah2">'.$tanggal.'</td>';
				$strhtml .= 		'<td class="kiri1"><b>'.$masalah.'</b></td>';
				$strhtml .= 		'<td class="tengah2">'.$tangani.'</td>';
				$strhtml .= 		'<td class="tengah2">'.$oleh.'</td>';
				$strhtml .= 		'<td class="kiri1"><b>'.$solusi.'</b></td>';
				$strhtml .= 		'<td class="tengah2"><b>'.$status.'</b></td>';
				$strhtml .= 	'</tr>';
			}
		
			$strhtml .= '</table>';
			$mpdf->WriteHTML($strhtml);
		}
		else
		{
			// Panggil Library mPdf
			$this->load->library('mpdf');
			//$mpdf = new mPDF('utf-8', 'Folio-L', 0, '', $kiri, $kanan, $atas, $bawah, $hdr, $ftr, 'L');	// ---- Cetak landscape
			$mpdf = new mPDF('utf-8', 'Folio-L', 0, '', 10, 10, 10, 10, 5, 15, '');		// ---- Cetak Potrait
			$mpdf->SetHeader('Pelanggaran Siswa||Hal. : {PAGENO} dari {nb}');
			$mpdf->SetFooter('http://'.$website.'|'.$sekolah.' '.$kota.'|e-mail : '.$email);
		
			// ============= Style =================
			$strhtml = $this->ambilCSSPdf();
			$mpdf->WriteHTML($strhtml);
			$strhtml = '';

			$urut = 0;
			if($semua == 0)
			{
				$query1 = $this->db->select('*')
							->from('tb_langgar')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_langgar.induk', 'left')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
							->where('tb_langgar.tanggal >=', $tglAwal)
							->where('tb_langgar.tanggal <=', $tglAkhir)
							->group_by('tb_kelas.kd_kelas')
							->get();
				$jmlKls = $query1->num_rows();
				$query = $this->db->select('*')
							->from('tb_kelas')
							->get();
			}
			else
			{
				$jmlKls = 1;
				$query = $this->db->select('*')
							->from('tb_kelas')
							->where('kd_kelas', $kelas)
							->get();
			}
			foreach($query->result() as $row)
			{
				$klsPlh = $row->kd_kelas;
				$query1 = $this->db->select('*')
							->from('tb_langgar')
							->join('tb_siswa', 'tb_siswa.no_induk = tb_langgar.induk', 'left')
							->join('tb_kelas', 'tb_kelas.kd_kelas = tb_siswa.kelas', 'left')
							->where('tb_langgar.tanggal >=', $tglAwal)
							->where('tb_langgar.tanggal <=', $tglAkhir)
							->where('tb_kelas.kd_kelas', $klsPlh)
							->order_by('tb_siswa.nama', 'asc')
							->order_by('tb_langgar.tanggal', 'asc')
							->get();
				if($query1->num_rows() > 0)
				{
					$nomer  = 1;
					$row1 = $query1->row();
					$nama_kelas = $row1->nama_kelas;
					$kelas = $row1->kd_kelas;
					$no_induk = 'all';
					$strhtml  = $this->headerRaporPDF($nama_kelas, $semester, $nama, $tapel, $no_induk, $nisn);
					$strhtml .= '<div style="text-align: center">';
					$strhtml .= 	'<h3>DAFTAR PELANGGARAN SISWA</h3><br/>';
					$strhtml .= 	'<h4 style="margin-top:-34px;">Tanggal : '.$tgl_awal.' s/d '.$tgl_akhir.'</h4><br/>';
					$strhtml .= '</div>';
					$strhtml .=	'<table class="rapor" style="font-size:14px;">';
					$strhtml .= 	'<tr class="bgClr">';
					$strhtml .= 		'<td class="tengah2" rowspan="2" style="width: 2%;font-weight: bold;">No</td>';
					$strhtml .= 		'<td class="tengah2" colspan="4" style="font-weight: bold;">Pelanggaran</td>';
					$strhtml .= 		'<td class="tengah2" colspan="4" style="font-weight: bold;">Penanganan</td>';
					$strhtml .= 	'</tr>';
					$strhtml .= 	'<tr class="bgClr">';
					$strhtml .= 		'<td class="tengah2" style="width:8%;font-weight: bold;">Tanggal</td>';
					$strhtml .= 		'<td class="tengah2" style="width:5%;font-weight: bold;">Induk</td>';
					$strhtml .= 		'<td class="tengah2" style="width:15%;font-weight: bold;">Nama</td>';
					$strhtml .= 		'<td class="tengah2" style="width:25%;font-weight: bold;">Macam</td>';
					$strhtml .= 		'<td class="tengah2" style="width:6%;font-weight: bold;">Tanggal</td>';
					$strhtml .= 		'<td class="tengah2" style="width:10%;font-weight: bold;">Oleh</td>';
					$strhtml .= 		'<td class="tengah2" style="width:25%;font-weight: bold;">Solusi</td>';
					$strhtml .= 		'<td class="tengah2" style="width: 4%;font-weight: bold;">Status</td>';
					$strhtml .= 	'</tr>';
					foreach($query1->result() as $row1)
					{
						$tanggal = $row1->tanggal;
						$induk   = $row1->induk;
						$nama    = $row1->nama;
						$macam   = $row1->masalah;
						$tangani = $row1->tangani;
						$oleh    = $row1->oleh;
						$solusi  = $row1->solusi;
						$sts     = $row1->statusL;
						if(strtolower($sts) == 'b') $status = 'Belum';
						elseif(strtolower($sts) == 's') $status = 'Sudah';
						elseif(strtolower($sts) == 'p') $status = 'Proses';
						$strhtml .= 	'<tr class="polos">';
						$strhtml .= 		'<td class="tengah2" style="width:%;font-weight: bold;">'.$nomer.'</td>';
						$strhtml .= 		'<td class="tengah2" style="width:8%;font-weight: bold;">'.$tanggal.'</td>';
						$strhtml .= 		'<td class="tengah2" style="width:5%;font-weight: bold;">'.$induk.'</td>';
						$strhtml .= 		'<td class="kiri1" style="width:15%;font-weight: bold;">'.$nama.'</td>';
						$strhtml .= 		'<td class="kiri1" style="width:25%;font-weight: bold;">'.$macam.'</td>';
						$strhtml .= 		'<td class="tengah2" style="width:6%;font-weight: bold;">'.$tangani.'</td>';
						$strhtml .= 		'<td class="tengah2" style="width:10%;font-weight: bold;">'.$oleh.'</td>';
						$strhtml .= 		'<td class="kiri1" style="width:25%;font-weight: bold;">'.$solusi.'</td>';
						$strhtml .= 		'<td class="tengah2" style="width: 4%;font-weight: bold;">'.$status.'</td>';
						$strhtml .= 	'</tr>';
						$nomer++;
					}
					$strhtml .= '</table>';
			
					$mpdf->WriteHTML($strhtml);
					$urut++;
					if($urut < $jmlKls)
						$mpdf->AddPage();
				}
			}
		}
		
		if($semua == 2)
			$NamaFile   = 'Pelanggaran-'.$no_ujian_smp.'.pdf';
		elseif($semua == 1)
			$NamaFile   = 'Pelanggaran-'.$kelas.'.pdf';
		else
			$NamaFile   = 'Pelanggaran-All.pdf';
		$mpdf->WriteHTML($stylesheet,1);
		$mpdf->Output($NamaFile,'D');
			
		exit;
	}

	// =====================================================================================
	// # Fungsi cetak Rapor
	// ======================================================================================
	public function raporSiswaPDF()
	{
		$tapel = $this->input->post('tapelSel');
		$semes = $this->input->post('semesSel');
		$no_ujian_smp = $this->session->userdata('username');
		
		$query = $this->db->select('*')
					->from('tb_siswa')
					->where('no_ujian_smp', $no_ujian_smp)
					->get();
		$row = $query->row();
		$induk = $row->no_induk;
		
		$query = $this->db->select('*')
					->from('tb_nilai')
					->where('tapel', $tapel)
					->where('semester', $semes)
					->where('induk', $induk)
					->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$noRec = $row -> no;
			$this->isiRaporPDF($noRec, 2, '', '', '');
		}
		//else redirect('home');
		
		exit;
	}
	



	
}


