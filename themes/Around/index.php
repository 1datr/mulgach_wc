
<body>
	<!-- header -->
	<div class="header">
		<div class="top-header">
			<div class="container">
				<div class="top-header-info">
					<div class="top-header-left wow fadeInLeft animated" data-wow-delay=".5s">
						<p>More than 10 new destinations for your trip</p>
					</div>
					<div class="top-header-right wow fadeInRight animated" data-wow-delay=".5s">
						<div class="top-header-right-info">
							<ul>
								<li><a href="login.html">Login</a></li>
								<li><a href="signup.html">Sign up</a></li>
							</ul>
						</div>
						<div class="social-icons">
							<ul>
								<li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a class="twitter facebook" href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a class="twitter google" href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
		</div>
		<div class="bottom-header">
			<div class="container">
				<div class="logo wow fadeInDown animated" data-wow-delay=".5s">
					<h1><a href="index.html"><img src="images/logo.jpg" alt="" /></a></h1>
				</div>
				<div class="top-nav wow fadeInRight animated" data-wow-delay=".5s">
					<nav class="navbar navbar-default">
						<div class="container">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">Menu						
							</button>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a href="index.html" class="active">Home</a></li>
								<li><a href="about.html">About</a></li>
								<li><a href="codes.html">Codes</a></li>
								<li><a href="#" class="dropdown-toggle hvr-bounce-to-bottom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gallery<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a class="hvr-bounce-to-bottom" href="gallery1.html">Gallery1</a></li>
										<li><a class="hvr-bounce-to-bottom" href="gallery2.html">Gallery2</a></li>          
									</ul>
								</li>	
								<li><a href="blog.html">Blog</a></li>
								<li><a href="contact.html">Contact</a></li>
							</ul>	
							<div class="clearfix"> </div>
						</div>	
					</nav>		
				</div>
			</div>
		</div>
	</div>
	<!-- //header -->
	<!-- banner -->
	<div class="banner">
			<div class="slider">
				<h2 class="wow shake animated" data-wow-delay=".5s">Trip</h2>
				<div class="border"></div>
				<script src="js/responsiveslides.min.js"></script>
				<script>
						// You can also use "$(window).load(function() {"
						$(function () {
						// Slideshow 4
							$("#slider3").responsiveSlides({
								auto: true,
								pager: true,
								nav: true,
								speed: 500,
								namespace: "callbacks",
								before: function () {
									$('.events').append("<li>before event fired.</li>");
								},
								after: function () {
									$('.events').append("<li>after event fired.</li>");
								}
							 });				
						});
				</script>
				<div  id="top" class="callbacks_container-wrap">
					<ul class="rslides" id="slider3">
						<li>
							<div class="slider-info">
								<h3 class="wow fadeInRight animated" data-wow-delay=".5s">Lorem ipsum dolor sit amet</h3>
								<p class="wow fadeInLeft animated" data-wow-delay=".5s">Curabitur eget metus eget erat vehicula semper vitae sed leo</p>
								<div class="more-button wow fadeInRight animated" data-wow-delay=".5s">
									<a href="single.html">Click Here	</a>
								</div>
							</div>
						</li>
						<li>
							<div class="slider-info">
								<h3>Consectetur adipiscing elit</h3>
								<p>Quisque nisl risus, egestas in convallis vitae, fringilla cursus magna</p>
								<div class="more-button">
									<a href="single.html">Read More	</a>
								</div>
							</div>
						</li>
						<li>
							<div class="slider-info">
								<h3>Proin eget consequat ante	</h3>
								<p> Suspendisse bibendum dictum metus, at finibus elit dignissim nec	</p>
								<div class="more-button">
									<a href="single.html">Click Here	</a>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
	</div>
	<!-- //banner -->
	<!-- banner-bottom -->
	<div class="banner-bottom">
		<div class="container">
			<div class="banner-bottom-grids">
				<div class="col-md-6 banner-bottom-left wow fadeInLeft animated" data-wow-delay=".5s">
					<div class="left-border">
						<div class="left-border-info">
							<p>Duis dapibus lacinia libero at aliquam</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 banner-bottom-left banner-bottom-right wow fadeInRight animated" data-wow-delay=".5s">
					<div class="left-border">
						<div class="left-border-info right-border-info">
							<p>Duis dapibus lacinia libero at aliquam</p>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //banner-bottom -->
	<!-- information -->
	<div class="information">
		<div class="container">
			<div class="information-heading">
				<h3 class="wow fadeInDown animated" data-wow-delay=".5s">Why Book With Us</h3>
				<p class="wow fadeInUp animated" data-wow-delay=".5s">Vivamus efficitur scelerisque nulla nec lobortis. Nullam ornare metus vel dolor feugiat maximus.Aenean nec nunc et metus volutpat dapibus ac vitae ipsum. Pellentesque sed rhoncus nibh</p>
			</div>
			
			<div class="information-grids">
				<div class="col-md-4 information-grid wow fadeInLeft animated" data-wow-delay=".5s">
					<div class="information-info">
						<div class="information-grid-img">
							<img src="images/8.jpg" alt="" />
						</div>
						<div class="information-grid-info">
							<h4>Sollicitudin sit amet </h4>
							<p>Duis dapibus lacinia libero at aliquam. Sed pulvinar, magna vitae consectetur ultricies, augue massa condimentum eros non luctus ipsum lacus interdum odio.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 information-grid wow fadeInUp animated" data-wow-delay=".5s">
					<div class="information-info">
						<div class="information-grid-info">
							<h4>Consectetur ultricies</h4>
							<p>Duis dapibus lacinia libero at aliquam. Sed pulvinar, magna vitae consectetur ultricies, augue massa condimentum eros non luctus ipsum lacus interdum odio.</p>
						</div>
						<div class="information-grid-img">
							<img src="images/3.jpg" alt="" />
						</div>
					</div>
				</div>
				<div class="col-md-4 information-grid wow fadeInRight animated" data-wow-delay=".5s">
					<div class="information-info">
						<div class="information-grid-img">
							<img src="images/7.jpg" alt="" />
						</div>
						<div class="information-grid-info">
							<h4>Nullam ornare metus</h4>
							<p>Duis dapibus lacinia libero at aliquam. Sed pulvinar, magna vitae consectetur ultricies, augue massa condimentum eros non luctus ipsum lacus interdum odio.</p>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //information -->
	
	<!-- popular -->
	<div class="popular">
		<div class="container">
			<div class="popular-heading information-heading">
				<h3 class="wow fadeInDown animated" data-wow-delay=".5s">Popular Places</h3>
				<p class="wow fadeInUp animated" data-wow-delay=".5s">Vivamus efficitur scelerisque nulla nec lobortis. Nullam ornare metus vel dolor feugiat maximus.Aenean nec nunc et metus volutpat dapibus ac vitae ipsum. Pellentesque sed rhoncus nibh</p>
			</div>
			<div class="popular-slide">
				<script>
						// You can also use "$(window).load(function() {"
						$(function () {
						// Slideshow 4
							$("#slider1").responsiveSlides({
								auto: true,
								pager: true,
								nav: false,
								speed: 500,
								namespace: "callbacks",
								before: function () {
									$('.events').append("<li>before event fired.</li>");
								},
								after: function () {
									$('.events').append("<li>after event fired.</li>");
								}
							 });				
						});
				</script>
				<div  id="top" class="callbacks_container-wrap">
					<ul class="rslides" id="slider1">
						<li>
							<div class="popular-slide-info wow bounceIn animated" data-wow-delay=".5s">
								<h4>Australia</h4>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas volutpat lacus at enim aliquet, quis iaculis nisi bibendum. Nullam cursus arcu lobortis, pharetra augue et, dignissim nunc. Morbi vestibulum tempus orci at faucibus. Sed ultricies dignissim magna tristique interdum</p>
							</div>
						</li>
						<li>
							<div class="popular-slide-info popular-slide1">
								<h4>Philippines</h4>
								<p>Habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas volutpat lacus at enim aliquet, quis iaculis nisi bibendum. Nullam cursus arcu lobortis, pharetra augue et, dignissim nunc. Morbi vestibulum tempus orci at faucibus. Sed ultricies dignissim magna tristique interdum Pellentesque</p>
							</div>
						</li>
						<li>
							<div class="popular-slide-info popular-slide2">
								<h4>Maldives</h4>
								<p>Tristique senectus pellentesque habitant morbi et netus et malesuada fames ac turpis egestas. Maecenas volutpat lacus at enim aliquet, quis iaculis nisi bibendum. Nullam cursus arcu lobortis, pharetra augue et, dignissim nunc. Morbi vestibulum tempus orci at faucibus. dignissim magna tristique interdum Sed ultricies</p>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="popular-grids">
				<div class="col-md-4 popular-grid wow fadeInLeft animated" data-wow-delay=".5s">
					<h5>Nullam convallis sagittis</h5>
					<p>Donec malesuada ultricies metus ac vehicula. Nullam convallis sagittis tellus ut dictum. Proin risus lacus, sollicitudin sit amet ante ac, dapibus convallis ipsum.</p>
				</div>
				<div class="col-md-4 popular-grid wow fadeInUp animated" data-wow-delay=".5s">
					<h5>Proin risus lacus</h5>
					<p>Donec malesuada ultricies metus ac vehicula. Nullam convallis sagittis tellus ut dictum. Proin risus lacus, sollicitudin sit amet ante ac, dapibus convallis ipsum.</p>
				</div>
				<div class="col-md-4 popular-grid wow fadeInRight animated" data-wow-delay=".5s">
					<h5>Sollicitudin sit amet ante</h5>
					<p>Donec malesuada ultricies metus ac vehicula. Nullam convallis sagittis tellus ut dictum. Proin risus lacus, sollicitudin sit amet ante ac, dapibus convallis ipsum.</p>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //popular -->
	
	<!-- footer -->
	<div class="footer">
		<div class="container">
			<div class="footer-grids">
				<div class="col-md-3 footer-nav wow fadeInLeft animated" data-wow-delay=".5s">
					<h4>Navigation</h4>
					<ul>
						<li><a href="about.html">About</a></li>
						<li><a href="gallery1.html">Gallery</a></li>
						<li><a href="blog.html">Blog</a></li>
						<li><a href="contact.html">Contact</a></li>
					</ul>
				</div>
				<div class="col-md-5 footer-nav wow fadeInUp animated" data-wow-delay=".5s">
					<h4>Newsletter</h4>
					<p>Nunc non feugiat quam, vitae placerat ipsum. Cras at felis congue, volutpat neque eget</p>
					<form>
						<input type="email" id="mc4wp_email" name="EMAIL" placeholder="Enter your email here" required="">
						<input type="submit" value="Subscribe">
					</form>
				</div>
				<div class="col-md-4 footer-nav wow fadeInRight animated" data-wow-delay=".5s">
					<h4>Latest News</h4>
					<div class="news-grids">
						<div class="news-grid">
							<h6>09/01/2016 : <a href="single.html">Cras at felis congue</a></h6>
							<h6>13/07/2016 : <a href="single.html">Volutpat neque eget</a></h6>
							<h6>13/02/2016 : <a href="single.html">Agittis tellus ut dictum</a></h6>
							<h6>28/11/2016 : <a href="single.html">Habitant morbi et netus</a></h6>
							<h6>19/01/2016 : <a href="single.html">pellentesque habitant morbi</a></h6>
							<h6>23/02/2016 : <a href="single.html">Maecenas volutpat lacus</a></h6>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="copyright wow fadeInUp animated" data-wow-delay=".5s">
				<p>© 2016 Around . All Rights Reserved . Design by <a href="http://w3layouts.com/">W3layouts</a></p>
			</div>
		</div>
	</div>
	<!-- //footer -->
</body>	