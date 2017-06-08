<table>
<?php
use BootstrapListView\ListViewWidget as ListViewWidget;
use BootstrapPager\PagerWidget as PagerWidget;

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
$this->usewidget(new ListViewWidget(),array('ds'=>$ds));
$this->usewidget(new PagerWidget(),array('ds'=>$ds));
?>