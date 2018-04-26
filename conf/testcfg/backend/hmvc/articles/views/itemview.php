
<h3>#{View ARTICLES} <?=$articles->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{articles.name}</label></th>
	<td valign="top">
	<?=$articles->getField('name',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{articles.text}</label></th>
	<td valign="top">
				<p><?=nl2br($articles->getField('text',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{articles.author}</label></th>
	<td valign="top">
	<?=$articles->getField('author',true) ?>	</td>
	</tr>
	</table>