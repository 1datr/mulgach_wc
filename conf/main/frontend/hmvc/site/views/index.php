<h1>опебед ледбедец</h1>
<p><?=$i?>
<span class="class_b">122</span>
</p>
<?php 
//print_r($this);
$otdel = $this->query('otdel', 'index');
$this->draw_controller_request($otdel);
?>