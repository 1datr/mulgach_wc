<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
</table>

<?php 
$sbplugin->template_start('bindings_item');
?>
	<label>Required:</label>		
	<input type="checkbox" name="constraints[{idx}][required]" />	
	<label>Field:</label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,'name'=>'constraints[{idx}][field]','htmlattrs'=>array('class'=>'fld_select'))); ?>
	<label>Table:</label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$tables,'name'=>'constraints[{idx}][table]','htmlattrs'=>array('class'=>'table_to_select','onchange'=>'load_fields(this)'))); ?>
	<label>field to:</label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$first_table_fields,'name'=>'constraints[{idx}][field_to]','htmlattrs'=>array('class'=>'fld_to_select'))); ?>	
	<button type="button" class="bindings_item_drop">x</button>
<?php 
$sbplugin->template_end();
?>

<form action="?r=hmvc/make/makefiles" id="bindings" method="post">
<h3>DEFINE THE BINDINGS FOR TRIADA <?=$_SESSION['makeinfo']['table']?></h3>
<?php 
$sbplugin->block_start('bindings_item',array('id'=>'items_block'));
?>
<!-- десь все связки -->
<?php 
if(!empty($settings))
{
	if(!empty($settings['constraints']))
	{
		$idx=0;
		foreach ($settings['constraints'] as $fld_from => $con)
		{
			?>
			<div class="multiform_block" role="item">
			<label>Required:</label>
			<input type="checkbox" name="constraints[<?=$idx?>][required]" nametemplate="constraints[#idx#][required]", <?=(($con['required']) ? "checked" : "")?> />			
			<label>Field:</label>
			<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,
						'name'=>"constraints[".$idx."][field]",						
						'htmlattrs'=>array('class'=>'fld_select','nametemplate'=>"constraints[#idx#][field]",),
						'value'=>$fld_from,
					)); ?>
			<label>Table:</label>
			<?php $this->usewidget(new ComboboxWidget(),array('data'=>$tables,
					'name'=>"constraints[".$idx."][table]",					
					'value'=>$con['model'],
					'htmlattrs'=>array('class'=>'table_to_select','nametemplate'=>"constraints[#idx#][table]",
						'onchange'=>'load_fields(this)'))
					); ?>
							
			<label>field to:</label>
			<?php $this->usewidget(new ComboboxWidget(),array('data'=>$this->_ENV['_CONNECTION']->get_table_fields($con['model']), //$first_table_fields,
					'name'=>"constraints[".$idx."][field_to]",					
					'value'=>$con['fld'],
					'htmlattrs'=>array('class'=>'fld_to_select','nametemplate'=>"constraints[#idx#][field_to]",))); ?>
									
			<button type="button" class="bindings_item_drop">x</button>
			</div>
			<?php
			$idx++;
		}
	}
}

$sbplugin->template_end(function(){
	?>
	<button type="button" class="bindings_item_add" title="Добавить связку">+</button>
	<?php 
})
?>


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
