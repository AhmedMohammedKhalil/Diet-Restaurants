<?php

	$pageTitle = 'Home';
	include 'init.php';
?>
<section class="header">
	<div class="logo">
		<hr class="line-1">
		<a href="#">Diet Restaurants</a>
		<span>Best Website For Choose Best Meal, Enjoy.</span>
		<hr class="line-1">
	</div>
</section>
<!-- content meals -->
<section id="container">
			<div class="wrap-container clearfix">
				<div id="main-content">
					<div class="wrap-content zerogrid ">
						<article class="background-gray">
							<div class="art-header">
								<hr class="line-2">
								<h2>Our Meals</h2>
							</div>
							<div class="art-content">
								<div class="row">
									<div class="col-1-3">
										<div class="wrap-col">
											<div class="item-container">
												<a class="example-image-link" href="<?php echo $imgs?>menu-1.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
													<div class="item-caption">
														<div class="item-caption-inner">
															<div class="item-caption-inner1">
																<h3>$45</h3>
																<span>Only</span>
															</div>
														</div>
													</div>
													<img class="example-image" src="<?php echo $imgs?>menu-1.jpg" alt=""/>
												</a>
											</div>
										</div>
									</div>
									<div class="col-1-3">
										<div class="wrap-col">
										<div class="item-container">
												<a class="example-image-link" href="<?php echo $imgs?>menu-1.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
													<div class="item-caption">
														<div class="item-caption-inner">
															<div class="item-caption-inner1">
																<h3>$45</h3>
																<span>Only</span>
															</div>
														</div>
													</div>
													<img class="example-image" src="<?php echo $imgs?>menu-1.jpg" alt=""/>
												</a>
											</div>
											
										</div>
									</div>
									<div class="col-1-3">
										<div class="wrap-col">
										<div class="item-container">
												<a class="example-image-link" href="<?php echo $imgs?>menu-1.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
													<div class="item-caption">
														<div class="item-caption-inner">
															<div class="item-caption-inner1">
																<h3>$45</h3>
																<span>Only</span>
															</div>
														</div>
													</div>
													<img class="example-image" src="<?php echo $imgs?>menu-1.jpg" alt=""/>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</article>
						<article class="background-gray">
							<div class="art-header">
								<hr class="line-2">
								<h2>Monthly Packages Meals</h2>
							</div>
							<div class="art-content">
								<div class="row">
									<div class="col-1-3">
										<div class="wrap-col post">
											<img src="<?php echo $imgs?>menu-13.jpg" alt=""/>
											<h3>Small Meals</h3>
											<p>Details</p>
											<h3 style="margin-bottom: 20px;">$150</h3>
											<a class="button" href="#">See All</a>
										</div>
									</div>
									<div class="col-1-3">
										<div class="wrap-col post">
											<img src="<?php echo $imgs?>menu-13.jpg" alt=""/>
											<h3>Small Meals</h3>
											<p>Details</p>
											<h3 style="margin-bottom: 20px;">$150</h3>
											<a class="button" href="#">See All</a>
										</div>
										
									</div>
									<div class="col-1-3">
										<div class="wrap-col post">
											<img src="<?php echo $imgs?>menu-13.jpg" alt=""/>
											<h3>Small Meals</h3>
											<p>Details</p>
											<h3 style="margin-bottom: 20px;">$150</h3>
											<a class="button" href="#">See All</a>
										</div>
										
									</div>
								</div>
							</div>
						</article>
					</div>
				</div>
			</div>
		</section>
<?php
	include $tpl . 'footer.php'; 
?>