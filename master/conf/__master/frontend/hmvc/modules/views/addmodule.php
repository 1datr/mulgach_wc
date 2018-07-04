<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php 
$frm = new mulForm(as_url('modules/makemodule'),$this);
?>
<h4><?=Lang::__t('Create plugin') ?></h4>
<table>
<tr>
	<td><label><?=Lang::__t('Select module:')?></label></td>
	<td><?php $this->usewidget(new ComboboxWidget(),array('data'=>$modules,'name'=>'module[parent]')); ?></td>
</tr>
<tr>
	<td><label><?=Lang::__t('New module name:')?></label></td>
	<td><input type="text" name="module[name]" value="" /></td>
</tr>
<tr><td></td>
	<td><?php 
	$frm->submit(Lang::__t('Create module'));
	?>
	</td>
</tr>
</table>




<?php 
$frm->close();
?>