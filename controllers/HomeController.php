<?php

class HomeController {

    public static function index() {
        include_once('models/Meal.php');
        include_once('models/Package.php');
        $meal = new Meal();
        $package = new Package();
        $meals = $meal->getLatest('*','meals','id');
        $packages = $package->getLatest('*','packages','id');
        return ['meals'=>$meals,'packages'=>$packages];
    }

    public static function show_restaurants() {
        include_once('../models/Restaurant.php');
        $res = new Restaurant();
        $restaurants = $res->getLatest('*','restaurants','id',false);
        $data =  base64_encode(json_encode($restaurants));
        header("location: ../restaurants.php?restaurants={$data}");
    }

    public static function show_restaurant($id) {
        include_once('../models/Restaurant.php');
        include_once('../models/Meal.php');
        include_once('../models/Package.php');

        $res = new Restaurant();
        $meal = new Meal();
        $package = new Package();

        $restaurant = $res->getAllRestaurant('*','restaurants',"where id ={$id}");
        $meals = $meal->getAllMeals('*','meals',"where restaurant_id ={$id}");
        $packages = $package->getAllPackages('*','packages',"where restaurant_id ={$id}");

        $data =  base64_encode(json_encode(['restaurant' => $restaurant,'meals' => $meals , 'packages' => $packages]));
        header("location: ../restaurant_details.php?data={$data}");
    }



    public static function show_meals() {
        include_once('../models/Meal.php');
        $meal = new Meal();
        $meals = $meal->getLatest('*','meals','id',false);
        $data = base64_encode(json_encode($meals));
        header("location: ../meals.php?meals={$data}");
    }

    public static function show_Meal($id) {
        include_once('../models/Restaurant.php');
        include_once('../models/Meal.php');

        $res = new Restaurant();
        $mealModel = new Meal();
        
        $meal = $mealModel->getAllMeals('*','meals',"where id ={$id}");
        $restaurant = $res->getAllRestaurant('*','restaurants',"where id ={$meal[0]['restaurant_id']}");

        $data =  base64_encode(json_encode(['restaurant' => $restaurant,'meal' => $meal]));
        header("location: ../meal_details.php?data={$data}");
    }

    public static function show_packages() {
        include_once('../models/Package.php');
        $package = new Package();
        $packages = $package->getLatest('*','packages','id',false);
        $data = base64_encode(json_encode($packages));
        header("location: ../packages.php?packages={$data}");
    }

    public static function show_Package($id) {
        include_once('../models/Restaurant.php');
        include_once('../models/Meal.php');
        include_once('../models/Package.php');

        $res = new Restaurant();
        $meal = new Meal();
        $packageModel = new Package();

        $package = $packageModel->getAllPackages('*','packages',"where id ={$id}");
        $restaurant = $res->getAllRestaurant('*','restaurants',"where id ={$package[0]['restaurant_id']}");
        $meals = $meal->getAllMealsForPackage($id);

        $data =  base64_encode(json_encode(['restaurant' => $restaurant,'meals' => $meals , 'package' => $package]));
        header("location: ../package_details.php?data={$data}");
    }

    public static function show_compare() {
        include_once('../models/Restaurant.php');
        $res = new Restaurant();
        $restaurants = $res->getAllRestaurant('id , name','restaurants');
        if(empty($restaurants)) 
            header('location: ../');
        $data =  base64_encode(json_encode(['restaurants' => $restaurants]));
        header('location: ../compare.php?data='.$data);
    }

}



