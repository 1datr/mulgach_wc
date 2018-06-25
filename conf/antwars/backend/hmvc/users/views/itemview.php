
<h3>#{View USERS} <?=$users->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{users.login}</label></th>
	<td valign="top">
	<?=$users->getField('login',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.password}</label></th>
	<td valign="top">
	<?=$users->getField('password',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.email}</label></th>
	<td valign="top">
	<?=$users->getField('email',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.token}</label></th>
	<td valign="top">
	<?=$users->getField('token',true) ?>	</td>
	</tr>
	</table>