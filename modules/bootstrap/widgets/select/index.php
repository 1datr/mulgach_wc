<?php
namespace BootstrapCombobox
{
	use \Widget;

	class ComboboxWidget extends \Widget 
	{	
		
		function out($params=array())
		{
			def_options(array('data'=>array(),'htmlattrs'=>array()), $params);
			if(!empty($params['name']))
			{
				$params['htmlattrs']['name']=$params['name'];
				unset($params['name']);
			}
			
			if(!empty($params['data']))
				$this->out_array_data($params);
			elseif(!empty($params['ds'])) 
				$this->out_dataset($params);
		}
		
		function out_array_data($params)
		{
		?><select <?=$this->get_attr_str($params['htmlattrs'])?>>
			<?php 
			$ctr=0;
			foreach($params['data'] as $idx => $row)
			{
				if($ctr==0)
				{					
					if(empty($params['value_key']))
					{
						if(!is_array($row))
							$params['value_key']="{%0}";
						else
							$params['value_key']=array_keys($row)[0];
						
					}
					if(empty($params['caption_template']))
					{
						if($params['value_key']=="{%0}")
						{
							$params['caption_template']=$params['value_key'];
						}
						else 
						{
							$params['caption_template']="{".$params['value_key']."}";
						}
					}
				
						//print_r($params);
				}
				
				if($params['value_key']=="{%0}")
				{
					$val=$row;
				}
				else 
				{
					$val = $row[$params['value_key']];
				}
				$selected="";
				if(!empty($params['value']))
				{
					if($val==$params['value'])
						$selected="selected";
				}

				?>
				<option value="<?=$val?>" <?=$selected?>><?=x_make_str($params['caption_template'],$row)?></option>
				<?php 
				$ctr++;
			}
			
			
			?>
			</select>	
			
			<?php
		}
		
		function out_dataset($params)
		{
			?>
			<select <?=$this->get_attr_str($params['htmlattrs'])?>>
					<?php 
					if(empty($params['required']))
					{
						?>
						<option value="" ></option>
						<?php 
					}
					
					//print_r($params);
					$params['ds']->walk(
							function($dr,$numrow) use ($params) 
							{						
								$checked="";
								// field
								if(!empty($params['field_value']))
									$val = $dr->getField($params['field_value']);
								else	
									$val = $dr->getPrimary();
																							
								if(!empty($params['value']))
								{								
									if($val==$params['value'])
										$checked="selected";
								}
								// caption 	
								if(!empty($params['field_caption']))
									$caption = $dr->getField($params['field_value']);
								elseif(!empty($params['caption_template']))
									$caption = x_make_str($params['caption_template'], $dr);
								else
									$caption = $dr->getView();
						?>
						<option value="<?=$val?>" <?=$checked?> ><?=$caption?></option>
						<?php 
								
							}
							);
				?>
			</select>					
			<?php
		}
			
	}

}
?>