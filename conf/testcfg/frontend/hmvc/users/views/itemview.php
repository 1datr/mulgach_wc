
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
		</td>
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
		<tr>
	<th valign="top"><label>#{users.avatar}</label></th>
	<td valign="top">
	<?=$users->getField('avatar',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.status}</label></th>
	<td valign="top">
	<?=$users->getField('status',true) ?>	</td>
	</tr>
	</table>