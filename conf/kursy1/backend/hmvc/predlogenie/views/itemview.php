
<h3>#{View PREDLOGENIE} <?=$predlogenie->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{predlogenie.ru}</label></th>
	<td valign="top">
	<?=$predlogenie->getField('ru',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{predlogenie.zvuk_ru}</label></th>
	<td valign="top">
	<?=$predlogenie->getField('zvuk_ru',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{predlogenie.en}</label></th>
	<td valign="top">
	<?=$predlogenie->getField('en',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{predlogenie.zvuk_en}</label></th>
	<td valign="top">
	<?=$predlogenie->getField('zvuk_en',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{predlogenie.transcription}</label></th>
	<td valign="top">
	<?=$predlogenie->getField('transcription',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{predlogenie.sound}</label></th>
	<td valign="top">
	<?=$predlogenie->getField('sound',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{predlogenie.type}</label></th>
	<td valign="top">
	<?=$predlogenie->getField('type',true) ?>	</td>
	</tr>
	</table>