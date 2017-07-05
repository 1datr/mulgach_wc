<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("slovo/save"),$this);
?>
<input type="hidden" name="slovo[id_slovo]" value="<?=((!empty($slovo)) ? $slovo->getField('id_slovo') : '')?>" />
<h3><?php 
if(!empty($slovo))   
{
	?>
	#{Edit SLOVO} <?=$slovo->getView()?>
	<?php
}
else
{
	?>
	#{Create SLOVO}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{slovo.ru}</label></th><td>
	<?php $form->field($slovo,'ru')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{slovo.zvuk_ru}</label></th><td>
	<?php $form->field($slovo,'zvuk_ru')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{slovo.en}</label></th><td>
	<?php $form->field($slovo,'en')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{slovo.risunok}</label></th><td>
	<?php $form->field($slovo,'risunok')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{slovo.zvuk_en}</label></th><td>
	<?php $form->field($slovo,'zvuk_en')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{slovo.transcription}</label></th><td>
	<?php $form->field($slovo,'transcription')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{slovo.type}</label></th><td>
	<?php $form->field($slovo,'type')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>