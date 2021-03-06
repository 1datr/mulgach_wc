<?php

class plg_confirmdelete extends mod_plugin 
{

	VAR $_controller;
	
	// ��������� :
	// controller - ����������, � �������� ����������� ������ 
	function __construct($_PARAMS=array())
	{
		
		if(is_object($_PARAMS))
		{
			$this->_controller = $_PARAMS;

			$this->add_js_css($this->_controller);
		}
		elseif(!empty($_PARAMS['controller']))
		{
			$this->_controller = $_PARAMS['controller'];

			$this->add_js_css($this->_controller);
			
		}		
	}
	
	function draw_itemblock_hidden_begin($item_class_name)
	{
		?>
		<div style="display:none">
			<div data-name="<?=$item_class_name?>">
			<?php 
	}
	
	function draw_itemblock_hidden_end()
	{
		?>
			</div>
		</div>
		<?php 
	}
	
	function draw_item($item_class_name)
	{
		?>
			<div class="item">
				<div data-name="<?=$item_class_name?>">
		<?php 
	}
	
	function draw_item_end()
	{
		?>
				</div>
			</div>
		<?php 
	}
		
	
	function itemblock_begin($item_class_name)
	{
		?>
		<div data-holder-for="<?=$item_class_name?>" class="list ui-sortable">
		<?php 
	}
	
	function itemblock_end()
	{
		?>
		<div class="add"></div>
		</div>
		<?php 
	}
	
	function draw_itemblock($item_class_name,$one_item)
	{
		?>
		<div data-name="<?=$item_class_name?>">
		<?php 
		$one_item();
		?>
		</div>
		<?php 
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
		$the_dir = url_seg_add(__DIR__,'js') ;
		if(! file_exists($the_dir))
			return array();
		$js_files = get_files_in_folder($the_dir);
		
		//echo $_SERVER['DOCUMENT_ROOT'];
		foreach ($js_files as $js_script)
		{
			//echo $js_script;
			$str_js = filepath2url($js_script);
			$js_array[] = $str_js;
		}
		return $js_array;
	}
	
	function css_files()
	{
		$css_array=array();
		GLOBAL $_BASEDIR;
		$the_dir = url_seg_add(__DIR__,'css');
		if(! file_exists($the_dir))
			return array();
		$css_files = get_files_in_folder($the_dir);	
		
		//echo $_SERVER['DOCUMENT_ROOT'];
		foreach ($css_files as $css_file)
		{
			//echo $js_script;
			$str_css = filepath2url($css_file);
			$css_array[] = $str_css;
		}
		return $css_array;
	}
	
}