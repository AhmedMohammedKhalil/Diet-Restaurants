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

    public function getMael($id) {

        $get = $this->con->prepare("SELECT * FROM meals where id = $id");

		$get->execute();

		$meal = $get->fetchAll(PDO::FETCH_ASSOC);

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
}