<?php

$models = "../models/";
$cont 	= '../controllers/'; 
$func	= '../functions/'; 
$css 	= '../assets/css/'; 
$imgs 	= '../assets/images/'; 
$uploads = "../uploads/";
$inc  = "../incs/";
$app   = '../';


$userroute = '../user/';  
$restaurantsroute = '../restaurants/';  

if(isset($valid)) {
    if(!isset($_SESSION['username'])) {
        header("location: {$app}");
    } else {
        if(isset($_SESSION['type']) && $_SESSION['type'] == 'restaurant') {
            header("location: {$restaurantsroute}");
        }
    }
}