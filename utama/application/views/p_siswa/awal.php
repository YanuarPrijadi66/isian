	<?php
		$level = $this->session->userdata('level');
		$pilih = $this->input->get('pl');
	?>

		<div class="row" id="idDataUtama"></div>
		<input type="hidden" id="lapel" name="lapel" value="<?php echo $level;?>">
		<input type="hidden" id="pilih" name="pilih" value="<?php echo $pilih;?>">
	