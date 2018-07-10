<table>
<tr><th>#{ENTITY NAME}</th><th>#{COMPILED}</th></tr>
<?php
foreach ($entities_table as $entityinfo)
	{
?>
	<tr>
	<td><?php 
		if($entityinfo['exists'])
		{
			?><?=$entityinfo['entity']->NAME?>
		<?php		
		}
		else 
		{
			?><?=$entityinfo['entity']?><?php 
		}
		?></td>
	<td>
	<?php
		if($entityinfo['exists'])
		{
			echo "x";
		}
	?>
	</td>
	<?php 
		if($entityinfo['exists'])
		{
			?>
			<td>
			<a href="<?=as_url('emaker/drop/'.$entityinfo['entity']->PARENT_CFG->_NAME.'/'.$entityinfo['entity']->NAME)?>" class="ref_delete" conf_message="#{Delete this entity?}" title="Drop it">
			<img alt="" src="<?=$this->get_image('../../images/trash-circle.png')?>" width="18px" height="18px" />
			</a>	
			</td>
			
			<td>
			<a href="<?=as_url('emaker/edit/'.$entityinfo['entity']->PARENT_CFG->_NAME.'/'.$entityinfo['entity']->NAME)?>" title="#{Edit the entity}">
			<img alt="" src="<?=$this->get_image('../../images/pen.jpg')?>" width="18px" height="18px">
			<a />
			</td>
			<?php 
		}	
		else 
		{
			?>
			<td colspan="2"><?php 
			$formrow = $this->_MODEL->empty_row_form_model();
			$formrow->setField('ename',$entityinfo['entity']);
			$formrow->setField('cfg',$cfg);
			$formrow->setField('existing_table',$entityinfo['entity']);
			$this->out_view('from_existing_table',['formrow'=>$formrow]); 
			?></td>
			<?php 
		}
	?>	
	</tr>
<?php 	
	}
?>
</table>
<?php 
/*
jq_onready($this,"
$('.ref_delete').click(function(obj) 
        		{
        			if(confirm($(obj).attr('conf_message'))
        			{
        				return true;
        			}
        			return false;
        		});");
        		*/
?>