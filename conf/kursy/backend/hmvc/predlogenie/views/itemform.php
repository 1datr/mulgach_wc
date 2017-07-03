<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("predlogenie/save"));
?>
<input type="hidden" name="predlogenie[]" value="<?=((!empty($predlogenie)) ? $predlogenie->getField('') : '')?>" />
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
	<th><label>#{predlogenie.id_predlogenie}</label></th><td>
				<input type="text" name="predlogenie[id_predlogenie]" value="<?=((!empty($predlogenie)) ? $predlogenie->getField('id_predlogenie',true) : '')?>" />
			<div class="error" id='err_id_predlogenie' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.ru}</label></th><td>
				<input type="text" name="predlogenie[ru]" value="<?=((!empty($predlogenie)) ? $predlogenie->getField('ru',true) : '')?>" />
			<div class="error" id='err_ru' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.zvuk_ru}</label></th><td>
				<input type="text" name="predlogenie[zvuk_ru]" value="<?=((!empty($predlogenie)) ? $predlogenie->getField('zvuk_ru',true) : '')?>" />
			<div class="error" id='err_zvuk_ru' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.en}</label></th><td>
				<input type="text" name="predlogenie[en]" value="<?=((!empty($predlogenie)) ? $predlogenie->getField('en',true) : '')?>" />
			<div class="error" id='err_en' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.zvuk_en}</label></th><td>
				<input type="text" name="predlogenie[zvuk_en]" value="<?=((!empty($predlogenie)) ? $predlogenie->getField('zvuk_en',true) : '')?>" />
			<div class="error" id='err_zvuk_en' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.transcription}</label></th><td>
				<input type="text" name="predlogenie[transcription]" value="<?=((!empty($predlogenie)) ? $predlogenie->getField('transcription',true) : '')?>" />
			<div class="error" id='err_transcription' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.sound}</label></th><td>
				<input type="text" name="predlogenie[sound]" value="<?=((!empty($predlogenie)) ? $predlogenie->getField('sound',true) : '')?>" />
			<div class="error" id='err_sound' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{predlogenie.type}</label></th><td>
				<input type="text" name="predlogenie[type]" value="<?=((!empty($predlogenie)) ? $predlogenie->getField('type',true) : '')?>" />
			<div class="error" id='err_type' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>