<?php 
$form=new mulForm(as_url("configs/install"),$this,[]);


// �������� ���� � ����������� ������

//;
$this->UseModel($newcfg_model);
$nc_row = $this->_MODEL->empty_row_form_model();
$nc_row->setField('pid',$sp->PID);
$nc_row->setField('passw',$sp->PASSW);
?>

<?php $form->field($nc_row, 'passw')->text() ?>

<?php $form->submit('#{NEXT>}'); ?>
<?php $form->close(); ?>

