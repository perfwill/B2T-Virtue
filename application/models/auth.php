<?php
class Auth {
	private $uid 					= 0;
	private $username 				= '';
	private $role 					= 'guest';
	private $bbt;

	public function __construct(){
		$this->bbt = get_instance();
		$this->userSetup();
	}

	public function getUid(){return $this->uid;}
	public function getUsername(){return $this->username;}	
	public function getRole(){return $this->role;}

	public function userSetup(){
		$sessionUid = $this->bbt->session->userdata('uid');
		if ($sessionUid){
			$this->uid = $sessionUid; 

			$this->bbt->db->select('username, role');
			$q = $this->bbt->db->get_where(TBL_BBTERS, array('uid' => $this->uid), 1);
			if ($q->num_rows() == 0) show_error('Something wrong in BBT_Controller.userSetup()');
			else {
				$this->username = $q->row()->username;
				$this->role = $q->row()->role;
			}
		}
	}

	public function login($username, $password, $remember){
		$this->bbt->db->select('uid, password');
		$q = $this->bbt->db->get_where(TBL_BBTERS, array('username' => $username), 1);
		if ($q->num_rows() == 0) {
			$this->bbt->setMsg($this->bbt->lang->line('login_incorrect_username'));
		}
		else if ($q->num_rows() == 1) {
			//verify the password
			if ($q->row()->password == $password){
				//User login information is correct 
				$this->bbt->session->set_userdata('uid', $q->row()->uid);
				if ($remember) $this->bbt->session->set_userdata('noexpire', 'on');
				$this->bbt->setMsg($this->bbt->lang->line('login_successful', $username));
			}else $this->bbt->setMsg($this->bbt->lang->line('login_incorrect_password'));
		}
		else show_error('Something wrong with the TBL_BBTERS table, username cannot be duplicated');

		redirect();
	}

	public function logout(){
		$this->bbt->session->sess_destroy();
		redirect('');
	}
}
