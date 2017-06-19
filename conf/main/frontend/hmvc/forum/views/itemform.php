<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<?php
$form = new mulForm("/?r=forum/save");
?>
<input type="hidden" name="forum[id]" value="<?=((!empty($forum)) ? $forum->getField('id') : '')?>" />
<input type="submit" value="SUBMIT" />
<table>
	<tr>
	<th><label>#{forum.name}</label></th><td>
				<input type="text" name="forum[name]" value="<?=((!empty($forum)) ? $forum->getField('name',true) : '')?>" />
			<div class="error" id='err_name' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{forum.description}</label></th><td>
				<input type="text" name="forum[description]" value="<?=((!empty($forum)) ? $forum->getField('description',true) : '')?>" />
			<div class="error" id='err_description' role="alert"></div>
			</td>
	</tr>
		<tr>
	<th><label>#{forum.forum_id}</label></th><td>
			<?php 
					$params = array('ds'=> $this->get_controller('forum')->_MODEL->find() ,'name'=>'forum[forum_id]');			
				if(!empty($forum))
		{
			$params['value']=$forum->getField('forum_id',true);
		}
		$this->usewidget(new ComboboxWidget(),$params);
		?>
		<div class="error" id='err_forum_id' role="alert"></div>
			</td>
	</tr>
	</table>
<input type="hidden" name="back_url" value="<?=$_SERVER['HTTP_REFERER']; ?>" />
</form>