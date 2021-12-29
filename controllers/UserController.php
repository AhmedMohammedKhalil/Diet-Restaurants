<?php
include_once('../models/User.php');
class UserController{

    
    public static function show_login($userroute = '../user/') {
        header('Location: '.$userroute.'login.php');
    }

    public static function show_register($userroute = '../user/') {
        header('Location: '.$userroute.'register.php');
    }

    public function login($userroute = '../user/') {
        
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
                    header('Location: '.$userroute."login.php?errors={$error}&data={$encoded}");
                    exit();
                }
                $user = new User();
                $user->getUserAndLogin($data);
            }
        }
        
    }

    public function register() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['register'])) {
                $name=trim($_POST['name']);
                $email = trim($_POST['email']);
                $address = trim($_POST['address']);
                $password = trim($_POST['password']);
                $confirm_password = trim($_POST['confirm_password']);
                $data = [
                    'email'=>$email,
                    'name'=>$name,
                    'address'=>$address,
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
                if (strlen($password)<8) {
                    array_push($error,"password must be greater than 8 digit");
                } 
                if ($password!=$confirm_password) {
                    array_push($error,"passwords not matched");
                } 
                if (empty($address)) {
                    array_push($error,"address required");
                } 
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: ../user/register.php?errors={$error}&data={$encoded}" );
                    exit();
                }
                $user = new User();
                $user->insert($data);

            }
        }


        
    }


    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['type']);
        unset($_SESSION['username']);
        header('location:../index.php');
    }

}