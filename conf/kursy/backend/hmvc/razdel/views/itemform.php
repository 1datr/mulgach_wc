<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("razdel/save"));
?>
<input type="hidden" name="razdel[id_razdel]" value="<?=((!empty($razdel)) ? $razdel->getField('id_razdel') : '')?>" />
<h3><?php 
if(!empty($razdel))   
{
	?>
	#{Edit RAZDEL} <?=$razdel->getView()?>
	<?php
}
else
{
	?>
	#{Create RAZDEL}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{razdel.id_kurs}</label></th><td>
				<input type="text" name="razdel[id_kurs]" value="<?=((!empty($razdel)) ? $razdel->getField('id_kurs',true) : '')?>" />
			<div class="error" id='err_id_kurs' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{razdel.number}</label></th><td>
				<input type="text" name="razdel[number]" value="<?=((!empty($razdel)) ? $razdel->getField('number',true) : '')?>" />
			<div class="error" id='err_number' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{razdel.name}</label></th><td>
				<input type="text" name="razdel[name]" value="<?=((!empty($razdel)) ? $razdel->getField('name',true) : '')?>" />
			<div class="error" id='err_name' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>