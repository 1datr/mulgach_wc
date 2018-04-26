<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("articles/save"),$this);
?>
<input type="hidden" name="articles[id]" value="<?=((!empty($articles)) ? $articles->getField('id') : '')?>" />
<h3><?php 
if($articles->_EXISTS_IN_DB)   
{
	?>
	#{Edit ARTICLES} <?=$articles->getView()?>
	<?php
}
else
{
	?>
	#{Create ARTICLES}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{articles.name}</label></th><td>
	<?php $form->field($articles,'name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{articles.text}</label></th><td>
	<?php $form->field($articles,'text')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{articles.author}</label></th><td>
	<?php $form->field($articles,'author')->text();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>