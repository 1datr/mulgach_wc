
<nav class="navbar navbar-toggleable-md fixed-top navbar-light" style="background-color: #e3f2fd;z-index:2;">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
   

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">     
      
        <ul class="navbar-nav mr-auto">
        
        <?php 
        
foreach ($menu as $punct)
{
	?>
	<li class="nav-item">
	<a class="nav-link" href="./<?=$punct['url'] ?>"><?=$punct['capt'] ?></a>
	</li>
	<?php 
}
?>        
      </ul>
      
     
        
      </div>
 </nav>   