<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("users/save"),$this);
?>
<input type="hidden" name="users[id]" value="<?=((!empty($users)) ? $users->getField('id') : '')?>" />
<h3><?php 
if($users->_EXISTS_IN_DB)   
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
	<th><label>#{users.email}</label></th><td>
	<?php $form->field($users,'email')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{users.token}</label></th><td>
	<?php $form->field($users,'token')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>