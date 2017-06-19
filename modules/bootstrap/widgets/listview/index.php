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
		function __construct($fld,$owner,$settings=array())
		{
			$this->datafld = $fld;
			$this->owner_widget = $owner;
			$this->settings = $settings;
			if(!empty($settings['caption_template']))
				$this->caption_template = $settings['caption_template'];
			else 
				$this->caption_template = "{caption}";
		}
		
		function draw(&$dr,&$numrow)
		{
			$thefield = $dr->getField($this->datafld);
			
			if(!empty($this->settings['html_template']))
			{
				echo x_make_str($this->settings['html_template'], $dr->getFields());
			}
			else 
			{
				if(is_object($thefield))
				{
					echo $thefield->getView(true);
				}
				else
					echo $dr->getField($this->datafld,true);
			}
		}
		
		function draw_col_head()
		{
	//		echo isset($this->settings['caption']);
			if(isset($this->settings['caption']))
			{
				echo $this->settings['caption'];
				
			}
			else
			{
			
				if($this->caption_template=='')
				{
					
				}
				else 
					echo \Lang::__t( $this->owner_widget->_table.'.'.$this->datafld);
			}
		}
		
		static function ref_column($template,$caption_template='')
		{
			return array('caption'=>'','html_template'=>$template,'caption_template'=>$caption_template);
		}
	}
	
	class ListViewWidget extends \Widget 
	{
		VAR $_table;
		
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
			
			$this->_table = $params['ds']->_ENV['_CONTROLLER']->_MODEL->_TABLE;
				
			//print_r($params['columns']);
			?><table class="<?=$params['tableclass']?>">
			<?php
			$params['ds']->walk(function($rec,$number) use (&$params)
			{	
				echo "<tr>";
				foreach ($params['columns'] as $idx => $column)
				{
					echo "<td>"; $column->draw($rec,$number); echo "</td>";
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
					echo "<th>";
					echo $col->draw_col_head();
					echo "</th>";
				}
				?>
				
				</tr>
				</thead>
				<?php 
			});
?>
</table><?php 
$this->usewidget(new PagerWidget(),array('ds'=>$params['ds']));
			}
	}

}
?>