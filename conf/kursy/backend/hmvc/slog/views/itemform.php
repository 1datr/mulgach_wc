<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("slog/save"));
?>
<input type="hidden" name="slog[id_slog]" value="<?=((!empty($slog)) ? $slog->getField('id_slog') : '')?>" />
<h3><?php 
if(!empty($slog))   
{
	?>
	#{Edit SLOG} <?=$slog->getView()?>
	<?php
}
else
{
	?>
	#{Create SLOG}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{slog.slog}</label></th><td>
				<input type="text" name="slog[slog]" value="<?=((!empty($slog)) ? $slog->getField('slog',true) : '')?>" />
			<div class="error" id='err_slog' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{slog.transcription}</label></th><td>
				<input type="text" name="slog[transcription]" value="<?=((!empty($slog)) ? $slog->getField('transcription',true) : '')?>" />
			<div class="error" id='err_transcription' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{slog.sound}</label></th><td>
				<input type="text" name="slog[sound]" value="<?=((!empty($slog)) ? $slog->getField('sound',true) : '')?>" />
			<div class="error" id='err_sound' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{slog.type}</label></th><td>
				<input type="text" name="slog[type]" value="<?=((!empty($slog)) ? $slog->getField('type',true) : '')?>" />
			<div class="error" id='err_type' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>