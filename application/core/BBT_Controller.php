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
	protected $role; 
	protected $username;
	protected $acl;

	public function __construct(){
		parent::__construct();
		$this->initBBT();
	}

	public function getRole(){
		return $this->role;
	}
	
	public function userSetup(){
		$sessionUid = $this->session->userdata('uid');
        	if (!$sessionUid){
	                //The user is not logged in 
	                $this->role = 'guest';
		}else{
			$this->uid = $sessionUid; 

			$this->db->select('username, role');
			$q = $this->db->get_where(TBL_BBTERS, array('uid' => $this->uid));

			if ($q->num_rows() == 0) show_error('Something wrong in BBT_Controller.userSetup()');
			else {
				$this->username = $q->row()->username;
				$this->role = $q->row()->role;
			}
		}
		
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

	public function initAcl(){
        	$this->load->library('Zend_Acl');

        	$this->acl = new Zend_Acl();
		$acl =& $this->acl;	
        	$acl->addRole(new Zend_Acl_Role('guest'));
        	$acl->addRole(new Zend_Acl_Role('member'));
	        $acl->addRole(new Zend_Acl_Role('vip'), 'member');
	        $acl->addRole(new Zend_Acl_Role('master'));

	        $acl->add(new Zend_Acl_Resource('basics'));
	        $acl->add(new Zend_Acl_Resource('xedit'));
	        $acl->add(new Zend_Acl_Resource('acp'));        

	        $acl->allow('member', 'basics');
	        $acl->allow('vip', 'xedit');
	        $acl->allow('vip', 'acp');      
	        $acl->allow('master');
	}

	public function initBBT(){
		$this->load->database();
		$this->defineDbTableNames();
        $this->initAcl();
		$this->userSetup();

		//Show any messages set by the previous request
		$this->showMsg();
	}
}
