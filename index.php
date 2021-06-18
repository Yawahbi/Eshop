<?php
	ob_start();
	session_start();
	$pageTitle="Home";
	include 'init.php';

	?>
	<!-- Start menu Home -->

	<section class="menu-home">
		<div class="container">
			<div class="row mb-3">
				<div class="col-12 ad-carousel p-0 h-100 mb-3">
					<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
					  <ol class="carousel-indicators">
					    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
					    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
					  </ol>
					  <div class="carousel-inner">
					    <div class="carousel-item active">
					      <img class="d-block w-100" src="<?php echo $image; ?>1b.png" alt="Third slide">
					      <div class="carousel-caption d-none d-md-block">

						  </div>
					    </div>
					     <div class="carousel-item">
					      <img class="d-block w-100" src="<?php echo $image; ?>2b.png" alt="Third slide">
					      <div class="carousel-caption d-none d-md-block">
						  </div>
					    </div>
					     <div class="carousel-item">
					      <img class="d-block w-100" src="<?php echo $image; ?>3b.jpg" alt="Third slide">
					      <div class="carousel-caption d-none d-md-block">
						  </div>
					    </div>
					     <div class="carousel-item">
					      <img class="d-block w-100" src="<?php echo $image; ?>4b.jpg" alt="Third slide">
					      <div class="carousel-caption d-none d-md-block">
						  </div>
					    </div>
					    <div class="carousel-item">
					      <img class="d-block w-100" src="<?php echo $image; ?>5b.jpg" alt="Third slide">
					      <div class="carousel-caption d-none d-md-block">
						  </div>
					    </div>
					  </div>
					  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
					    <span class="sr-only">Previous</span>
					  </a>
					  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					    <span class="carousel-control-next-icon" aria-hidden="true"></span>
					    <span class="sr-only">Next</span>
					  </a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- End menu Home -->
	<section id="product-slider">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2 >Tous les <b> Produits </b></h2>
					<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
					<div class="carousel-inner">
						<div class="item carousel-item active">
							<div class="row">
								<?php
									$stmt =$con->prepare('SELECT * FROM products');

									$stmt->execute();

									$rows=$stmt->fetchAll();

									$i=0;
									foreach ($rows as $row) {
									?>
								<div class="col-sm-6 col-md-4 col-lg-3">
									<div class="thumb-wrapper">
										<div class="img-box">
											<img src="<?php echo $images; echo $row['product_image']; ?>" class="img-responsive img-fluid" alt="<?php echo $row['product_title'] ?>">
										</div>
										<div class="thumb-content">
											<h4><?php echo $row['product_title'] ?></h4>
											<p class="item-price">
												<?php

														if($row['old_price'] != 0){
															echo "<strike>".$row['old_price']."</strike>";
														}

												?>

												<span><?php echo $row['product_price'] ?></span></p>
											<p class="item-description">
												<?php echo $row['short_desc'] ?>
											</p>
											<div class="star-rating">
												<ul class="list-inline">
													<?php
													$goodRating = $row['Rating'];
														while($goodRating > 0):

														?>
														<li class="list-inline-item">
															<i class="fa fa-star" style="color: #FF9529;"></i>
														</li>
													<?php

														$goodRating = $goodRating - 1;
														endwhile;

													?>
													<?php
													$badRating = 5 - $row['Rating'];
														while($badRating > 0):
													?>
														<li class="list-inline-item">
															<i class="fa fa-star" style="color: #cdc9c9;"></i>
														</li>
													<?php

														$badRating = $badRating - 1;
														endwhile;

													?>
												</ul>
											</div>
											<a href="product.php?do=Add&productid=<?php echo $row['product_id']; ?>" class="btn btn-primary">Montrer</a>
										</div>
									</div>
								</div>
								<?php
									}// La fin de notre boucle foreach !!
								?>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</section>
	<?php

	include 'includes/templates/footer.php';
	ob_end_flush();
?>
