<table>
<tr><th>#{ENTITY NAME}</th><th>#{COMPILED}</th></tr>
<?php
foreach ($entities_table as $entity)
	{
?>
	<tr>
	<td><?=$entity->NAME?></td>
	<td>
	<?php
	if($entity->COMPILED)
		echo "x";
	?>
	</td>
	</tr>
<?php 	
	}
?>
</table>