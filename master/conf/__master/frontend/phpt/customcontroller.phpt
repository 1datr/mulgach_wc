<#php 
class <?=UcaseFirst($triada)?>Controller extends BaseController
{

<?php
foreach($actions as $idx => $action)
{
?>
	public function Action<?=UcaseFirst($action['name'])?>()
	{
		<?php 
		if(isset($action['automakeview']))
		{
			?>
			$this->out_view('<?=$action['name']?>',array());
			<?php
		}
		?>
	}
<?
}
?>
	
	
}
#>