
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
	<th valign="top"><label>#{users.phone}</label></th>
	<td valign="top">
	<?=$users->getField('phone',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.address}</label></th>
	<td valign="top">
	<?=$users->getField('address',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.web}</label></th>
	<td valign="top">
	<?=$users->getField('web',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.skype}</label></th>
	<td valign="top">
	<?=$users->getField('skype',true) ?>	</td>
	</tr>
	</table>