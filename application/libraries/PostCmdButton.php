<?php
class PostCmdButton {
	private $name 		= 	'';
	private $link		= 	'';
	private $icon		= 	'';
	
	public function __construct($name_ll, $location, $iconurl = ''){
		$this->name = get_instance()->lang->line($name_ll);
		$this->link = site_url($location);
		$this->icon = $iconurl;
	}	

	public function name(){return $this->name;}
	public function link(){return $this->link;}
	public function icon(){return $this->icon;}

	public function hasIcon(){return empty($this->icon) ? false : true;}
}
