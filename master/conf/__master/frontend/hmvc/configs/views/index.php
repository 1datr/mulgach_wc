<table>
<?php
//print_r($files);
foreach ($files as $the_file)
{
	if(!is_dir($the_file))
	{
		continue;
	}
	?>
	<tr>
	<td><a href="<?=as_url('hmvc/'.basename($the_file))?>"><?=basename($the_file)?></a></td>
	<td><a href="<?=as_url('configs/editconf/'.basename($the_file))?>" title="#{Change config}">
<img alt="" src="<?=$this->get_image('../../images/icon_conf.png')?>" width="18px" height="18px">
	</a>
	</td>	
	<td>
	<a href="<?=as_url('lang/'.basename($the_file))?>" title="#{Translation}">
	<img src="<?=$this->get_image('../../images/lang.png')?>" width="18px" height="18px" alt="#{Translation}" />
	</a>
	</td>
	<?php
	if(basename($the_file)!=$curr_config)
	{
		?>
		<td>
		<a href="<?=as_url('configs/drop/'.basename($the_file))?>" class="ref_delete" conf_message="#{Delete this configuration?}" title="Drop it">
			<img alt="" src="<?=$this->get_image('../../images/trash-circle.png')?>" width="18px" height="18px" />
		</a>
		</td>
		<?php 
	}
	?>
	
	</tr>
	<?php 
}
?>
</table>
<?php 
$frm=new mulForm(as_url("configs/new"),$this);
?>
<label for="newcfg">#{New config name}</label>
<input type="text" id="newcfg" name="newcfg">
<input type="submit" class="btn btn-primary" value="#{Create new config}" />
<?php 
$frm->close();
?>