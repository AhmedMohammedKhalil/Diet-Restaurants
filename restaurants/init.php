<?php

	$models = "../models/";
	$cont 	= '../controllers/'; 
	$css 	= '../assets/css/'; 
    $imgs 	= '../assets/images/'; 
	$inc  = "../incs/";
	$uploads = "../uploads/";
	$app   = '../';


	$restaurantsroute = '../restaurants/';  
	$userroute = '../user/';  
	
	if(isset($valid)) {
		if(!isset($_SESSION['username'])) {
			header("location: {$app}");
		} else {
			if(isset($_SESSION['type']) && $_SESSION['type'] == 'user') {
				header("location: {$userroute}");
			}
		}
	}