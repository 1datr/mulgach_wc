<?php 
$form = new mulForm(as_url("/emaker/save"),$this,[],false);
?>
<?php $form->field('entity', 'type',['namemode'=>'multi','nameidx'=>$idx])->ComboBox($typelist,['htmlattrs'=>['class'=>'fldtype','onchange'=>'on_type_change(this)']]);  ?>
