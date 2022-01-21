<?php
include_once('../models/Admin.php');
class AdminController{

    
    public static function show_login($adminroute = '../admin/') {
        header('Location: '.$adminroute.'login.php');
    }

    public function login($adminroute = '../admin/') {
        
        $error=[];
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['login'])) {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $captcha = trim($_POST['captcha']);
                $data = [
                    'email'=>$email,
                    'password' => $password,
                ];
                $encoded= json_encode($data);
                if(empty($email)) {
                    array_push($error,"Email required");
                }
                if(empty($password)) {
                    array_push($error,"Password required");
                }
                if(strlen($password)<8) {
                    array_push($error,"password must be greater than 8 digit");
                } 
                if ($captcha != $_SESSION['CAPTCHA_CODE']) {
                    array_push($error,"Captcha not matched");
                } 
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header('Location: '.$adminroute."login.php?errors={$error}&data={$encoded}");
                    exit();
                }
                $admin = new Admin();
                $admin->getAdminAndLogin($data);
            }
        }
        
    }

    

    
    public function showProfile ($adminroute = '../admin/') {
        header('Location: '.$adminroute);
    }
    public function showAllSubscribes ($adminroute = '../admin/') {
        $admin = new admin(); 
        $subscribes = $admin->getAllSubscribes();
        $encoded = base64_encode(json_encode($subscribes));
        header('Location: '.$adminroute.'all_subscribes.php?subscribes='.$encoded);
    }
    public function showAllOrders($adminroute = '../admin/') {
        $admin = new admin(); 
        $orders = $admin->getAllOrders();
        $encoded = base64_encode(json_encode($orders));
        header('Location: '.$adminroute.'all_orders.php?orders='.$encoded);
    }
    public function showSettings ($adminroute = '../admin/') {
        header('Location: '.$adminroute.'settings.php');
    }
    public function showChangePassword ($adminroute = '../admin/') {
        header('Location: '.$adminroute.'changepassword.php');
    }

    public function editAdmin ($adminroute = '../admin/') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['adminEdit'])) {
                $name=trim($_POST['name']);
                $email = trim($_POST['email']);
                $data = [
                    'email'=>$email,
                    'name'=>$name,
                ];
                $encoded= json_encode($data);
                $error=[];
                if (empty($name)) {
                    array_push($error,"name required");
                } 
                if (!empty($name) && is_numeric($name)) {
                    array_push($error,"name must be contains letters (not number only)");
                } 
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: {$adminroute}settings.php?errors={$error}&data={$encoded}" );
                    exit();
                }
                $admin = new admin();
                $admin_id = $_SESSION['admin']['id'];
                $success = $admin->update($admin_id,$data);
                if($success) {
                    $_SESSION['admin']['name'] = $name;
                    $_SESSION['username'] = $name;
                    $_SESSION['admin']['email'] = $email;
                    header("location: {$adminroute}" );
                }

            }
        }
        
    }
    //
    public function changePassword ($adminroute = '../admin/') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['change_pass'])) {
                $password = trim($_POST['password']);
                $confirm_password = trim($_POST['confirm_password']);
                $data = [
                    'password' => $password
                ];
                $error=[];
                if(strlen($password)<8) {
                    array_push($error,"password must be greater than 8 digit");
                } 
                if ($password!=$confirm_password) {
                    array_push($error,"passwords not matched");
                } 
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: {$adminroute}changepassword.php?errors={$error}" );
                    exit();
                }
                $admin = new admin();
                $admin_id = $_SESSION['admin']['id'];
                $success = $admin->changePassword($admin_id,$data);
                if($success) {
                    $_SESSION['admin']['password'] = password_hash($password, PASSWORD_BCRYPT);
                    header("location: ../admin/" );
                }

            }
        }
        
    }

    public function showAllRestaurants($adminroute = '../admin/') {
        $admin = new admin(); 
        $restaurants = $admin->getAllRestaurants();
        $encoded = base64_encode(json_encode($restaurants));
        header('Location: '.$adminroute.'all_restaurants.php?restaurants='.$encoded);
    }

    public function showAllUsers($adminroute = '../admin/') {
        $admin = new admin(); 
        $users = $admin->getAllUsers();
        $encoded = base64_encode(json_encode($users));
        header('Location: '.$adminroute.'all_users.php?users='.$encoded);
    }
    public function showAllPackages($adminroute = '../admin/') {
        include_once('../models/Package.php');
        $package = new Package(); 
        $select = "P.* , R.name as res_name";
        $table = "packages P , restaurants R";
        $where = "where P.restaurant_id = R.id";
        $allpackages = $package->getAllPackages($select,$table,$where,null,'P.id','ASC');
        $encoded = base64_encode(json_encode($allpackages));
        header('Location: '.$adminroute.'all_packages.php?packages='.$encoded);
    }
    public function showAllMeals($adminroute = '../admin/') {
        include_once('../models/Meal.php');
        $meal = new Meal(); 
        $select = "M.* , R.name as res_name";
        $table = "meals M , restaurants R";
        $where = "where M.restaurant_id = R.id";
        $allMeals = $meal->getAllMeals($select,$table,$where,null,'M.id','ASC');
        $encoded = base64_encode(json_encode($allMeals));
        header('Location: '.$adminroute.'all_meals.php?meals='.$encoded);
    }

    public function showUserDetials($user_id,$adminroute = '../admin/') {
        $admin = new Admin();
        $encoded = base64_encode(json_encode($admin->getUser($user_id)));
        header('Location: '.$adminroute.'user_details.php?user='.$encoded);
    } 

    public function logout()
    {
        unset($_SESSION['admin']);
        unset($_SESSION['type']);
        unset($_SESSION['username']);
        header('location:../index.php');
    }

}