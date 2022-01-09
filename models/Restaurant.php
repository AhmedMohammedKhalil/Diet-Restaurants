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
                $query = $this->con->prepare("SELECT * FROM restaurants WHERE email=:email");
                $query->bindParam("email", $email, PDO::PARAM_STR);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $_SESSION['restaurant'] = $result;    
                $_SESSION['username'] = $result['name'];
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

    public function getRestaurant($id) {

        $get = $this->con->prepare("SELECT * FROM restaurants where id = $id");

		$get->execute();

		$res = $get->fetchAll(PDO::FETCH_ASSOC);

		return $res;
    }
    public function getRateForUser($res_id,$user_id) {
        $get = $this->con->prepare("SELECT * FROM rates where type='restaurant' and type_id = $res_id and user_id = $user_id");

		$get->execute();

		$res = $get->fetchAll(PDO::FETCH_ASSOC);

		return $res;
    }

    public function getAllRates($res_id) {
        $getall = $this->con->prepare("SELECT * FROM rates where type='restaurant' and type_id = $res_id");

		$getall->execute();

		$rates = $getall->fetchAll(PDO::FETCH_ASSOC);

		return $rates;
    }

    public function addRate($res_id,$user_id,$rating,$where) {
        if($where != '')
        {
            $query = $this->con->prepare("UPDATE rates SET rating=:rating {$where}");
            $query->bindParam("rating", $rating, PDO::PARAM_STR);
            $successed = $query->execute();
        } else {
            $query = $this->con->prepare("INSERT INTO rates(type_id,user_id,rating,type) 
                                    VALUES (:res_id,:user_id,:rating,'restaurant')");
            $query->bindParam("res_id", $res_id, PDO::PARAM_STR);
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->bindParam("rating", $rating, PDO::PARAM_STR);
            $successed = $query->execute();
        }
        return $successed;
    }

    public function updateRate($count_rating,$res_id) {

        $query = $this->con->prepare("UPDATE restaurants SET count_rating=:count_rating WHERE id={$res_id}");
        $query->bindParam("count_rating", $count_rating, PDO::PARAM_STR);
        $successed = $query->execute();
        return $successed;
    }


    public function update($res_id,$data) {
        extract($data);
        
        //$address = nl2br($address);
        $query = $this->con->prepare("UPDATE restaurants SET name = :name , email = :email , address = :address , owner_name = :owner_name , phone = :phone , description = :description , photo = :photo WHERE id={$res_id}");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("address", $address, PDO::PARAM_STR);
        $query->bindParam("owner_name", $owner_name, PDO::PARAM_STR);
        $query->bindParam("phone", $phone, PDO::PARAM_STR);
        $query->bindParam("description", $description, PDO::PARAM_STR);
        $query->bindParam("photo", $photo, PDO::PARAM_STR);
        $successed = $query->execute();
        return $successed;
    }

   

    public function changePassword($restaurant_id,$data) {
        extract($data);
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $query = $this->con->prepare("UPDATE restaurants SET password=:hash WHERE id={$restaurant_id}");
        $query->bindParam("hash", $hash, PDO::PARAM_STR);
        $successed = $query->execute();
        return $successed;
    }

    public function getAllOrders($res_id) {
        $query = $this->con->prepare("SELECT U.name as u_name , U.id as u_id  , M.* 
                                    from meals M,restaurants R,users U,user_meals UM 
                                    where R.id = :res_id and U.id = UM.user_id and M.id = UM.meal_id 
                                    and R.id = M.restaurant_id
                                    ");
        $query->bindParam("res_id", $res_id, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllSubscribes($res_id) {
        $query = $this->con->prepare("SELECT  U.name as u_name , U.id as u_id ,P.name as pack_name , US.*
                                    from packages P,restaurants R,users U,user_subscripes US 
                                    where R.id = :res_id and U.id = US.user_id and P.id = US.package_id 
                                    and R.id = P.restaurant_id
                                    ");
        $query->bindParam("res_id", $res_id, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}