<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("bykva/save"),$this);
?>
<input type="hidden" name="bykva[id_bukva]" value="<?=((!empty($bykva)) ? $bykva->getField('id_bukva') : '')?>" />
<h3><?php 
if($bykva->_EXISTS_IN_DB)   
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
	<?php $form->field($bykva,'bukva')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{bykva.transcription}</label></th><td>
	<?php $form->field($bykva,'transcription')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{bykva.sound}</label></th><td>
	<?php $form->field($bykva,'sound')->file();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{bykva.type}</label></th><td>
	<?php $form->field($bykva,'type')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>