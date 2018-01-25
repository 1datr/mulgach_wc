<?php 
$sbplugin->template_start('bindings_item');
?>
	<label><?=Lang::__t('Required:') ?></label>		
	<input type="checkbox" name="constraints[{idx}][required]"  class="cb_required" />	
	<label><?=Lang::__t('Field:') ?></label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$table_info['fields'],'name'=>'constraints[{idx}][field]','htmlattrs'=>array('class'=>'fld_select','onchange'=>'check_required(this)'))); ?>
	<label><?=Lang::__t('Table:') ?></label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$table_info['tables'],'name'=>'constraints[{idx}][table]','htmlattrs'=>array('class'=>'table_to_select','onchange'=>'load_fields(this)'))); ?>
	<label><?=Lang::__t('field to:') ?></label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$table_info['first_table_fields'],'name'=>'constraints[{idx}][field_to]','htmlattrs'=>array('class'=>'fld_to_select'))); ?>	
	<button type="button" class="bindings_item_drop">x</button>
<?php 
$sbplugin->template_end();
?>
