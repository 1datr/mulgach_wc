
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
	<th valign="top"><label>#{users.first_name}</label></th>
	<td valign="top">
	<?=$users->getField('first_name',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.last_name}</label></th>
	<td valign="top">
	<?=$users->getField('last_name',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.phone}</label></th>
	<td valign="top">
	<?=$users->getField('phone',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.web}</label></th>
	<td valign="top">
	<?=$users->getField('web',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.address}</label></th>
	<td valign="top">
	<?=$users->getField('address',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.sostoyanie_dopuska}</label></th>
	<td valign="top">
	<?=$users->getField('sostoyanie_dopuska',true)?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.skype}</label></th>
	<td valign="top">
	<?=$users->getField('skype',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.status}</label></th>
	<td valign="top">
	<?=$users->getField('status',true)?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{users.hash}</label></th>
	<td valign="top">
	<?=$users->getField('hash',true) ?>	</td>
	</tr>
	</table>