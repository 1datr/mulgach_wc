<?php 
$form = new mulForm(as_url("/emaker/save"),$this,[],false);
//mul_dbg($row);
$row->draw_def_form($form,['prefix'=>$prefix]);
?>