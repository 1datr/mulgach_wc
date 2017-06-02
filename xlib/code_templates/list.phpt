<?php

	$_FILTER = 1;
	$_ORDER="";
	
	{ORDER_CODE}
	{FILTER_CODE}
	
	$URL_P = new url_parser();
	
	$res_count = mysql_query("{count_query}");
	$count_row = mysql_fetch_assoc($res_count);
	$_PER_PAGE=20;
	$_PAGE_COUNT = ceil($count_row['COUNT']/$_PER_PAGE);

	$limit_base = (!empty($_REQUEST['page']) ? ($_REQUEST['page']-1)*$_PER_PAGE : 0 ); 
	
	$res = mysql_query("{query} $_ORDER LIMIT $limit_base, $_PER_PAGE ");
	if(mysql_num_rows($res)>0)
	{
	?>
		<table>
		<thead><tr>{head}</tr></thead>
		<thead><tr>{filters}</tr></thead>
		<?php
		while ($row = mysql_fetch_assoc($res))
		{
		
			{rowcode}
		}
		?>		
		</table>
		<?php
	}
	else
	{
		echo "<h2>No record found</h2>";
	}

	
	echo "<div>";
	if($_PAGE_COUNT>1)
	{
		for($page=1;$page <= $_PAGE_COUNT;$page++)
		{
			if(($page==$_REQUEST['page'])||(($page==1)&&(empty($_REQUEST['page']))))
				echo "<span>$page</span>";
			else
				{					
					echo "<a href=\"".$URL_P->make_changed_url(array('page'=>$page))."\">$page</a>";
				}
		}
	}
	echo "</div>";
?>