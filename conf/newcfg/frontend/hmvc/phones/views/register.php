<?php
$form = new \mulForm(as_url('phones/makeuser'),$this);
$captcha = mul_captcha::use_captcha($this,['model'=>&$reg_form_struct,'form'=>&$form]);
//var_dump($reg_struct);
?>
<table>
	<tr>
	<th><label>#{phones.}</label></th><td>
	<?php $form->field($reg_struct,'')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{phones._re}</label></th><td>
	<?php $form->field($reg_struct,'_re')->password();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{phones.user_id}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('user')->_MODEL->find() ,'name'=>'phones[user_id]');			
					if(!empty($phones))
		{
			$params['value']=$phones->getField('user_id',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_user_id' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{phones.name}</label></th><td>
	<?php $form->field($reg_struct,'name')->text();	 ?>	</td>
	</tr>
		<tr>
	<th><label>#{phones.phone}</label></th><td>
	<?php $form->field($reg_struct,'phone')->text();	 ?>	</td>
	</tr>
	  <tr> 	  
    <td rowspan="2">#{CAPTCHA_CAPTION}</td>
    <td>
    <? $captcha->full_html($form,$reg_struct);  ?>
    </td>
  </tr>

</table>

<?php
$form->submit('#{REGISTER}');
$form->close();
?>