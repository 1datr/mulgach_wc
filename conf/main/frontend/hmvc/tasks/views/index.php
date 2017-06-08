<?php 
use BootstrapPager\PagerWidget as PagerWidget;
//print_r($_REQUEST);
?>
<table>
<?php
$ds->walk(function($rec,$number)
{
	echo "<tr>";
	$rec->foreach_fields(
		function($fld,$val)
			{
				if(! is_object($val))
					echo "<td>{$val}</td>";				 					
			}	
		);
	echo "<td>".$rec->getField('proj_id')->getField('name')."</td>";
	echo "<td>".$rec->getField('otv_sotr')->getView()."</td>";
	echo "</tr>";

	//print_r($rec);
});
?>
</table>

<?php
//$pw = new Widget();
$this->usewidget(new PagerWidget(),array('ds'=>$ds));
?>
