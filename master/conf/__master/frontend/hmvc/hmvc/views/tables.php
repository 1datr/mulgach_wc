<form action="?r=hmvc/make" method="post">
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
<label>Rewrite only baseinfo&nbsp;</label><input type="checkbox" name="baseinfo_only" checked><br />
<label>Frontend&nbsp;</label><input type="checkbox" name="ep[frontend]" checked>
<label>Backend&nbsp;</label><input type="checkbox" name="ep[backend]" checked>
<label>Install&nbsp;</label><input type="checkbox" name="ep[install]" >
<label>REST&nbsp;</label><input type="checkbox" name="ep[rest]" >
<br />
<input type="submit" value="MAKE HMVC" >
</form>
