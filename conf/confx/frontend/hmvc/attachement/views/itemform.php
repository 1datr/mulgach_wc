<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("attachement/save"),$this);
?>
<input type="hidden" name="attachement[]" value="<?=((!empty($attachement)) ? $attachement->getField('') : '')?>" />
<h3><?php 
if($attachement->_EXISTS_IN_DB)   
{
	?>
	#{Edit ATTACHEMENT} <?=$attachement->getView()?>
	<?php
}
else
{
	?>
	#{Create ATTACHEMENT}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{attachement.file_path}</label></th><td>
	<?php $form->field($attachement,'file_path')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{attachement.comment}</label></th><td>
	<?php $form->field($attachement,'comment')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{attachement.message_id}</label></th><td>
	<?php $form->field($attachement,'message_id')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>