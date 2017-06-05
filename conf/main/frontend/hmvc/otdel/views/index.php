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