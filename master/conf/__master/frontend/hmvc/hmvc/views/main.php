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
	function fld_in_settings($fld,$settings_str)
	{
		$str_to_find='{'.$fld.'}';
		if(stristr($settings_str, $str_to_find)!= FALSE)
		{
			return true;
		}
		return false;
	}
// Блок с полями
	$sbplugin->table_block_start('field_item',array('id'=>'fields_block'),array(),'
		<thead>
		<tr><th>#{Field}</th><th>#{Type}</th><th>#{Required}</th><th>#{File field}</th></tr>
		</thead>
		');

	$idx=0;
	
	foreach($fields as $fld => $finfo)
	{
		//print_r($finfo);
		?>
		<tr class="multiform_block" role="item">
		<td><input type="text" name="model_fields[<?=$idx?>][name]" value="<?=$fld?>"/></td>
		<td><?=$finfo['Type']?></td>			
		<td>
		<?php
		$checked_selected = "";
		//mul_dbg($this);
		//$typeinfo = $this->_ENV['_MODEL']->get_field_type($fld);
		//mul_dbg($typeinfo);
		
		
		if( ($finfo['Null']=='NO') && (!in_array($finfo['Type'],array('text','mediumtext','longtext'))) )  
		{
			$checked_selected = "checked disabled";
		}
		elseif (fld_in_settings($fld,$settings['view']))
		{
			$checked_selected = "checked";
		}
		?>
		<input type="checkbox" name="model_fields[<?=$idx?>][required]" id="field_<?=$fld?>_required" <?=$checked_selected?> />
		<?php 
		if($checked_selected=='checked disabled') 
		{
			?>
			<input type="hidden" name="model_fields[<?=$idx?>][required]" value="on" />
			<?php 
		}
		?>
		</td>		
		<?php 
		//mul_dbg($finfo);
		if( in_array($finfo['Type'],array('text','blob') ))
		{
			?>
			<td>
			<?php 
			$_CHECKED='';
			$_FILTER='';			
			$_DISPLAY='display:none';
			
		//	mul_dbg($_hmvc->_SETTINGS['file_fields']);
		//	mul_dbg($_hmvc->_SETTINGS['file_fields'][$fld]);
			
			if(isset($_hmvc->_SETTINGS['file_fields'][$fld]))
			{
				$_CHECKED='checked';
				$_DISPLAY='';
				if(isset($_hmvc->_SETTINGS['file_fields'][$fld]['type']))
					$_FILTER='value="'.$_hmvc->_SETTINGS['file_fields'][$fld]['type'].'"';
			}
			?>
			<input type="checkbox" name="model_fields[<?=$idx?>][file_fields]" value="on" onclick='$(fileinfo_<?=$idx?>).toggle()' <?=$_CHECKED?> />
			<span id="fileinfo_<?=$idx?>" style="<?=$_DISPLAY?>">
			<label>#{File type:}&nbsp;</lable></label><input type="text" name="model_fields[<?=$idx?>][filter]" <?=$_FILTER?> />
			</span>
			</td>
			<?php 
		}
		?>
		
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
	
	
<h3>#{AUTHORIZATION}</h3>	
<div style="border-width: 1px; border-color:#ddd; border-style: solid; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; border-top-right-radius: 5px; border-top-left-radius: 5px; ">
<label for="cb_usercon_">#{Users and auth controller}</label>
<?php 
$checked="";
$display="display: none;";
$display_authcon="";
if($authcon)
{
	$checked=" checked ";
	$display="";
	$display_authcon="display: none;";
}
?>
<input type="checkbox" name="authcon[enable]" onclick="toggle_ep_divs('');" <?=$checked?> /><br/>
	<div id="authcon_settings_" style="<?=$display?>padding-left:20px;">
		<label for="authcon_login_">#{Login field}</label>
		<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,'name'=>'authcon[login]','value'=>$fld_login_,'htmlattrs'=>array('class'=>'fld_select','id'=>'authcon_login_',))); ?><br />
			
		<label for="authcon_passw_">#{Password field}</label>
		<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,'name'=>'authcon[passw]','value'=>$fld_passw_,'htmlattrs'=>array('class'=>'fld_select','id'=>'authcon_passw_',))); ?><br />
			
		<label for="authcon_hash_">#{Hash field}</label>
		<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,'name'=>'authcon[hash]','value'=>$fld_hash_,'htmlattrs'=>array('class'=>'fld_select','id'=>'authcon_hash_',))); ?><br />
			
		<label for="authcon_email_">#{e-mail}</label>
		<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,'name'=>'authcon[email]','value'=>$fld_email_,'htmlattrs'=>array('class'=>'fld_select','id'=>'authcon_email_',))); ?><br />
			
		
	</div>
	
	<div id="con_for_auth_div_" style="<?=$display_authcon?>">
	<label for="cb_con_auth_">#{Controller using for authorize:}</label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$triads['frontend'],
							'name'=>"con_auth",											
							'htmlattrs'=>array('id'=>'cb_con_auth_'.$_ep),
							'value'=>(isset($_SESSION['authhost']) ? $_SESSION['authhost'] : ''),
							)							
						); ?>
	</div>
	
</div>	


	
