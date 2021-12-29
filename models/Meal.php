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


    function getAllMeals($field, $table, $where = NULL, $and = NULL, $orderfield = 'id', $ordering = "DESC") {

		$getAll = $this->con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

		$getAll->execute();

		$all = $getAll->fetchAll(PDO::FETCH_ASSOC);

		return $all;

	}

    function getAllMealsForPackage($id) {
        $getAll = $this->con->prepare("SELECT m.* 
                                    FROM meals m 
                                    JOIN package_meals pm ON m.id = pm.meal_id 
                                    Join packages p ON pm.package_id = p.id 
                                    WHERE p.id = $id");
        $getAll->execute();

        $all = $getAll->fetchAll(PDO::FETCH_ASSOC);

        return $all;

    }
}