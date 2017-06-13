<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?><form method="post"  action="/?r=forum/save">
<input type="hidden" name="forum[id]" value="<?=((!empty($forum)) ? $forum->getField('id') : '')?>" />
<input type="submit" value="SUBMIT" />
<table>
	<tr>
	<th><label>name</label></th><td>
				<input type="text" name="forum[name]" value="<?=((!empty($forum)) ? $forum->getField('name',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>description</label></th><td>
				<input type="text" name="forum[description]" value="<?=((!empty($forum)) ? $forum->getField('description',true) : '')?>" />
			</td>
	</tr>
		<tr>
	<th><label>forum_id</label></th><td>
				<input type="text" name="forum[forum_id]" value="<?=((!empty($forum)) ? $forum->getField('forum_id',true) : '')?>" />
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
</form>