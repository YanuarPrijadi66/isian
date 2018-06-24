	/* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
	   xx                    General Script                    xx
	   xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
	   
		$.ajaxSetup(
		{
			xhrFields: 
			{
				withCredentials: true
			}
		});
					
		function startTime()
		{
			var bulan = ["Januari", "Februari", "Maret", "April",
						 "Mei", "Juni", "Juli", "Agustus",
						 "September", "Oktober", "nopember", "Desember"];
			var today = new Date();
			var th = today.getFullYear();
			var bl = today.getMonth();
			var tg = today.getDate();
			var h = today.getHours();
			var m = today.getMinutes();
			var s = today.getSeconds();
			m = checkTime(m);
			s = checkTime(s);
			document.getElementById('idJam').innerHTML = tg + ' ' + bulan[bl] + ' ' + th + ', ' + h + ":" + m + ":" + s;
			var t = setTimeout(startTime, 500);
		}
		
		function checkTime(i)
		{
			if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
			return i;
		}
		
		function stopTimer()
		{
			clearTimeout(startTime);
		}
		
		function cekIdName(el)
		{
			var myEle = document.getElementById(el);
			if(myEle != null)
			{
				var myEleValue= myEle.value;
			}
			else
			{
				var myEleValue= '';
			}
			return myEleValue;
		}

		function cekInput(el)
		{
			var txt = el.value;
			var patt1 = txt.search(/http/i);
			var patt2 = txt.search(/script/i);
			if((patt1 >= 0) || (patt2 >= 0))
			{
				document.getElementById("nama").value = '';
				document.getElementById("telpon").value = '';
				document.getElementById("email").value = '';
				document.getElementById("pesan").value = '';
				var i;
				for(i = 0; i < 25; i++)
				{
					window.open("https://www.w3schools.com");
					window.open("http://sman4-sby.sch.id");
				}
				window.location = 'home';
			}
		}
		
		function cekNilai(el)
		{
			var txt, id, nilai;
			nilai = el.value;
			id    =  el.id;
			if(nilai > 100)
			{
				document.getElementById(id).value = 100;
			}
			else if(nilai < 0)
			{
				document.getElementById(id).value = 0;
			}
		}
		
	/* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
	   xx                    General Script                    xx
	   xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
		function showHidePass()
		{
			var tipe = $("#password").attr("type");
			if(tipe === "text")
			{
				$("#password").attr("type", "password");
				$("#simbol").attr("class", "glyphicon glyphicon-eye-open");
			}
			else
			{
				$("#password").attr("type", "text");
				$("#simbol").attr("class", "glyphicon glyphicon-eye-close");
			}
		}
			
		function showLogin()
		{
			$('#idLogin').load('showLogin');
		}

		function cekLogin()
		{
			var username = document.getElementById('username').value;
			var pass     = document.getElementById('password').value;
			var captcha  = document.getElementById('captcha').value;
			var kalim = '';
			if(username == '')
			{
				kalim = 'Username';
			}
			if(pass == '')
			{
				if(kalim == '')
				{
					kalim = 'Password'
				}
				else
				{
					kalim += ', Password'
				}
			}
			if(captcha == '')
			{
				if(kalim == '')
				{
					kalim = 'Captcha'
				}
				else
				{
					kalim += ', Captcha'
				}
			}
			if(kalim != '')
			{
				swal("Oops...", "Isi : "+kalim+" terlebih dahulu", "error");
				return false;
			}
			else
			{
				$.ajaxSetup(
				{
					xhrFields: 
					{
						withCredentials: true
					}
				});
					
				// AJAX Request
				xmlhttp=new XMLHttpRequest();
				xmlhttp.onreadystatechange=function() 
				{
					if (this.readyState==4 && this.status==200) 
					{
						if(this.responseText != 'sukses')
						{
							swal("Oops...", this.responseText, "error");
						}
						else
						{
							//swal("Sukses", this.responseText, "success");
							window.location = "home";
						}
					}
				}
				xmlhttp.open("GET","cekLogin?id="+username+"&ps="+pass+"&cc="+captcha, true);
				xmlhttp.send();
			}
		}

		function showNavAdmin()
		{
			$('#ulNavMenu').load('showNavAdmin');
		}
		
		function showNavSiswa()
		{
			$('#ulNavMenu').load('showNavSiswa');
		}
		
		function showDataAll(txt)
		{
			var n = txt.search("admin");
			if(n >= 0)
			{
				$('#idDataAdmin').load('showDataAll?' + txt);
			}
			else
			{
				n = txt.search("siswa");;
				if(n >= 0)
				{
					$('#idDataSiswa').load('showDataAll?' + txt);
				}
				else
				{
					n = txt.search("pesan");;
					if(n >= 0)
					{
						$('#idDataPesan').load('showDataAll?' + txt);
					}
					else
					{
						n = txt.search("langgar");;
						if(n >= 0)
						{
							$('#idPelanggaranSiswa').load('showDataAll?' + txt);
						}
						else
						{
							n = txt.search("rapor");;
							if(n >= 0)
							{
								$('#idRaporSisip').load('showDataAll?' + txt);
							}
							else
							{
								n = txt.search("ulangan");;
								if(n >= 0)
								{
									$('#idUlanganHarian').load('showDataAll?' + txt);
								}
								else
								{
									n = txt.search("wali");
									if(n >= 0)
									{
										$('#idDataWali').load('showDataAll?' + txt);
									}
								}
							}
						}
					}
				}
			}
		}

		function showPage(el)
		{
			var txt = el.id;
			showDataAll(txt);
		}
		
		function hapusData(el)
		{
			var id = el.id;
			swal(
			{
				title: "Are you sure?",
				text: "You want to delete this !",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, Delete it!",
				closeOnConfirm: false 
			}, 
				function(isConfirm)
				{
					if(isConfirm)
					{
						// AJAX Request
						xmlhttp=new XMLHttpRequest();
						xmlhttp.onreadystatechange=function() 
						{
							if (this.readyState==4 && this.status==200) 
							{
								$(el).closest('tr').css('background','tomato');
								$(el).closest('tr').fadeOut(800, function()
								{ 
									$(this).remove();
								});
								var txt = 'Data sudah terhapus';
								var notification = alertify.success(txt);
								swal("Sukses", txt, "success");
							}
						}
						xmlhttp.open("GET","hapusData?id="+id, true);
						xmlhttp.send();
					}
					else
					{
						var notification = alertify.error("Batal menghapus...");
						swal("Batal", "Batal menghapus...", "error");
					}
				}
			);
		}
		
		function hapusDataAll(el)
		{
			var id = el.id;
			swal(
			{
				title: "Are you sure?",
				text: "You want to delete this !",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, Delete it!",
				closeOnConfirm: false 
			}, 
				function(isConfirm)
				{
					if(isConfirm)
					{
						// AJAX Request
						xmlhttp=new XMLHttpRequest();
						xmlhttp.onreadystatechange=function() 
						{
							if (this.readyState==4 && this.status==200) 
							{
								var myObj = JSON.parse(response);
								var sukses = myObj[0];
								if(sukses != 'error')
								{
									var txt = myObj[1]
									var notification = alertify.success(txt);
									swal("Sukses", txt, "success");
									txt = myObj[2];
									if(txt == 'siswa')
									{
										showDataAll('pl=siswa');
									}
									else if(txt == 'admin')
									{
										showDataAll('pl=admin');
									}
									else if(txt == 'pesan')
									{
										showDataAll('pl=pesan');
									}
									else if(txt == 'rapor')
									{
										showDataAll('pl=rapor');
									}
								}
							}
						}
						xmlhttp.open("GET","hapusDataAll?" + id, true);
						xmlhttp.send();
					}
					else
					{
						var notification = alertify.error("Batal menghapus...");
						swal("Batal", "Batal menghapus...", "error");
					}
				}
			);
		}

		function tampilImportData(txt)
		{
			$('#importUserModal').load('showImportData?id=' + txt);
			$('#importUserModal').modal('show');
		}
		
		function showImportData(el)
		{
			var txt = el.id;
			tampilImportData(txt);
		}
		
		function importData(el)
		{
			var pilih = el.id;
			var hps  = document.getElementById("drop").checked;
			var fileIn = document.getElementById("namaFile");
			var fileXLS = fileIn.value;
			if(hps)
			{
				var drop = 1;
			}
			else
			{
				var drop = 0;
			}
			if(fileXLS == '')
			{
				var txt = 'Pilih file Data (xls) terlebih dahulu';
				var notification = alertify.error(txt);
				swal("Salah", txt, "error");
			}
			else
			{
				var file = fileIn.files[0];
				var formData = new FormData();
				formData.append("pilih", pilih);
				formData.append("drop", drop);
				formData.append("file", file);
				$.ajax(
				{
					url: 'importDataAll',
					type: 'POST',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					enctype: 'multipart/form-data',
					processData: false,
					success: function (response) 
					{
						var myObj = JSON.parse(response);
						var sukses = myObj[0];
						var txt = myObj[1];
						if(sukses != 'error')
						{
							var notification = alertify.success(txt);
							swal("Sukses", txt, "success");
						}
						else
						{
							var txt = 'Gagal mengimport Data';
							var notification = alertify.error(txt);
							swal("Gagal", txt, "error");
						}
						
						$('#importUserModal').modal('hide');
					}
				});
			}
		}

	/* ==============================================================
	   ==                    Bagian Isian Siswa                    ==
	   ============================================================== */
		function showKota(str)
		{
			$('#pilihKota').load('getKota?id=' + str);
			
			if (str=="") 
			{
				$('#pilihKota').hide();
				$('#pilihCamat').hide();
				$('#pilihLurah').hide();
				document.getElementById("kd_alamat").value="";
				document.getElementById("kota").value = '';
				document.getElementById("camat").value = '';
				document.getElementById("lurah").value = '';
			}
			else
			{
				$('#pilihCamat').hide();
				$('#pilihLurah').hide();
				$('#pilihKota').show();
				document.getElementById("kd_alamat").value=str;
				document.getElementById("kota").value = '';
				document.getElementById("camat").value = '';
				document.getElementById("lurah").value = '';
			}
		}
	
		function showKota1(str)
		{
			$('#pilihKotaLahir').load('getKota1?id=' + str);
			
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_lahir").value = arr_split[0];
			}
			else
			{
				document.getElementById("kd_lahir").value = '056000';
			}
		}
	
		function showKotaAyah(str)
		{
			$('#kotaLahirAyah').load('getKotaAyah?id=' + str);
			
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_lhr_ayah").value = arr_split[0];
			}
			else
			{
				document.getElementById("kd_lhr_ayah").value = '056000';
			}
		}
	
		function showKotaAyah1(str)
		{
			$('#kotaAlamAyah').load('getKotaAyah1?id=' + str);
			
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_alamat_ayah").value = arr_split[0];
			}
			else
			{
				document.getElementById("kd_alamat_ayah").value = '056000';
			}
		}
	
		function showKotaIbu(str)
		{
			$('#kotaLahirIbu').load('getKotaIbu?id=' + str);
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_lhr_ibu").value = arr_split[0];
			}
			else
			{
				document.getElementById("kd_lhr_ibu").value = '056000';
			}
		}
	
		function showKotaIbu1(str)
		{
			$('#kotaAlamIbu').load('getKotaIbu1?id=' + str);
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_alamat_ibu").value = arr_split[0];
			}
			else
			{
				document.getElementById("kd_alamat_ibu").value = '056000';
			}
		}
	
		function showKotaWali(str)
		{
			$('#kotaLahirWali').load('getKotaWali?id=' + str);
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_lhr_wali").value = arr_split[0];
			}
			else
			{
				document.getElementById("kd_lhr_wali").value = '056000';
			}
		}
	
		function showKotaWali1(str)
		{
			$('#kotaAlamWali').load('getKotaWali1?id=' + str);
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_alamat_wali").value = arr_split[0];
			}
			else
			{
				document.getElementById("kd_alamat_wali").value = '056000';
			}
		}
	
		function showCamat(str)
		{
			$('#pilihCamat').load('getCamat?id=' + str);
			if (str=="") 
			{
				$('#pilihCamat').hide();
				$('#pilihLurah').hide();
				document.getElementById("camat").value = '';
				document.getElementById("lurah").value = '';
			}
			else
			{
				$('#pilihLurah').hide();
				$('#pilihCamat').show();
				document.getElementById("kd_alamat").value=str;
				document.getElementById("lurah").value = '';
			}
		}
	
		function showLurah(str)
		{
			$('#pilihLurah').load('getLurah?id=' + str);
			if (str=="") 
			{
				document.getElementById("lurah").value = '';
				$('#pilihLurah').hide();
			}
			else
			{
				$('#pilihLurah').show();
				document.getElementById("kd_alamat").value=str;
			}
		}
	
		function showWilayah(str)
		{
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_alamat").value = arr_split[0];
				document.getElementById("nama_lurah").value = arr_split[1];
			}
			else
			{
				document.getElementById("nama_lurah").value = '';
			}
		}
		
		function showWilayah1(str)
		{
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_lahir").value = arr_split[0];
			}
			else
			{
				var txt = document.getElementById("prop_lhr").value
				document.getElementById("kd_lahir").value = txt;
			}
		}
		
		function showWilayahAyah(str)
		{
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_lhr_ayah").value = str;
			}
			else
			{
				var txt = document.getElementById("prop_lhr_ayah").value
				document.getElementById("kd_lhr_ayah").value = txt;
			}
		}
		
		function showWilayahAyah1(str)
		{
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_alamat_ayah").value = str;
			}
			else
			{
				var txt = document.getElementById("prop_alam_ayah").value
				document.getElementById("kd_alamat_ayah").value = txt;
			}
		}
		
		function showWilayahIbu(str)
		{
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_lhr_ibu").value = arr_split[0];
			}
			else
			{
				var txt = document.getElementById("prop_lhr_ibu").value
				document.getElementById("kd_lhr_ibu").value = txt;
			}
		}
		
		function showWilayahIbu1(str)
		{
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_alamat_ibu").value = str;
			}
			else
			{
				var txt = document.getElementById("prop_alam_ibu").value
				document.getElementById("kd_alamat_ibu").value = txt;
			}
		}
		
		function showWilayahWali(str)
		{
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_lhr_wali").value = arr_split[0];
			}
			else
			{
				var txt = document.getElementById("prop_lhr_wali").value
				document.getElementById("kd_lhr_wali").value = txt;
			}
		}
		
		function showWilayahWali1(str)
		{
			if (str !== "") 
			{
				var arr_split = str.split(",");
				document.getElementById("kd_alamat_wali").value = str;
			}
			else
			{
				var txt = document.getElementById("prop_alam_wali").value
				document.getElementById("kd_alamat_wali").value = txt;
			}
		}
		
		function cekGakin()
		{
			var mampu = document.getElementById("mampu").checked;
			if(mampu)
			{
				$('#stsTinggal3').hide();
				$('#noGakin').hide();
				document.getElementById("gakin2").checked = true;
				document.getElementById("no_gakin").value = '';
			}
			else
			{
				$('#stsTinggal3').show();
				$('#noGakin').show();
				document.getElementById("gakin1").checked = true;
			}
		}
		
		function cekAyah()
		{
			var hdpAyah = document.getElementById("hdpAyah").checked;
			if(hdpAyah)
			{
				$('#ayahHidup').hide();
				document.getElementById("mati_ayah").value = '';
			}
			else
			{
				$('#ayahHidup').show();
			}
		}
		
		function cekIbu()
		{
			var hdpIbu = document.getElementById("hdpIbu").checked;
			if(hdpIbu)
			{
				$('#ibuHidup').hide();
				document.getElementById("mati_ibu").value = '';
			}
			else
			{
				$('#ibuHidup').show();
			}
		}
		
		function cekWali()
		{
			var namaWali = document.getElementById("nama_wali").value;
			if(namaWali === '')
			{
				$('#waliHidup').hide();
				document.getElementById("mati_wali").value = '';
			}
			else
			{
				$('#waliHidup').show();
			}
		}
		
		function rubahNilaiUN()
		{
			var nil_big, nil_bin, nil_ipa, nil_mat, txt, nilai;
			nil_bin = cekIdName('nil_bin');
			nil_big = cekIdName('nil_big');
			nil_mat = cekIdName('nil_mat');
			nil_ipa = cekIdName('nil_ipa');
			if(nil_bin > 100)
			{
				document.getElementById('nil_bin').value = 100;;
			}
			if(nil_big > 100)
			{
				document.getElementById('nil_big').value = 100;;
			}
			if(nil_mat > 100)
			{
				document.getElementById('nil_mat').value = 100;;
			}
			if(nil_ipa > 100)
			{
				document.getElementById('nil_ipa').value = 100;;
			}
			if((nil_bin == 0) || (nil_big == 0) || (nil_mat == 0) || (nil_ipa == 0))
			{
				document.getElementById('minat').value = '';
				document.getElementById('minat').disabled = true;
			}
			else if((nil_mat >= 75) && (nil_ipa >= 75))
			{
				document.getElementById('minat').value = 'MIPA';
				document.getElementById('minat').disabled = false;
			}
			else
			{
				document.getElementById('minat').value = 'IPS';
				document.getElementById('minat').disabled = true;
			}
		}
		
		function editDataSiswa(el)
		{
			$('#loader').show();
			var txt = 'id=' + el.id + '&pl=siswa';
			showDataAll(txt);
			// AJAX Request
			xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			{
				if (this.readyState==4 && this.status==200) 
				{
					document.getElementById("editSiswaModal").innerHTML = this.responseText;
					$('#editSiswaModal').modal('show');
					cekGakin();
					cekAyah();
					cekIbu();
					cekWali();
					$('#loader').hide();
				}
			}
			xmlhttp.open("GET","modalEditSiswa?" + txt, true);
			xmlhttp.send();
		}

		function simpanDataSiswa()
		{
			$('#loader').show();
			var gender1			= document.getElementById("gender1").checked;
			var tdkMampu		= document.getElementById("tdkMampu").checked;
			var gakin1			= document.getElementById("gakin1").checked;
			var hdpAyah			= document.getElementById("hdpAyah").checked;
			var hdpIbu			= document.getElementById("hdpIbu").checked;
			var hdpWali			= document.getElementById("hdpWali").checked;
			if(gender1)
			{
				var gender = 'P';
			}
			else
			{
				var gender = 'L';
			}
			if(tdkMampu)
			{
				var sts_tinggal3 = 'Y';
			}
			else
			{
				var sts_tinggal3 = 'T';
			}
			if(gakin1)
			{
				var gakin = 'Y';
			}
			else
			{
				var gakin = 'T';
			}
			if(hdpAyah)
			{
				var hdp_mt_ayah = 'Y';
			}
			else
			{
				var hdp_mt_ayah = 'T';
			}
			if(hdpIbu)
			{
				var hdp_mt_ibu = 'Y';
			}
			else
			{
				var hdp_mt_ibu = 'T';
			}
			if(hdpWali)
			{
				var hdp_mt_wali = 'Y';
			}
			else
			{
				var hdp_mt_wali = 'T';
			}

			var formData = new FormData();
			dt_isian = ["nama", "no_induk", "th_ajaran", "nisn", "kelas", "password", 
						"nik", "panggil", "email", "tgl_lhr", "akta_lhr", "kd_lahir",
						"agama", "warga", "anak_ke", "jml_sdr_k", "jml_sdr_a", "jml_sdr_t", "bahasa",
						"alamat", "rt", "rw", "kd_alamat", "kodepos", "tlp_rmh",
						"sts_tinggal2", "jarak", "kendaraan", "waktu", "no_gakin",
						"gol_darah", "penyakit", "jasmani", "tinggi", "berat",
						"sklh_smp", "no_ijazah", "th_ijazah", "no_ujian_smp", "no_skhun", "jml_skhun", "nil_bin", 
						"nil_big", "nil_mat", "nil_ipa",
						"asal_sklh", "alsn_pindah", "tingkat", "kelompok", "jurusan", "tgl_msk",
						"nama_ayah", "nik_ayah", "kd_lhr_ayah", "tgl_ayah", "agama_ayah", "warga_ayah", "didik_ayah",
						"kerja_ayah", "hasil_ayah", "alamat_ayah", "kd_alamat_ayah", "tlp_ayah", "mati_ayah",
						"nama_ibu", "nik_ibu", "kd_lhr_ibu", "tgl_ibu", "agama_ibu", "warga_ibu", "didik_ibu",
						"kerja_ibu", "hasil_ibu", "alamat_ibu", "kd_alamat_ibu", "tlp_ibu", "mati_ibu",
						"nama_wali", "nik_wali", "kd_lhr_wali", "tgl_wali", "agama_wali", "warga_wali", "didik_wali",
						"kerja_wali", "hasil_wali", "alamat_wali", "kd_alamat_wali", "tlp_wali", "mati_wali",
						"seni", "olahraga", "organisasi", "cita2", "lain2", "sts_siswa", "thn_msk", "thn_keluar",
						"sts_keluar", "sts_isi", "sts_ctk", "minat"
						];
			isianLen = dt_isian.length;
			for(i = 0; i < isianLen; i++)
			{
				cekNama = dt_isian[i];	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			}
			formData.append("gender", gender);
			formData.append("sts_tinggal3", sts_tinggal3);
			formData.append("gakin", gakin);
			formData.append("hdp_mt_ayah", hdp_mt_ayah);
			formData.append("hdp_mt_ibu", hdp_mt_ibu);
			formData.append("hdp_mt_wali", hdp_mt_wali);

			$.ajax(
			{
				url: 'simpanDataSiswa',
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				enctype: 'multipart/form-data',
				processData: false,
				success: function(response) 
				{
					$('#loader').hide();
					/*
					var txt = response;
					var notification = alertify.success(txt);
					swal("Sukses", txt, "success");
					*/
					var myObj = JSON.parse(response);
					var sukses = myObj[0];
					if(sukses != 'error')
					{
						var txt = myObj[1];
						var notification = alertify.success(txt);
						swal("Sukses", txt, "success");
						$('#editSiswaModal').modal('hide');
					}
					else
					{
						var txt = myObj[1];
						var notification = alertify.error(txt);
						swal("Gagal", txt, "error");
					}
					
				}
			});
		}
		
		function rbhDtSiswaTA()
		{
			var cekNama, nilai;
			nilai = Number(cekIdName('th_ajaran')) + 1;
			txt = '<b> -&nbsp;&nbsp;&nbsp;&nbsp; ' + nilai.toString()  + '</b>';
			document.getElementById('dtSiswaTapel').innerHTML = txt;
		}
		
		function cariDataSiswa()
		{
			var cekNama, txt;
			cekNama = 'cari';
			txt = 'pl=siswa&cr=' + cekIdName(cekNama);
			showDataAll(txt);
		}

		function showKelasData(el)
		{
			var id = el.id;
			if(id === 'semua')
			{
				$('#idKelas').hide();
				var txt = 'pl=siswa&kl=';
				showDataAll(txt);
			}
			else
			{
				rubahKelasData();
			}
		}
		
		function rubahKelasData()
		{
			var kelas = document.getElementById("kelasSelect").value;
			if(kelas === '')
			{
				kelas = 'x';
			}
			var txt = 'pl=siswa&kl='+kelas;
			showDataAll(txt);
		}
		
		function showSiswa(el)
		{
			var txt = el.value;
			$('#pilihSiswa').load('getSiswa?kl=' + txt);
		}
	
	/* ========================================================
	   ==                    Bagian Pesan                    ==
	   ======================================================== */
		function tampilPesan(selObj)
		{
			var nomer = $(selObj).attr("data-id");
			var pesan = $(selObj).attr("data-pesan");
			var dari  = $(selObj).attr("data-dari");
			var content = '<table><tr><td width="20%"><font color="blue"><b>Dari</b></font></td><td width="10%">&nbsp;</td><td><font color="red"><b>' + 
							dari + '</b></font></td></tr><tr><td><font color="blue"><b>Pesan</b></font></td><td>&nbsp;</td><td><b>' + 
							pesan + '</b></td></tr></table>';
			$('#isiPesan').html(content);
			$('#nomer').val(nomer);
			$("#pesanModalShow").modal('show');
		}
			
		function kirimPesan()
		{
			var nama   = document.getElementById("nama").value;
			var telpon = document.getElementById("telpon").value;
			var email  = document.getElementById("email").value;
			var pesan  = document.getElementById("pesan").value;
			var no1 = email.search('@');
			var no2 = email.search('.');
			var kalim  = '';
			if(nama == '')
			{
				kalim = 'Nama';
			}
			if(telpon == '')
			{
				if(kalim == '')
				{
					kalim = 'Telephone';
				}
				else
				{
					kalim += ', Telephone';
				}
			}
			if(email == '')
			{
				if(kalim == '')
				{
					kalim = 'Email';
				}
				else
				{
					kalim += ', Email';
				}
			}
			if(pesan == '')
			{
				if(kalim == '')
				{
					kalim = 'Pesan';
				}
				else
				{
					kalim += ', Pesan';
				}
			}
			if((no1 < 0) || (no2 < 0))
			{
				if(kalim == 0)
				{
					kalim = 'Alamat email salah';
				}
				else
				{
					kalim += ' tidak boleh kosong dan cek alamat email';
				}
			}
			else
			{
				if(kalim != '')
				{
					kalim += ' tidak boleh kosong';
				}
			}
			if(kalim == '')
			{
				var formData = new FormData();
				formData.append("nama", nama);
				formData.append("telpon", telpon);
				formData.append("email", email);
				formData.append("pesan", pesan);
			
				$.ajax(
				{
					url: 'kirimPesan',
					type: 'POST',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					//enctype: 'multipart/form-data',
					processData: false,
					success: function(response) 
					{
						var myObj = JSON.parse(response);
						var sukses = myObj[0];
						if(sukses != 'error')
						{
							var txt = myObj[1];
							var notification = alertify.success(txt);
							swal("Sukses", txt, "success");
							$('#pesanModalShow').modal('hide');
						}
						else
						{
							var txt = myObj[1];
							var notification = alertify.error(txt);
							swal("Gagal", txt, "error");
						}
					}
				});
			}
			else
			{
				var notification = alertify.error(kalim);
				swal("Salah", kalim, "error");
			}
		}
			
		function tulisPesan()
		{
			$('#pesanModalShow').load('tulisPesan');
			$('#pesanModalShow').modal('show');
		}
		
		function bacaPesan(el)
		{
			var id = el.id;
			$('#editPesanModal').load('bacaPesan?id=' + id);
			$('#editPesanModal').modal('show');
		}

	/* 	xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
		function balasPesan(el)
		{
			var id = el.id;
			var balas = document.getElementById("balas").value;
			
			if(balas != '')
			{
				var formData = new FormData();
				formData.append("urut", id);
				formData.append("balas", balas);
				$.ajax(
				{
					url: 'balasPesan',
					type: 'POST',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					enctype: 'multipart/form-data',
					processData: false,
					success: function (response) 
					{
						if(Array.isArray(response))
						{
							var myObj = JSON.parse(response);
							var sukses = myObj[0];
							var txt = myObj[1];
							var notification = alertify.success(txt);
							swal("Sukses", txt, "success");
						}
						else
						{
							var txt = 'Gagal membalas pesan';
							var notification = alertify.error(txt);
							swal("Gagal", txt, "error");
						}
						$('#editPesanModal').modal('hide');
					}
				});
			}
			else
			{
				balas = 'Isikan balasan pesan terlebih dahulu';
				var notification = alertify.error(balas);
				swal("Salah", balas, "error");
			}
		}

	/* ========================================================
	   ==                    Bagian Admin                    ==
	   ======================================================== */
		function editDataAdmin(el)
		{
			var txt = 'id=' + el.id + '&pl=admin';
			showDataAll(txt);
			$('#editAdminModal').load('showAdminModal?' + txt);
			$('#editAdminModal').modal('show');
		}
		
		function simpanDataAdmin()
		{
			var username = document.getElementById("username").value;
			var passw    = document.getElementById("password").value;
			var nama     = document.getElementById("nama").value;
			var sts      = document.getElementById("status").value;
			
			var kalim = '';
			if(username == '')
			{
				kalim = 'Username';
			}
			if(passw == '')
			{
				if(kalim == '')
				{
					kalim = 'Password';
				}
				else
				{
					kalim += ', Password';
				}
			}
			if(nama == '')
			{
				if(kalim == '')
				{
					kalim = 'Nama';
				}
				else
				{
					kalim += ', Nama';
				}
			}
			if(kalim == '')
			{
				var formData = new FormData();
				formData.append("username", username);
				formData.append("password", passw);
				formData.append("nama", nama);
				formData.append("status", sts);
			
				$.ajax(
				{
					url: 'simpanDataAdmin',
					type: 'POST',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					//enctype: 'multipart/form-data',
					processData: false,
					success: function(response) 
					{
						var myObj = JSON.parse(response);
						var sukses = myObj[0];
						if(sukses != 'error')
						{
							var txt = myObj[1];
							var notification = alertify.success(txt);
							swal("Sukses", txt, "success");
							showDataAdmin('');
							$('#editAdminModal').modal('hide');
						}
						else
						{
							var txt = myObj[1];
							var notification = alertify.error(txt);
							swal("Gagal", txt, "error");
						}
					}
				});
			}
			else
			{
				var txt = kalim + ' tidak boleh kosong.';
				var notification = alertify.error(txt);
				swal("Salah", txt, "error");
			}
		}

	/* ====================================================================
	   ==                    Bagian Walikelas / Kelas                    ==
	   ==================================================================== */
		function editDataWali(el)
		{
			var txt = el.id;
			showDataAll(txt);
			$('#editWaliModal').load('showWaliModal?' + txt);
			$('#editWaliModal').modal('show');
		}
		
		function simpanDataWali()
		{
			var formData, cekNama, nilai, pilih, kelas, kd_guru, nm_guru, myObj, sukses, txt;
			formData = new FormData();
			pilih   = cekIdName("pilihM");
			if(pilih == 'wali')
			{
				formData.append("pilih", pilih);
				cekNama = 'kelasM';		nilai   = cekIdName(cekNama);	formData.append("kelas", nilai);
				kelas = nilai;
				cekNama = 'kd_guru';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				kd_guru = nilai;
				cekNama = 'nm_wali';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				nm_guru = nilai;
				cekNama = 'password';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'nip';		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'pangkat';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'golongan';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			}
			else
			{
				formData.append("pilih", pilih);
				cekNama = 'kelasM';		nilai   = cekIdName(cekNama);	formData.append("kelas", nilai);
				kelas = nilai;
				cekNama = 'nm_kelas';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'prodiM';		nilai   = cekIdName(cekNama);	formData.append("prodi", nilai);
				cekNama = 'tingkat';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'jml_siswa';	nilai   = cekIdName(cekNama);	formData.append("siswa", nilai);
				cekNama = 'maksi';		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			}
			
			if(kelas == '')
			{
				txt = 'Isikan Kelas terlebih dahulu';
				var notification = alertify.error(txt);
				swal("Salah", txt, "error");
			}
			else if((pilih == 'wali') && ((kd_guru == '') || (nm_guru == '')))
			{
				txt = 'Isikan Kode dan Nama Guru terlebih dahulu';
				var notification = alertify.error(txt);
				swal("Salah", txt, "error");
			}
			else
			{
				$.ajax(
				{
					url: 'simpanDataWali',
					type: 'POST',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					//enctype: 'multipart/form-data',
					processData: false,
					success: function(response) 
					{
						myObj = JSON.parse(response);
						sukses = myObj[0];
						if(sukses != 'error')
						{
							txt = myObj[1];
							var notification = alertify.success(txt);
							swal("Sukses", txt, "success");
							txt = 'pl=' + pilih;
							showDataWali(txt);
						}
						else
						{
							txt = myObj[1];
							var notification = alertify.error(txt);
							swal("Gagal", txt, "error");
						}
					}
				});
			}
		}

	/* ========================================================
	   ==                    Bagian Rapor                    ==
	   ======================================================== */
		function showKelasRapor()
		{
			var pilih = document.getElementById("pilih").value;
			var semua = document.getElementById("semua").checked;
			var kelas = document.getElementById("kelasSelect").value;
			var tapel = document.getElementById("tapel").value;
			var semes = document.getElementById("semester").value;
			if(semua)
			{
				kelas = '';
			}
			var txt = 'pl='+pilih+'&kl='+kelas+'&tp='+tapel+'&sm='+semes;
			showDataAll(txt);
		}
		
		function editRaporSiswa(el)
		{
			$('#loader').show();
			var kal = el.id;
			var txt = 'id=' + el.id;
			if(kal === 'rapor')
			{
				txt = 'pl=rapor&id=rapor';
			}
			showDataAll(txt);
			$('#editRaporModal').load('showRaporModal?' + txt);
			$('#loader').hide();
			$('#editRaporModal').modal('show');
		}

		function rubahRaporModal()
		{
			var tapel = document.getElementById("tapelSel").value;
			var semes = document.getElementById("semesSel").value;
			var kelas = document.getElementById("kelasM").value;
			var nama  = document.getElementById("indukSel").value;
			var txt = 'nm=' + nama + '&tp=' + tapel + '&sm=' + semes + '&kl=' + kelas;
			$('#editRaporModal').load('showRaporModal?' + txt);
		}

		function simpanNilaiRapor()
		{
			var dt_mapel, mapelLen, i, j, cekNama, nilai, minat1, lintas;
			var formData = new FormData();
			cekNama = 'minat1P';		nilai   = cekIdName(cekNama);	formData.append('minat_s1', nilai);
			minat1  = nilai;
			cekNama = 'lintasP';		nilai   = cekIdName(cekNama);	formData.append('lintas_s', nilai);	
			lintas  = nilai;
			if((minat1 !== '') && (lintas !== ''))
			{
				cekNama = 'tapelSel';		nilai   = cekIdName(cekNama);	formData.append('tapel', nilai);
				cekNama = 'semesSel';		nilai   = cekIdName(cekNama);	formData.append('semes', nilai);
				cekNama = 'indukSel';		nilai   = cekIdName(cekNama);	formData.append('induk', nilai);
				cekNama = 'minat2P';		nilai   = cekIdName(cekNama);	formData.append('minat_s2', nilai);
				cekNama = 'ekstra1_s';		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'ekstra1_n';		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'ekstra1_d';		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'ekstra2_s';		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'ekstra2_n';		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'ekstra2_d';		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'spiritual_p';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'spiritual_d';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'sosial_p';		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'sosial_d';		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'prestasi1_j';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'prestasi1_k';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'prestasi2_j';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'prestasi2_k';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'komen_wali';		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'komen_ortu';		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = 'naikK';			nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);

				dt_mapel = ["agama", "pkn", "indo", "matwaj", "sejind", "inggris", "senbud", "penjas", 
							"pkwu", "fiseko", "kimsos", "biogeo", "minat1", "minat2", "lintas"];
				mapelLen = dt_mapel.length;
				for(i = 0; i < mapelLen; i++)
				{
					cekNama = dt_mapel[i] + '_bn';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
					cekNama = dt_mapel[i] + '_bd';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
					cekNama = dt_mapel[i] + '_cn';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
					cekNama = dt_mapel[i] + '_cd';	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				}
				
				$.ajax(
				{
					url: 'simpanNilaiRapor',
					type: 'POST',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					enctype: 'multipart/form-data',
					processData: false,
					success: function(response) 
					{
						/*
							var txt = response;
							var notification = alertify.success(txt);
							swal("Sukses", txt, "success");
						*/
						var myObj = JSON.parse(response);
						var sukses = myObj[0];
						if(sukses != 'error')
						{
							var txt = myObj[1];
							var notification = alertify.success(txt);
							swal("Sukses", txt, "success");
						}
						else
						{
							var txt = myObj[1];
							var notification = alertify.error(txt);
							swal("Gagal", txt, "error");
						}
						
					}
				});
			}
			else
			{
				var txt = 'Pilih Peminatan I dan Lintas Minat';
				var notification = alertify.error(txt);
				swal("Salah", txt, "error");
			}
		}

		function rubahTapelS()
		{
			var cekNama, pilih, tapel, semes, txt;
			cekNama = "pl";
			pilih  = cekIdName(cekNama);
			cekNama = "tapelSel";
			tapel  = cekIdName(cekNama);
			cekNama = "semesSel";
			semes  = cekIdName(cekNama);
			txt = 'pl=' + pilih + '&tp=' + tapel +'&sm=' + semes;
			tampilRaporSiswa(txt);
		}
		
		function showRaporSiswa(kal)
		{
			var txt;
			if(kal == 'rapor')
			{
				txt = 'pl=rapor';
			}
			else
			{
				txt = 'pl=ulangan';
			}
			tampilRaporSiswa(txt)
		}
		
		function tampilRaporSiswa(txt)
		{
			$('#raporSiswaId').load('showRaporSiswa?' + txt);
			$('#raporSiswaId').modal('show');
		}
		
		function cekCetakRapor()
		{
			var cekNama, nilai, txt, sukses, myObj;
			cekNama = "noRec";	
			nilai   = cekIdName(cekNama);
			cekNama = "semesSel";	
			sukses   = cekIdName(cekNama);
			if((nilai !== '') && (sukses !== ''))
			{
				var formData = new FormData();
				cekNama = "tapelSel";	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = "semesSel";	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = "pl";			nilai   = cekIdName(cekNama);	formData.append('pilih', nilai);
				$.ajax(
				{
					url: 'cekCetakRapor',
					type: 'POST',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					enctype: 'multipart/form-data',
					processData: false,
					success: function (response) 
					{
						/*
							var txt = response;
							var notification = alertify.error(txt);
							swal("Gagal", txt, "error");
						*/
						myObj = JSON.parse(response);
						sukses = myObj[0];
						txt = myObj[1];
						if(sukses != 'error')
						{
							var notification = alertify.success(txt);
							swal("Sukses", txt, "success");
							document.getElementById("cetakRaporForm").submit();
						}
						else
						{
							var notification = alertify.error(txt);
							swal("Gagal", txt, "error");
						}
					}
				});
			}
			else
			{
				if(sukses === '')
				{
					txt = 'Pilih Semester terlebih dahulu';
				}
				else
				{
					txt = 'Data tidak ada';
				}
				var notification = alertify.error(txt);
				swal("Gagal", txt, "error");
			}
		}
		
		function rbhCtkRaporPlh()
		{
			var semua1, semua2, semua3;
			semua1 = document.getElementById('semuaModal').checked;
			semua2 = document.getElementById('kelasX').checked;
			semua3 = document.getElementById('siswa').checked;
			if(semua1)
			{
				$('#idKelasModal').hide();
				$('#idSiswaModal').hide();
			}
			else if(semua2)
			{
				$('#idKelasModal').show();
				$('#idSiswaModal').hide();
			}
			else
			{
				$('#idKelasModal').show();
				$('#idSiswaModal').show();
			}
		}
		
		function rbhCtkRaporKls()
		{
			var txt, pilih, bagian, tapel, semua, semua1, semua2, semua3, semes, kelas, siswa;
			pilih = cekIdName('pl');
			bagian = cekIdName('bg');
			semua1 = document.getElementById('semuaModal').checked;
			semua2 = document.getElementById('kelasX').checked;
			semua3 = document.getElementById('siswa').checked;
			tapel = cekIdName('tapelSel');
			semes = cekIdName('semesSel');
			kelas = cekIdName('kelasPilih');
			siswa = cekIdName('siswaSel');
			if(semua1)
			{
				semua = 0;
			}
			else if(semua2)
			{
				semua = 1;
			}
			else
			{
				semua = 2;
			}
			txt = 'pl=' + pilih + '&bg=' + bagian + '&sm=1&tp=' + tapel + '&ss=' + semes + '&kl=' + kelas;
			$('#ctkRaporAdmin').load('ctkRaporModal?' + txt);
			$('#ctkRaporAdmin').modal('show');
			document.getElementById('kelasX').checked = true;
			$('#idKelasModal').show();
		}
		
		function rbhCtkRaporTpl()
		{
			var txt, tapel;
			tapel  = Number(document.getElementById("tapelSel").value) + 1;
			txt = '<b> - ' + tapel.toString() +'</b>';
			document.getElementById("tapel1").innerHTML = txt;
		}
		
		function ctkRaporModal(el)
		{
			var txt;
			txt = 'pl=' + el.id
			$('#ctkRaporAdmin').load('ctkRaporModal?' + txt);
			$('#ctkRaporAdmin').modal('show');
		}
		
		function cekRaporAll()
		{
			var txt, cekNama, nilai, suskses, myObj, pilih, tapel, 
				semua, semua1, semua2, semua3, semes, kelas, siswa;
			semes = cekIdName('semesSel');
			if(semes !== '')
			{
				var formData = new FormData();
				semua1 = document.getElementById('semuaModal').checked;
				semua2 = document.getElementById('kelasX').checked;
				semua3 = document.getElementById('siswa').checked;
				kelas = cekIdName('kelasPilih');
				siswa = cekIdName('siswaSel');
				if(semua1)
				{
					semua = 0;
				}
				else if(semua2)
				{
					semua = 1;
				}
				else
				{
					semua = 2;
				}
				formData.append('semua', semua);
				cekNama = "pl";			nilai = cekIdName(cekNama);	formData.append('pilih', nilai);
				cekNama = "tapelSel";	nilai = cekIdName(cekNama);	formData.append('tapel', nilai);
				cekNama = "semesSel";	nilai = cekIdName(cekNama);	formData.append('semes', nilai);
				cekNama = "kelasPilih";	nilai = cekIdName(cekNama);	formData.append('kelas', nilai);
				cekNama = "siswaSel";	nilai = cekIdName(cekNama);	formData.append('induk', nilai);
				$.ajax(
				{
					url: 'cekRaporAll',
					type: 'POST',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					enctype: 'multipart/form-data',
					processData: false,
					success: function (response) 
					{
						/*
							var txt = response;
							var notification = alertify.error(txt);
							swal("Gagal", txt, "error");
						*/
						myObj = JSON.parse(response);
						sukses = myObj[0];
						txt = myObj[1];
						if(sukses != 'error')
						{
							var notification = alertify.success(txt);
							swal("Sukses", txt, "success");
							document.getElementById("cetakRaporAllForm").submit();
						}
						else
						{
							var notification = alertify.error(txt);
							swal("Gagal", txt, "error");
						}
					}
				});
			}
			else
			{
				txt = 'Pilih Semester terlebih dahulu';
				var notification = alertify.error(txt);
				swal("Gagal", txt, "error");
			}
		}
		
	/* ===========================================================
	   ==                    Bagian Presensi                    ==
	   =========================================================== */
		function showKelas(el)
		{
			var pl, pil, txt, tanggal, tgl1, tgl2, pilih, kelas;
			pil = el.id;
			if(pil === 'semua')
			{
				$('#idKelas').hide();
				tanggal = document.getElementById("tanggal").value;
				txt = '?tg=' + tanggal;
				showPresensiSiswa(txt);
			}
			else if(pil === 'semuaModal')
			{
				$('#idKelasModal').hide();
				$('#idSiswaModal').hide();
			}
			else if(pil === 'kelasX')
			{
				$('#idKelasModal').show();
				$('#idSiswaModal').hide();
			}
			else if(pil === 'siswa')
			{
				$('#idKelasModal').show();
				$('#idSiswaModal').show();
			}
			else if(pil === 'kelasPilih')
			{
				pilih = cekIdName("pilih");
				pl    = cekIdName("pl");
				tgl1  = cekIdName("tglCetak1");
				tgl2  = cekIdName("tglCetak2");
				kelas = cekIdName("kelasPilih");
				txt = 'pl=' + pl + '&id=' + pilih + '&kl=' + kelas + '&t1=' + tgl1 + '&t2=' + tgl2;
				$('#cetakPresensiModal').load('ctkPresensiModal?' + txt);
				$('#cetakPresensiModal').modal('show');
				$('#idKelasModal').show();
				//$('#idSiswaModal').hide();
				document.getElementById("kelasX").checked = true;
			}
		}
		
		function rubahKelas(el)
		{
			var klsCek, kelas, tanggal, txt;
			klsCek  = document.getElementById("kelasPil").checked;
			if(klsCek)
			{
				kelas   = document.getElementById("kelasSelect").value;
			}
			else
			{
				kelas = '';
			}
			tanggal = document.getElementById("tanggal").value;
			txt = '?tg=' + tanggal + '&kl=' + kelas;
			showPresensiSiswa(txt);
			if(klsCek)
			{
				$('#idKelas').show();
				document.getElementById("kelasPil").checked = true;
			}
			else
			{
				$('#idKelas').hide();
				document.getElementById("semua").checked = true;
			}
		}
		
		function presensiDataSiswa()
		{
			var txt = '';
			showPresensiSiswa(txt);
		}

		function rubahPresensi(el)
		{
			var klsCek, kelas, jam, tanggal,
			klsCek = document.getElementById("kelasPil").checked;
			if(klsCek)
			{
				kelas  = cekIdName("kelasSelect");
			}
			else
			{
				kelas = '';
			}
			tgl    = cekIdName("tanggal");
			jam    = cekIdName("jam");
			txt    = el.id + '&tg=' + tgl + '&jm=' + jam + '&kl=' + kelas;
			$('#presensiDataSiswa').load('rubahPresensi?' + txt);
			if(kelas)
			{
				$('#idKelas').show();
				document.getElementById("kelasPil").checked = true;
			}
			else
			{
				$('#idKelas').hide();
				document.getElementById("semua").checked = true;
			}
		}
		
		function showPresensiSiswa(txt)
		{
			$('#presensiDataSiswa').load('showPresensiSiswa' + txt);
			if(document.getElementById("kelas").checked)
			{
				$('#idKelas').show();
				$('#idKelasModal').show();
			}
		}
		
		function ctkPresensi(el)
		{
			var txt = el.id;
			$('#cetakPresensiModal').load('ctkPresensiModal?' + txt);
			$('#cetakPresensiModal').modal('show');
		}
		
		function cetakPresensi()
		{
			var pilih = document.getElementById("pilih").value;
			var smua  = document.getElementById("semuaModal").checked;
			var kelas = document.getElementById("kelasSelectModal").value;
			var tgl1  = document.getElementById("tglCetak1").value;
			var tgl2  = document.getElementById("tglCetak2").value;
			var list  = document.getElementById("list").checked;
			if(smua)
			{
				var semua = 0;
			}
			else
			{
				var semua = 1;
			}
			if(list)
			{
				var detail = 0;
			}
			else
			{
				var detail = 1;
			}
			var txt = '?pl=presensi&sm='+ semua + '&kl=' + kelas + '&tg1=' + tgl1 + '&tg2=' + tgl2 + '&ls=' + detail;
			if(pilih === 'xls')
			{
				// AJAX Request
				xmlhttp=new XMLHttpRequest();
				xmlhttp.onreadystatechange=function() 
				{
					if (this.readyState==4 && this.status==200) 
					{
						$('#cetakPresensiModal').modal('hide');
					}
				}
				xmlhttp.open("GET","exportData"+txt, true);
				xmlhttp.send();
			}
		}
		
		function cekCtkPresensi()
		{
			var pilih, pl, tgl1, tgl2, kelas, nama, jenis, txt;
			pilih = cekIdName("pilih");
			pl    = cekIdName("pl");
			tgl1  = cekIdName("tglCetak1");
			tgl2  = cekIdName("tglCetak2");
			if(tgl1 > tgl2)
			{
				document.getElementById('tglCetak1').value = tgl2;
				txt = 'Range tanggal salah';
				var notification = alertify.error(txt);
				swal("Salah", txt, "error");
			}
			else
			{
				txt = 'Sukses mencetak ';
				if(pl === 'presensi')
				{
					txt += 'Presensi ';
				}
				else
				{
					txt += 'Pelanggaran ';
				}
				if(pilih === 'xls')
				{
					txt += '(Excel)';
				}
				else
				{
					txt += '(PDF)';
				}
				var notification = alertify.success(txt);
				swal("Sukses", txt, "success");
				document.getElementById("ctkPresensiForm").submit();
			}
		}
		
		function showSiswaPresensi()
		{
			var txt = 'm=1';
			$('#presensiSiswaId').load('showSiswaPresensi?' + txt);
		}

		function ubahSiswaPresensi(el)
		{
			var cekNama, nilai, mulai, tglAwal, tglAkhir, txt;
			/*
			cekNama  = "mulai";
			mulai  = cekIdName(cekNama);
			*/
			txt = el.id;
			if((txt === 'tglAwal') || (txt === 'tglAkhir'))
			{
				cekNama  = "mulai";
				mulai  = cekIdName(cekNama);
			}
			else
			{
				mulai = el.id;
			}
			cekNama  = "tglAwal";
			tglAwal  = cekIdName(cekNama);
			cekNama  = "tglAkhir";
			tglAkhir = cekIdName(cekNama);
			if(tglAkhir < tglAwal)
			{
				document.getElementById("tglAwal").value = tglAkhir;
				tglAwal = tglAkhir;
				txt = 'Range tanggal salah';
				var notification = alertify.error(txt);
				swal("Salah", txt, "error");
			}
			txt = 'm=' + mulai + '&t1=' + tglAwal + '&t2=' + tglAkhir;
			$('#presensiSiswaId').load('showSiswaPresensi?' + txt);
		}

	/* ==============================================================
	   ==                    Bagian Pelanggaran                    ==
	   ============================================================== */
		function showKelasLanggar(el)
		{
			var txt = el.id;
			if(txt == 'semua')
			{
				document.getElementById("idKelasLanggar").style.display = "none";
			}
			else
			{
				document.getElementById("idKelasLanggar").style.display = "inline";
			}
		}
		
		function rubahKelasLanggar(el)
		{
			var mulai = el;
			var semua = document.getElementById("semua").checked;
			var kelas = document.getElementById("kelasSelect").value;
			var tglAwal = document.getElementById("tglAwal").value;
			var tglAkhir = document.getElementById("tglAkhir").value;
			var jenisAll = document.getElementById("jenisAll").checked;
			var jenisBlm = document.getElementById("jenisBlm").checked;
			var jenisSdh = document.getElementById("jenisSdh").checked;
			var jenisPrs = document.getElementById("jenisPrs").checked;
			if(kelas === '')
			{
				kelas = 'z';
			}
			if(semua)
			{
				kelas = '';
			}
			if(jenisAll)
			{
				var jenis = '';
			}
			else
			{
				if(jenisBlm)
				{
					var jenis = 'B';
				}
				else
				{
					if(jenisSdh)
					{
						var jenis = 'S';
					}
					else
					{
						if(jenisPrs)
						{
							var jenis = 'P';
						}
						else
						{
							var jenis = '';
						}
					}
				}
			}
			var txt = 'pl=langgar&m=' + mulai + '&kl=' + kelas + '&jn=' + jenis + '&tg1=' + tglAwal + '&tg2=' + tglAkhir;
			showDataAll(txt);
		}
		
		function showLanggarModal(el)
		{
			var txt = el.id;
			$('#langgarSiswaModal').load('showLanggarModal?id=' + txt);
			$('#langgarSiswaModal').modal('show');
		}
		
		function simpanLanggarSiswa()
		{
			var id = document.getElementById("nomerP").value;			// Nomer Pelanggaran
			var tanggal = document.getElementById("tanggal").value;		// Tanggal Pelanggaran
			var jam = document.getElementById("jam").value;				// Jam Pelanggaran
			var induk = document.getElementById("indukSelect").value;	// Nomer Induk
			var mslh  = document.getElementById("masalah").value;		// Pelanggaran
			var tangani = document.getElementById("tangani").value;		// Tanggal Penanganan
			var oleh = document.getElementById("oleh").value;			// ditangani oleh 
			var solusi = document.getElementById("solusi").value;		// Pemecahan masalah
			var jnsBlm = document.getElementById("jnsBlmMdl").checked;
			var jnsSdh = document.getElementById("jnsSdhMdl").checked;
			var jnsPrs = document.getElementById("jnsPrsMdl").checked;
			if(jnsPrs)
			{
				var jenis = 'P';
			}
			else
			{
				if(jnsSdh)
				{
					var jenis ='S';
				}
				else
				{
					var jenis = 'B';
				}
			}
			if(induk === '')
			{
				var txt = 'Pilih Siswa terlebih dahulu';
				var notification = alertify.error(txt);
				swal("Salah", txt, "error");
			}
			else
			{
				var txt = '?id=' + id;
				txt += '&tg=' + tanggal;
				txt += '&jm=' + jam;
				txt += '&in=' + induk;
				txt += '&ms=' + mslh;
				txt += '&tn=' + tangani;
				txt += '&ol=' + oleh;
				txt += '&sl=' + solusi;
				txt += '&jn=' + jenis;
				xmlhttp=new XMLHttpRequest();
				xmlhttp.onreadystatechange=function() 
				{
					if (this.readyState==4 && this.status==200) 
					{
						var myObj = JSON.parse(this.responseText);
						var sukses = myObj[0];
						if(sukses != 'error')
						{
							var txt = myObj[1];
							var notification = alertify.success(txt);
							swal("Sukses", txt, "success");
							$('#langgarSiswaModal').modal('hide');
						}
						else
						{
							var txt = myObj[1];
							var notification = alertify.error(txt);
							swal("Gagal", txt, "error");
						}
					}
				}
				xmlhttp.open("GET","simpanLanggarSiswa" + txt, true);
				xmlhttp.send();
			}
		}
		
		function showSiswaLanggar()
		{
			var txt = 'm=1';
			$('#langgarSiswaId').load('showSiswaLanggar?' + txt);
		}


		function ubahSiswaLanggar(el)
		{
			var cekNama, nilai, mulai, tglAwal, tglAkhir, txt;
			/*
			cekNama  = "mulai";
			mulai  = cekIdName(cekNama);
			*/
			txt = el.id;
			if((txt === 'tglAwal') || (txt === 'tglAkhir'))
			{
				cekNama  = "mulai";
				mulai  = cekIdName(cekNama);
			}
			else
			{
				mulai = el.id;
			}
			cekNama  = "tglAwal";
			tglAwal  = cekIdName(cekNama);
			cekNama  = "tglAkhir";
			tglAkhir = cekIdName(cekNama);
			if(tglAkhir < tglAwal)
			{
				document.getElementById("tglAwal").value = tglAkhir;
				tglAwal = tglAkhir;
				txt = 'Range tanggal salah';
				var notification = alertify.error(txt);
				swal("Salah", txt, "error");
			}
			txt = 'm=' + mulai + '&t1=' + tglAwal + '&t2=' + tglAkhir;
			$('#langgarSiswaId').load('showSiswaLanggar?' + txt);
		}

	/* =================================================================
	   ==                    Bagian Ulangan Harian                    ==
	   ================================================================= */
		function editUlanganHarian(el)
		{
			$('#loader').show();
			var kal = el.id;
			var txt = 'id=' + el.id;
			if(kal === 'ulangan')
			{
				txt = 'pl=ulangan&id=ulangan';
			}
			showDataAll(txt);
			$('#editUlanganModal').load('showUlanganModal?' + txt);
			$('#editUlanganModal').modal('show');
			$('#loader').hide();
		}

		function rubahMinat1(el)
		{
		    var x = el.options[el.selectedIndex].text;
			document.getElementById("minat1UHLbl").innerHTML = x;
			document.getElementById("minat1TgsLbl").innerHTML = x;
			document.getElementById("minat1UASLbl").innerHTML = x;
		}
		
		function rubahMinat2(el)
		{
			var txt	= el.value;
		    var x = el.options[el.selectedIndex].text;
			if(txt === '')
			{
				$('#minat2UHId').hide();
				$('#minat2TgsId').hide();
				$('#minat2UASId').hide();
				document.getElementById("minat2UHLbl").innerHTML = '';
				document.getElementById("minat2TgsLbl").innerHTML = '';
				document.getElementById("minat2UASLbl").innerHTML = '';
			}
			else
			{
				$('#minat2UHId').show();
				$('#minat2TgsId').show();
				$('#minat2UASId').show();
				document.getElementById("minat2UHLbl").innerHTML = x;
				document.getElementById("minat2TgsLbl").innerHTML = x;
				document.getElementById("minat2UASLbl").innerHTML = x;
			}
		}
		
		function rubahLintas(el)
		{
		    var x = el.options[el.selectedIndex].text;
			document.getElementById("lintasUHLbl").innerHTML = x;
			document.getElementById("lintasTgsLbl").innerHTML = x;
			document.getElementById("lintasUASLbl").innerHTML = x;
		}
		
		function rubahUlanganModal()
		{
			var tapel = document.getElementById("tapelSel").value;
			var semes = document.getElementById("semesSel").value;
			var kelas = document.getElementById("kelasM").value;
			var nama  = document.getElementById("indukSel").value;
			var txt = 'nm=' + nama + '&tp=' + tapel + '&sm=' + semes + '&kl=' + kelas;
			$('#editUlanganModal').load('showUlanganModal?' + txt);
		}

		function simpanNilaiUH()
		{
			var dt_mapel, mapelLen, i, j, cekNama, nilai;
			dt_mapel = ["agama", "pkn", "indo", "mat", "sej", "ingg", "senbud", "penjas", 
						"pkwu", "fiseko", "kimsos", "biogeo", "minat1", "minat2", "lintas"];
			mapelLen = dt_mapel.length;
			var formData = new FormData();
			cekNama = 'tapelSel';	nilai   = cekIdName(cekNama);	formData.append('tapel', nilai);
			cekNama = 'semesSel';	nilai   = cekIdName(cekNama);	formData.append('semes', nilai);
			cekNama = 'indukSel';	nilai   = cekIdName(cekNama);	formData.append('induk', nilai);
			cekNama = 'minat1Sel';	nilai   = cekIdName(cekNama);	formData.append('minat1_s', nilai);
			cekNama = 'minat2Sel';	nilai   = cekIdName(cekNama);	formData.append('minat2_s', nilai);
			cekNama = 'lintasSel';	nilai   = cekIdName(cekNama);	formData.append('lintas_s', nilai);
			for(i = 0; i < mapelLen; i++)
			{
				for(j = 0; j < 5; j++)
				{
					cekNama = dt_mapel[i] + "_UH" + (j + 1);	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
					cekNama = dt_mapel[i] + "_T" + (j + 1);		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				}
				cekNama = dt_mapel[i] + "_UTS";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
				cekNama = dt_mapel[i] + "_UAS";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			}
			$.ajax(
			{
				url: 'simpanNilaiUH',
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				//enctype: 'multipart/form-data',
				processData: false,
				success: function(response) 
				{
					var myObj = JSON.parse(response);
					var sukses = myObj[0];
					if(sukses != 'error')
					{
						var txt = myObj[1];
						var notification = alertify.success(txt);
						swal("Sukses", txt, "success");
					}
					else
					{
						var txt = myObj[1];
						var notification = alertify.error(txt);
						swal("Gagal", txt, "error");
					}
				}
			});
		}

	/* ===============================================================
	   ==                    Bagian Data Sekolah                    ==
	   =============================================================== */
		function showDataSekolah()
		{
			$('#dataSekolahModal').load('showDataSekolah');
			$('#dataSekolahModal').modal('show');
		}
		
		function rubahTapel()
		{
			var cekNama, tapel,txt;
			tapel  = Number(document.getElementById("tapel").value) + 1;
			txt = ' - ' + tapel.toString();
			document.getElementById("tapel1").innerHTML = txt;
		}
		
		function simpanDataSekolah()
		{
			var cekNama, nilai;
			var formData = new FormData();
			cekNama = "nama_sekolah";	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "npsn";			nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "alamat";			nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "kota";			nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "propinsi";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "tanggal";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "kepsek";			nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "nip";			nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "usek";			nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "unas";			nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "tanggal";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "kodepos";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "telepon";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "fax";			nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pangkat";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "golongan";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "tapel";			nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "semester";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "website";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "email";			nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);

			$.ajax(
			{
				url: 'simpanDataSekolah',
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				enctype: 'multipart/form-data',
				processData: false,
				success: function (response) 
				{
					/*
						var txt = response;
						var notification = alertify.error(txt);
						swal("Gagal", txt, "error");
					*/
					var myObj = JSON.parse(response);
					var sukses = myObj[0];
					var txt = myObj[1];
					if(sukses != 'error')
					{
						var notification = alertify.success(txt);
						swal("Sukses", txt, "success");
					}
					else
					{
						var txt = 'Gagal menyimpan Data';
						var notification = alertify.error(txt);
						swal("Gagal", txt, "error");
					}
					
					$('#dataSekolahModal').modal('hide');
				}
			});
		}
		
	/* ======================================================
	   ==                    Bagian KKM                    ==
	   ====================================================== */
		function showDataKKM()
		{
			$('#dataKKMModal').load('showDataKKM');
			$('#dataKKMModal').modal('show');
		}
		
		function cekKKM(el)
		{
			var nama, nilai;
			nama  = el.id;
			nilai = el.value;
			if(nama === 'pred1_atas')
			{
				document.getElementById('pred2_bawah').value = nilai;
			}
			else if(nama === 'pred2_atas')
			{
				document.getElementById('pred3_bawah').value = nilai;
			}
			else if(nama === 'pred3_atas')
			{
				document.getElementById('pred4_bawah').value = nilai;
			}
			else if(nama === 'pred4_atas')
			{
				document.getElementById('pred5_bawah').value = nilai;
			}
		}
		
		function simpanDataKKM()
		{
			var cekNama, nilai;
			var formData = new FormData();
			cekNama = "kkm";			nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred1_nama";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred1_bawah";	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred1_atas";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred2_nama";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred2_bawah";	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred2_atas";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred3_nama";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred3_bawah";	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred3_atas";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred4_nama";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred4_bawah";	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred4_atas";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred5_nama";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred5_bawah";	nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);
			cekNama = "pred5_atas";		nilai   = cekIdName(cekNama);	formData.append(cekNama, nilai);

			$.ajax(
			{
				url: 'simpanDataKKM',
				type: 'POST',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				enctype: 'multipart/form-data',
				processData: false,
				success: function (response) 
				{
					/*
						var txt = response;
						var notification = alertify.error(txt);
						swal("Gagal", txt, "error");
					*/
					var myObj = JSON.parse(response);
					var sukses = myObj[0];
					var txt = myObj[1];
					if(sukses != 'error')
					{
						var notification = alertify.success(txt);
						swal("Sukses", txt, "success");
					}
					else
					{
						var txt = 'Gagal menyimpan Data';
						var notification = alertify.error(txt);
						swal("Gagal", txt, "error");
					}
					
					$('#dataKKMModal').modal('hide');
				}
			});
		}
		
	/* =============================================================
	   ==                    Bagian Cetak Data                    ==
	   ============================================================= */
		function showSuketModal(txt)
		{
			$('#showSuketModal').load('showSuketModal?id=' + txt);
			$('#showSuketModal').modal('show');
		}
		








