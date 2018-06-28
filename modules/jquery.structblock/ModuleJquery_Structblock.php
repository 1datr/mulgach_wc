<?php

class mul_jquery_structblock extends mul_Module 
{
	VAR $_controller;
	
	// Параметры :
	// controller - контроллер, к которому подключаешь плагин 
	function __construct($_PARAMS=array())
	{
	//	$obj_ui_plug = use_jq_plugin('__ui');
		if(is_object($_PARAMS))
		{
			$this->_controller = $_PARAMS;
		//	$obj_ui_plug->add_js_css($this->_controller);
			$this->add_js_css($this->_controller);
		}
		elseif(!empty($_PARAMS['controller']))
		{
			$this->_controller = $_PARAMS['controller'];
		//	$obj_ui_plug->add_js_css($this->_controller);
			$this->add_js_css($this->_controller);
			
		}		
	}
	
	function add_js_css($controller_obj)
	{
		$js_files = $this->js_files();		
		foreach ($js_files as $str_js)
		{
			$controller_obj->add_js($str_js);
		}
		
		$css_files = $this->css_files();
		foreach ($css_files as $str_css)
		{
			$controller_obj->add_css($str_css);
		}
	}
	
	function js_files()
	{
		$js_array=array();
		GLOBAL $_BASEDIR;
		$js_folder = url_seg_add(__DIR__,'js');
		if(file_exists($js_folder))
		{
			$js_files = get_files_in_folder($js_folder);
			
			foreach ($js_files as $js_script)
			{
				//echo $js_script;
				$str_js = filepath2url($js_script);
				$js_array[] = $str_js;
			}
			
			return $js_array;
		}
		return array();
	}
	
	function css_files()
	{
		$css_array=array();
		GLOBAL $_BASEDIR;
		$css_folder = url_seg_add(__DIR__,'css');
		if(file_exists($css_folder))
		{
			$css_files = get_files_in_folder($css_folder);
			
			//echo $_SERVER['DOCUMENT_ROOT'];
			foreach ($css_files as $css_file)
			{
				//echo $js_script;
				$str_css = filepath2url($css_file);
				$css_array[] = $str_css;
			}
			
			return $css_array;
		}
		return array();
	}
	
	function template_start($blockname,$attrs=array())
	{
		if(empty($attrs['class']))
			$attrs['class']='multiform_block';
		elseif( strstr($attrs['class'],"multiform_block")==false) 
			$attrs['class']=$attrs['class'].' multiform_block';
			
		$attrs['id']=$blockname;
		?>
		<div style="display: none;">
		<div <?=xx_implode($attrs, ' ', "{idx}=\"{%val}\"") ?> >
		<?php 
	}
	
	function template_end($fun_add_button=NULL)
	{
		?>
		</div>	
		</div>
		<?php 
	}
	
	function template_table_start($blockname,$attrs=array())
	{
		if(empty($attrs['class']))
			$attrs['class']='multiform_block';
		elseif( strstr($attrs['class'],"multiform_block")==false)
			$attrs['class']=$attrs['class'].' multiform_block';
				
		$attrs['id']=$blockname;
		?>
		<div style="display: none;">
		<table>
		<tr <?=xx_implode($attrs, ' ', "{idx}=\"{%val}\"") ?> >
		<?php 
	}
		
	function template_table_end($fun_add_button=NULL)
	{
		?>
		</tr>	
		</table>
		</div>
		<?php 
	}
	
	function block_start($blockname,$attrs=array(),$itemsattrs=array())
	{
		?>
		<div <?=xx_implode($attrs, ' ', "{idx}=\"{%val}\"") ?>  itemtemplate="<?=$blockname?>">
		<div class="items">
		<?php 
	}
	
	function block_end($fun_add_button=NULL)
	{
	?>
		</div>
		<?php 
		if($fun_add_button!=NULL)
		{
			$fun_add_button();
		}
		?>	
		</div>
	<?php 
	}
	
	function table_block_start($blockname,$attrs=array(),$itemsattrs=array(),$THEAD=NULL)
	{
		?>
			<table <?=xx_implode($attrs, ' ', "{idx}=\"{%val}\"") ?>  itemtemplate="<?=$blockname?>">
			<?php 
			if($THEAD!=NULL)
			{
				if(is_string($THEAD))
					echo $THEAD;
				else 
					$THEAD();
			}
			?>
			<tbody class="items">
			<?php 
		}
		
	function table_block_end($fun_add_button=NULL)
		{
		?>
			</tbody>
			<?php 
			if($fun_add_button!=NULL)
			{
				$fun_add_button();
			}
			?>	
			</table>
		<?php 
		}
	
}
