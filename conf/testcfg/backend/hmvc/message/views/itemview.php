
<h3>#{View MESSAGE} <?=$message->getView()?></h3>
<table>

	<tr>
	<th valign="top"><label>#{message.topic}</label></th>
	<td valign="top">
	<?=$message->getField('topic',true) ?>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{message.message}</label></th>
	<td valign="top">
				<p><?=nl2br($message->getField('message',true)) ?></p>	</td>
	</tr>
		<tr>
	<th valign="top"><label>#{message.user_from}</label></th>
	<td valign="top">
			<?=$message->getField('user_from')->getView() ?>	
			</td>
	</tr>
		<tr>
	<th valign="top"><label>#{message.user_to}</label></th>
	<td valign="top">
			<?=$message->getField('user_to')->getView() ?>	
			</td>
	</tr>
		<tr>
	<th valign="top"><label>#{message.picture}</label></th>
	<td valign="top">
	<?=$message->getField('picture',true) ?>	</td>
	</tr>
	</table>