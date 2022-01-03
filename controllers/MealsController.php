<?php
class MealsController {

    public function rate($id) {
        include_once('../models/Restaurant.php');
        include_once('../models/Meal.php');

        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['Make_Rate'])) {
                $res = new Restaurant();
                $mealModel = new Meal();
                $meal = $mealModel->getAllMeals('*','meals',"where id ={$id}");
                $restaurant = $res->getAllRestaurant('*','restaurants',"where id ={$meal[0]['restaurant_id']}");
                $user_id = $_SESSION['user']['id'];
                $rate = trim($_POST['rate']);
                $data = [
                    'rate'=>$rate,
                    'meal'=>$meal,
                    'restaurant' => $restaurant
                ];
                $encoded = base64_encode(json_encode($data));
                $userRate = $mealModel->getRateForUser($id,$user_id);
                $where = '';
                if(count($userRate) > 0) {
                    $user_id = intval($user_id);
                    $where = "WHERE user_id =$user_id and type='meal' and type_id =$id"; 
                }
                $success = $mealModel->addRate($id,$user_id,$rate,$where);
                if(!$success) {
                    $error=json_encode(["sever error exist"]);
                    header("location: ../meal_details.php?errors={$error}&data={$encoded}" );
                    exit();
                }
                $id = intval($id);
                if($meal[0]['count_rating'] == 0) {
                    $success = $mealModel->updateRate($rate,$id);
                } else {
                    $AllRates = $mealModel->getAllRates($id);
                    $sum = 0;
                    foreach($AllRates as $rate) {
                        $sum += $rate['rating'];
                    }
                    $rate_count = $sum / count($AllRates);
                    $success = $mealModel->updateRate($rate_count,$id);
                }
                if($success) {
                    $meal = $mealModel->getAllMeals('*','meals',"where id ={$id}");
                    $data = [
                        'rate'=>$rate,
                        'meal'=>$meal,
                        'restaurant' => $restaurant
                    ];
                    $encoded = base64_encode(json_encode($data));
                    header("location: ../meal_details.php?data={$encoded}" );
                    exit();
                }
                   

            }
        }
    }

    public function makeFilter() {
        include_once('../models/Meal.php');

        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['Filter'])) { 
                $mealModel = new Meal();
                $search = trim($_POST['search']) ?? '';
                $price = $_POST['price'] ?? [];
                $calories = $_POST['calories'] ?? [];
                $meals = $mealModel->getLatest('*','meals','id',false);
                $encoded = base64_encode(json_encode($meals));
              
                if(empty($search) && count($price) == 0 && count($calories) == 0) {
                    $error=json_encode(["Not Data Enterd for Filter"]);
                    header("location: ../meals.php?errors={$error}&meals={$encoded}" );
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
                    $meals = base64_encode(json_encode($mealModel->getAllMeals('*','meals',"WHERE {$str}")));
                    $filter = json_encode(['search' => $search,'price' => $price , 'calories' => $calories]);
                    header("location: ../meals.php?filters={$filter}&meals={$meals}" );

                }
            }
        }
    }
}