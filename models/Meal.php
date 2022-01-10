<?php 
include_once('connect.php');
class Meal{
    protected $con;
    public function __construct()
    {
        $db = new DB();
        $this->con = $db->connect();
    }

    public function getLatest($select, $table, $order,$limited = true, $limit = 10) {

        if($limited)
		    $getStmt = $this->con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
        else
            $getStmt = $this->con->prepare("SELECT $select FROM $table ORDER BY $order DESC");
		$getStmt->execute();

		$rows = $getStmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;

	}


    public function getAllMeals($field, $table, $where = NULL, $and = NULL, $orderfield = 'id', $ordering = "DESC") {

		$getAll = $this->con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

		$getAll->execute();

		$all = $getAll->fetchAll(PDO::FETCH_ASSOC);

		return $all;

	}

    public function getAllMealsForPackage($id) {
        $getAll = $this->con->prepare("SELECT m.* 
                                    FROM meals m 
                                    JOIN package_meals pm ON m.id = pm.meal_id 
                                    Join packages p ON pm.package_id = p.id 
                                    WHERE p.id = $id");
        $getAll->execute();

        $all = $getAll->fetchAll(PDO::FETCH_ASSOC);

        return $all;

    }

    public function getMeal($id) {

        $get = $this->con->prepare("SELECT * FROM meals where id = $id");

		$get->execute();

		$meal = $get->fetch(PDO::FETCH_ASSOC);

		return $meal;
    }

    public function getRateForUser($meal_id,$user_id) {
        $get = $this->con->prepare("SELECT * FROM rates where type='meal' and type_id = $meal_id and user_id = $user_id");

		$get->execute();

		$meal = $get->fetchAll(PDO::FETCH_ASSOC);

		return $meal;
    }

    public function getAllRates($meal_id) {
        $getall = $this->con->prepare("SELECT * FROM rates where type='meal' and type_id = $meal_id");

		$getall->execute();

		$rates = $getall->fetchAll(PDO::FETCH_ASSOC);

		return $rates;
    }

    public function addRate($meal_id,$user_id,$rating,$where) {
        if($where != '')
        {
            $query = $this->con->prepare("UPDATE rates SET rating=:rating {$where}");
            $query->bindParam("rating", $rating, PDO::PARAM_STR);
            $successed = $query->execute();
        } else {
            $query = $this->con->prepare("INSERT INTO rates(type_id,user_id,rating,type) 
                                    VALUES (:meal_id,:user_id,:rating,'meal')");
            $query->bindParam("meal_id", $meal_id, PDO::PARAM_STR);
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->bindParam("rating", $rating, PDO::PARAM_STR);
            $successed = $query->execute();
        }
        return $successed;
    }

    public function updateRate($count_rating,$meal_id) {

        $query = $this->con->prepare("UPDATE meals SET count_rating=:count_rating WHERE id={$meal_id}");
        $query->bindParam("count_rating", $count_rating, PDO::PARAM_STR);
        $successed = $query->execute();
        return $successed;
    }

    public function orderMeal($user_id,$meal_id) {
        $query = $this->con->prepare("INSERT INTO user_meals(user_id,meal_id) 
                                    VALUES (:user_id,:meal_id)");
        $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $query->bindParam("meal_id", $meal_id, PDO::PARAM_STR);
        $successed = $query->execute();
        return $successed;
    }


    public function insert($data) {
        $dataInserted = array_values($data);
        $query = $this->con->prepare("INSERT INTO meals(calories,name,price,weight,details,photo,restaurant_id) 
                                    VALUES (?,?,?,?,?,?,?)");
        $query->execute($dataInserted);
        $id = $this->con->lastInsertId();
        return $id;                    
    }

    public function updateMeal($data) {
        $dataupdated = array_values($data);
        $query = $this->con->prepare("UPDATE meals SET calories = ? , name = ? , price = ? , weight = ? , details = ? , photo = ? 
                        where id = ? ");
        $success = $query->execute($dataupdated);
        return $success;
    }


    public function getAllpackages($id) {

        $get = $this->con->prepare("SELECT p.* 
                                    FROM packages p 
                                    JOIN package_meals pm ON p.id = pm.package_id 
                                    Join meals m ON pm.meal_id = m.id 
                                    WHERE m.id = $id");

		$get->execute();

		$packages = $get->fetchAll(PDO::FETCH_ASSOC);

		return $packages;
    }

    public function getCountMealInPackage($id) {
        $get = $this->con->prepare("SELECT count(*) as count
                                    FROM package_meals
                                    WHERE package_id = $id");

        $get->execute();

        $packages = $get->fetch(PDO::FETCH_ASSOC);
        $count = $packages['count'];
        return $count;
    }

    public function delPackages($id) {
        $get = $this->con->prepare("DELETE FROM package_meals 
                            WHERE meal_id = $id");
        $get->execute();
    }

    public function delRates($id) {
        $get = $this->con->prepare("DELETE FROM rates
                            WHERE type = 'meal' and type_id = $id");
        $get->execute();
    }

    public function delUserMeal($id) {
        $get = $this->con->prepare("DELETE FROM user_meals
                            WHERE meal_id = $id");
        $get->execute();
    }

    public function delete($id) {
        $get = $this->con->prepare("DELETE FROM meals 
                            WHERE id = $id");
        $success = $get->execute();
        return $success;
    }
}