<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm("?r=forum/save");
?>
<input type="hidden" name="forum[]" value="<?=((!empty($forum)) ? $forum->getField('') : '')?>" />
<h3><?php 
if(!empty($forum))   
{
	?>
	#{Edit FORUM} <?=$forum->getView()?>
	<?php
}
else
{
	?>
	#{Create FORUM}
	<?php
}
?></h3>
<table>
<br />
<font size='1'><table class='xdebug-error xe-warning' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Warning: Invalid argument supplied for foreach() in E:\OpenServer\domains\mulgach\master\conf\__master\frontend\phpt\view_itemform.phpt on line <i>24</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0000</td><td bgcolor='#eeeeec' align='right'>138288</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='E:\OpenServer\domains\mulgach\master\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.0000</td><td bgcolor='#eeeeec' align='right'>152424</td><td bgcolor='#eeeeec'>require_once( <font color='#00bb00'>'E:\OpenServer\domains\mulgach\api\index.php'</font> )</td><td title='E:\OpenServer\domains\mulgach\master\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>7</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.0120</td><td bgcolor='#eeeeec' align='right'>698256</td><td bgcolor='#eeeeec'>mul_page->draw(  )</td><td title='E:\OpenServer\domains\mulgach\api\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>102</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.0650</td><td bgcolor='#eeeeec' align='right'>703344</td><td bgcolor='#eeeeec'>mul_page->hmvc_request(  )</td><td title='E:\OpenServer\domains\mulgach\modules\page\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>305</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.0650</td><td bgcolor='#eeeeec' align='right'>705152</td><td bgcolor='#eeeeec'>mul_page->call_action(  )</td><td title='E:\OpenServer\domains\mulgach\modules\page\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>333</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.0680</td><td bgcolor='#eeeeec' align='right'>827592</td><td bgcolor='#eeeeec'><a href='http://www.php.net/function.call-user-func-array:{E:\OpenServer\domains\mulgach\modules\page\index.php:814}' target='_new'>call_user_func_array:{E:\OpenServer\domains\mulgach\modules\page\index.php:814}</a>
(  )</td><td title='E:\OpenServer\domains\mulgach\modules\page\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>814</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.0680</td><td bgcolor='#eeeeec' align='right'>827784</td><td bgcolor='#eeeeec'>HmvcController->ActionMake(  )</td><td title='E:\OpenServer\domains\mulgach\modules\page\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>814</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.0680</td><td bgcolor='#eeeeec' align='right'>828992</td><td bgcolor='#eeeeec'>HmvcController->make_hmvc(  )</td><td title='E:\OpenServer\domains\mulgach\master\conf\__master\frontend\hmvc\hmvc\controller.php' bgcolor='#eeeeec'>...\controller.php<b>:</b>225</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>0.0700</td><td bgcolor='#eeeeec' align='right'>889800</td><td bgcolor='#eeeeec'>HmvcController->make_mvc_frontend(  )</td><td title='E:\OpenServer\domains\mulgach\master\conf\__master\frontend\hmvc\hmvc\controller.php' bgcolor='#eeeeec'>...\controller.php<b>:</b>563</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>10</td><td bgcolor='#eeeeec' align='center'>0.1100</td><td bgcolor='#eeeeec' align='right'>911240</td><td bgcolor='#eeeeec'>parse_code_template(  )</td><td title='E:\OpenServer\domains\mulgach\master\conf\__master\frontend\hmvc\hmvc\controller.php' bgcolor='#eeeeec'>...\controller.php<b>:</b>381</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>11</td><td bgcolor='#eeeeec' align='center'>0.1100</td><td bgcolor='#eeeeec' align='right'>936688</td><td bgcolor='#eeeeec'>include( <font color='#00bb00'>'E:\OpenServer\domains\mulgach\master\conf\__master\frontend\phpt\view_itemform.phpt'</font> )</td><td title='E:\OpenServer\domains\mulgach\api\mullib\utils.php' bgcolor='#eeeeec'>...\utils.php<b>:</b>363</td></tr>
</table></font>
</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
<?php $form->submit('#{SAVE}'); ?>
</form>