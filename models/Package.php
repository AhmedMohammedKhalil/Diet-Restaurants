<?php 
include_once('connect.php');
class Package{
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


    function getAllPackages($field, $table, $where = NULL, $and = NULL, $orderfield = 'id', $ordering = "DESC") {

		$getAll = $this->con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

		$getAll->execute();

		$all = $getAll->fetchAll(PDO::FETCH_ASSOC);

		return $all;

	}

    public function getPackage($id) {

        $get = $this->con->prepare("SELECT * FROM packages where id = $id");

		$get->execute();

		$package = $get->fetchAll(PDO::FETCH_ASSOC);

		return $package;
    }
    public function getRateForUser($package_id,$user_id) {
        $get = $this->con->prepare("SELECT * FROM rates where type='package' and type_id = $package_id and user_id = $user_id");

		$get->execute();

		$package = $get->fetchAll(PDO::FETCH_ASSOC);

		return $package;
    }

    public function getAllRates($package_id) {
        $getall = $this->con->prepare("SELECT * FROM rates where type='package' and type_id = $package_id");

		$getall->execute();

		$rates = $getall->fetchAll(PDO::FETCH_ASSOC);

		return $rates;
    }

    public function addRate($package_id,$user_id,$rating,$where) {
        if($where != '')
        {
            $query = $this->con->prepare("UPDATE rates SET rating=:rating {$where}");
            $query->bindParam("rating", $rating, PDO::PARAM_STR);
            $successed = $query->execute();
        } else {
            $query = $this->con->prepare("INSERT INTO rates(type_id,user_id,rating,type) 
                                    VALUES (:package_id,:user_id,:rating,'package')");
            $query->bindParam("package_id", $package_id, PDO::PARAM_STR);
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->bindParam("rating", $rating, PDO::PARAM_STR);
            $successed = $query->execute();
        }
        return $successed;
    }

    public function updateRate($count_rating,$package_id) {

        $query = $this->con->prepare("UPDATE packages SET count_rating=:count_rating WHERE id={$package_id}");
        $query->bindParam("count_rating", $count_rating, PDO::PARAM_STR);
        $successed = $query->execute();
        return $successed;
    }


    public function subscribePackage($user_id,$package_id) {

        $start = date('d/m/Y');
        $end = date('d/m/Y', strtotime("+30 days"));
        $query = $this->con->prepare("INSERT INTO user_subscripes(user_id,package_id,start,end) 
                                    VALUES (:user_id,:package_id,:start,:end)");
        $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $query->bindParam("package_id", $package_id, PDO::PARAM_STR);
        $query->bindParam("start", $start, PDO::PARAM_STR);
        $query->bindParam("end", $end, PDO::PARAM_STR);
        $successed = $query->execute();
        return $successed;
    }

    public function insert($data,$meals) {
        $dataInserted = array_values($data);
        $query = $this->con->prepare("INSERT INTO packages(calories,name,price,details,photo,restaurant_id) 
                                    VALUES (?,?,?,?,?,?)");
        $query->execute($dataInserted);
        $id = $this->con->lastInsertId();
        foreach($meals as $m) {
            $query = $this->con->prepare("INSERT INTO package_meals(package_id,meal_id) 
                                    VALUES ({$id},{$m})");
            $query->execute();
        }
        return $id;                    
    }

    public function getPackageById($id) {

        $get = $this->con->prepare("SELECT * FROM packages where id = $id");

		$get->execute();

		$package = $get->fetch(PDO::FETCH_ASSOC);

		return $package;
    }
    public function getPackageMeals($id) {
        
        $get = $this->con->prepare("SELECT * FROM package_meals where package_id = $id");

		$get->execute();

		$packagemeals = $get->fetchAll(PDO::FETCH_ASSOC);

		return $packagemeals;
    }

    public function updatePackage($data,$meals) {
        $dataupdated = array_values($data);
        extract($data);
        $query = $this->con->prepare("UPDATE packages SET calories = ? , name = ? , price = ? , details = ? , photo = ? 
                        where id = ? ");
        $success = $query->execute($dataupdated);
        if($success) {
            $this->delPackageMeals($id);
            foreach($meals as $m) {
                $query = $this->con->prepare("INSERT INTO package_meals(package_id,meal_id) 
                                        VALUES ({$id},{$m})");
                $query->execute();
            }
        }
        return $success;
    }

    public function delPackageMeals($id) {
        $query = $this->con->prepare("Delete from package_meals where package_id = {$id}");
		$query->execute();
    }

    public function getAllSubscribes($id) {
        $get = $this->con->prepare("SELECT * FROM user_subscripes where package_id = $id");

		$get->execute();

		$subscribes = $get->fetchAll(PDO::FETCH_ASSOC);

        return $subscribes;
    }

    public function delSubscribtion($id) {
        $query = $this->con->prepare("Delete from user_subscripes where package_id = {$id}");
		$query->execute();
    }

    public function delRates($id) {
        $get = $this->con->prepare("DELETE FROM rates
                            WHERE type = 'package' and type_id = $id");
        $get->execute();
    }

    public function delete($id) {
        $query = $this->con->prepare("Delete from packages where id = {$id}");
		$success = $query->execute();
        return $success;
    }

}

