<table>
<?php
$ds->walk(function($row,$number)
{
	echo "<tr>";
	foreach ($row as $key => $val)
	{
		echo "<td>{$val}</td>";
	}
	echo "</tr>";
});
?>
</table>

<nav aria-label="Page navigation example">
	<ul class="pagination">
	<li class="page-item"><a class="page-link" href="#">Previous</a></li>
<?php 
$ds->draw_pager(function($page,$info)
{
	if($info['current_page']==$page)
	{
		?><li class="page-item  active"><a class="page-link" href="#"><?=$page?></a></li><?php 
	}
	else 
	{
		?>
		<li class="page-item"><a class="page-link" href="?r=workers/page:<?=$page?>"><?=$page?></a></li>
		<?php 
	}
});
?>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>