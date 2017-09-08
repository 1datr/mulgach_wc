<#php
$frm=new mulForm(as_url('{this_controller}/auth'),$this);
#>
<div class="error" id="err_auth" role="alert"></div>
<table>
<tr><th>#{Login}</th><td><input type="text" name="{login_fld}" /></td></tr>
<tr><th>#{Password}</th><td><input type="password" name="{passw_fld}" /></td></tr>
<tr></tr>
</table>
<input type="hidden" name="url_required" value="<#=get_back_page()#>" />
<#php $frm->submit('#{Log in}'); #>