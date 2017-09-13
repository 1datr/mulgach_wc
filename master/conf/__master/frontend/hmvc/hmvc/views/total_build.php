<?php 
use BootstrapProgressBar\ProgressBarWidget as ProgressBarWidget;
?>
<h3>#{TOTAL UPDATE}</h3>
<?php
$form=new mulForm(as_url("hmvc/maketotal/"),$this);
$this->_MODEL->scenario('total');
$row_total = $this->_MODEL->empty_row_form_model();
$row_total->setField('cfg',$config);
$form->scenario($row_total);
?>
<?=$form->field($row_total,'cfg')->hidden()?>
<?php $this->usewidget(new ProgressBarWidget(),array(
						'value'=>66,
	)); ?>
<table>
<tr><td><label>#{Rewrite all files}&nbsp;</label></td><td><?=$form->field($row_total,'rewrite_all')->checkbox()?></td></tr>
<tr><td><label>#{Ignore existing settings}&nbsp;</label></td><td><?=$form->field($row_total,'ignore_existing')->checkbox()?></td></tr>
<tr><td><label>#{Autofind authorize controller}&nbsp;</label></td><td><?=$form->field($row_total,'autofind_auth')->checkbox()?></td></tr>
</table>

<?php $form->submit('#{NEXT >}'); ?>
<?php $form->close(); ?>