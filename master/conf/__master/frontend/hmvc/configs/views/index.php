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
	<a href="<?=as_url('hmvc/'.basename($the_file))?>"><?=basename($the_file)?></a>
	<a href="<?=as_url('configs/editconf/'.basename($the_file))?>" title="#{Change config}">#{Edit config}</a>
	<?php
	if(basename($the_file)!='main')
	{
		?>
		
		<a href="<?=as_url('configs/drop/'.basename($the_file))?>" title="Drop it">x</a>
		<?php 
	}
	?>
	</li>
	<?php 
}
?>
</ul>
<?php 
$frm=new mulForm(as_url("configs/new"),$this);
?>
<label for="newcfg">#{New config name}</label>
<input type="text" id="newcfg" name="newcfg">
<input type="submit" class="btn btn-primary" value="#{Create new config}" />
<?php 
$frm->close();
?>