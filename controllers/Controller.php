<?php
session_start();
include_once('HomeController.php');
include_once('UserController.php');
include_once('AdminController.php');
include_once('RestaurantsController.php');
include_once('MealsController.php');
include_once('PackagesController.php');
$action = $_GET['do'];
if($action != "") {

    if(isset($_SESSION['username'])) {

        if($_SESSION['type'] == 'user') {

            // user route
            if($action == 'userLogout') {
                $user = new UserController();
                $user->logout();
            }
            if($action == 'rateMeal') {
                $id = $_GET['id'];
                $meal = new MealsController();
                $meal->rate($id);
            }
            if($action == 'ratePackage') {
                $id = $_GET['id'];
                $meal = new PackagesController();
                $meal->rate($id);
            }
            if($action == 'rateRes') {
                $id = $_GET['id'];
                $meal = new RestaurantsController();
                $meal->rate($id);
            }
            if($action == 'showUserProfile') {
                $user = new UserController();
                $user->showProfile();
            }
            if($action == 'showUserSubscribes') {
                $user = new UserController();
                $user->showSubscribes();
            }
            if($action == 'showUserOrders') {
                $user = new UserController();
                $user->showOrders();
            }
            if($action == 'showUserSettings') {
                $user = new UserController();
                $user->showSettings();
            }
            if($action == 'showUserChangePassword') {
                $user = new UserController();
                $user->showChangePassword();
            }
            if($action == 'editUser') {
                $user = new UserController();
                $user->editUser();
            }
            if($action == "showUserupdatePhoto") {
                $user = new UserController();
                $user->showUpdatePhoto();
            }
            if($action == "userUpdatePhoto") {
                $user = new UserController();
                $user->updatephoto();
            }
            if($action == "UserchangePass") {
                $user = new UserController();
                $user->changePassword();
            }
            if($action == "buyMeal") {
                $id = $_GET['id'];
                $meal = new MealsController();
                $meal->buyMeal($id);
            }
            if($action == "makeSubscripe") {
                $id = $_GET['id'];
                $package = new PackagesController();
                $package->subscribePackage($id);
            }
        } elseif ($_SESSION['type'] == 'admin') {

            if($action == 'adminLogout') {
                $admin = new AdminController();
                $admin->logout();
            }
            if($action == 'showAdminProfile') {
                $admin = new AdminController();
                $admin->showProfile();
            }
            if($action == 'showAdminChangePassword') {
                $admin = new AdminController();
                $admin->showChangePassword();
            }
            if($action == 'showAdminSubscribes') {
                $admin = new AdminController();
                $admin->showAllSubscribes();
            }
            
            if($action == 'showAdminSettings') {
                $admin = new AdminController();
                $admin->showSettings();
            }
            if($action == 'editAdmin') {
                $admin = new AdminController();
                $admin->editAdmin();
            }
            if($action == "AdminChangePass") {
                $admin = new AdminController();
                $admin->changePassword();
            }
            if($action == "showAdminOrders") {
                $admin = new AdminController();
                $admin->showAllOrders();
            }
            if($action == "showAdminRestaurants") {
                $admin = new AdminController();
                $admin->showAllRestaurants();
            }
            if($action == "showAdminUsers") {
                $admin = new AdminController();
                $admin->showAllUsers();
            }
            if($action == "showAdminPackages") {
                $admin = new AdminController();
                $admin->showAllPackages();
            }
            if($action == "showAdminMeals") {
                $admin = new AdminController();
                $admin->showAllMeals();
            }
            if($action == "showUserDetails") {
                $id = $_GET['id'];
                $admin = new AdminController();
                $admin->showUserDetials($id);
            }
        } else {

            //restaurants route

            if($action == 'ResLogout') {
                $res = new RestaurantsController();
                $res->logout();
            }
            if($action == 'showResProfile') {
                $res = new RestaurantsController();
                $res->showProfile();
            }
            if($action == 'showResSubscribes') {
                $res = new RestaurantsController();
                $res->showSubscribes();
            }
            if($action == 'showResOrders') {
                $res = new RestaurantsController();
                $res->showOrders();
            }
            if($action == 'showResSettings') {
                $res = new RestaurantsController();
                $res->showSettings();
            }
            if($action == 'showResChangePassword') {
                $res = new RestaurantsController();
                $res->showChangePassword();
            }
            if($action == "ReschangePass") {
                $res = new RestaurantsController();
                $res->changePassword();
            }
            if($action == 'editRes') {
                $res = new RestaurantsController();
                $res->editrestaurant();
            }
            if($action == 'showUserDetails') {
                $id = $_GET['id'];
                $user = new UserController();
                $user->userDetails($id);
            }
            if($action == "showResPackages") {
                $packages = new PackagesController();
                $packages->showAllPackages();
            }
            if($action == "showResMeals") {
                $meals = new MealsController();
                $meals->showAllMeals();
            }
            if($action == "createMeal") {
                $meals = new MealsController();
                $meals->createMeal();
            }
            if($action == "storeMeal") {
                $meals = new MealsController();
                $meals->storeMeal();
            }
            if($action == "editMeal") {
                $id = $_GET['id'];
                $Meal = new MealsController();
                $Meal->editMeal($id);
            }
            if($action == "updateMeal") {
                $Meal = new MealsController();
                $Meal->updateMeal();
            }
            if($action == "delMeal") {
                $id = $_GET['id'];
                $meal = new MealsController();
                $meal->delMeal($id);
            }
            if($action == "createPackage") {
                $package = new PackagesController();
                $package->createPackage();
            }
            if($action == "storePackage") {
                $package = new PackagesController();
                $package->storePackage();
            }
            if($action == "editPackage") {
                $id = $_GET['id'];
                $package = new PackagesController();
                $package->editPackage($id);
            }
            if($action == "updatePackage") {
                $package = new PackagesController();
                $package->updatePackage();
            }
            if($action == "delPackage") {
                $id = $_GET['id'];
                $package = new PackagesController();
                $package->delPackage($id);
            }

        }

    }

        // all 
        if($action == 'showAdminLogin') {
            AdminController::show_login();
        }
        if($action == 'adminLogin') {
            $user = new AdminController();
            $user->login();
        }
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
        if($action == "searchRes") {
            $res = new RestaurantsController();
            $res->search();
        }
        if($action == 'showCompare') {
            HomeController::show_compare();
        }
        if($action == 'filterMeals') {
            $meal = new MealsController();
            $meal->makeFilter();
        }
        if($action == 'filterPackages') {
            $package = new PackagesController();
            $package->makeFilter();
        }
        
        if($action = "makeCompare") {
            $res = new RestaurantsController();
            $res->compare();

        }


}
