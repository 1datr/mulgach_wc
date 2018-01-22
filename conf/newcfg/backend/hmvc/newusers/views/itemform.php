<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("newusers/save"),$this);
?>
<input type="hidden" name="newusers[id]" value="<?=((!empty($newusers)) ? $newusers->getField('id') : '')?>" />
<h3><?php 
if($newusers->_EXISTS_IN_DB)   
{
	?>
	#{Edit NEWUSERS} <?=$newusers->getView()?>
	<?php
}
else
{
	?>
	#{Create NEWUSERS}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{newusers.login}</label></th><td>
	<?php $form->field($newusers,'login')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{newusers.password}</label></th><td>
	<?php $form->field($newusers,'password')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{newusers.email}</label></th><td>
	<?php $form->field($newusers,'email')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{newusers.thehash}</label></th><td>
	<?php $form->field($newusers,'thehash')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>