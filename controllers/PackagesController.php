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

}