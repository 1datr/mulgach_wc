<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("zadanie/save"),$this);
?>
<input type="hidden" name="zadanie[id_zadaniya]" value="<?=((!empty($zadanie)) ? $zadanie->getField('id_zadaniya') : '')?>" />
<h3><?php 
if($zadanie->_EXISTS_IN_DB)   
{
	?>
	#{Edit ZADANIE} <?=$zadanie->getView()?>
	<?php
}
else
{
	?>
	#{Create ZADANIE}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{zadanie.id_urok}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('urok')->_MODEL->find() ,'required'=>true, 'name'=>'zadanie[id_urok]');
					if(!empty($zadanie))
		{
			$params['value']=$zadanie->getField('id_urok',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_id_urok' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{zadanie.proverka}</label></th><td>
	<?php $form->field($zadanie,'proverka')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{zadanie.tematika}</label></th><td>
	<?php $form->field($zadanie,'tematika')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{zadanie.title}</label></th><td>
	<?php $form->field($zadanie,'title')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{zadanie.zadanie_text}</label></th><td>
	<?php $form->field($zadanie,'zadanie_text')->textarea();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>