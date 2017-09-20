<?php
$frm=new mulForm(as_url('phones/auth'),$this);
?>
<div class="error" id="err_auth" role="alert"></div>
<table>
<tr><th>#{Login}</th><td><input type="text" name="" /></td></tr>
<tr><th>#{Password}</th><td><input type="password" name="" /></td></tr>
<tr></tr>
</table>
<?php $dismissed_url_var = $this->get_user_descriptor().'_dismissed_url'; ?>
<input type="hidden" name="url_required" value="" />
<?php $frm->submit('#{Log in}'); ?>