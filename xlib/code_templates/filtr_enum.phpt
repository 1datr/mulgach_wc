<form>

<?php 
$_PARAMS = $URL_P->params;
unset($_PARAMS['filter']['{fld}']);
array_to_hidden($_PARAMS,array('filter'=>array('{fld}','page')));
?>
<table>
<?php 
 $_values = get_enum_field_values('{table}','{fld}');
 foreach($_values as $idx => $val)
 { 	
 	?>
 	<tr>
 	<th><?=$_capts['{table}']["{fld}.enum.{$val}"]?></th>
 	<td>
 	<?php 
 	if(!empty($_REQUEST['filter']['{fld}']))
 	{
 		if(in_array($val,$_REQUEST['filter']['{fld}']))  
 		{
 			?>
 			<input type="checkbox" name="filter[{fld}][]" value="<?=$val?>" checked />
 			<?php
 		}
 		else
 		{
 			?>
 			<input type="checkbox" name="filter[{fld}][]" value="<?=$val?>" />
 			<?php
 		}
 	}
 	else
 	{
 		?>
 		<input type="checkbox" name="filter[{fld}][]" value="<?=$val?>" />
 		<?php
 	}
 	?>   	 
 	</td>
 	</tr>
 	<?php
 }
?>
</table>
<input type="submit" value="Применить" class="btn btn-primary btn-sm" />
<?php 
$URL_P2 = $URL_P;
unset($URL_P2->params['filter']['{fld}']);
$url = $URL_P2->make_changed_url(array());
// $(this).parent('form').find('input[type=checkbox]').each(function( i ) {$(this).removeAttr("checked");})
?>
<button class="btn btn-primary btn-sm" onclick="uncheck_brothers(this)" >Отменить</button>

</form>

