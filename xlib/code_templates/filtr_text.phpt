<table>
<tr>
<td>
<form>
<input type="submit" value="x" class="btn btn-primary btn-sm" />
<?php 
$_PARAMS = $URL_P->params;
unset($_PARAMS['filter']['{fld}']);
array_to_hidden($_PARAMS,array('filter'=>array('{fld}','page')));
?>	
</form>
</td>
<td>
<form>
<?php 
$_PARAMS = $URL_P->params;
unset($_PARAMS['filter']['{fld}']);
array_to_hidden($_PARAMS,array('filter'=>array('{fld}','page')));
?>
<input type="text" name="filter[{fld}]" value="<?=$_REQUEST['filter']['{fld}']?>" />
<input type="submit" value="&#9658;" class="btn btn-primary btn-sm" />

</td>
</tr>
</table>
</form>