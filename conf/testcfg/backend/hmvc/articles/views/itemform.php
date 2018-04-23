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
			<?php 
					$params = array('ds'=> $this->get_controller('')->_MODEL->find() ,'name'=>'articles[author]');			
					if(!empty($articles))
		{
			$params['value']=$articles->getField('author',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_author' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>