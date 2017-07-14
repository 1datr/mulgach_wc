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
$form = new mulForm("?r=hmvc/make/makefiles",$this);
?>

<h2>HMVC <?=$_SESSION['makeinfo']['table']?> #{table scaffolding}</h2>
<div style="color:red;">
<?php 
foreach ($warnings as $idx => $wrnng)
{
	?>
	<div><?=$wrnng?></div>
	<?php 
}
?>
</div>

<ul class="nav nav-tabs">
  <li class="nav-item"><a data-toggle="tab" role="tab" class="nav-link  active" href="#main">#{tabMain}</a></li>
  <li class="nav-item"><a data-toggle="tab" role="tab" class="nav-link" href="#capts">#{tabCaptsMenues}</a></li>  
</ul>
<?php 
$this->inline_css('
.tab-page {
	padding: 10px;
	border-left: 1px solid #ddd;
	border-bottom: 1px solid #ddd;
	border-right: 1px solid #ddd;
	border-bottom-right-radius: 10px;
	border-bottom-left-radius: 10px;
}		
');
?>

<div class="tab-content">
 	<div id="main" class="tab-pane active tab-page" role="tabpanel">
 	<?php 
  	$this->out_view('main',array(
							'fields'=>$fields,
							'tables'=>$tables,							
							'first_table_fields'=>$first_table_fields,
							'settings'=>$settings,
  							'sbplugin'=>$sbplugin,
  							'_hmvc'=>$_hmvc,));
  	?>
 	</div>
  	<div id="capts" class="tab-pane tab-page" role="tabpanel">
  	<?php 
  	$this->out_view('captions',array(
							'fields'=>$fields,
							'tables'=>$tables,							
							'first_table_fields'=>$first_table_fields,
							'settings'=>$settings,
							'sbplugin'=>$sbplugin,
  							'triads'=>$triads,
  							// def fields
				  			'fld_login_'=>$fld_login_,
				  			'fld_passw_'=>$fld_passw_,
				  			'fld_hash_'=>$fld_hash_,
  							'_hmvc'=>$_hmvc,
  							
  	));
  	?>
  	</div>
</div>

<br/>
<?php $form->submit('#{MAKE HMVC}'); ?>

<input type="hidden" name="conf" id="config" value="<?=$_SESSION['makeinfo']['conf']?>" >

</form>
<div id="console"></div>
