<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm(as_url("kursy/save"));
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
				<input type="text" name="kursy[id_prep]" value="<?=((!empty($kursy)) ? $kursy->getField('id_prep',true) : '')?>" />
			<div class="error" id='err_id_prep' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{kursy.name}</label></th><td>
				<input type="text" name="kursy[name]" value="<?=((!empty($kursy)) ? $kursy->getField('name',true) : '')?>" />
			<div class="error" id='err_name' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{kursy.full_text}</label></th><td>
				<textarea name="kursy[full_text]" ><?=((!empty($kursy)) ? $kursy->getField('full_text',true) : '')?></textarea>
			<div class="error" id='err_full_text' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{kursy.small_text}</label></th><td>
				<input type="text" name="kursy[small_text]" value="<?=((!empty($kursy)) ? $kursy->getField('small_text',true) : '')?>" />
			<div class="error" id='err_small_text' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{kursy.web}</label></th><td>
				<input type="text" name="kursy[web]" value="<?=((!empty($kursy)) ? $kursy->getField('web',true) : '')?>" />
			<div class="error" id='err_web' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{kursy.sostoyanie_dopuska}</label></th><td>
			<?php 
			$params = array('data'=> $this->_MODEL->get_field_value_list('sostoyanie_dopuska'),'name'=>'kursy[sostoyanie_dopuska]');
			if(!empty($kursy))
			{
				$params['value']=$kursy->getField('sostoyanie_dopuska',true);
			}
			$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_sostoyanie_dopuska' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>