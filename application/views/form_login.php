<?=validation_errors()?>
<div id='login-form' class='login-form'> 
<?=form_open('index/login')?>
	<?=form_fieldset('')?>
		<div class='textfield'>
			<?=form_label('Username: ', 'username')?>
			<?=form_input('username')?>
		</div>	
		<div class='textfield'>
			<?=form_label('Password: ', 'password')?>
			<?=form_password('password')?>
		</div>
		<div class='checkfield'>
			<?=form_label('Remember me', 'remember_chk')?>
			<?=form_checkbox('remember_chk', 'yes', TRUE)?>
		</div>
		<div class='buttons'>
			<?=form_submit('login', 'Login')?>	
		</div>
	<?=form_fieldset_close()?>
<?=form_close()?>
</div>
