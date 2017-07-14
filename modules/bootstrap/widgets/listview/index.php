<?php
namespace BootstrapListView
{
	use \Widget;
	use BootstrapPager\PagerWidget as PagerWidget;

	class LVW_Column
	{
		VAR $datafld;
		VAR $owner_widget;
		VAR $settings=array();
		VAR $caption_template="";
		VAR $fldinfo;

		function __construct($fld,$owner,$settings=array())
		{
			$this->datafld = $fld;
			$this->owner_widget = $owner;
						
			$def_template = '{value}';
			$def_capt_template = '{value}';
			$is_visible=true;
			
			$this->fldinfo = $this->owner_widget->_CONTROLLER->_MODEL->getFldInfo($fld);
			
			if($this->fldinfo['password'])
			{
				$def_template = "";
				$def_capt_template="";
				$is_visible=false;
			}
			
			def_options(array('html_template'=>$def_template,'caption_template'=>$def_capt_template,'visible'=>$is_visible), $settings);		
			
		//	mul_dbg($settings,false);
			
			if(isset($this->fldinfo['file']))
			{
				$the_type = $this->fldinfo['file']['type'];
				$arr = explode('/',$the_type);
				$class=$arr[0];
				
				$settings['html_template'] = '<?php
if(!empty($value))
								{
								?>
								<a href="{value}" target="newwin"><?=basename($value)?></a>
								<?php
								}
								?>';
				
				switch($class)
				{
					case 'audio': {
						use_jq_plugin('jqplayer',$this->owner_widget->_CONTROLLER);
						$settings['html_template'] = '<?php 
if(!empty($value))
								{
								?>
								<audio src="{value}" preload="auto" controls></audio>
								<?php
								}
								?>';
					};break;

				}
			}	
			
			
			
			$this->settings = $settings;
			
			if(!empty($settings['caption_template']))
				$this->caption_template = $settings['caption_template'];
			else 
				$this->caption_template = "{caption}";
		}
		
		function draw(&$dr,&$numrow)
		{
			if(!$this->settings['visible']) return NULL;
			
			$thefield = $dr->getField($this->datafld);
			
			if(!empty($this->settings['html_template']))
			{
				$vars = $dr->getFields();
				
				$thevalue='';
				if(is_object($thefield))
				{
					$thevalue = $thefield->getView(true);
				}
				else
					$thevalue = $dr->getField($this->datafld,true);
				
				$vars['value']=$thevalue;
				if(isset($this->fldinfo['file']))
				{
					$a=1;
				}
				
			//	mul_dbg($this->settings);
				
				return x_make_str($this->settings['html_template'], $vars);
			}
			else 
			{
			//	mul_dbg('emptty ');
			}
				
			return " ";
			
		}
		
		function draw_col_head()
		{
			if(!$this->settings['visible']) return NULL;
			
			$vars=array();
			if(isset($this->settings['caption']))
				$vars['value']=$this->settings['caption'];
			else
				$vars['value']=\Lang::__t( $this->owner_widget->_table.'.'.$this->datafld);
			
			return x_make_str($this->settings['caption_template'], $vars);
			
		}
		
		static function ref_column($template,$caption_template='')
		{
			return array('caption'=>'','html_template'=>$template,'caption_template'=>$caption_template);
		}
	}
	
	class ListViewWidget extends \Widget 
	{
		VAR $_table;
		VAR $_CONTROLLER;
		
		static function init_column($key,$widg,$val)
		{
			if(is_string($key) && is_array($val))
			{
				$col_obj = new LVW_Column($key,$widg,$val);
					
			}
			elseif(is_int($key) && is_string($val))
			{
				$col_obj = new LVW_Column($val,$widg);
			}
			return $col_obj;
		}
		
		function make_columns($params)
		{
			$columns=array();
			foreach ($params['columns'] as $key => $val)
			{
				$col_obj = $this->init_column($key,$val);
				$columns[]=$col_obj;
			}
			return $columns;
		}
		
		function out($params=array())
		{
			def_options(array('tableclass'=>'table'),$params);
			
			$this->_CONTROLLER = $params['ds']->_ENV['_CONTROLLER'];
			
			$this->_table = $params['ds']->_ENV['_CONTROLLER']->_MODEL->_TABLE;
				
			//print_r($params['columns']);
			?><table class="<?=$params['tableclass']?>">
			<?php
			$params['ds']->walk(function($rec,$number) use (&$params)
			{	
				echo "<tr>";
				foreach ($params['columns'] as $idx => $column)
				{
					$td_content = $column->draw($rec,$number);
				//	mul_dbg($td_content,false);

					if( is_string($td_content) )
					{
						echo "<td>{$td_content}</td>";
					}
				}
				echo "</tr>";
				
			}, 
			// head 
			function($keys) use (&$params)
			{
				if(empty($params['columns']))
				{
					$params['columns']=array();
					foreach($keys as $fldname)
					{
						$params['columns'][] = new LVW_Column($fldname,$this);
					}
				}
				else 
				{
					$collist=array();
					foreach($params['columns'] as $key => $col)
					{

						if($col == "__default__")
						{		
							
							foreach($keys as $fldname)
							{
								$collist[] = new LVW_Column($fldname,$this);
							}

						}
						else 
						{
							$collist[] = ListViewWidget::init_column($key,$this,$col);
						}
					}
					$params['columns'] = $collist;
					
				}
				?>
				<thead>
				<tr>
				<?php 
				foreach ($params['columns'] as $idx => $col)
				{
					$th_content = $col->draw_col_head();
					if(is_string($th_content) )
					{
						echo "<th>{$th_content}</th>";
					}
				}
				?>
				
				</tr>
				</thead>
				<?php 
			});
?>
</table><?php 
$this->usewidget(new PagerWidget($this->_PARAMS['controller']),array('ds'=>$params['ds']));
			}
	}

}
?>