<?php 
$form = new mulForm(as_url("hmvc/emaker/makefiles"),$this,[],false);
?>
<?php 
$sbplugin->template_start('fields_item');
?>
	<label><?=Lang::__t('Field name:') ?></label>		
	<?php $form->field($emptyfld, 'fldname',['namemode'=>'multi','name_ptrn'=>'{idx}'])->text([]);  ?>
	<label><?=Lang::__t('Primary:') ?></label>
	<?php $form->field($emptyfld, 'primary',['namemode'=>'multi','name_ptrn'=>'{idx}'])->checkbox([]);  ?>	
	<button type="button" class="fields_item_drop">x</button>
<?php 
$sbplugin->template_end();
?>

<?php $form->draw_begin(); ?>

<?php $sbplugin->block_start('fields_item',array('id'=>'fields_block'));?>
<label><?=Lang::__t('Field name:') ?></label>		
<?php $form->field($newentity, 'cfg')->text([]);  ?>
<button type="button" class="fields_item_add" title="#{Add field}">+</button>
<?php 
	foreach ($newentity->getField('fieldlist') as $idx => $fld)
	{
?>
<div class="multiform_block">
	<label><?=Lang::__t('Field name:') ?></label>		
	<?php $form->field($fld, 'fldname',['namemode'=>'multi','nameidx'=>0])->text([]);  ?>
	<label><?=Lang::__t('Primary:') ?></label>
	<?php $form->field($fld, 'primary',['namemode'=>'multi','nameidx'=>0])->checkbox([]);  ?>	
	<button type="button" class="efld_drop">x</button>
</div>
<?php 
	}
?>	
<?php $sbplugin->block_end(); ?>

<?php $form->close(); 
jq_onready($this, "$('#fields_block').jqStructBlock();");
?>