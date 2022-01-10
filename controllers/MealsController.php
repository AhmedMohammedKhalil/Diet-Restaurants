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


    public function buyMeal($id) {
        include_once('../models/Meal.php');
        $user_id = $_SESSION['user']['id'];
        $meal = new Meal();
        $success = $meal->orderMeal($user_id,$id);
        if($success) {
            header('location: Controller.php?do=showUserOrders');
        }
    }

    public function showAllMeals() {
        include_once('../models/Meal.php');
        $mealModel = new Meal();
        $meals = base64_encode(json_encode($mealModel->getAllMeals('*','meals')));
        header("location: ../restaurants/meals.php?meals={$meals}" );
    }


    public function createMeal () {
        header("location: ../restaurants/add_meal.php" );
    }

    public function storeMeal () {
        include_once('../models/Meal.php');
        $restaurant_id = $_SESSION['restaurant']['id'];
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['Add_Meal'])) {
                $name=trim($_POST['name']);
                $calories = trim($_POST['calories']);
                $price = trim($_POST['price']);
                $weight = trim($_POST['weight']);
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
                if (!empty($calories) && !is_numeric($calories)) {
                    array_push($error,"calories must be number");
                } 
                if (empty($price)) {
                    array_push($error,"price required");
                }
                if (!empty($price) && !is_numeric($price)) {
                    array_push($error,"price must be number");
                } 
                if (empty($weight)) {
                    array_push($error,"weight required");
                }
                if (!empty($weight) && !is_numeric($weight)) {
                    array_push($error,"weight must be number");
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

                $data = [
                    'calories'=>$calories,
                    'name'=>$name,
                    'price'=>$price ,
                    'weight'=>$weight ,
                    'details'=>$details,
                    'photo' => $photoName,
                    'restaurant_id' => $restaurant_id
                ];

                $encoded= json_encode($data);
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: ../restaurants/add_meal.php?errors={$error}&data={$encoded}" );
                    exit();
                }
                $meal = new Meal();
                $meal_id = $meal->insert($data);
                if($meal_id) {
                    $path = '../uploads/meals/'.$meal_id;
                    if(!is_dir($path)) {
                        mkdir($path);
                    }
                    move_uploaded_file($photoTmp, '../uploads/meals/'.$meal_id.'/'. $photoName);
                    $this->showAllMeals();
                }
                
            } 
        }
    }

    public function editMeal ($id) {
        include_once('../models/Meal.php');
        $mealModel = new Meal();
        $meal = base64_encode(json_encode($mealModel->getMeal($id)));
        header("location: ../restaurants/update_meal.php?meal={$meal}" );
    }

    public function updateMeal () {
        include_once('../models/Meal.php');
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['update_Meal'])) {
                $meal_id = trim($_POST['id']);
                $name=trim($_POST['name']);
                $calories = trim($_POST['calories']);
                $price = trim($_POST['price']);
                $weight = trim($_POST['weight']);
                $details = trim($_POST['details']);
                $photoName = $_FILES['image']['name'];
                $mealModel = new Meal();
                $meal = $mealModel->getMeal($meal_id);
                $photo = $meal['photo'];
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
                if (!empty($calories) && !is_numeric($calories)) {
                    array_push($error,"calories must be number");
                } 
                if (empty($price)) {
                    array_push($error,"price required");
                }
                if (!empty($price) && !is_numeric($price)) {
                    array_push($error,"price must be number");
                } 
                if (empty($weight)) {
                    array_push($error,"weight required");
                }
                if (!empty($weight) && !is_numeric($weight)) {
                    array_push($error,"weight must be number");
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

                    $path = '../uploads/meals/'.$meal_id;
                    
                }

                $data = [
                    'calories'=>$calories,
                    'name'=>$name,
                    'price'=>$price ,
                    'weight'=>$weight ,
                    'details'=>$details,
                    'photo' => !empty($photoName) ? $photoName : $photo,
                    'id' => $meal_id,
                ];

                $encoded= json_encode($data);
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: ../restaurants/update_meal.php?errors={$error}&data={$encoded}" );
                    exit();
                }
                $success = $mealModel->updateMeal($data);
                if($success) {
                    if( !empty($photoName)) {
                        unlink($path.'/'.$photo);
                        move_uploaded_file($photoTmp, $path.'/'. $photoName);
                    } 
                    $this->showAllMeals();
                }
                



                
            } 
        }
    }

    public function delMeal($id) {
        include_once('../models/Meal.php');
        $error =[];
        $meal = new Meal();
        $packages = $meal->getAllpackages($id);
        foreach($packages as $package) {
            $count = $meal->getCountMealInPackage($package['id']);
            if($count == 1) {
                $error[] = "Connot delete Meal ,{$package['name']} is related with it";
            } 
        }
        if(!empty($error)) {
            $error=json_encode($error);
            header('location: ../restaurants/errors.php?errors='.$error);
        } else {
            $meal->delPackages($id);
            $meal->delRates($id);
            $meal->delUserMeal($id);
            $success = $meal->delete($id);
            if($success) {
                $this->showAllMeals();
            }
        }
    }



}