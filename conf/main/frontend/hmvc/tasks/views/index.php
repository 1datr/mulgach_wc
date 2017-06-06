<?php 
use BootstrapPager\PagerWidget as PagerWidget;
//print_r($_REQUEST);
?>
<table>
<?php
$ds->walk(function($row,$number)
{
	echo "<tr>";
	foreach ($row as $key => $val)
	{
		echo "<td>{$val}</td>";
	}
	echo "</tr>";
});
?>
</table>

<?php
//$pw = new Widget();
$this->usewidget(new PagerWidget(),array('ds'=>$ds));
?>
