<?php
trait plgCaptcha {
	public function picture(){}
	public function picture_url(){}
	public function full_html(&$form,&$model_row){}
	// ���������� �������� �� ������ �� ����� �������, ��������� ������� ������� 
	public static function recognize($data){}
	// �������� ������ �� ����
	public function check_captcha($data){}
}