<nav class="navbar navbar-toggleable-xl navbar-inverse bg-primary">
<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#nav-content" aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>

<!-- Brand -->
<a class="navbar-brand" href="#">Logo</a>

<!-- Links -->
<div class="collapse navbar-collapse" id="nav-content">   
<ul class="navbar-nav">
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
</nav>




  