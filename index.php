<?php
	ob_start();
	session_start();
	$pageTitle="Home";
	include 'init.php';

	$do='';

	$do=isset($_GET['do']) ? $_GET['do'] : '';
	if($do == '') {
		// La page home de notre produits !!
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
											<a href="products.php?do=Add&productid=<?php echo $row['product_id']; ?>" class="btn btn-primary">Montrer</a>
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
	}else if($do=='AddHotDeal'){
		$productid=0;
		if(isset($_GET['productid']) && is_numeric($_GET['productid'])){
			$productid=$_GET['productid'];
		}else{
			$productid=0;
		}
  		$stmt=$con->prepare('SELECT * FROM products WHERE product_id = ?');
  		$stmt->execute(array($productid));
  		$row=$stmt->fetch();
  		$count=$stmt->rowCount();

  		if($count > 0){ // si il est superieur a 0 donc il existe !!

  			$categorie_id=$row['product_category_id'];

			$stmat2=$con->prepare('SELECT * FROM categories WHERE cat_id = ?');

			$stmat2->execute(array($categorie_id));

			$categorie=$stmat2->fetch();

		?>
		<div id="product-slider">
	    		<h2 >Ajouter au <b> Panier </b></h2>
	    </div>
		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- Product main img -->
					<div class="col-md-4">
						<div id="product-main-img">
							<div class="product-preview">
								<img src="<?php echo $images; echo $row['product_image']?>" alt="product <?php echo $row['product_id']; ?>">
							</div>
						</div>
					</div>
					<!-- /Product main img -->

					<!-- Product details -->
					<div class="col-md-7 ">
						<div class="product-details pl-4">
							<h2 class="product-name"><?php echo $row['product_title']; ?></h2>
							<div>
								<div class="product-rating">
									<?php
									$goodRating = $row['Rating'];
										while($goodRating > 0):

										?>
										<i class="fa fa-star" style="color: #FF9529;"></i>
									<?php

										$goodRating = $goodRating - 1;
										endwhile;

									?>
									<?php
									$badRating = 5 - $row['Rating'];
										while($badRating > 0):
									?>
										<i class="fa fa-star" style="color: #cdc9c9;"></i>
									<?php

										$badRating = $badRating - 1;
										endwhile;

									?>
								</div>
							</div>
							<div>
								<?php

									$price = $row['product_price'] * 0.5;

								?>
								<h3 class="product-price"><?php echo $price." Dhs"; ?>  <del class="product-old-price"><?php echo $row['product_price']." Dhs"; ?></del></h3>
								<?php

								if($row['product_quantity'] < 1){

									echo '<span class="product-available">In Stock</span>';

								}

								?>
							</div>
							<p class="pl-2"><?php echo $row['product_description']; ?></p>

							<!-- Start Add to cart -->
							<form action="checkout.php" method="post">
								<div class="add-to-cart pl-2">
									<div class="qty-label mb-2">
										Quantité
										<div class="input-number">
											<input type="number" id="quantite" name="quantite" min="1" max="100" value="1">
											<span class="qty-up">+</span>
											<span class="qty-down">-</span>
										</div>
									</div>
									<input type="hidden" name="product_title" value="<?php echo $row['product_title']; ?>">
									<input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
									<input type="hidden" name="hot_deal" value="yes">
									<button type="submit" class="add-to-cart-btn"><i class='fa fa-shopping-cart'></i> Ajouter au <b> Panier </b></button>
								</div>
							</form>

							<!-- End Add to cart -->

							<ul class="product-links pl-2">
								<li>Catégorie:</li>
								<li><a href="categorie.php?catid=<?php echo $categorie['cat_id']; ?>& catname=<?php echo $categorie['cat_title'];?>"><?php echo $categorie['cat_title']; ?></a></li>
							</ul>

						</div>
					</div>
					<!-- /Product details -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- Section -->
		<div class="section mb-4">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<?php

						$stmt2=$con->prepare('SELECT * FROM products WHERE product_category_id = ? ORDER BY product_id DESC LIMIT 4' );

				  		$stmt2->execute(array($categorie_id));

				  		$products=$stmt2->fetchAll();


					?>

					<div class="col-md-12">
						<div class="section-title text-center">
							<h3 class="">Produits similaires</h3>
						</div>
					</div>

					<!-- product -->
					<?php
					foreach($products as $product):
					?>
					<div class="col-md-4 col-lg-3 col-sm-6 mb-3">
						<div class="product mx-3 p-3 h-100 product-show-background">
							<div class="product-img m-2" style="height: 180px;">
								<img src="<?php echo $images; echo $product['product_image']?>" alt="">
							</div>
							<div class="product-body">
								<p class="product-category"><?php echo $categorie['cat_title']?></p>
								<h3 class="product-name"><a href="<?php echo "products.php?do=Add&productid=".$product['product_id']; ?> "><?php echo $product['product_title']?></a></h3>
								<h4 class="product-price"><?php echo $product['product_price']?> Dhs
									<?php

											if($product['old_price'] != 0){
												echo '<del class="product-old-price">'.$product['old_price'].' Dhs</del>';
											}

										?>
								</h4>
								<div class="product-rating">
									<ul class="list-inline">
										<?php
											$goodRating = $product['Rating'];
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
											$badRating = 5 - $product['Rating'];
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
							</div>
						</div>
					</div>
					<!-- /product -->

					<?php
						endforeach;
					?>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /Section -->
		<?php

		}else{
			echo "<h1 class='text-center'>".'Panier'."</h1>";
			echo "<div class='container'>";
				$message='<div class="alert alert-danger">'.'Il n\'y a aucun produit avec cet identifiant'.'</div>';
				redirectFunction($message,'back',3);
			echo "</div>";
		}
	}
	else if($do=='Add'){
		$productid=0;
		if(isset($_GET['productid']) && is_numeric($_GET['productid'])){
			$productid=$_GET['productid'];
		}else{
			$productid=0;
		}
  		$stmt=$con->prepare('SELECT * FROM products WHERE product_id = ?');
  		$stmt->execute(array($productid));
  		$row=$stmt->fetch();
  		$count=$stmt->rowCount();

  		if($count > 0){ // si il est superieur a 0 donc il existe !!

  			$categorie_id=$row['product_category_id'];

			$stmat2=$con->prepare('SELECT * FROM categories WHERE cat_id = ?');

			$stmat2->execute(array($categorie_id));

			$categorie=$stmat2->fetch();

		?>
		<div id="product-slider">
	    		<h2 >Ajouter au <b> Panier </b></h2>
	    </div>
		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- Product main img -->
					<div class="col-md-4">
						<div id="product-main-img">
							<div class="product-preview">
								<img src="<?php echo $images; echo $row['product_image']?>" alt="product <?php echo $row['product_id']; ?>">
							</div>
						</div>
					</div>
					<!-- /Product main img -->

					<!-- Product details -->
					<div class="col-md-7 ">
						<div class="product-details pl-4">
							<h2 class="product-name"><?php echo $row['product_title']; ?></h2>
							<div>
								<div class="product-rating">
									<?php
									$goodRating = $row['Rating'];
										while($goodRating > 0):

										?>
										<i class="fa fa-star" style="color: #FF9529;"></i>
									<?php

										$goodRating = $goodRating - 1;
										endwhile;

									?>
									<?php
									$badRating = 5 - $row['Rating'];
										while($badRating > 0):
									?>
										<i class="fa fa-star" style="color: #cdc9c9;"></i>
									<?php

										$badRating = $badRating - 1;
										endwhile;

									?>
								</div>
							</div>
							<div>
								<h3 class="product-price"><?php echo $row['product_price']." Dhs"; ?>  <del class="product-old-price"><?php echo $row['old_price']." Dhs"; ?></del></h3>
								<?php

								if($row['product_quantity'] < 1){

									echo '<span class="product-available">In Stock</span>';

								}

								?>
							</div>
							<p class="pl-2"><?php echo $row['product_description']; ?></p>

							<!-- Start Add to cart -->
							<form action="checkout.php" method="post">
								<div class="add-to-cart pl-2">
									<div class="qty-label mb-2">
										Quantité
										<div class="input-number">
											<input type="number" id="quantite" name="quantite" min="1" max="100" value="1">
											<span class="qty-up">+</span>
											<span class="qty-down">-</span>
										</div>
									</div>
									<input type="hidden" name="product_title" value="<?php echo $row['product_title']; ?>">
									<input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
									<button type="submit" class="add-to-cart-btn"><i class='fa fa-shopping-cart'></i> Ajouter au <b> Panier </b></button>
								</div>
							</form>

							<!-- End Add to cart -->

							<ul class="product-links pl-2">
								<li>Catégorie:</li>
								<li><a href="categorie.php?catid=<?php echo $categorie['cat_id']; ?>& catname=<?php echo $categorie['cat_title'];?>"><?php echo $categorie['cat_title']; ?></a></li>
							</ul>

		

						</div>
					</div>
					<!-- /Product details -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- Section -->
		<div class="section mb-4">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<?php

						$stmt2=$con->prepare('SELECT * FROM products WHERE product_category_id = ? ORDER BY product_id DESC LIMIT 4' );

				  		$stmt2->execute(array($categorie_id));

				  		$products=$stmt2->fetchAll();


					?>

					<div class="col-md-12">
						<div class="section-title text-center">
							<h3 class="">Produits similaires</h3>
						</div>
					</div>

					<!-- product -->
					<?php
					foreach($products as $product):
					?>
					<div class="col-md-4 col-lg-3 col-sm-6 mb-3">
						<div class="product mx-3 p-3 h-100 product-show-background">
							<div class="product-img m-2" style="height: 180px;">
								<img src="<?php echo $images; echo $product['product_image']?>" alt="">
							</div>
							<div class="product-body">
								<p class="product-category"><?php echo $categorie['cat_title']?></p>
								<h3 class="product-name"><a href="<?php echo "products.php?do=Add&productid=".$product['product_id']; ?> "><?php echo $product['product_title']?></a></h3>
								<h4 class="product-price"><?php echo $product['product_price']?> Dhs
									<?php

											if($product['old_price'] != 0){
												echo '<del class="product-old-price">'.$product['old_price'].' Dhs</del>';
											}

										?>
								</h4>
								<div class="product-rating">
									<ul class="list-inline">
										<?php
											$goodRating = $product['Rating'];
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
											$badRating = 5 - $product['Rating'];
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
							</div>
						</div>
					</div>
					<!-- /product -->

					<?php
						endforeach;
					?>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /Section -->
		<?php

		}else{
			echo "<h1 class='text-center'>".'Ajouter au <b> Panier </b>'."</h1>";
			echo "<div class='container'>";
				$message='<div class="alert alert-danger">'.'Il n\'y a aucun produit avec cet identifiant'.'</div>';
				redirectFunction($message,'back',3);
			echo "</div>";
		}
	}

	include 'includes/templates/footer.php';
	ob_end_flush();
?>