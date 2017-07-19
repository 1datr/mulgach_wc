<?php 
class UsersController extends AuthController
{

	public function Rules()
	{
		return array(
			'action_args'=>array(
				'index'=>['page'=>'integer'],	
				'edit'=>['id'=>'integer'],	
				'delete'=>['id'=>'integer'],
			),			
			'action_access'=>array(
						new ActionAccessRule('deny',_array_diff($this->getActions(),array('login','auth')),'anonym','users/login')
				),	
		);
	}
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="USERS";
	
		$conn = get_connection();
		
		$this->add_block("BASE_MENU", "users", "menu");

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page);
		
		
		$this->inline_script("
		    $( document ).ready(function() {
        		$('.ref_delete').click(function() 
        		{
        			if(confirm('Удалить объект?'))
        			{
        				return true;
        			}
        			return false;
        		});
    		});
		");
		
		$this->out_view('index',array('ds'=>$ds));
	}
	
	public function ActionCreate()
	{
		$this->add_block("BASE_MENU", "users", "menu");
		$this->_TITLE="CREATE USERS";
		$this->out_view('itemform',array('users'=>$this->_MODEL->CreateNew()));
	}
	
	public function ActionEdit($id)
	{		
		$this->add_block("BASE_MENU", "users", "menu");
		$users = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id");
		$this->_TITLE=$users->getView()." #{EDIT}"; 
		$this->out_view('itemform',array('users'=>$users));
	}
	
	public function ActionSave()
	{
		$newitem = $this->_MODEL->findByPrimary($_POST['users']);
		
		if($newitem!=null)
		{
			$newitem->FillFromArray($_POST['users']);
		}
		else 
		{
			$newitem = $this->_MODEL->GetRow($_POST['users']);
		}		
		
		$newitem->save();
		
		if(!empty($_POST['back_url']))
			$this->redirect($_POST['back_url']);
		else 
			$this->redirect(as_url('users'));		
	}
			
	public function ActionDelete($id)
	{
		$this->_MODEL->Delete($this->_MODEL->_SETTINGS['primary']."=".$id);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function ActionView($id)
	{
		$this->add_block("BASE_MENU", "users", "menu");
		$users = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id"); 
		$this->_TITLE=$users->getView()." #{VIEW}"; 
		$this->out_view('itemview',array('users'=>$users));
	}
	
	public function ActionMenu()
	{
		$menu = $this->getinfo('basemenu');
		//print_r($menu);
		$this->out_view('menu',array('menu'=>$menu));
	}	
	
	public function ActionLogin()
	{
		$this->_TITLE=Lang::__t('Authorization');
		$this->use_layout('layout_login');
		$this->out_view('loginform',array());
	}
	
	public function ActionCaptcha()
	{
		$this->_TITLE=Lang::__t('Authorization');
		$this->_RESULT_TYPE="image/png";
		//$this->use_layout('layout_login');
		//$this->out_view('loginform',array());
		
		$img_dir="../../img/";
		
		$font_dir="../../font/";
		
		// Количество линий. Обратите внимание, что они накладываться будут дважды (за текстом и на текст). Поставим рандомное значение, от 3 до 7.
		$linenum = rand(3, 7);
		// Задаем фоны для капчи. Можете нарисовать свой и загрузить его в папку /img. Рекомендуемый размер - 150х70. Фонов может быть сколько угодно
		$img_arr = array(
				"bg1.png"
		);
		// Шрифты для капчи. Задавать можно сколько угодно, они будут выбираться случайно
		$font_arr = array();
	//	$font_arr[0]["fname"] = "DroidSans.ttf";	// Имя шрифта. Я выбрал Droid Sans, он тонкий, плохо выделяется среди линий.
		$font_arr[0]["fname"] ="ms_sans_serif.ttf";
		$fonts = get_files_in_folder( url_seg_add( $this->get_current_dir(), $font_dir),['']);
		$font_arr[0]["size"] = rand(20, 30);				// Размер в pt
		// Генерируем "подстилку" для капчи со случайным фоном
		$n = rand(0,sizeof($font_arr)-1);
		$img_fn = $img_arr[rand(0, sizeof($img_arr)-1)];
		
		$im = imagecreatefrompng( url_seg_add( $this->get_current_dir(),$img_dir,$img_fn));
		
		// Рисуем линии на подстилке
		for ($i=0; $i<$linenum; $i++)
		{
			$color = imagecolorallocate($im, rand(0, 150), rand(0, 100), rand(0, 150)); // Случайный цвет c изображения
			imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
		}
		
		$col_r = rand(0, 200);
		$col_g = 0;
		$col_b = rand(0, 200); // Опять случайный цвет. Уже для текста.
		
		$code = GenRandStr();
		// Накладываем текст капчи
		$x = rand(0, 15);
		for($i = 0; $i < strlen($code); $i++) {
			
			$delta = rand(-50,50);
			$curr_r = ( ($col_r+$delta>=0) ? ($col_r+($delta)): $col_r );
			$delta = rand(-50,50);
			$curr_g = ( ($col_g+$delta>=0) ? ($col_g+($delta)): $col_g );
			$delta = rand(-50,50);
			$curr_b = ( ($col_b+$delta>=0) ? ($col_b+($delta)): $col_b );
			
			mul_dbg("$curr_r : $curr_g : $curr_b");
			
			$color = imagecolorallocate($im, $curr_r, $curr_g, $curr_b); // случайный цвет
			$letter=substr($code, $i, 1);
		//	$_size = $font_arr[$n]["size"];
			$_size = rand(35, 40);
			//$_font = url_seg_add($this->get_current_dir(),$font_dir,$font_arr[$n]["fname"]);
			$_font = $fonts[ rand(0,sizeof($fonts)-1)];
			imagettftext($im, $_size, rand(2, 20), $x, rand(50, 55), $color, $_font, $letter);
			$x+=25;
		}
		
		// Опять линии, уже сверху текста
		for ($i=0; $i<$linenum; $i++)
		{
			$color = imagecolorallocate($im, rand(0, 255), rand(0, 200), rand(0, 255));
			imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
		}
		// Возвращаем получившееся изображение
		
		ImagePNG ($im);
		ImageDestroy ($im);
	}
	
	public function ActionAuth()
	{
		$auth_res = $this->_MODEL->auth($_POST['login'],$_POST['password']);
		if($auth_res)
		{
			$_SESSION[$this->get_ep_param('sess_user_descriptor')]=array('login'=>$_POST['login']);

			$this->redirect(as_url('users'));
		}
		else 
			$this->redirect_back();

		//$this->out_view('loginform',array());
	}
	
	
	
	public function ActionLogout()
	{
		$this->logout();
		$this->redirect(as_url('users/login'));
	}
}
?>