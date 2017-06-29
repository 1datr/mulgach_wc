<#php
$frm=new mulForm(as_url('{this_controller}/auth'));
#>
<table>
<tr><th>#{Login}</th><td><input type="text" name="{login_fld}" /></td></tr>
<tr><th>#{Password}</th><td><input type="password" name="{passw_fld}" /></td></tr>
<tr></tr>
</table>
<#php $frm->submit('#{Log_in}'); #>