<?php
class PackagesController {

    public function rate($id) {
        include_once('../models/Restaurant.php');
        include_once('../models/Meal.php');  
        include_once('../models/Package.php');
      
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['Make_Rate'])) {
                $res = new Restaurant();
                $meal = new Meal();
                $packageModel = new Package();
        
                $package = $packageModel->getAllPackages('*','packages',"where id ={$id}");
                $restaurant = $res->getAllRestaurant('*','restaurants',"where id ={$package[0]['restaurant_id']}");
                $meals = $meal->getAllMealsForPackage($id);

                $user_id = $_SESSION['user']['id'];
                $rate = trim($_POST['rate']);
                $data = [
                    'rate'=>$rate,
                    'meals'=>$meals,
                    'restaurant' => $restaurant,
                    'package' => $package
                ];
                $encoded = base64_encode(json_encode($data));
                $userRate = $packageModel->getRateForUser($id,$user_id);
                $where = '';
                if(count($userRate) > 0) {
                    $user_id = intval($user_id);
                    $where = "WHERE user_id =$user_id and type='package' and type_id =$id"; 
                }
                $success = $packageModel->addRate($id,$user_id,$rate,$where);
                if(!$success) {
                    $error=json_encode(["sever error exist"]);
                    header("location: ../package_details.php?errors={$error}&data={$encoded}" );
                    exit();
                }
                $id = intval($id);
                if($package[0]['count_rating'] == 0) {
                    $success = $packageModel->updateRate($rate,$id);
                } else {
                    $AllRates = $packageModel->getAllRates($id);
                    $sum = 0;
                    foreach($AllRates as $rate) {
                        $sum += $rate['rating'];
                    }
                    $rate_count = $sum / count($AllRates);
                    $success = $packageModel->updateRate($rate_count,$id);
                }
                if($success) {
                    $package = $packageModel->getAllPackages('*','packages',"where id ={$id}");
                    $data = [
                        'rate'=>$rate,
                        'meals'=>$meals,
                        'restaurant' => $restaurant,
                        'package' => $package
                    ];
                    $encoded = base64_encode(json_encode($data));
                    $_SESSION['msg'] = "Package has been successfully rated";
                    header("location: ../package_details.php?data={$encoded}" );
                    exit();
                }
                   

            }
        }
    }

    public function makeFilter() {
        include_once('../models/Package.php');

        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['Filter'])) { 
                $packageModel = new Package();
                $search = trim($_POST['search']) ?? '';
                $price = $_POST['price'] ?? [];
                $calories = $_POST['calories'] ?? [];
                $packages = $packageModel->getLatest('*','packages','id',false);
                $encoded = base64_encode(json_encode($packages));
              
                if(empty($search) && count($price) == 0 && count($calories) == 0) {
                    $error=json_encode(["Not Data Enterd for Filter"]);
                    header("location: ../packages.php?errors={$error}&packages={$encoded}" );
                    exit();
                } else {
                    $str = "" ; 
                    if(!empty($search)) {
                        $str .= "name like '%{$search}%' or details like '%{$search}%'";
                    }
                    if(count($price) > 0) {
                        if(strlen($str) > 0)
                            $str .= " or ";
                        $i = 1;
                        foreach($price as $p) {
                            if($p == 1) 
                                $str .= " price between 0 and 500 ";
                            if($p == 2) 
                                $str .= " price between 501 and 1500";
                            if($p == 3) 
                                $str .= " price between 1501 and 2500";
                            if($p == 4) 
                                $str .= " price between 2501 and 3500";
                            if($p == 5) 
                                $str .= " price > 3500";
                            if(count($price) > 1 && $i != count($price))
                                $str .= " or ";
                            $i++;
                            
                        }       
                    }
                    if(count($calories) > 0) {
                        if(strlen($str) > 0)
                            $str .= " or ";
                        $i = 1;
                        foreach($calories as $c) {
                            if($c == 1) 
                                $str .= " calories between 0 and 500 ";
                            if($c == 2) 
                                $str .= " calories between 501 and 1500";
                            if($c == 3) 
                                $str .= " calories between 1501 and 2500";
                            if($c == 4) 
                                $str .= " calories between 2501 and 3500";
                            if($c == 5) 
                                $str .= " calories > 3500";
                            if(count($calories) > 1 && $i != count($calories))
                                $str .= " or ";
                            $i++;
                        }       
                    }
                    $packages = base64_encode(json_encode($packageModel->getAllPackages('*','packages',"WHERE {$str}")));
                    $filter = json_encode(['search' => $search,'price' => $price , 'calories' => $calories]);
                    header("location: ../packages.php?filters={$filter}&packages={$packages}" );

                }
            }
        }
    }

    public function subscribePackage($id) {
        include_once('../models/Package.php');
        $user_id = $_SESSION['user']['id'];
        $package = new Package();
        $success = $package->subscribePackage($user_id,$id);
        if($success) {
            $_SESSION['msg'] = "Package has been successfully subscribed";
            header('location: Controller.php?do=showUserSubscribes');
        }
    }


    public function showAllPackages() {
        include_once('../models/Package.php');
        $restaurant_id = $_SESSION['restaurant']['id'];
        $packageModel = new Package();
        $packages = base64_encode(json_encode($packageModel->getAllPackages('*','packages','where restaurant_id ='.$restaurant_id)));
        header("location: ../restaurants/packages.php?packages={$packages}" );
    }


    public function createPackage () {
        include_once('../models/Meal.php');
        $restaurant_id = $_SESSION['restaurant']['id'];
        $mealModel = new Meal();
        $meals = $mealModel->getAllMeals('*','meals','where restaurant_id ='.$restaurant_id,null,'id','ASC');
        $encoded = base64_encode(json_encode($meals));
        if(count($meals) > 0) 

            header("location: ../restaurants/add_package.php?meals={$encoded}" );
        else 
            header("location: ../restaurants/" );

    }

    public function storePackage () {
        include_once('../models/Package.php');
        include_once('../models/Meal.php');

        $restaurant_id = $_SESSION['restaurant']['id'];
        $mealModel = new Meal();
        $meals = $mealModel->getAllMeals('*','meals','where restaurant_id ='.$restaurant_id,null,'id','ASC');
        $meals = base64_encode(json_encode($meals));
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['Add_Package'])) {
                $name=trim($_POST['name']);
                $calories = trim($_POST['calories']);
                $price = trim($_POST['price']);
                $mealsSelected = $_POST['meals'];
                $details = trim($_POST['details']);
                $photoName = $_FILES['image']['name'];
                $error=[];
                if (empty($name)) {
                    array_push($error,"name required");
                } 
                if (!empty($name) && is_numeric($name)) {
                    array_push($error,"name must be contains letters (not number only)");
                } 
                
                if (empty($calories)) {
                    array_push($error,"calories required");
                }
                if (!empty($calories) && (!is_numeric($calories) || $calories < 0)) {
                    array_push($error,"calories must be number and greater than 0");
                } 
                if (empty($price)) {
                    array_push($error,"price required");
                }
                if (!empty($price) && (!is_numeric($price) || $price < 0)) {
                    array_push($error,"price must be number and greater than 0");
                } 
                
                if (empty($details)) {
                    array_push($error,"details required");
                } 
                if (empty($photoName)) { 
                    array_push($error,"photo required");
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
                }

                $olddata = [
                    'calories'=>$calories,
                    'name'=>$name,
                    'price'=>$price ,
                    'details'=>$details,
                    'meals'=> $mealsSelected,
                    'photo' => $photoName,
                    'restaurant_id' => $restaurant_id
                ];

                $dataInserted = [
                    'calories'=>$calories,
                    'name'=>$name,
                    'price'=>$price ,
                    'details'=>$details,
                    'photo' => $photoName,
                    'restaurant_id' => $restaurant_id
                ];

                $encoded= json_encode($olddata);
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: ../restaurants/add_package.php?errors={$error}&data={$encoded}&meals={$meals}" );
                    exit();
                }
                $package = new package();
                $package_id = $package->insert($dataInserted,$mealsSelected);
                if($package_id) {
                    $path = '../uploads/packages/'.$package_id;
                    if(!is_dir($path)) {
                        mkdir($path);
                    }
                    move_uploaded_file($photoTmp, '../uploads/packages/'.$package_id.'/'. $photoName);
                    $_SESSION['msg'] = "Package Added successfully ";

                    $this->showAllPackages();
                }
                
            } 
        }
    }

    public function editPackage ($id) {
        include_once('../models/Package.php');
        include_once('../models/Meal.php');

        $restaurant_id = $_SESSION['restaurant']['id'];
        $mealModel = new Meal();
        $meals = $mealModel->getAllMeals('*','meals','where restaurant_id ='.$restaurant_id,null,'id','ASC');
        $packageModel = new package();
        $package = $packageModel->getPackageById($id);
        $packagemeals = $packageModel->getPackageMeals($id);
        $data = base64_encode(json_encode(['package' => $package , 'meals' => $meals , 'packagemaels' => $packagemeals]));
        header("location: ../restaurants/update_package.php?data={$data}" );
    }

    public function updatePackage () {
        include_once('../models/Package.php');
        include_once('../models/Meal.php');

        $restaurant_id = $_SESSION['restaurant']['id'];
        $mealModel = new Meal();
        $meals = $mealModel->getAllMeals('*','meals','where restaurant_id ='.$restaurant_id,null,'id','ASC');
        $meals = base64_encode(json_encode($meals));
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['update_Package'])) {
                $package_id=trim($_POST['id']);
                $name=trim($_POST['name']);
                $calories = trim($_POST['calories']);
                $price = trim($_POST['price']);
                $mealsSelected = $_POST['meals'];
                $details = trim($_POST['details']);
                $photoName = $_FILES['image']['name'];
                $packageModel = new Package();
                $package = $packageModel->getPackageById($package_id);
                $photo = $package['photo'];
                $error=[];
                if (empty($name)) {
                    array_push($error,"name required");
                } 
                if (!empty($name) && is_numeric($name)) {
                    array_push($error,"name must be contains letters (not number only)");
                } 
                
                if (empty($calories)) {
                    array_push($error,"calories required");
                }
                if (!empty($calories) && (!is_numeric($calories) || $calories < 0)) {
                    array_push($error,"calories must be number and greater than 0");
                } 
                if (empty($price)) {
                    array_push($error,"price required");
                }
                if (!empty($price) && (!is_numeric($price) || $price < 0)) {
                    array_push($error,"price must be number and greater than 0");
                } 
                
                if (empty($details)) {
                    array_push($error,"details required");
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
                    $path = '../uploads/packages/'.$package_id;

                }

                $olddata = [
                    'calories'=>$calories,
                    'name'=>$name,
                    'price'=>$price ,
                    'details'=>$details,
                    'meals'=> $mealsSelected,
                    'photo'=>!empty($photoName) ? $photoName : $photo,
                    'id' => $package_id
                ];

                $dataInserted = [
                    'calories'=>$calories,
                    'name'=>$name,
                    'price'=>$price ,
                    'details'=>$details,
                    'photo'=>!empty($photoName) ? $photoName : $photo,
                    'id' => $package_id
                ];

                $encoded= json_encode($olddata);
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: ../restaurants/update_package.php?errors={$error}&data={$encoded}&meals={$meals}" );
                    exit();
                }

                $package = new package();
                $success = $package->updatePackage($dataInserted,$mealsSelected);
                if($success) {
                    if(!empty($photoName)) {
                        $path = '../uploads/packages/'.$package_id;
                        if(!is_dir($path)) {
                            mkdir($path);
                        }
                        unlink($path.'/'.$photoName);
                        move_uploaded_file($photoTmp, '../uploads/packages/'.$package_id.'/'. $photoName);
                    } 
                    $_SESSION['msg'] = "Package Updated successfully ";
                    $this->showAllPackages();
                }
                
            } 
        }
    }


    public function delPackage($id) {
        include_once('../models/Package.php');
        $error =[];
        $package = new Package();
        $subscribes = $package->getAllSubscribes($id);
        foreach($subscribes as $subscribe) {
            $endDate = new DateTime($subscribe['end']);
            $now = new DateTime();
            if($endDate > $now) {
                $error[] = "Connot delete Package , there is User subscribed it and his subscription ended at {$subscribe['end']}";
            } 
        }
        if(!empty($error)) {
            $error=json_encode($error);
            header('location: ../restaurants/errors.php?errors='.$error);
        } else {
            $package->delSubscribtion($id);
            $package->delRates($id);
            $package->delpackageMeals($id);
            $success = $package->delete($id);
            if($success) {
                $dirname="../uploads/packages/{$id}";
                array_map("unlink", glob("$dirname/*"));
                array_map("rmdir", glob("$dirname/*"));
                rmdir($dirname);
                $_SESSION['msg'] = "Package deleted successfully ";
                $this->showAllPackages();
            }
        }
    }

}