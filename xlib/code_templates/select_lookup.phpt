<?php
$res_lookup = mysql_query("SELECT * FROM {loopkup_table}");
?>
<select name="{table}[{field}]">
<?php
	while ($row_lookup = mysql_fetch_assoc($res_lookup)) 
	{
		if(${table}['{field}']==$row_lookup['{lookup_field}'])
		{
			echo "<option selected value=\"".$row_lookup['{lookup_field}']."\">".$row_lookup['{show}']."</option>";
		}
		else 
		{
			echo "<option value=\"".$row_lookup['{lookup_field}'] ."\">".$row_lookup['{show}']."</option>";
		}
	}
?>
</select>