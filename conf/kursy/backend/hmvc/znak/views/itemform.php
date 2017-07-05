<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("znak/save"));
?>
<input type="hidden" name="znak[id_znak]" value="<?=((!empty($znak)) ? $znak->getField('id_znak') : '')?>" />
<h3><?php 
if(!empty($znak))   
{
	?>
	#{Edit ZNAK} <?=$znak->getView()?>
	<?php
}
else
{
	?>
	#{Create ZNAK}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{znak.znak}</label></th><td>
	<?php $form->field($znak,'znak')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{znak.transcription}</label></th><td>
	<?php $form->field($znak,'transcription')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{znak.sound}</label></th><td>
	<?php $form->field($znak,'sound')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{znak.type}</label></th><td>
	<?php $form->field($znak,'type')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>