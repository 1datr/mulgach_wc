<h1 class="h1">#{Configuration }<?=$config?></h1>
<div class="row">
<?php 
  	$this->out_view('triads',array(
							'fields'=>$fields,
							'tables'=>$tables,	
  							'config'=>$config,
  							'triads'=>$triads,
							'first_table_fields'=>$first_table_fields,
							'settings'=>$settings,
  							'sbplugin'=>$sbplugin,
  							'_config'=>$_config,
  							'_hmvc'=>$_hmvc,));
  	?>
</div> 
 
<div class="row">
<div class="col-sm-4">
<?php 
$this->out_view('form_from_table',array('tables'=>$tables,'config'=>$config,'sbplugin'=>$sbplugin));
?>
</div>

<div class="col-sm-4">
<?php 
$this->out_view('form_from_actionlist',array('tables'=>$tables,'config'=>$config,'sbplugin'=>$sbplugin));
?>

</div>
</div>