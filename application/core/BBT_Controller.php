<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BBT 
 *
 * BBT Vietnamese social network 
 *
 * @package             Cix
 * @since               Version 2.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Controller Class Extension
 *
 * @package             Cix
 * @subpackage		Core
 */

class BBT_Controller extends CI_Controller{
	protected $acl;

	public function __construct(){
		parent::__construct();
		$this->initBBT();
	}
	
	public function defineDbTableNames(){
		define('TBL_BBTERS', 'bbters');
	}

	public function showMsg(){
		if ($this->session->flashdata('msg')){
			echo "<div id='msgbox' class='msgbox'>";
			echo $this->session->flashdata('msg');
			echo "</div>";
		}
	}

	public function setMsg($msg){
		$this->session->set_flashdata('msg', $msg);
	}

	public function initAcl(){
        	$this->load->library('Zend_Acl');

        	$this->acl = new Zend_Acl();
			$acl =& $this->acl;	
        	$acl->addRole(new Zend_Acl_Role('guest'));
        	$acl->addRole(new Zend_Acl_Role('member'));
	        $acl->addRole(new Zend_Acl_Role('vip'), 'member');
	        $acl->addRole(new Zend_Acl_Role('master'));

	        $acl->add(new Zend_Acl_Resource('main'));
	        $acl->add(new Zend_Acl_Resource('xedit'));
	        $acl->add(new Zend_Acl_Resource('acp'));        

	        $acl->allow('member', 'main');
	        $acl->allow('vip', 'xedit');
	        $acl->allow('vip', 'acp');      
	        $acl->allow('master');
	}

	public function initBBT(){
		$this->load->database();
		$this->defineDbTableNames();
        $this->initAcl();

		//Load the Authentication class and initialize user data
		$this->load->model('Auth', 'auth');

		//Show any messages set by the previous request
		$this->showMsg();
	}
}
