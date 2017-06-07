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
			?>
			<select <?=$this->get_attr_str($params['htmlattrs'])?>>
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
				?>
				<option value="<?=$val?>"><?=x_make_str($params['caption_template'],$row)?></option>
				<?php 
				$ctr++;
			}
			?>
			</select>	
			
			<?php
			
		}
	}

}
?>