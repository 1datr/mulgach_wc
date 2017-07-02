<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("bykva/save"));
?>
<input type="hidden" name="bykva[id_bukva]" value="<?=((!empty($bykva)) ? $bykva->getField('id_bukva') : '')?>" />
<h3><?php 
if(!empty($bykva))   
{
	?>
	#{Edit BYKVA} <?=$bykva->getView()?>
	<?php
}
else
{
	?>
	#{Create BYKVA}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{bykva.bukva}</label></th><td>
				<input type="text" name="bykva[bukva]" value="<?=((!empty($bykva)) ? $bykva->getField('bukva',true) : '')?>" />
			<div class="error" id='err_bukva' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{bykva.transcription}</label></th><td>
				<input type="text" name="bykva[transcription]" value="<?=((!empty($bykva)) ? $bykva->getField('transcription',true) : '')?>" />
			<div class="error" id='err_transcription' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{bykva.sound}</label></th><td>
				<input type="text" name="bykva[sound]" value="<?=((!empty($bykva)) ? $bykva->getField('sound',true) : '')?>" />
			<div class="error" id='err_sound' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{bykva.type}</label></th><td>
				<input type="text" name="bykva[type]" value="<?=((!empty($bykva)) ? $bykva->getField('type',true) : '')?>" />
			<div class="error" id='err_type' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>