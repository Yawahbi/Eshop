<?php
	ob_start();
	session_start();
	$pageTitle="Home";
	include 'init.php';

	?>
	<!-- Start menu Home -->

	<section class="menu-home">
		<div class="container">
				<div class="col-12 ad-carousel p-0 h-100 mb-3">
					      <img  src="<?php echo $banner; ?>banner.png" >
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
											<a href="product.php?productid=<?php echo $row['product_id']; ?>" class="btn btn-primary">Montrer</a>
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
