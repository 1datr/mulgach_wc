<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("lifearea/save"),$this);
?>
<input type="hidden" name="lifearea[id]" value="<?=((!empty($lifearea)) ? $lifearea->getField('id') : '')?>" />
<h3><?php 
if(!empty($lifearea))   
{
	?>
	#{Edit LIFEAREA} <?=$lifearea->getView()?>
	<?php
}
else
{
	?>
	#{Create LIFEAREA}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{lifearea.title_ru}</label></th><td>
	<?php $form->field($lifearea,'title_ru')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{lifearea.title_eng}</label></th><td>
	<?php $form->field($lifearea,'title_eng')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>