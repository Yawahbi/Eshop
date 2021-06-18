<?php 

	 include 'connect.php';

	$tpl='includes/templates/'; // Template directory
	$css='assets/css/';
	$function='includes/functions/';
	$js='assets/js/';
	$image='assets/images/banners/';
	$images='assets/images/products/';
	$svg = '../../assets/svg/';


	//Include les choses importantes
	include $function.'functions.php';

	//Include The Header File
	include $tpl.'header.php';

	//la navigation bar ne doit pas se trouver dans toutes les pages donc on doit filtrer notre include.

	if(!isset($noNavigationBar)){
		include $tpl.'navbar.php';
	}
?>