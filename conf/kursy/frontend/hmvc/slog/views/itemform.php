<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("slog/save"),$this);
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
	<?php $form->field($slog,'slog')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{slog.transcription}</label></th><td>
	<?php $form->field($slog,'transcription')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{slog.sound}</label></th><td>
	<?php $form->field($slog,'sound')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{slog.type}</label></th><td>
	<?php $form->field($slog,'type')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>