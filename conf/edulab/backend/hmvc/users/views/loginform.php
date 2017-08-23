<?php
$frm=new mulForm(as_url('users/auth'),$this);
?>
<div class="error" id="err_auth" role="alert"></div>
<table>
<tr><th>#{Login}</th><td><input type="text" name="login" /></td></tr>
<tr><th>#{Password}</th><td><input type="password" name="password" /></td></tr>
<tr></tr>
</table>
<?php $frm->submit('#{Log in}'); ?>