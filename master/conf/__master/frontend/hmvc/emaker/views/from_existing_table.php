<nobr>
<?php
$frm = new mulForm(as_url('emaker/creationform'),$this,['htmlattrs'=>['style'=>'margin:0px;']]);

$frm->field($formrow, 'cfg')->hidden([]);

?>

<?php 
$frm->submit("MAKE FROM EXISTING TABLE",'',['class'=>'btn btn-sm']);
?>
			<?php $frm->field($formrow, 'ename')->hidden(['noerrbox'=>true,'htmlattrs'=>['placeholder'=>Lang::__t('Entity name'),]]); ?>
			<?php $frm->field($formrow, 'auth_entity')->checkbox() ?><label>#{FOR AUTH}</label>		
			<?php $frm->field($formrow, 'existing_table')->hidden(['noerrbox'=>true,]); ?>			
		
			<?php
			$frm->close();
?>
</nobr>	
