
<h3>#{View GAME} <?=$game->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{game.owner_id}</label></th>
	<td valign="top">
			<?=$game->getField('owner_id')->getView() ?>	
			</td>
	</tr>
		<tr>
	<th valign="top"><label>#{game.creation_date}</label></th>
	<td valign="top">
	<?=$game->getField('creation_date',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{game.name}</label></th>
	<td valign="top">
	<?=$game->getField('name',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{game.charact}</label></th>
	<td valign="top">
	<?=$game->getField('charact',true) ?>	</td>
	</tr>
	</table>