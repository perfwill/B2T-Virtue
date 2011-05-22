<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BBT 
 *
 * BBT Vietnamese social network 
 *
 * @since               Version 0.2
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Post class
 *
 * This class handles user posts (Blogs, Forum topics)
 */

abstract class Ab_Post_Model {	
	private $id					= 0; 					
	private $time				= '';					//when the post is created
	private $author				= 0;
	private $title				= '';
	private $content			= '';

	private $db				= null;
	
	
	public function __construct($id = 0){
		$this->db =& get_instance()->db;
	}

	public function __get($var){
		return $this->$var;
	}

	public function setAuthor($author = 0){$this->author = $author;}
	public function setTitle($title = ''){$this->title = $title;}
	public function setContent($content = ''){$this->content = $content;}

	/**
	 * Get post information from database
	 *
	 * @parameter int $id
	 */
	public function fetch($id){
		$this->db->select('time, author, title, content');
		$this->_fetchJoin();		//Join post data with specific post types (blog, forum post)'s data
		$q = $this->db->get_where(TBL_POST, array('id' => $id), 1);
		if ($q->num_rows() == 1){
			$result = $q->row();
			$this->formatTime($result->time);
			$this->title = $result->title;
			$this->content = $result->content;
			$this->author = $result->author;
			$this->id = $id;
		} else redirect('msg/show/post_not_found'); 
	}

	/**
	 * This function is to be implemented in child classes
	 *
	 * @access protected
	 */
	protected function _fetchJoin(){}

	protected function formatTime($timestamp){
		$this->time = date('c', $timestamp);
	}

	/**
	 * Save the post to database
	 */
	public function save(){
		$data = array(
			'time' => time(),
			'author' => $this->author,
			'title' => $this->title,
			'content' => $this->content
		);

		$this->db->insert(TBL_POST, $data);
		$this->id = $this->db->insert_id();
	}

	/**
	 * Return a data array for passing to view
	 */
	public function data(){
		$data = array(
			'title' 	=> $this->title,
			'content' 	=> $this->content,
			'time' 		=> $this->time,
			'author'	=> $this->author
		);

		$this->_additionalData($data);
		return $data;
	}

	/**
	 * This function is to be implemented in child classes to modify the data array
	 *
	 * @access protected
	 */
	protected function _additionalData(){}
}
