<form action="?r=hmvc/make/" method="post">
<label for="thetable">Table</label>
<select name="table">
<?php 
foreach ($tables as $table)
{
	?>
	<option value="<?=$table?>"><?=$table?></option>
	<?php 
}
?>
</select>
<input type="hidden" name="conf" value="<?=$config?>" /><br />
<label>Rewrite all files&nbsp;</label><input type="checkbox" name="rewrite_all" ><br />
<label>Frontend&nbsp;</label><input type="checkbox" name="ep[frontend]" checked>
<label>Backend&nbsp;</label><input type="checkbox" name="ep[backend]" checked>
<label>Install&nbsp;</label><input type="checkbox" name="ep[install]" checked>
<label>REST&nbsp;</label><input type="checkbox" name="ep[rest]" checked >
<br />
<input type="submit" value="NEXT >" >
</form>
