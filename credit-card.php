<?php
	ob_start();
	session_start();
	$pageTitle="Payment";
	include 'init.php';

	if(!isset($_SESSION['user'])){

		$message='<div class="alert alert-warning mt-4">'. 'Vous devez vous connecter avant de valider votre paiement!' .'</div>';
		redirectFunction($message,'login.php',3);

	}

	$formErrors = array();
	$formValidation=array();

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		if(isset($_POST['username']) && is_string($_POST['username'])){

			if(isset($_POST['cardNumber']) && is_numeric($_POST['cardNumber'])){

				if(isset($_POST['cvv']) && is_numeric($_POST['cvv'])){

					$userid 	 = $_SESSION['userid'];
					$username	 = $_POST['username'];
					$cardNumber	 = $_POST['cardNumber'];
					$cvv 		 = $_POST['cvv'];

					$validation=(luhn_validate($cardNumber));

					if($validation == true){

						$user=getItem('user_id','users',$userid);

						$userMail=$user['email'];

						$fullName=$user['fullName'];

						$msg = lang('HI').$fullName.' /n /n /n '.lang('PAYMENT2').'/n/n/n '.'<b>'.lang('CONGRATULATIONS').'</b>';

						$montantTotal = $_SESSION['totaux'];

						//mail($userMail,'Payment Done',$msg);

						//$formValidation[]='Your Payment is done , Congratulations '.$fullName.' Please check your mail !';

						$to      = $userMail;
					    $subject = lang('Paiement - Ecommerce ENSAA');
					    $message = "Salut,
						Nous vous informons que votre transaction a été confirmée. Voici le détail de l\'opération:
						
						Site Web: Eshop
						Nom du client :  ".$fullName.'
						E-mail du client: '.$userMail.'
						Montant de la transaction :'.$montantTotal."MAD
						Pour plus d\'informations, veuillez contacter votre revendeur.
						Merci.";
					    $headers = 'De:'.' Eshop@gmail.com';

					    if(mail($to, $subject, $message, $headers)){

					    	$formValidation[] = 'Paiement terminé! Veuillez vérifier votre e-mail';
					    	emptyCart($userid);
					    	header("refresh:8;url=index.php");

					    }else{

					    	$formErrors[]='Erreur lors du paiement! réessayer';

					    }

					}
					else{

						$formErrors[]="Votre carte de crédit n'est pas valide";

					}

				}
				else{

					$formErrors[]="votre cvv n'est pas valide, veuillez le vérifier!";

				}

			}
			else{

				$formErrors[]="Votre numéro de carte n'est pas valide, veuillez le vérifier!";

			}

		}
		else{

			$formErrors[]="Votre nom d'utilisateur n'est pas valide, veuillez le vérifier!";

		}
	}
?>

	<!-- Start Payment form -->

	<div class="container text-center">
		<div class="payment-container">
			<div class="logo-payment">
				<span>P</span>
			</div>
			<h1 class="mb-0">Passerelle de paiement</h1>
			<form class="pt-5 pb-5" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				<div class="input-group mb-3 px-5">
					<label class="d-block">Titulaire de la carte:</label>
					<div class="payment-input-container">
						<div class="payment-input-logo">
							<i class="fa fa-user-alt"></i>
						</div>
			        	<input type="text" name="username" placeholder="Veuillez entrer votre nom de carte" required class="form-control">
					</div>
			   	</div>
			   	<div class="input-group mb-3 px-5 pb-3">
					<label class="d-block">Numéro de carte:</label>
					<div class="payment-input-container">
						<div class="payment-input-logo">
							<i class="fas fa-credit-card"></i>
						</div>
			        	<input type="text" name="cardNumber" placeholder="Veuillez entrer votre numero de carte" class="form-control" required>
					</div>
			   	</div>
			   	<div class="input-group mb-3 px-5 pb-3">
			   		<div class="row text-left  w-100 ml-1">
			   			<div class="col-8 p-0">
			   				<label class="d-block">Date d'expiration:</label>
							<div class="payment-input-container">
								<div class="payment-input-logo">
									<i class="far fa-calendar-alt" style="font-style: 1.2rem"></i>
								</div>
					        	<input type="date" id="start"
							       min="2020-01-01" max="2028-12-31" class="form-control text-center" name="card-number" placeholder="00/00" required="required">
							</div>
			   			</div>
			   			<div class="col-4 pr-0">
			   				<label class="d-block">CVC :</label>
							<div class="payment-input-container">
					        	<input type="text" class="form-control text-center" name="cvv" placeholder="CVC" required="required">
							</div>
			   			</div>
			   		</div>
			   	</div>
			  	<button type="submit" class="btn btn-block btn-payment">Confirmer</button>
			</form>
			<?php

				if(!empty($formErrors)){
					echo '<div class="error-show pb-3 px-3">';
						echo '<div class="alert alert-danger mb-0" role="alert">';
								foreach ($formErrors as $error) {
									echo $error;
								}
						echo "</div>";
					echo "</div>";
				}

			?>
			<?php

				if(!empty($formValidation)){
					echo '<div class="error-show pb-3 px-3">';
						echo '<div class="alert alert-success mb-0" role="alert">';
								foreach ($formValidation as $validation) {
									echo $validation;
								}
						echo "</div>";
					echo "</div>";
				}

			?>
		</div>
	</div>


	<!-- End Payment form -->

<?php

	include 'includes/templates/footer.php';
	ob_end_flush();

?>
