
<h3>#{View ANT} <?=$ant->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{ant.race}</label></th>
	<td valign="top">
			<?=$ant->getField('race')->getView() ?>	
			</td>
	</tr>
		<tr>
	<th valign="top"><label>#{ant.number}</label></th>
	<td valign="top">
	<?=$ant->getField('number',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{ant.owner_id}</label></th>
	<td valign="top">
			<?=$ant->getField('owner_id')->getView() ?>	
			</td>
	</tr>
		<tr>
	<th valign="top"><label>#{ant.game_id}</label></th>
	<td valign="top">
			<?=$ant->getField('game_id')->getView() ?>	
			</td>
	</tr>
	</table>