<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BBT 
 *
 * BBT Vietnamese social network 
 *
 * @since               Version 0.1.4
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Authentication class
 *
 * This class handles user authentication information, login and logout
 */

class Auth_model {
	private $uid 					= 0;
	private $username 				= '';
	private $role 					= 'guest';
	private $bbt;

	public function __construct(){
		$this->bbt = get_instance();
		$this->userSetup();
	}

	public function uid(){return $this->uid;}
	public function username(){return $this->username;}	
	public function role(){return $this->role;}

	/**
	 * Setup user authentication data
	 */
	public function userSetup(){
		$sessionUid = $this->bbt->session->userdata('uid');
		if ($sessionUid){
			$this->uid = $sessionUid; 

			$this->bbt->db->select('username, role');
			$q = $this->bbt->db->get_where(TBL_MEMBER, array('uid' => $this->uid), 1);
			if ($q->num_rows() == 0) show_error('Something wrong in BBT_Controller.userSetup()');
			else {
				$this->username = $q->row()->username;
				$this->role = $q->row()->role;
			}
		}
	}

	/**
	 * Verify user authentication information and log he in
	 *
	 * @param string $username
	 * @param string $password
	 * @param string $remember whether the 'remember' checkbox is checked or not
	 */
	public function login($username, $password, $remember){
		$this->bbt->db->select('uid, password');
		$q = $this->bbt->db->get_where(TBL_MEMBER, array('username' => $username), 1);
		if ($q->num_rows() == 0) {
			set_msg($this->bbt->lang->line('login_incorrect_username'));
		}
		else if ($q->num_rows() == 1) {
			//verify the password
			if ($q->row()->password == $password){
				//User login information is correct 
				$this->bbt->session->set_userdata('uid', $q->row()->uid);
				if ($remember) $this->bbt->session->set_userdata('noexpire', 'on');
				set_msg($this->bbt->lang->line('login_successful', $username));
			}else set_msg($this->bbt->lang->line('login_incorrect_password'));
		}
		else show_error('Something wrong with the TBL_BBTERS table, username cannot be duplicated');

		redirect('index');
	}

	/*
	 * Simply logout
	 */
	public function logout(){
		$this->bbt->session->sess_destroy();
		redirect('index');
	}
}
