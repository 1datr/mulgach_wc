<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("lifearea/save"));
?>
<input type="hidden" name="lifearea[]" value="<?=((!empty($lifearea)) ? $lifearea->getField('') : '')?>" />
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
	<th><label>#{lifearea.id}</label></th><td>
				<input type="text" name="lifearea[id]" value="<?=((!empty($lifearea)) ? $lifearea->getField('id',true) : '')?>" />
			<div class="error" id='err_id' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{lifearea.title_ru}</label></th><td>
				<input type="text" name="lifearea[title_ru]" value="<?=((!empty($lifearea)) ? $lifearea->getField('title_ru',true) : '')?>" />
			<div class="error" id='err_title_ru' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{lifearea.title_eng}</label></th><td>
				<input type="text" name="lifearea[title_eng]" value="<?=((!empty($lifearea)) ? $lifearea->getField('title_eng',true) : '')?>" />
			<div class="error" id='err_title_eng' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>