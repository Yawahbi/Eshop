<?php

	ob_start();
	session_start();
	$pageTitle="Categorie";
	include 'init.php';

	$catid=0;
	if(isset($_GET['catid']) && is_numeric($_GET['catid'])){
		$catid=$_GET['catid'];
	}else{
		$catid=0;
	}
	if(isset($_GET['catname']) && is_string($_GET['catname'])){
		$catname=$_GET['catname'];
	}else{
		$catname=Error;
	}

	// La page home de notre categorie !!
	$check=checkItem('cat_id','categories',$catid);

	if($check > 0){ // ca veut dire que cette categorie existe !!

		$rows=getItems($catid);

		$count=count($rows);
		?>

		<section id="product-slider">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h2 >Category<b> <?php echo $catname; ?></b></h2>
						<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
						<div class="carousel-inner">
							<div class="item carousel-item active">
								<div class="row">
									<?php
									if($count > 0){
										foreach ($rows as $row) { //debut de notre boucle !!
									?>
									<div class="col-sm-6 col-md-4 col-lg-3">
										<div class="thumb-wrapper">
											<div class="img-box">
												<img src="<?php echo $images; echo $row['product_image']; ?>" class="img-responsive img-fluid" alt="">
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
		}else{
			echo "<div class='container'>";
			echo"<div class='alert alert-warning empty-category'><strong>".'Cette cat??gorie est vide! Veuillez la v??rifier une autre fois'."</strong></div>";
			echo "</div>";echo "</div>";echo "</div>";echo "</div>";echo "</div>";echo "</div>";
			echo "</div>";echo "</div>";echo "</section>";
		}
	}else{
		$message='<div class="alert alert-danger">'.'Il n\'y a pas de cat??gorie avec cet identifiant'.'</div>';
		redirectFunction($message,'back',3);
	}
	?>

<?php

		include 'includes/templates/footer.php';
		ob_end_flush();
?>
