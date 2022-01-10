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


    public function rate($id) {
        include_once('../models/Restaurant.php');
        include_once('../models/Meal.php');
        include_once('../models/Package.php');

               
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['Make_Rate'])) {
                $res = new Restaurant();
                $meal = new Meal();
                $package = new Package();

                $restaurant = $res->getAllRestaurant('*','restaurants',"where id ={$id}");
                $meals = $meal->getAllMeals('*','meals',"where restaurant_id ={$id}");
                $packages = $package->getAllPackages('*','packages',"where restaurant_id ={$id}"); 
                $user_id = $_SESSION['user']['id'];
                $rate = trim($_POST['rate']);
                $data = [
                    'rate'=>$rate,
                    'meals'=>$meals,
                    'restaurant' => $restaurant,
                    'packages' => $packages
                ];
                $encoded = base64_encode(json_encode($data));
                $userRate = $res->getRateForUser($id,$user_id);
                $where = '';
                if(count($userRate) > 0) {
                    $user_id = intval($user_id);
                    $where = "WHERE user_id =$user_id and type='restaurant' and type_id =$id"; 
                }
                $success = $res->addRate($id,$user_id,$rate,$where);
                if(!$success) {
                    $error=json_encode(["sever error exist"]);
                    header("location: ../restaurant_details.php?errors={$error}&data={$encoded}" );
                    exit();
                }
                $id = intval($id);
                if($restaurant[0]['count_rating'] == 0) {
                    $success = $res->updateRate($rate,$id);
                } else {
                    $AllRates = $res->getAllRates($id);
                    $sum = 0;
                    foreach($AllRates as $rate) {
                        $sum += $rate['rating'];
                    }
                    $rate_count = $sum / count($AllRates);
                    $success = $res->updateRate($rate_count,$id);
                }
                if($success) {
                    $restaurant = $res->getAllRestaurant('*','restaurants',"where id ={$id}");
                    $data = [
                        'rate'=>$rate,
                        'meals'=>$meals,
                        'restaurant' => $restaurant,
                        'packages' => $packages
                    ];
                    $encoded = base64_encode(json_encode($data));
                    header("location: ../restaurant_details.php?data={$encoded}" );
                    exit();
                }
                   

            }
        }
    }

    public function search() {
        include_once('../models/Restaurant.php');

        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['search'])) { 
                $resmodel = new Restaurant();
                $search = trim($_POST['searchRes']) ?? '';
                $restaurants = $resmodel->getLatest('*','restaurants','id',false);
                $encoded = base64_encode(json_encode($restaurants));
              
                if(empty($search)) {
                    $error=json_encode(["search is required"]);
                    header("location: ../restaurants.php?errors={$error}&restaurants={$encoded}" );
                    exit();
                } else {
                    $str = "" ; 
                    if(!empty($search)) {
                        $str .= "name like '%{$search}%' or description like '%{$search}%'";
                    }

                    $restaurants = base64_encode(json_encode($resmodel->getAllRestaurant('*','restaurants',"WHERE {$str}")));
                    header("location: ../restaurants.php?search={$search}&restaurants={$restaurants}" );

                }
            }
        }
    }


    public function compare() {
        include_once('../models/Restaurant.php');

        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['compare'])) { 
                $res = new Restaurant();
                $restaurants = $res->getAllRestaurant('id , name','restaurants');
                $data =  base64_encode(json_encode(['restaurants' => $restaurants]));
                $res1 = trim($_POST['res1']);
                $res2 = trim($_POST['res2']);
                if($res1 == $res2) {
                    $errors=json_encode(["Restaurants are same"]);
                    header("location: ../compare.php?errors={$errors}&data={$data}" );
                    exit();
                }
                $restaurant1 = $res->getRestaurant($res1);
                $restaurant2 = $res->getRestaurant($res2);
                $compare = ['res1' => $restaurant1 , 'res2' => $restaurant2 , 'restaurants' => $restaurants];
                $compare = base64_encode(json_encode($compare));
                header("location: ../compare.php?compare={$compare}" );


                
            }
        }

    }



    public function showProfile ($restaurantsroute = '../restaurants/') {
        header('Location: '.$restaurantsroute);
    }
    public function showSubscribes ($restaurantsroute = '../restaurants/') {
        $restaurants_id = $_SESSION['restaurant']['id'];
        $restaurant = new Restaurant(); 
        $subscribes = $restaurant->getAllSubscribes($restaurants_id);
        $encoded = base64_encode(json_encode($subscribes));
        header('Location: '.$restaurantsroute.'subscribes.php?subscribes='.$encoded);
    }
    public function showOrders ($restaurantsroute = '../restaurants/') {
        $restaurants_id = $_SESSION['restaurant']['id'];
        $restaurant = new Restaurant(); 
        $orders = $restaurant->getAllOrders($restaurants_id);
        $encoded = base64_encode(json_encode($orders));
        header('Location: '.$restaurantsroute.'orders.php?orders='.$encoded);
    }
    public function showSettings ($restaurantsroute = '../restaurants/') {
        header('Location: '.$restaurantsroute.'settings.php');
    }
    public function showChangePassword ($restaurantsroute = '../restaurants/') {
        header('Location: '.$restaurantsroute.'changepassword.php');
    }

    public function editrestaurant ($restaurantsroute = '../restaurants/') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['resEdit'])) {
                $name=trim($_POST['name']);
                $email = trim($_POST['email']);
                $address = trim($_POST['address']);
                $owner_name =trim($_POST['owner_name']);
                $phone = trim($_POST['phone']);
                $description = trim($_POST['description']);
                $photoName = $_FILES['image']['name'];
                $error=[];
                $photo = "";
                if (empty($name)) {
                    array_push($error,"name required");
                } 
                if (!empty($name) && is_numeric($name)) {
                    array_push($error,"name must be contains letters (not number only)");
                } 
                if (empty($address)) {
                    array_push($error,"address required");
                } 
                if (empty($address)) {
                    array_push($error,"address required");
                }
                if (empty($description)) {
                    array_push($error,"description required");
                }
                if (empty($owner_name)) {
                    array_push($error,"owner name required");
                }
                if (!empty($owner_name) && is_numeric($owner_name)) {
                    array_push($error,"owner name must be contains letters (not number only)");
                }
                if (empty($phone)) {
                    array_push($error,"phone required");
                }
                if (!empty($phone) && !is_numeric($phone)) {
                    array_push($error,"phone must be contains number only");
                } 

                if (!empty($photoName)) {

                    $photoSize = $_FILES['image']['size'];
                    $photoTmp	= $_FILES['image']['tmp_name'];
                    // List Of Allowed File Typed To Upload

                    $photoAllowedExtension = array("jpeg", "jpg", "png");

                    // Get photo Extension
                    $explode = explode('.', $photoName);
                    $photoExtension = strtolower(end($explode));
                    if (! empty($photoName) && ! in_array($photoExtension, $photoAllowedExtension)) {
                        $error[] = 'This Extension Is Not <strong>Allowed</strong>';
                    }
    
                    if ($photoSize > 4194304) {
                        $error[] = 'photo Cant Be Larger Than <strong>4MB</strong>';
                    }
                    $restaurant_id = $_SESSION['restaurant']['id'];
                    $oldphoto = $_SESSION['restaurant']['photo'];
                    $path = '../uploads/restaurants/'.$restaurant_id;
                    if(!is_dir($path)) {
                        mkdir($path);
                    } 
                    if($oldphoto != null) {
                        unlink($path.'/'.$oldphoto);
                    }
                    move_uploaded_file($photoTmp, '../uploads/restaurants/'.$restaurant_id.'/'. $photoName);
                    $photo = $photoName;
                } else {
                    $restaurant_id = $_SESSION['restaurant']['id'];
                    $oldphoto = $_SESSION['restaurant']['photo'];
                    $photo = $oldphoto;
                }

                $data = [
                    'email'=>$email,
                    'name'=>$name,
                    'address'=>$address,
                    'owner_name'=>$owner_name,
                    'phone'=>$phone,
                    'description'=>$description,
                    'photo'=>$photo
                ];
                $encoded= json_encode($data);
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: {$restaurantsroute}settings.php?errors={$error}&data={$encoded}" );
                    exit();
                }
                
                $restaurant = new Restaurant();
                $restaurants_id = $_SESSION['restaurant']['id'];
                $success = $restaurant->update($restaurants_id,$data);
                if($success) {
                    $_SESSION['restaurant']['name'] = $name;
                    $_SESSION['username'] = $name;
                    if(!empty($photoName))
                        $_SESSION['restaurant']['photo'] = $photoName ;
                    $_SESSION['restaurant']['email'] = $email;
                    $_SESSION['restaurant']['address'] = $address;
                    $_SESSION['restaurant']['owner_name'] = $owner_name;
                    $_SESSION['restaurant']['phone'] = $phone;
                    $_SESSION['restaurant']['description'] = $description;

                    header("location: {$restaurantsroute}" );
                }

            }
        }
        
    }

    public function changePassword ($restaurantsroute = '../restaurants/') {
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
                    header("location: {$restaurantsroute}changepassword.php?errors={$error}" );
                    exit();
                }
                $restaurants = new Restaurant();
                $restaurants_id = $_SESSION['restaurant']['id'];
                $success = $restaurants->changePassword($restaurants_id,$data);
                if($success) {
                    $_SESSION['restaurant']['password'] = password_hash($password, PASSWORD_BCRYPT);
                    header("location: ../restaurants/" );
                }

            }
        }
        
    }
}