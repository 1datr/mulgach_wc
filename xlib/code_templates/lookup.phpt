<select name="${table}[{field}]"><?php
$res_lookup = mysql_query("SELECT * FROM {lookup_table} ");
	if(mysql_num_rows($res_lookup)>0)
	{
		echo "<option value=\"\"></option>";
		while ($row_lookup = mysql_fetch_assoc($res_lookup)) {
			if(!empty(${table}['{field}']) )
			{
				if(${table}['{field}']==$row_lookup['{field_lookup}'])
		    		echo "<option selected value=\"{$row_lookup['{field_lookup}']}\">{$row_lookup['{show}']}</option>";
				else 
					echo "<option value=\"{$row_lookup['{field_lookup}']}\">{$row_lookup['{show}']}</option>";
			}
			else 
				echo "<option value=\"{$row_lookup['{field_lookup}']}\">{$row_lookup['{show}']}</option>";
	   
		}

		
	}
?>
</select>