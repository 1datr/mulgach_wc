<table>
<?php
$conn->list_rows($res,function($row,$number)
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