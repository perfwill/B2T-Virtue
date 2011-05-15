<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BBT 
 *
 * BBT Vietnamese social network 
 *
 * @since               Project start
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Index Controller
 *
 * This class handles the home and the introduction page
 */
class Index extends BBT_Controller {
	function __construct(){
		parent::__construct();
	}

	function _langLoad(){
		$this->lang->load('auth');
	}

	function index(){
		if ($this->isAllowed()){
			/*The true BBT*/
			$this->load->page('home');
		}else{
			/*The introduction page when not logged in*/
			$this->load->page('intro', false);
		}
	}

	function login(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'lang:login_username', 'required');
		$this->form_validation->set_rules('password', 'lang:login_password', 'required');
		$this->form_validation->set_error_delimiters('<em>','</em>');
		//Process the form
		if ($this->input->post('login')) {
			if ($this->form_validation->run()){
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$remember = ($this->input->post('remember_chk')=='yes')? true : false;

				$this->auth->login($username, $password, $remember);
			}else $this->index();
		}
	}

	function logout(){
		$this->auth->logout();
	}
}
