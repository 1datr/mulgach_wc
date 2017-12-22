<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("preps/save"),$this);
?>
<input type="hidden" name="preps[id_prep]" value="<?=((!empty($preps)) ? $preps->getField('id_prep') : '')?>" />
<h3><?php 
if($preps->_EXISTS_IN_DB)   
{
	?>
	#{Edit PREPS} <?=$preps->getView()?>
	<?php
}
else
{
	?>
	#{Create PREPS}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{preps.first_name}</label></th><td>
	<?php $form->field($preps,'first_name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{preps.last_name}</label></th><td>
	<?php $form->field($preps,'last_name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{preps.user_id}</label></th><td>
	<?php $form->field($preps,'user_id')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{preps.sostoyanie_dopuska}</label></th><td>
	<?php $form->field($preps,'sostoyanie_dopuska')->ComboBox();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>