<ul>
<?php
//print_r($files);
foreach ($files as $the_file)
{
	if(!is_dir($the_file))
	{
		continue;
	}
	?>
	<li>
	<a href="?r=hmvc/<?=basename($the_file)?>"><?=basename($the_file)?></a>
	<?php
	if(basename($the_file)!='main')
	{
		?>
		<a href="?r=configs/drop/<?=basename($the_file)?>" title="Drop it">x</a>
		<?php 
	}
	?>
	</li>
	<?php 
}
?>
</ul>
<form method="post" action="?r=configs/new">
<label for="newcfg">New config name</label>
<input type="text" id="newcfg" name="newcfg">
<input type="submit" value="Create new config" />
</form>