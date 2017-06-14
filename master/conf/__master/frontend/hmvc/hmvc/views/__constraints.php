<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
</table>

<!-- 
<div class="multiform_block" style="visibility: hidden;">
</div>
 -->
<?php 
$dynaform->draw_itemblock_hidden_begin('binding');
	?>
	<label>Required:</label>		
	<input type="checkbox" name="required" />	
	<label>Field:</label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,'name'=>'field','htmlattrs'=>array('class'=>'fld_select'))); ?>
	<label>Table:</label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$tables,'name'=>'table','htmlattrs'=>array('class'=>'table_to_select','onchange'=>'load_fields(this)'))); ?>
	<label>field to:</label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$first_table_fields,'name'=>'field_to','htmlattrs'=>array('class'=>'fld_to_select'))); ?>	
	<?php	
$dynaform->draw_itemblock_hidden_end();
?>

<form action="?r=hmvc/make/makefiles" id="bindings" method="post">
<h3>DEFINE THE BINDINGS FOR TRIADA <?=$_SESSION['makeinfo']['table']?></h3>
<div id="constraints_block">
<!-- десь все связки -->
<div class="multiform_block">
<?php 
$dynaform->itemblock_begin('binding',$item_class_name);
if(!empty($settings))
{
	if(!empty($settings['constraints']))
	{
		$idx=0;
		foreach ($settings['constraints'] as $fld_from => $con)
		{
			$dynaform->draw_item('binding');
			?>
			<div class="multiform_block">
			<label>Field:</label>
			<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,
						'name'=>"constraints[{$idx}][field]",
						'htmlattrs'=>array('class'=>'fld_select'),
						'value'=>$fld_from,
					)); ?>
			<label>Table:</label>
			<?php $this->usewidget(new ComboboxWidget(),array('data'=>$tables,
					'name'=>"constraints[{$idx}][table]",
					'value'=>$con['model'],
					'htmlattrs'=>array('class'=>'table_to_select',
						'onchange'=>'load_fields(this)'))
					); ?>
							
			<label>field to:</label>
			<?php $this->usewidget(new ComboboxWidget(),array('data'=>$this->_ENV['_CONNECTION']->get_table_fields($con['model']), //$first_table_fields,
					'name'=>"constraints[{$idx}][field_to]",
					'value'=>$con['fld'],
					'htmlattrs'=>array('class'=>'fld_to_select'))); ?>
			<label>Required:</label>		
			<input type="checkbox" name="constraints[][required]" />	
			<button type="button" onclick="drop_block(this)">x</button>
			</div>
			<?php
			$dynaform->draw_item_end();			
		}
	}
}
$dynaform->itemblock_end();
?>
</div>
<button type="button" onclick="add_block()" title="Добавить связку">+</button>
<div>
<label for="_view">View:&nbsp;</label><input type="text" name="view" size="60" id="_view" value="<?=$settings['view']?>" />
<p><label>Fields:&nbsp;</label>
<?php 
foreach($fields as $fld => $fldinfo)
{
	?>
	<div style="display: inline-block" class="drg_view">{<?=$fld?>}</div>
	<?php 
}
?>
</p>
</div>
<input type="hidden" name="conf" id="config" value="<?=$_SESSION['makeinfo']['conf']?>" >
<input type="submit" value="MAKE HMVC" >
</form>
<div id="console"></div>