<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("kursy/save"),$this);
?>
<input type="hidden" name="kursy[id_kurs]" value="<?=((!empty($kursy)) ? $kursy->getField('id_kurs') : '')?>" />
<h3><?php 
if(!empty($kursy))   
{
	?>
	#{Edit KURSY} <?=$kursy->getView()?>
	<?php
}
else
{
	?>
	#{Create KURSY}
	<?php
}
?></h3>
<table>

	<tr>
	<th><label>#{kursy.id_prep}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('preps')->_MODEL->find() ,'required'=>true, 'name'=>'kursy[id_prep]');
					if(!empty($kursy))
		{
			$params['value']=$kursy->getField('id_prep',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_id_prep' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{kursy.name}</label></th><td>
	<?php $form->field($kursy,'name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{kursy.full_text}</label></th><td>
	<?php $form->field($kursy,'full_text')->textarea();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{kursy.small_text}</label></th><td>
	<?php $form->field($kursy,'small_text')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{kursy.web}</label></th><td>
	<?php $form->field($kursy,'web')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{kursy.sostoyanie_dopuska}</label></th><td>
	<?php $form->field($kursy,'sostoyanie_dopuska')->ComboBox();	 ?>	</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>