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
	<button type="button" class="efld_drop">x</button>
<?php 
$sbplugin->template_end();
?>

<?php $form->draw_begin(); ?>
<div class="multiform_block">
	<label><?=Lang::__t('Field name:') ?></label>		
	<?php $form->field($primaryfld, 'fldname',['namemode'=>'multi','nameidx'=>0])->text([]);  ?>
	<label><?=Lang::__t('Primary:') ?></label>
	<?php $form->field($primaryfld, 'primary',['namemode'=>'multi','nameidx'=>0])->checkbox([]);  ?>	
	<button type="button" class="efld_drop">x</button>
</div>	
<?php $form->close(); ?>