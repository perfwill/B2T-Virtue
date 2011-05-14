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
 * Controller Class Extension
 *
 * This class extends the default CodeIgniter's core Controller class
 */

class BBT_Controller extends CI_Controller{
	protected $acl;

	public function __construct(){
		parent::__construct();
		$this->initBBT();
	}

	public function _langLoad(){}
	
	public function defineDbTableNames(){
		define('TBL_MEMBER', 'member');
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
		//Connect to the database
		$this->load->database();

		//Define database table name constants
		$this->defineDbTableNames();

		//Build the Access Control List (ACL)
        $this->initAcl();

		//Load the authentication class and initialize user data
		$this->load->model('Auth', 'auth');

		//Load language files
		$this->_langLoad();

		//Show any messages set by the previous request
		show_msg();
	}
}
