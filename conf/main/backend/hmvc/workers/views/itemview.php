
<h3>#{View WORKERS} <?=$workers->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{workers.number}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('number',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.fio}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('fio',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.fio_eng}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('fio_eng',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.position}</label></th>
	<td valign="top">
	<?=$workers->getField('position',true)?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.city}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('city',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.address1}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('address1',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.address2}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('address2',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.mail1}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('mail1',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.mail2}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('mail2',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.phone1}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('phone1',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.phone2}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('phone2',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.phone3}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('phone3',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.responsibility}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('responsibility',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.login}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('login',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.password}</label></th>
	<td valign="top">
				<p><?=nl2br($workers->getField('password',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.is_arhiv}</label></th>
	<td valign="top">
	<?=$workers->getField('is_arhiv',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.level}</label></th>
	<td valign="top">
	<?=$workers->getField('level',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{workers.token}</label></th>
	<td valign="top">
	<?=$workers->getField('token',true) ?>	</td>
	</tr>
	</table>