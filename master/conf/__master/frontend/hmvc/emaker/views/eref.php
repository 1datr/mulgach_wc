<?php 
$form = new mulForm(as_url("/emaker/save"),$this,[],false);
?>
<table class="_eref">
<tr>
<td><?php $form->field($row,'entity_to', ['namemode'=>'multi','nameidx'=>$idx])->ComboBox($elist,['htmlattrs'=>['class'=>'fldtype','onchange'=>'on_entity_change(this)']]);  ?></td>
<td><?php $form->field($row,'fld_to', ['namemode'=>'multi','nameidx'=>$idx])->ComboBox($_fields,['htmlattrs'=>['class'=>'fldtype','onchange'=>'on_fld_to_change(this)']]);  ?></td>
</tr>
</table>