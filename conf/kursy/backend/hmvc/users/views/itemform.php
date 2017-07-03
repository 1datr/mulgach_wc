<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("users/save"));
?>
<input type="hidden" name="users[id]" value="<?=((!empty($users)) ? $users->getField('id') : '')?>" />
<h3><?php 
if(!empty($users))   
{
	?>
	#{Edit USERS} <?=$users->getView()?>
	<?php
}
else
{
	?>
	#{Create USERS}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{users.login}</label></th><td>
				<input type="text" name="users[login]" value="<?=((!empty($users)) ? $users->getField('login',true) : '')?>" />
			<div class="error" id='err_login' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{users.password}</label></th><td>
				<input type="text" name="users[password]" value="<?=((!empty($users)) ? $users->getField('password',true) : '')?>" />
			<div class="error" id='err_password' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{users.first_name}</label></th><td>
				<input type="text" name="users[first_name]" value="<?=((!empty($users)) ? $users->getField('first_name',true) : '')?>" />
			<div class="error" id='err_first_name' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{users.last_name}</label></th><td>
				<input type="text" name="users[last_name]" value="<?=((!empty($users)) ? $users->getField('last_name',true) : '')?>" />
			<div class="error" id='err_last_name' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{users.phone}</label></th><td>
				<input type="text" name="users[phone]" value="<?=((!empty($users)) ? $users->getField('phone',true) : '')?>" />
			<div class="error" id='err_phone' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{users.web}</label></th><td>
				<input type="text" name="users[web]" value="<?=((!empty($users)) ? $users->getField('web',true) : '')?>" />
			<div class="error" id='err_web' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{users.address}</label></th><td>
				<input type="text" name="users[address]" value="<?=((!empty($users)) ? $users->getField('address',true) : '')?>" />
			<div class="error" id='err_address' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{users.sostoyanie_dopuska}</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('sostoyanie_dopuska'),'name'=>'users[sostoyanie_dopuska]');
			if(!empty($users))
			{
				$params['value']=$users->getField('sostoyanie_dopuska',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_sostoyanie_dopuska' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{users.skype}</label></th><td>
				<input type="text" name="users[skype]" value="<?=((!empty($users)) ? $users->getField('skype',true) : '')?>" />
			<div class="error" id='err_skype' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{users.status}</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('status'),'name'=>'users[status]');
			if(!empty($users))
			{
				$params['value']=$users->getField('status',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_status' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{users.hash}</label></th><td>
				<input type="text" name="users[hash]" value="<?=((!empty($users)) ? $users->getField('hash',true) : '')?>" />
			<div class="error" id='err_hash' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>