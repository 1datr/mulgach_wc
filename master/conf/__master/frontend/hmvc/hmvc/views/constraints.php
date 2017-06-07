<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
</table>

<form action="?r=hmvc/make/2" method="post">
<div id="constraints_block">

<div id="multiform_block" class="multiform_block">
<label>Field:</label>
<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,'fldname'=>'constraints[][field]','htmlattrs'=>array('class'=>'fld_select'))); ?>
<label>Table:</label>
<?php $this->usewidget(new ComboboxWidget(),array('data'=>$tables,'fldname'=>'constraints[][table]','htmlattrs'=>array('class'=>'table_to_select','onchange'=>'load_fields(this)'))); ?>
<label>field to:</label>
<?php $this->usewidget(new ComboboxWidget(),array('fldname'=>'constraints[][field_to]','htmlattrs'=>array('class'=>'fld_to_select'))); ?>
</div>

</div>
<button type="button" onclick="add_block()">+</button>
<div id="console"></div>
<input type="hidden" name="conf" id="config" value="<?=$_POST['conf']?>" >
<input type="submit" value="MAKE HMVC" >
</form>