<?php
class Auth {
	private $uid 					= 0;
	private $username 				= '';
	private $role 					= 'guest';
	private $bbt;

	public function __construct(){
		$bbt = get_instance();
		$this->userSetup();
	}

	public function getUid(){return $this->uid;}
	public function getUsername(){return $this->username;}	
	public function getRole(){return $this->role;}

	public function userSetup(){
		$sessionUid = $bbt->session->userdata('uid');
		if ($sessionUid){
			$this->uid = $sessionUid; 

			$bbt->db->select('username, role');
			$q = $bbt->db->get_where(TBL_BBTERS, array('uid' => $this->uid), 1);
			if ($q->num_rows() == 0) show_error('Something wrong in BBT_Controller.userSetup()');
			else {
				$this->username = $q->row()->username;
				$this->role = $q->row()->role;
			}
		}
	}

	public function login($username, $password, $remember){
		$bbt->db->select('uid, password');
		$q = $bbt->db->get_where(TBL_BBTERS, array('username' => $username), 1);
		if ($q->num_rows() == 0) {
			$bbt->setMsg($bbt->lang->line('login_incorrect_username'));
		}
		else if ($q->num_rows() == 1) {
			//verify the password
			if ($q->row()->password == $password){
				//User login information is correct 
				$bbt->session->set_userdata('uid', $q->row()->uid);
				if ($remember) $bbt->session->set_userdata('noexpire', 'on');
				$bbt->setMsg($bbt->lang->line('login_successful', $username));
			}else $bbt->setMsg($bbt->lang->line('login_incorrect_password'));
		}
		else show_error('Something wrong with the TBL_BBTERS table, username cannot be duplicated');

		redirect;
	}
}
