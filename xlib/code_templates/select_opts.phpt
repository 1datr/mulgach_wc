<select name="{table}[{field}]">
<?php
				//{$row['valuta_rascenka1']}
				$opts = get_enum_field_values('{table}','{field}');				
				foreach($opts as $opt)
				{
					if($opt==${table}['{field}'])
					{
						echo "<option selected value=\"{$opt}\">{$opt}</option>";
					}
					else 
					{
						echo "<option value=\"{$opt}\">{$opt}</option>";
					}
				}
?>
</select>