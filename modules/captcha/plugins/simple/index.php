<?php

class plg_simple extends mod_plugin 
{
	VAR $params;
	// ��������� :
	// controller - ����������, � �������� ����������� ������ 	
	function __construct($_PARAMS=array())
	{
		def_options(['img_id'=>'img-captcha'], $_PARAMS);
		$this->params = $_PARAMS;
		
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
	
	function picture($opts=[])
	{
		header('Content-type: image/png');
		//$this->use_layout('layout_login');
		//$this->out_view('loginform',array());
		
		def_options(['code_var'=>'CAPTCHA_CODE'], $opts);
		
		$img_dir="/img/";
		
		$font_dir="/font/";
		
		// ���������� �����. �������� ��������, ��� ��� ������������� ����� ������ (�� ������� � �� �����). �������� ��������� ��������, �� 3 �� 7.
		$linenum = rand(3, 7);
		// ������ ���� ��� �����. ������ ���������� ���� � ��������� ��� � ����� /img. ������������� ������ - 150�70. ����� ����� ���� ������� ������
		$img_arr = array(
				"bg1.png"
		);
		// ������ ��� �����. �������� ����� ������� ������, ��� ����� ���������� ��������
		$font_arr = array();
		//	$font_arr[0]["fname"] = "DroidSans.ttf";	// ��� ������. � ������ Droid Sans, �� ������, ����� ���������� ����� �����.
		$font_arr[0]["fname"] ="ms_sans_serif.ttf";
		$fonts = get_files_in_folder( url_seg_add( __DIR__, $font_dir),['']);
		$font_arr[0]["size"] = rand(20, 30);				// ������ � pt
		// ���������� "���������" ��� ����� �� ��������� �����
		$n = rand(0,sizeof($font_arr)-1);
		$img_fn = $img_arr[rand(0, sizeof($img_arr)-1)];
		
		$im = imagecreatefrompng( url_seg_add( __DIR__,$img_dir,$img_fn));
		
		// ������ ����� �� ���������
		for ($i=0; $i<$linenum; $i++)
		{
			$color = imagecolorallocate($im, rand(0, 150), rand(0, 100), rand(0, 150)); // ��������� ���� c �����������
			imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
		}
		
		$col_r = rand(0, 200);
		$col_g = 0;
		$col_b = rand(0, 200); // ����� ��������� ����. ��� ��� ������.
		
		$code = GenRandStr();
		$_SESSION[$opts['code_var']]=$code;
		// ����������� ����� �����
		$x = rand(0, 10);
		for($i = 0; $i < strlen($code); $i++) {
				
			$delta = rand(-50,50);
			$curr_r = ( ($col_r+$delta>=0) ? ($col_r+($delta)): $col_r );
			$delta = rand(-50,50);
			$curr_g = ( ($col_g+$delta>=0) ? ($col_g+($delta)): $col_g );
			$delta = rand(-50,50);
			$curr_b = ( ($col_b+$delta>=0) ? ($col_b+($delta)): $col_b );			
				
			$color = imagecolorallocate($im, $curr_r, $curr_g, $curr_b); // ��������� ����
			$letter=substr($code, $i, 1);
			//	$_size = $font_arr[$n]["size"];
			$_size = rand(25, 35);
			//$_font = url_seg_add($this->get_current_dir(),$font_dir,$font_arr[$n]["fname"]);
			$_font = $fonts[ rand(0,sizeof($fonts)-1)];
			imagettftext($im, $_size, rand(-20, 20), $x, rand(50, 55), $color, $_font, $letter);
			$x+=rand(20,30);
		}
		
		// ����� �����, ��� ������ ������
		for ($i=0; $i<$linenum; $i++)
		{
			$color = imagecolorallocate($im, rand(0, 255), rand(0, 200), rand(0, 255));
			imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
		}
		// ���������� ������������ �����������
		
		ImagePNG ($im);
		ImageDestroy ($im);
	}
	
	public function picture_url()
	{
		return "?srv=captcha_pic";
	}
	
	public function get_onclick_update_js()
	{
		return "$('#img-captcha').attr('src',$('#".$this->params['img_id']."').attr('src'));return false;";
	}
	
	public function full_html()
	{
		?>
		<img src="<?=$this->picture_url()?>" id="<?=$this->params['img_id']?>" />
		<!--�������, ������������� ����� ��� CAPTCHA-->
		<button type="button" class="btn btn-default" aria-label="Left Align" onclick="<?=$this->get_onclick_update_js()?>">
  			<span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>#{Update captcha}
		</button>			  
		<?php 
	}
}