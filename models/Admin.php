<?php 
include_once('connect.php');
class Admin{
    protected $con;
    public function __construct()
    {
        $db = new DB();
        $this->con = $db->connect();
    }

    

    public function getAdminAndLogin($data) {
        extract($data);
        $encoded = json_encode($data);
        $query = $this->con->prepare("SELECT * FROM admins WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            $error=json_encode(["this email not found"]);
            header("location: ../admin/login.php?errors={$error}&data={$encoded}" );
            exit();
        } else if(!password_verify($password, $result['password'])){
            $error=json_encode(["Wrong password"]);
            header("location: ../admin/login.php?errors={$error}&data={$encoded}" );
            exit();
        } else {
            $_SESSION['admin'] = $result;    
            $_SESSION['username'] = $result['name'];
            $_SESSION['type'] ="admin";
            unset($_SESSION['CAPTCHA_CODE']);
            $_SESSION['msg'] = "Admin Login Successfuly";
            header('location: ../index.php' );
            exit();
        }
    }

    public function update($admin_id,$data) {
        extract($data);
        //$address = nl2br($address);
        $query = $this->con->prepare("UPDATE admins SET name=:name , email = :email WHERE id={$admin_id}");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $successed = $query->execute();
        return $successed;
    }


    public function changePassword($admin_id,$data) {
        extract($data);
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $query = $this->con->prepare("UPDATE admins SET password=:hash WHERE id={$admin_id}");
        $query->bindParam("hash", $hash, PDO::PARAM_STR);
        $successed = $query->execute();
        return $successed;
    }

    public function getAllOrders() {
        $query = $this->con->prepare("SELECT R.name as res_name  , M.* , U.name as user_name , U.id as user_id 
                                    from meals M,restaurants R,users U,user_meals UM 
                                    where U.id = UM.user_id and M.id = UM.meal_id 
                                    and R.id = M.restaurant_id
                                    ");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllRestaurants() {
        $query = $this->con->prepare("SELECT * FROM restaurants");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllUsers() {
        $query = $this->con->prepare("SELECT * FROM users");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllSubscribes() {
        $query = $this->con->prepare("SELECT R.name as res_name , R.id as res_id  , P.name as pack_name , US.* , U.name as user_name , U.id as user_id
                                    from packages P,restaurants R,users U,user_subscripes US 
                                    where  U.id = US.user_id and P.id = US.package_id 
                                    and R.id = P.restaurant_id
                                    ");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    

    public function getUser($id) {
        
        $get = $this->con->prepare("SELECT * FROM users where id = $id");

		$get->execute();

		$user = $get->fetch(PDO::FETCH_ASSOC);

		return $user;
    }
}