<form>
<?php 
$_PARAMS = $URL_P->params;
unset($_PARAMS['filter']['{field}']);
array_to_hidden($_PARAMS,array('filter'=>array('{fld}','page')));
?>
<table>
<?php
$res_loo = mysql_query("SELECT * FROM {table}");
while ($row_lookup = mysql_fetch_assoc($res_loo)) 
{
?>
	<tr>
	<td>
	<?php 
 	if(!empty($_REQUEST['filter']['{field}']))
 	{
 		if(in_array($row_lookup['{fld}'],$_REQUEST['filter']['{field}']))  
 		{
 			?>
 			<input type="checkbox" name="filter[{field}][]" value="<?=$row_lookup['{fld}']?>" checked />
 			<?php
 		}
 		else
 		{
 			?>
 			<input type="checkbox" name="filter[{field}][]" value="<?=$row_lookup['{fld}']?>" />
 			<?php
 		}
 	}
 	else
 	{
 		?>
 		<input type="checkbox" name="filter[{field}][]" value="<?=$row_lookup['{fld}']?>" />
 		<?php
 	}
 	?>	
	</td>
	<th><?=$row_lookup['{show}']?></th>
	</tr>
<?php
}
?>
</table>
<input type="submit" value="Применить"  class="btn btn-primary btn-sm"  />
<button class="btn btn-primary btn-sm" onclick="uncheck_brothers(this)" >Отменить</button>
</form>