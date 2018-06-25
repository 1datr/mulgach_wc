<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("ant_race/save"),$this);
?>
<input type="hidden" name="ant_race[id]" value="<?=((!empty($ant_race)) ? $ant_race->getField('id') : '')?>" />
<h3><?php 
if($ant_race->_EXISTS_IN_DB)   
{
	?>
	#{Edit ANT_RACE} <?=$ant_race->getView()?>
	<?php
}
else
{
	?>
	#{Create ANT_RACE}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{ant_race.name}</label></th><td>
	<?php $form->field($ant_race,'name')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>