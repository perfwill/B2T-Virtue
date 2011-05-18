<?php
class Msg extends BBT_Controller {
	function __construct(){
		parent::__construct();
		$this->lang->load('msg');
	}
	function show($error_ll = ''){
		$data = array('msg' => $this->lang->line($error_ll));
		$this->load->page('msg', false, $data);
	}
}
