<?php 
$form = new mulForm(as_url("/emaker/save"),$this,[],false);
?>
<?php $form->field($row,'entity_to', ['namemode'=>'multi','nameidx'=>$idx])->ComboBox($elist,['htmlattrs'=>['class'=>'fldtype','onchange'=>'on_entity_change(this)']]);  ?>
<span class="fldname"></span>