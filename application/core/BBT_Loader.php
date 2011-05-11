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
 * Loader class extension 
 *
 * @package 		Cix
 * @subpackage 		Core
 */
class BBT_Loader extends CI_Loader{
	private $ci;
	private $_view_url 	= '';
	private $_css_url 	= '';
	private $_js_url 	= '';
	private $_site_url	= '';

	public function __construct(){
		parent::__construct();
		$this->ci =& get_instance();
		$this->_site_url = get_instance()->config->site_url();
		$this->_view_url = $this->_site_url.'/views/';
		$this->_css_url = $this->_view_url.'css/';
		$this->_js_url = $this->_view_url.'js/';
	}

	/**
	 * Load a page
	 *
	 * @param string $page
	 */
	function page($page, bool $useJQuery){?>
		<html>
		<head>
			<meta http-equiv="content-type" content="text-html; charset=utf-8">
			<?php if($useJQuery):?>
			<script type="text/javascript" 
			src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js">
			</script>
			<?php endif;?>
			<?php $this->_page_resources($page) ?>
		</head>
		<body>
			<?php $this->ci->load->view("page_{$page}") ?>
		</body>
		</html>
	<?php
	}

	/**
	 * Load resources for the page (CSS and Javascript)
	 *
	 * @param string $page
	 */
	function _page_resources($page){
		$rsFile = $this->_ci_view_path."page_{$page}_load.php";
		if (file_exists($rsFile)) {
			include($rsFile);
			$csses = array();
			$jses  = array();
			foreach($elems as $elem){
				$elemFile = $this->_ci_view_path."{$elem}_load.php";
				if (file_exists($elemFile))
					include($elemFile); 
			}
			foreach($csses as $css => $dummy){
				$filePath =  "{$this->_css_url}{$css}.css";
				echo "<link rel='stylesheet' type='text/css' href='{$filePath}'/>";
			} 
			foreach($jses as $js => $dummy){
				$filePath = "{$this->_js_url}{$js}.js";
				echo "<script type='text/javascript' src='{$filePath}'></script>";
			}
		}
	} 
}
