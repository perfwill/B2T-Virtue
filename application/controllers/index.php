<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BBT 
 *
 * BBT Vietnamese social network 
 *
 * @package             Index
 * @since               Version 2.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Index Controller
 *
 * @package             Index
 */
class Index extends BBT_Controller {
	function __construct(){
		parent::__construct();
	}

	function index(){
		if ($this->acl->isAllowed($this->role, 'basics')){
			/*The true BBT*/
			$this->load->page('home');
		}else{
			/*The introduction page when not logged in*/
			$this->load->page('intro', false);
		}
	}

	function login(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', $this->lang->line('login_username'), 'required');
		$this->form_validation->set_rules('password', $this->lang->line('login_password'), 'required');
		$this->form_validation->set_error_delimiters('<em>','</em>');
		//Process the form
		if ($this->input->post('login')) {
			if ($this->form_validation->run()){
				$username = $this->input->post('username');
				$password = $this->input->post('password');

				$this->db->select('uid, password');
				$q = $this->db->get_where(TBL_BBTERS, array('username' => $username), 1);
				if ($q->num_rows() == 0) {
					$this->session->set_flashdata('msg', $this->lang->line('login_incorect_username'));
					redirect('');
				}
				else if ($q->num_rows() == 1) {
					//verify the password
					if ($q->row()->password == $password){
						//User login information is correct 
						$this->session->set_userdata('uid', $q->row()->uid);
						$remember = ($this->input->post('remember_chk')=='yes')?true:false;
						if ($remember) $this->session->set_userdata(
								'noexpire', 'on');
						$this->session->set_flashdata('msg', $this->lang->line('login_successful', $username));
					}else $this->session->set_flashdata('msg', $this->lang->line('login_incorrect_password'));
					redirect('');
				}else show_error('Something wrong with the TBL_BBTERS table, username cannot be duplicated');
			}else $this->index();
		}
	}

	function logout(){
		$this->session->sess_destroy();
		redirect('');
	}
}
