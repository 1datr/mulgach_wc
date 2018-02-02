<?php 
$form = new mulForm(as_url("/emaker/makenew"),$this,[],false);
?>
<?php 
$sbplugin->template_table_start('fields_item',['valign'=>"top",'class'=>'fielditem']);
?>
	<td><?php $form->field($emptyfld, 'fldname',['namemode'=>'multi','name_ptrn'=>'{idx}'])->text([]);  ?></td>
	<td><?php $form->field($emptyfld, 'type',['namemode'=>'multi','name_ptrn'=>'{idx}'])->ComboBox($typelist,[]);  ?></td>
	<td><?php $form->field($emptyfld, 'primary',['namemode'=>'multi','name_ptrn'=>'{idx}'])->checkbox([]);  ?></td>	
	<td><?php $form->field($emptyfld, 'required',['namemode'=>'multi','name_ptrn'=>'{idx}'])->checkbox([]);  ?></td>	
	<td><button type="button" class="fields_item_drop">x</button></td>
<?php 
$sbplugin->template_table_end();
?>

<?php $form->draw_begin(); ?>

<?php $form->field($newentity, 'cfg')->hidden([]);  ?>

<?php $sbplugin->table_block_start('fields_item',array('id'=>'fields_block'),[],"
<tr><th>#{Field name:}</th><th>#{Type:}</th><th>#{Primary:}</th><th>#{Required:}</th></tr>		
		");?>
<h4>#{New entity creation}</h4>
<label><?=Lang::__t('Field name:') ?></label>	
<?php $form->field($newentity, 'ename')->text([]);  ?>
<button type="button" class="fields_item_add btn btn-primary btn-sm" target="fields_block" title="#{Add field}">#{ADD FIELD}</button>
<?php 
	foreach ($newentity->getField('fieldlist') as $idx => $fld)
	{
?>
<tr class="multiform_block" role="item" valign="top" class="fielditem">
	<td><?php $form->field($fld, 'fldname',['namemode'=>'multi','nameidx'=>0])->text([]);  ?></td>
	<td><?php $form->field($fld, 'type',['namemode'=>'multi','nameidx'=>0])->ComboBox($typelist,[]);  ?></td>
	<td><?php $form->field($fld, 'primary',['namemode'=>'multi','nameidx'=>0])->checkbox([]);  ?></td>	
	<td><?php $form->field($fld, 'required',['namemode'=>'multi','nameidx'=>0])->checkbox([]);  ?></td>	
	<td></td>
</tr>
<?php 
	}
?>	
<?php $sbplugin->table_block_end(); ?>
<?php $form->submit('#{MAKE ENTITY}'); ?>
<?php $form->close(); 
jq_onready($this, "$('#fields_block').jqStructBlock();");
?>