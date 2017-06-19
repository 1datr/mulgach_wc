<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
</table>

<?php 
$sbplugin->template_start('bindings_item');
?>
	<label><?=Lang::__t('Required:') ?></label>		
	<input type="checkbox" name="constraints[{idx}][required]"  class="cb_required" />	
	<label><?=Lang::__t('Field:') ?></label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,'name'=>'constraints[{idx}][field]','htmlattrs'=>array('class'=>'fld_select','onchange'=>'check_required(this)'))); ?>
	<label><?=Lang::__t('Table:') ?></label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$tables,'name'=>'constraints[{idx}][table]','htmlattrs'=>array('class'=>'table_to_select','onchange'=>'load_fields(this)'))); ?>
	<label><?=Lang::__t('field to:') ?></label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$first_table_fields,'name'=>'constraints[{idx}][field_to]','htmlattrs'=>array('class'=>'fld_to_select'))); ?>	
	<button type="button" class="bindings_item_drop">x</button>
<?php 
$sbplugin->template_end();
?>

<?php 
$sbplugin->template_start('subfld_item');
?>
	<input type="text" name="fields[{idx}][subflds][{idx2}]" />
<?php 
$sbplugin->template_end();
?>

<?php 
$sbplugin->template_table_start('field_item');
?>
	<td><input type="text" name="fields[{idx}][name]" /></td>			
	<td><input type="checkbox" name="fields[{idx}][required]" /></td>
<?php 
$sbplugin->template_table_end();
?>

<?php 
$form = new mulForm("?r=hmvc/make/makefiles");
?>

<ul class="nav nav-tabs">
  <li class="nav-item"><a data-toggle="tab" role="tab" class="nav-link  active" href="#main">#{tabMain}</a></li>
  <li class="nav-item"><a data-toggle="tab" role="tab" class="nav-link" href="#capts">#{tabCapts}</a></li>  
</ul>

<div class="tab-content">
  <div id="main" class="tab-pane active" role="tabpanel">
	<h3>#{DEFINE THE BINDINGS FOR TRIADA }<?=$_SESSION['makeinfo']['table']?></h3>
<?php 
$sbplugin->block_start('bindings_item',array('id'=>'items_block'));
?>
<!-- ���� ��� ������ -->
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
	<button type="button" class="bindings_item_add" title="�������� ������">+</button>
	<?php 
});
?>
	<h4>#{FIELDS SETTINGS FOR MODEL}</h4>
<?php 
// ���� � ������
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

</div>
	
  <div id="capts" class="tab-pane" role="tabpanel">
  <?php 
  $this->out_view('captions',array(
							'fields'=>$fields,
							'tables'=>$tables,							
							'first_table_fields'=>$first_table_fields,
							'settings'=>$settings,
							'sbplugin'=>$sbplugin,));
  ?>
  </div>

</div>

<input type="hidden" name="conf" id="config" value="<?=$_SESSION['makeinfo']['conf']?>" >
<input type="submit" value="#{MAKE HMVC}" >
</form>
<div id="console"></div>
