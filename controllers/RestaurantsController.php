<?php
include_once('../models/Restaurant.php');

class RestaurantsController {

    public static function show_login($restaurantsroute = '../restaurants/') {
        header('Location: '.$restaurantsroute.'login.php');
    }

    public static function show_register($restaurantsroute = '../restaurants/') {
        header('Location: '.$restaurantsroute.'register.php');
    }


    public function login($restaurantsroute = '../restaurants/') {
        
        $error=[];
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['login'])) {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $data = [
                    'email'=>$email,
                    'password' => $password,
                ];
               $encoded= json_encode($data);
                if(strlen($password)<8){
                    $error=json_encode(['password must be greater than 8 digit']);
                    header('Location: '.$restaurantsroute."login.php?errors={$error}&data={$encoded}");
                    exit();
                }
                $restaurant = new Restaurant();
                $restaurant->getRestaurantAndLogin($data);
            }
        }
        
    }

    public function register() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['register'])) {
                $name=trim($_POST['name']);
                $email = trim($_POST['email']);
                $owner_name = trim($_POST['owner_name']);
                $phone = trim($_POST['phone']);
                $address = trim($_POST['address']);
                $description = trim($_POST['description']);
                $password = trim($_POST['password']);
                $confirm_password = trim($_POST['confirm_password']);
                $data = [
                    'email'=>$email,
                    'name'=>$name,
                    'owner_name'=>$owner_name ,
                    'phone'=>$phone ,
                    'address'=>$address,
                    'description'=>$description,
                    'password' => $password,
                ];
                $encoded= json_encode($data);
                $error=[];
                if (empty($name)) {
                    array_push($error,"name required");
                } 
                if (!empty($name) && is_numeric($name)) {
                    array_push($error,"name must be contains letters (not number only)");
                } 
                if (empty($owner_name)) {
                    array_push($error,"owner_name required");
                }
                if (!empty($owner_name) && is_numeric($owner_name)) {
                    array_push($error,"owner_name must be contains letters (not number only)");
                } 
                if (empty($phone)) {
                    array_push($error,"phone required");
                }
                if (!empty($phone) && !is_numeric($phone)) {
                    array_push($error,"phone must be number");
                } 
                if (!empty($phone) && strlen($phone)<6) {
                    array_push($error,"Phone must be 6 digit");
                }
                if (strlen($password)<8) {
                    array_push($error,"password must be greater than 8 digit");
                } 
                if ($password!=$confirm_password) {
                    array_push($error,"passwords not matched");
                } 
                if (empty($address)) {
                    array_push($error,"address required");
                } 
                if (empty($description)) {
                    array_push($error,"description required");
                } 
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: ../restaurants/register.php?errors={$error}&data={$encoded}" );
                    exit();
                }
                $res = new Restaurant();
                $res->insert($data);

            }
        }


        
    }


    public function logout()
    {
        unset($_SESSION['restaurant']);
        unset($_SESSION['type']);
        unset($_SESSION['username']);
        header('location:../index.php');
    }
}