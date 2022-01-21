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
$adminroute = '../admin/';  


if(isset($valid)) {
    if(!isset($_SESSION['username'])) {
        header("location: {$app}");
    } else {
        if(isset($_SESSION['type']) && $_SESSION['type'] == 'restaurant') {
            header("location: {$restaurantsroute}");
        }
        if(isset($_SESSION['type']) && $_SESSION['type'] == 'user') {
            header("location: {$userroute}");
        }
    }
}