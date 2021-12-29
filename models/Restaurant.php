<?php 
include_once('connect.php');
class Restaurant{
    protected $con;
    public function __construct()
    {
        $db = new DB();
        $this->con = $db->connect();
    }

    public function getRestaurantAndLogin($data) {
        extract($data);
        $encoded = json_encode($data);
        $query = $this->con->prepare("SELECT * FROM restaurants WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            $error=json_encode(["this email not found"]);
            header("location: ../restaurants/login.php?errors={$error}&data={$encoded} " );
            exit();
        } else if(!password_verify($password, $result['password'])){
            $error=json_encode(["Wrong password"]);
            header("location: ../restaurants/login.php?errors={$error}&data={$encoded} " );
            exit();
        } else {
            $_SESSION['restaurant'] = $result;    
            $_SESSION['username'] = $result['name'];
            $_SESSION['type'] ="restaurant";
            header('location: ../index.php' );
            exit();
        }
    }

    public function insert($data) {
        extract($data);
        $encoded = json_encode($data);
        $query = $this->con->prepare("SELECT * FROM restaurants WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($query->rowCount() > 0) {
            $error= json_encode(['email is exist']);
            header("location: ../restaurants/register.php?errors={$error}&data={$encoded} " );
            exit();
        } 
        else
        {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $query = $this->con->prepare("INSERT INTO restaurants(name,email,password,owner_name,phone,address,description) 
                                    VALUES (:name,:email,:password_hash,:owner_name,:phone,:address,:description)");
            $query->bindParam("name", $name, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
            $query->bindParam("owner_name", $owner_name, PDO::PARAM_STR);
            $query->bindParam("phone", $phone, PDO::PARAM_STR);
            $query->bindParam("address", $address, PDO::PARAM_STR);
            $query->bindParam("description", $description, PDO::PARAM_STR);
            $successed = $query->execute();
            if($successed){
                $_SESSION['restaurant'] = $data;    
                $_SESSION['username'] = $data['name'];
                $_SESSION['type'] ="restaurant";

                header('location: ../index.php' );
                exit();
            }else{
                $error=json_encode(["sever error exist"]);
                header("location: ../restaurants/register.php?errors={$error}&data={$encoded}" );
                exit();
            }
        }
    }
    
    public function getLatest($select, $table, $order = 'id',$limited = true, $limit = 10) {

        if($limited)
		    $getStmt = $this->con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
        else
            $getStmt = $this->con->prepare("SELECT $select FROM $table ORDER BY $order DESC");
		$getStmt->execute();

		$rows = $getStmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;

	}

    function getAllRestaurant($field, $table, $where = NULL, $and = NULL, $orderfield = 'id', $ordering = "DESC") {

		$getAll = $this->con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

		$getAll->execute();

		$all = $getAll->fetchAll(PDO::FETCH_ASSOC);

		return $all;

	}
}