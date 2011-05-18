<?=validation_errors()?>
<div id='form-blog-edit' class='form-blog-edit'> 
<?=form_open('blog/save')?>
	<?=form_fieldset('')?>
		<div class='textfield'>
			<?=form_label($this->lang->line('post_title').': ', 'post_title')?>
				<?php 
					$data = array(
						'name' 		=> 'post_title',
						'id' 		=> 'post_title',
						'maxlength' => 80,
						'size' 		=> 60,
						'value' 	=> $post['title']
					);
					echo form_input($data);
				?>
		</div>	
		<div class='textareafield'>
				<?php 
					$data = array(
						'name' 		=> 'post_content',
						'id' 		=> 'post_content',
						'value' 	=> $post['content']
					);
					echo form_textarea($data);
				?>
		</div>
		<div class='submit'>
			<?=form_submit('submit', $this->lang->line('post_submit'))?>	
		</div>
	<?=form_fieldset_close()?>
<?=form_close()?>
</div>
