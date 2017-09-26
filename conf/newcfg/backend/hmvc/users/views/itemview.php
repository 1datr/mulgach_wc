
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
	<th valign="top"><label>#{users.hash}</label></th>
	<td valign="top">
	<?=$users->getField('hash',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.email}</label></th>
	<td valign="top">
	<?=$users->getField('email',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.fio}</label></th>
	<td valign="top">
	<?=$users->getField('fio',true) ?>	</td>
	</tr>
	</table>