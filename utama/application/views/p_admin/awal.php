	<?php
		$level = $this->session->userdata('level');
		$pilih1 = $this->input->get('pl');
		$pilih2 = $this->input->get('pl1');
	?>

		<div class="row" id="idDataUtama"></div>
		<input type="hidden" id="lapel" name="lapel" value="<?php echo $level;?>">
		<input type="hidden" id="pilih" name="pilih" value="<?php echo $pilih1;?>">
		<input type="hidden" id="pilih1" name="pilih1" value="<?php echo $pilih2;?>">
		
