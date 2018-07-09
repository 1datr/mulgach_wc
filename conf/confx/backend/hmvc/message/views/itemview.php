
<h3>#{View MESSAGE} <?=$message->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{message.from}</label></th>
	<td valign="top">
			<?=$message->getField('from')->getView() ?>	
			</td>
	</tr>
		<tr>
	<th valign="top"><label>#{message.to}</label></th>
	<td valign="top">
			<?=$message->getField('to')->getView() ?>	
			</td>
	</tr>
		<tr>
	<th valign="top"><label>#{message.when}</label></th>
	<td valign="top">
	<?=$message->getField('when',true) ?>	</td>
	</tr>
	</table>