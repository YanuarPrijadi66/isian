		<?php
			$query = $this->db->select('*')
						->from('tb_sekolah')
						->get();
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$nama = $row->nama_sekolah;
				$kota = $row->kota;
			}
			else
			{
				$nama = '';
				$kota = '';
			}	
		?>
        <div class="container">
            <!-- Codrops top bar -->
            <div class="codrops-top">
                <a href="home" target="_blank">
                    <strong>&laquo; <?php echo $nama.' '.$kota.' ';?></strong>
                </a>
                <div class="clr"></div>
            </div>
			<br/>
            <section id="idLogin">				
            </section>
        </div>
