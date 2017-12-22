
<h3>#{View LIFEAREA} <?=$lifearea->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{lifearea.title_ru}</label></th>
	<td valign="top">
	<?=$lifearea->getField('title_ru',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{lifearea.title_eng}</label></th>
	<td valign="top">
	<?=$lifearea->getField('title_eng',true) ?>	</td>
	</tr>
	</table>