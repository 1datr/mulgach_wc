
<h3>#{View UROK} <?=$urok->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{urok.id_razdel}</label></th>
	<td valign="top">
	<?=$urok->getField('id_razdel',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{urok.number}</label></th>
	<td valign="top">
	<?=$urok->getField('number',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{urok.name}</label></th>
	<td valign="top">
	<?=$urok->getField('name',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{urok.video1}</label></th>
	<td valign="top">
	<?=$urok->getField('video1',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{urok.video2}</label></th>
	<td valign="top">
	<?=$urok->getField('video2',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{urok.video3}</label></th>
	<td valign="top">
	<?=$urok->getField('video3',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{urok.document1}</label></th>
	<td valign="top">
	<?=$urok->getField('document1',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{urok.document2}</label></th>
	<td valign="top">
	<?=$urok->getField('document2',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{urok.hometask}</label></th>
	<td valign="top">
	<?=$urok->getField('hometask',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{urok.presentation}</label></th>
	<td valign="top">
	<?=$urok->getField('presentation',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{urok.text_block}</label></th>
	<td valign="top">
	<?=$urok->getField('text_block',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{urok.theme}</label></th>
	<td valign="top">
	<?=$urok->getField('theme',true) ?>	</td>
	</tr>
	</table>