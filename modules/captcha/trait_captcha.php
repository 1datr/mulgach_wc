<?php
trait plgCaptcha {
	
	public function picture(){}
	
	public static function srv_name(){}
	
	public function picture_url(){}
	public function full_html(&$form,&$model_row){}
	// распознать являются ли данные из формы формата, присущего данному плагину 
	public static function recognize($data){}
	// проверка данных из форм
	public function check_captcha($data){}
}