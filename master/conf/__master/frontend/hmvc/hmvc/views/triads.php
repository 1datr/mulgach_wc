<h3>#{TRIADS LIST}</h3>
<div class="container">
<ul class="nav nav-tabs">
<?php 
$tkeys = array_keys($triads);
//mul_dbg($tkeys);
foreach ($tkeys as $idx => $triada)
{
?>
  <li class="nav-item"><a data-toggle="tab" role="tab" class="nav-link <?=(($idx==0)?'active':'')?>" href="#hmvcs_<?=$triada?>"><?=$triada?></a></li> 
<?php 
}
?>
</ul>
<?php 
$this->inline_css('
.tab-page {
	padding: 10px;
	border-left: 1px solid #ddd;
	border-bottom: 1px solid #ddd;
	border-right: 1px solid #ddd;
	border-bottom-right-radius: 10px;
	border-bottom-left-radius: 10px;
	height: 100px;
}	

.columns-page{
	column-break-before:always;

  	-webkit-column-width:15em;
  	-moz-column-width:15em;
	height: 95px;		
}	

.pseudo_td1 {
	width:80px;
	display:inline-block;
	margin-right:20px;
}

.pseudo_td2 {
	width:50px;
	display:inline-block;
	margin-right:20px;
}
.pseudotable{
	list-style-type: none;
}
');
?>
<div class="tab-content">
<?php 
$idx=0;
foreach ($triads as $ep => $triadlist)
{
	?>
	<div id="hmvcs_<?=$ep?>" class="tab-pane <?=(($idx==0)?'active':'')?> tab-page" role="tabpanel">
		<div style="owerflow: auto;height:100px;">
			<div class="columns-page">
				<ul class="pseudotable">
				<?php 
				//mul_dbg($_config);
			 	foreach($triadlist as $idx => $triada){
			 		?>
			 		<li><span class="pseudo_td1"><?=$triada?></span>
			 		<span class="pseudo_td2"><a class="ref_delete" conf_message="#{Delete this triada?}" href="<?=as_url('hmvc/delete/'.$_config->_NAME.'/'.$ep.'/'.$triada)?>">x</a></span></li>
			 		<?php 
			 	}
			 	?>
			 	</ul>
			</div>
	 	</div>
 	</div>
	<?php 
	$idx++;
}
?>
</div>
</div>