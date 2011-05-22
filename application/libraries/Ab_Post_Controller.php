<?php
abstract class Ab_Post_Controller extends BBT_Controller{
	protected $typeName 		= '';

	private $modelName 			= '';
	private $view_editForm		= '';
	private $introMsg			= '';

	//List of commands (edit, report abuse, thank...) near the title (topCmds) and at bottom (bottomCmds)
	protected $topCmds, $bottomCmds; 

	abstract protected function _typeName();	

	public function __construct(){
		parent::__construct();

		if (!$this->isAllowed()) redirect('msg/show/login_required');

		$this->typeName = $this->_typeName();
		$this->modelName = "{$this->typeName}_model";
		$this->view_editForm = "form_{$this->typeName}_edit";

		$this->lang->load('post');
		$this->introMsg = $this->lang->line("{$this->typeName}_intro_msg");

		$this->load->model($this->modelName, 'post');
	}

	final public function display($id = 0){
		$this->post->fetch($id);

		$this->setupTopCmds();
		$this->setupBottomCmds();

		$data = array(
				'post' 			=> $this->post->data(),
				'topCmds' 		=> $this->topCmds,
				'bottomCmds'	=> $this->bottomCmds,
			);

		$this->load->page('post_display', true, $data);
	}

	protected function setupTopCmds(){
		$this->topCmds = new PostCmdBar();
		$this->topCmds->add('report', "index/report/{$this->post->id}");
		if ($this->isEditAllowed()) {
			$this->topCmds->add('edit', "{$this->typeName}/edit/{$this->post->id}");
		}
		if ($this->isAllowed('xedit'))
			$this->topCmds->add('delete', "{$this->typeName}/delete/{$this->post->id}");
	}

	protected function setupBottomCmds(){
		$this->bottomCmds = new PostCmdBar();
		$this->bottomCmds->add('response', "reply/{$this->post->id}");
		$this->bottomCmds->add('thank', "thank/{$this->post->id}");
		$this->bottomCmds->add('share', "share/{$this->post->id}");
	}

	final public function create(){
		$this->edit(0);
	}

	final public function isEditAllowed(){
		if ($this->isAllowed('xedit')) return true;
		else {
			if ($this->auth->uid() == $this->post->author) return true;
			else return false;
		}
	}

	final public function edit($id = 0){
		if ($id != 0) {
			$this->post->fetch($id);
			if (!$this->isEditAllowed()) redirect('index');
		}

		$data = array(
			'introMsg' => $this->introMsg,
			'view_editForm' => $this->view_editForm,
			'post' => $this->post->data()
		);
		$this->load->page('post_edit', true, $data);

	}

	final protected function receiveInput(){
		$this->post->setTitle($this->input->post('post_title'));
		$this->post->setContent($this->input->post('post_content'));
		$this->post->setAuthor($this->input->post('author'));

		$this->_additionalInput();
	}

	protected function _additionalInput(){}

	final public function save(){
		$this->receiveInput();
		$this->post->save();
		set_msg($this->lang->line('post_create_success'));
		redirect("{$this->typeName}/display/{$this->post->id}");
	}
}
