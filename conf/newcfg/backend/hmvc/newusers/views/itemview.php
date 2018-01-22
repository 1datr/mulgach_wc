
<h3>#{View NEWUSERS} <?=$newusers->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{newusers.login}</label></th>
	<td valign="top">
	<?=$newusers->getField('login',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{newusers.password}</label></th>
	<td valign="top">
		</td>
	</tr>
		<tr>
	<th valign="top"><label>#{newusers.email}</label></th>
	<td valign="top">
	<?=$newusers->getField('email',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{newusers.thehash}</label></th>
	<td valign="top">
	<?=$newusers->getField('thehash',true) ?>	</td>
	</tr>
	</table>