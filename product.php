<?php
	ob_start();
	session_start();
	$pageTitle="Products";
	include 'init.php';

	?>
<?php
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
									Quantit??
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
								<li>Cat??gorie:</li>
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
			echo "<h1 class='text-center'>"."Ajouter au <b> Panier </b>"."</h1>";
			echo "<div class='container'>";
				$message='<div class="alert alert-danger">'."Il n'y a aucun produit avec cet identifiant".'</div>';
				redirectFunction($message,'back',3);
			echo "</div>";
		}

	include 'includes/templates/footer.php';
	ob_end_flush();
?>
