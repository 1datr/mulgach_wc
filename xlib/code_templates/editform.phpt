<form method="post" class="submitable" action="{action}">
<?php
if(empty($_MODE_EDIT))
{
	?>
	<input type="submit" value="��������" />
	<?php 
}
else
{
?>
	<input type="submit" name="saveall" value="���������" />
	<input type="hidden" name="page_from" value="<?=$_SERVER['HTTP_REFERER']?>"/>
<?php
}
?>
{primary}
{error_block}
<table>
{rows}
</table>
</form>