<table>
  <tr>
    <th>#{LangKey}</th>
    <th>#{LangVal}</th>
  </tr>
<?php
foreach ($results as $key => $val) {
?>
  <tr>
    <td><?=$key?></td>
    <td><?=$val?></td>
  </tr>
<?php 	
}
?>
</table>