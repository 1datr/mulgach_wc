<?php

include __DIR__."{basedir}/dbconf.php";
require_once __DIR__.'{basedir}/xlib/utils.php';

include __DIR__."{basedir}/dbconnect.php";

include __DIR__."/enter.php";

include __DIR__."/inc/__capts.php";

function validate($form)
{
	$req_err =array();
	
	{fieldcheck}
	
	return $req_err;
}

function validate_post($descr)
{
	$req_err =validate($_POST[$descr]);
	if(count($req_err)>0)
	{
		echo "<div><h6>Error the edit/add form:</h6>";
		foreach($req_err as $err => $err_msg)
		{
			echo "<div>{$err_msg}</div>";
		}
		echo "</div>";
		die();
	}
}

if(!empty($_POST['{table}']))
{
	// Валиднуть
	if(!empty($_REQUEST['validate']))
	{
		$req_err =validate($_POST['{table}']);
	
		//print_r($req_err, JSON_UNESCAPED_UNICODE);
		echo json_encode(json_fix_cyr($req_err));
		exit();
	}
	
	if(!empty($_POST['{table}']['{fld_primary}']))	// edit crm_worker
	{
		validate_post('{table}');
		
		$sql = make_update_form_sql('{table}', $_POST['{table}'],"{fld_primary}=".$_POST['{table}']['{fld_primary}']);
		//echo $sql;
		mysql_query($sql);
		$_BACK_PAGE = $_SERVER['HTTP_REFERER'];
		if(!empty($_POST['page_from']))
		{
			$_BACK_PAGE = $_POST['page_from'];
		}
		?>
		<script>
			document.location = "<?=$_BACK_PAGE ?>"
		</script>

		<?php 
	}
	else 	// add crm_worker
	{
		validate_post('{table}');
		
		$sql = make_insert_form_sql('{table}',$_POST['{table}']);
		mysql_query($sql);
		
		$_BACK_PAGE = $_SERVER['HTTP_REFERER'];
		if(!empty($_POST['page_from']))
		{
			$_BACK_PAGE = $_POST['page_from'];
		}
		?>
		<script>
			document.location = "<?=$_BACK_PAGE ?>"
		</script>

		<?php 
		
	}
}
else 
{
	if(!empty($_REQUEST['delete_id']))
	{
		$res = mysql_query("DELETE FROM {table} WHERE {fld_primary}=".$_REQUEST['delete_id']);
		?>
		<script>
			document.location = "<?php echo $_SERVER['HTTP_REFERER']; ?>"
		</script>
		<?php 
	}
	elseif(!empty($_REQUEST['id']))
	{		
		
		$res = mysql_query("SELECT * FROM {table} WHERE {fld_primary}=".$_REQUEST['id']);
	
		${table} = mysql_fetch_assoc($res);
		
		$_TITLE={EDIT_TITLE};
				
		$_MODE_EDIT=true;
		$_PAGE = '{edit_page_block}';
		
		include "./inc/basiclayout.php";
	}
}
?>