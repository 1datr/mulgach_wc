<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("primeneniye/save"),$this);
?>
<input type="hidden" name="primeneniye[id]" value="<?=((!empty($primeneniye)) ? $primeneniye->getField('id') : '')?>" />
<h3><?php 
if($primeneniye->_EXISTS_IN_DB)   
{
	?>
	#{Edit PRIMENENIYE} <?=$primeneniye->getView()?>
	<?php
}
else
{
	?>
	#{Create PRIMENENIYE}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{primeneniye.id_predlogenie}</label></th><td>
	<?php $form->field($primeneniye,'id_predlogenie')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{primeneniye.id_lifearea}</label></th><td>
	<?php $form->field($primeneniye,'id_lifearea')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>