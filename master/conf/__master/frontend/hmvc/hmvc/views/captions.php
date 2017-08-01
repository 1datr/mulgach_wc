<?php 
use BootstrapCombobox\ComboboxWidget as ComboboxWidget;
?>
<h3>#{CAPTIONS}</h3>
<?php 
$table = $_SESSION['makeinfo']['table'];

$eps = $_SESSION['makeinfo']['ep'];
unset($eps['rest']);
$eps = array_keys($eps);
?>
<ul class="nav nav-tabs" role="tablist">
<?php 
foreach ($eps as $idx => $_ep)
{
	?>
	<li class="nav-item">
	<a class="nav-link <?=(($idx==0)?'active':'')?>" data-toggle="tab" href="#capts_<?=$_ep?>" role="tab"><?=$_ep?></a>
	</li>		
	<?php	
}
?>
</ul>
<div class="tab-content">
<?php 
//print_r($_SESSION);
foreach ($eps as $idx => $_ep)
{
	?>
	<div class="tab-pane <?=(($idx==0)?'active':'')?> tab-page" id="capts_<?=$_ep?>" role="tabpanel">
	<table>
  	<tr>
    	<th>#{FieldName}</th>
    	<th>#{FieldCaption}</th>
  	</tr>
	<?php 
	foreach ($fields as $fld => $fldinfo)
	{
		?>
		<tr>
		<th><?=$fld?></th>
		<?php 
		$thelang=new Lang(NULL, $_SESSION['makeinfo']['conf'],$_ep);
		$lang_val = $thelang->getkey($table.'.'.$fld);
		?>
		<td><input type="text" name="captions[<?=$_ep?>][<?=$table?>.<?=$fld?>]" value="<?=($lang_val!=NULL) ? $lang_val: $fld?>" /></td>
		</tr>
		<?php 
	}
	?>
	</table>
	</div>
	<?php 
}
?>
<h3>#{MAIN MENU AND AUTH}</h3>

<?php 
$eps=array('frontend','backend');
?>
<ul class="nav nav-tabs" role="tablist">
<?php 
	foreach ($eps as $idx => $_ep)
	{
	?>
	<li class="nav-item">
		<a class="nav-link <?=(($idx==0)?'active':'')?>" data-toggle="tab" href="#mainmenu_<?=$_ep?>" role="tab"><?=$_ep?></a>
	</li>		
	<?php
	}
?>		
</ul>
<div class="tab-content">
<?php 

	foreach ($eps as $idx => $_ep)
	{
	?>
	<div class="tab-pane <?=(($idx==0)?'active':'')?> tab-page" id="mainmenu_<?=$_ep?>" role="tabpanel">
	<label for="cb_usercon_<?=$_ep?>">#{Users and auth controller}</label>
	<input type="checkbox" name="authcon[<?=$_ep?>][enable]" onclick="toggle_ep_divs('<?=$_ep?>');" /><br/>
		<div id="authcon_settings_<?=$_ep?>" style="display: none; padding-left:20px;">
			<label for="authcon_login_<?=$_ep?>">#{Login field}</label>
			<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,'name'=>'authcon['.$_ep.'][login]','value'=>$fld_login_,'htmlattrs'=>array('class'=>'fld_select','id'=>'authcon_login_'.$_ep,))); ?><br />
			
			<label for="authcon_passw_<?=$_ep?>">#{Password field}</label>
			<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,'name'=>'authcon['.$_ep.'][passw]','value'=>$fld_passw_,'htmlattrs'=>array('class'=>'fld_select','id'=>'authcon_passw_'.$_ep,))); ?><br />
			
			<label for="authcon_hash_<?=$_ep?>">#{Hash field}</label>
			<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,'name'=>'authcon['.$_ep.'][hash]','value'=>$fld_hash_,'htmlattrs'=>array('class'=>'fld_select','id'=>'authcon_hash_'.$_ep,))); ?><br />
			
			<label for="authcon_email_<?=$_ep?>">#{e-mail}</label>
			<?php $this->usewidget(new ComboboxWidget(),array('data'=>$fields,'name'=>'authcon['.$_ep.'][email]','value'=>$fld_email_,'htmlattrs'=>array('class'=>'fld_select','id'=>'authcon_email_'.$_ep,))); ?><br />
			
		
		</div>
	
	<div id="con_for_auth_div_<?=$_ep?>">
	<label for="cb_con_auth_<?=$_ep?>">#{Controller using for authorize:}</label>
	<?php $this->usewidget(new ComboboxWidget(),array('data'=>$triads[$_ep],
							'name'=>"con_auth[".$_ep."]",											
							'htmlattrs'=>array('id'=>'cb_con_auth_'.$_ep),
							'value'=>(isset($_SESSION['authhost'][$_ep]) ? $_SESSION['authhost'][$_ep] : ''),
							)							
						); ?>
	</div>
	
	<label for="cb_menu_<?=$_ep?>">#{Generate main menu}</label>
	<input id="cb_menu_<?=$_ep?>" type="checkbox" name="mainmenu[<?=$_ep?>]" onchange="$('#connect_from_<?=$_ep?>').toggle();" />
	
	<?php 
	//print_r($_SESSION);
	?>
	
		<div id="connect_from_<?=$_ep?>">
		<label for="menu_connect_from_<?=$_ep?>">#{Connect menu from :}</label>
		<?php $this->usewidget(new ComboboxWidget(),array('data'=>$triads[$_ep],
						'name'=>"connect_from[".$_ep."]",					
						//'value'=>$con['model'],
						'value'=>(isset($_SESSION['connect_from'][$_ep]) ? $_SESSION['connect_from'][$_ep] : ''),
						'htmlattrs'=>array())
						); ?>
		</div>
	</div>
	<?php
	}
?>	
</div>

</div>
