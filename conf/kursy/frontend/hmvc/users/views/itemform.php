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
	<?php $form->field($users,'login')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.password}</label></th><td>
	<?php $form->field($users,'password')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.first_name}</label></th><td>
	<?php $form->field($users,'first_name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.last_name}</label></th><td>
	<?php $form->field($users,'last_name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.phone}</label></th><td>
	<?php $form->field($users,'phone')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.web}</label></th><td>
	<?php $form->field($users,'web')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.address}</label></th><td>
	<?php $form->field($users,'address')->text();	 ?>	</td>
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
	<?php $form->field($users,'skype')->text();	 ?>	</td>
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
	<?php $form->field($users,'hash')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>