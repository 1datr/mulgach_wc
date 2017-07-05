<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("predlogenie/save"));
?>
<input type="hidden" name="predlogenie[id_predlogenie]" value="<?=((!empty($predlogenie)) ? $predlogenie->getField('id_predlogenie') : '')?>" />
<h3><?php 
if(!empty($predlogenie))   
{
	?>
	#{Edit PREDLOGENIE} <?=$predlogenie->getView()?>
	<?php
}
else
{
	?>
	#{Create PREDLOGENIE}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{predlogenie.ru}</label></th><td>
	<?php $form->field($predlogenie,'ru')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.zvuk_ru}</label></th><td>
	<?php $form->field($predlogenie,'zvuk_ru')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.en}</label></th><td>
	<?php $form->field($predlogenie,'en')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.zvuk_en}</label></th><td>
	<?php $form->field($predlogenie,'zvuk_en')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.transcription}</label></th><td>
	<?php $form->field($predlogenie,'transcription')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.sound}</label></th><td>
	<?php $form->field($predlogenie,'sound')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.type}</label></th><td>
	<?php $form->field($predlogenie,'type')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>