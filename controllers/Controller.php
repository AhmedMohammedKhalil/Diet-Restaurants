<?php
session_start();
include_once('HomeController.php');
include_once('UserController.php');
include_once('RestaurantsController.php');
include_once('MealsController.php');
include_once('PackagesController.php');
$action = $_GET['do'];
if($action != "") {

    // user route
    if($action == 'showUserLogin') {
        UserController::show_login();
    }
    if($action == 'showUserRegister') {
        UserController::show_register();
    }
    if($action == 'userLogin') {
        $user = new UserController();
        $user->login();
    }
    if($action == 'userRegister') {
        $user = new UserController();
        $user->Register();
    }
    if($action == 'userLogout') {
        $res = new UserController();
        $res->logout();
    }

    //restaurants route
    if($action == 'showResLogin') {
        RestaurantsController::show_login();
    }
   
    if($action == 'showResRegister') {
        RestaurantsController::show_register();
    }
    if($action == 'resLogin') {
        $res = new RestaurantsController();
        $res->login();
    }
    if($action == 'resRegister') {
        $res = new RestaurantsController();
        $res->Register();
    }

    if($action == 'ResLogout') {
        $res = new RestaurantsController();
        $res->logout();
    }

    // all 
    if($action == 'showRestaurants') {
        HomeController::show_restaurants();
    }
    if($action == 'showRestaurant') {
        $id = $_GET['id'];
        HomeController::show_restaurant($id);
    }
    if($action == 'showMeals') {
        HomeController::show_meals();
    }
    if($action == 'showMeal') {
        $id = $_GET['id'];
        HomeController::show_Meal($id);
    }
    if($action == 'showPackages') {

        HomeController::show_packages();
    }
    if($action == 'showPackage') {
        $id = $_GET['id'];
        HomeController::show_Package($id);
    }
    if($action == 'showCompare') {

        HomeController::show_compare();
    }
    
    
}
