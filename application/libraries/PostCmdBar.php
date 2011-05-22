<?php
class PostCmdBar {
	private $buttons = array();		//the list of buttons
	private $i = 0, $count = 0;

	public function __construct(){} 

	public function addButton($button){
		$this->buttons[] = $button;
		++$this->count;
	}

	public function add($name_ll, $location, $iconurl = ''){
		$btn = new PostCmdButton($name_ll, $location, $iconurl);
		$this->addButton($btn);
	}

	public function next(){
		++$this->i;
		if ($this->count == 0) return false;
		else {
			if ($this->i <= $this->count) return $this->buttons[$this->i-1];
			else return false;
		}
	}

	public function i(){
		return $this->i;
	}
}
