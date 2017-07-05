
<h3>#{View SLOVO} <?=$slovo->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{slovo.ru}</label></th>
	<td valign="top">
	<?=$slovo->getField('ru',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{slovo.zvuk_ru}</label></th>
	<td valign="top">
	<?=$slovo->getField('zvuk_ru',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{slovo.en}</label></th>
	<td valign="top">
	<?=$slovo->getField('en',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{slovo.risunok}</label></th>
	<td valign="top">
	<?=$slovo->getField('risunok',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{slovo.zvuk_en}</label></th>
	<td valign="top">
	<?=$slovo->getField('zvuk_en',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{slovo.transcription}</label></th>
	<td valign="top">
	<?=$slovo->getField('transcription',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{slovo.type}</label></th>
	<td valign="top">
	<?=$slovo->getField('type',true) ?>	</td>
	</tr>
	</table>