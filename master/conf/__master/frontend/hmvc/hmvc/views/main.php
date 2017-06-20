 <?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>

	<h3>#{DEFINE THE BINDINGS FOR TRIADA }<?=$_SESSION['makeinfo']['table']?></h3>
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
			<label><?=Lang::__t('Required:')?></label>
			<?php 
			if($fields[$fld_from]['Null']=='NO')
			{
				?>
				<input type="hidden" name="constraints[<?=$idx?>][required]" value="on" />
				<input disabled type="checkbox" name="constraints[<?=$idx?>][required]" class="cb_required" nametemplate="constraints[#idx#][required]", <?=(($con['required']) ? "checked" : "")?> />
				<?php 
			}
			else 
			{
				?>
				<input type="checkbox" name="constraints[<?=$idx?>][required]" class="cb_required" nametemplate="constraints[#idx#][required]", <?=(($con['required']) ? "checked" : "")?> />
				<?php 
			}
			?>			
			<label><?=Lang::__t('Field:')?></label>
			<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,
						'name'=>"constraints[".$idx."][field]",						
						'htmlattrs'=>array(
								'class'=>'fld_select',
								'nametemplate'=>"constraints[#idx#][field]",
								'onchange'=>'check_required(this)',
			),
						'value'=>$fld_from,
					)); ?>
			<label><?=Lang::__t('Table:')?></label>
			<?php $this->usewidget(new ComboboxWidget(),array('data'=>$tables,
					'name'=>"constraints[".$idx."][table]",					
					'value'=>$con['model'],
					'htmlattrs'=>array('class'=>'table_to_select','nametemplate'=>"constraints[#idx#][table]",
						'onchange'=>'load_fields(this)'))
					); ?>
							
			<label><?=Lang::__t('field to:')?></label>
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

$sbplugin->block_end(function(){
	?>
	<button type="button" class="bindings_item_add" title="Добавить связку">+</button>
	<?php 
});
?>
	<h4>#{FIELDS SETTINGS FOR MODEL}</h4>
<?php 
// Блок с полями
	$sbplugin->table_block_start('field_item',array('id'=>'fields_block'),array(),'
		<thead>
		<tr><th>#{Field}</th><th>#{Required}</th></tr>
		</thead>
		');

	$idx=0;
	foreach($fields as $fld => $finfo)
	{
		//print_r($finfo);
		?>
		<tr class="multiform_block" role="item">
		<td><input type="text" name="model_fields[<?=$idx?>][name]" value="<?=$fld?>"/></td>			
		<td>
		<input type="checkbox" name="model_fields[<?=$idx?>][required]" id="field_<?=$fld?>_required" <?=(($finfo['Null']=='NO') ? "checked disabled" : "")?> />
		<?php if($finfo['Null']=='NO') 
				{
					?>
					<input type="hidden" name="model_fields[<?=$idx?>][required]" value="on" />
					<?php 
				}
		?>
		</td>
		</tr>
		<?php 
		$idx++;
	}
	$sbplugin->table_block_end(function(){
		?>
		<tfooot>
		<tr>
		<td colspan="2">
		
		</td>
		</tr>
		</tfooot>
		<?php 
	});
?>

	<div>
	<label for="_view">#{View:}&nbsp;</label><input type="text" name="view" size="60" id="_view" value="<?=$settings['view']?>" />
	<p><label>#{Fields:}&nbsp;</label>
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


	
