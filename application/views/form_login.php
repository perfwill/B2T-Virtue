<?=validation_errors()?>
<div id='form-login' class='form-login'> 
<?=form_open('index/login')?>
	<?=form_fieldset('')?>
		<div class='textfield'>
			<?=form_label($this->lang->line('login_username').': ', 'username')?>
			<?=form_input('username')?>
		</div>	
		<div class='textfield'>
			<?=form_label($this->lang->line('login_password').': ', 'password')?>
			<?=form_password('password')?>
		</div>
		<div class='checkfield'>
			<?=form_label($this->lang->line('login_remember'), 'remember_chk')?>
			<?=form_checkbox('remember_chk', 'yes', TRUE)?>
		</div>
		<div class='submit'>
			<?=form_submit('login', $this->lang->line('login'))?>	
		</div>
	<?=form_fieldset_close()?>
<?=form_close()?>
</div>
