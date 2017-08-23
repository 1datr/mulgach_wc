
<h3>#{View PREPS} <?=$preps->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{preps.first_name}</label></th>
	<td valign="top">
	<?=$preps->getField('first_name',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{preps.last_name}</label></th>
	<td valign="top">
	<?=$preps->getField('last_name',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{preps.user_id}</label></th>
	<td valign="top">
			<?=$preps->getField('user_id')->getView() ?>	
			</td>
	</tr>
		<tr>
	<th valign="top"><label>#{preps.sostoyanie_dopuska}</label></th>
	<td valign="top">
	<?=$preps->getField('sostoyanie_dopuska',true)?>	</td>
	</tr>
	</table>