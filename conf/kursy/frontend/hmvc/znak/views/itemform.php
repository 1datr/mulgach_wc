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
				<input type="text" name="znak[znak]" value="<?=((!empty($znak)) ? $znak->getField('znak',true) : '')?>" />
			<div class="error" id='err_znak' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{znak.transcription}</label></th><td>
				<input type="text" name="znak[transcription]" value="<?=((!empty($znak)) ? $znak->getField('transcription',true) : '')?>" />
			<div class="error" id='err_transcription' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{znak.sound}</label></th><td>
				<input type="text" name="znak[sound]" value="<?=((!empty($znak)) ? $znak->getField('sound',true) : '')?>" />
			<div class="error" id='err_sound' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{znak.type}</label></th><td>
				<input type="text" name="znak[type]" value="<?=((!empty($znak)) ? $znak->getField('type',true) : '')?>" />
			<div class="error" id='err_type' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>