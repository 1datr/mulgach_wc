<?php
namespace BootstrapListView
{
	use \Widget;
	use BootstrapPager\PagerWidget as PagerWidget;

	class ListViewWidget extends \Widget 
	{
		function out($params=array())
		{
			def_options(array('tableclass'=>'table'),$params);
			?><table class="<?=$params['tableclass']?>">
<?php
$params['ds']->walk(function($rec,$number)
{	
	echo "<tr>";
	$rec->foreach_fields(
		function($fld,$val)
			{
				echo "<td>";
	
				if(! is_object($val))
					echo $val;	
				else 
					echo $val->getView();
				echo "</td>";
			}	
		);	
	echo "</tr>";

	//print_r($rec);
}, function($keys){

	?>
	<thead>
	<tr>
	
	<?= xx_implode($keys,'','<th>{%val}</th>') ?>
	</tr>
	</thead>
	<?php 
});
?>
</table><?php 
$this->usewidget(new PagerWidget(),array('ds'=>$params['ds']));
			}
	}

}
?>