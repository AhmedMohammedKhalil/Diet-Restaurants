<?php 
include_once('connect.php');
class User{
    protected $con;
    public function __construct()
    {
        $db = new DB();
        $this->con = $db->connect();
    }

    public function insert($data) {
        extract($data);
        $encoded = json_encode($data);
        $query = $this->con->prepare("SELECT * FROM users WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($query->rowCount() > 0) {
            $error= json_encode(['email is exist']);
            header("location: ../user/register.php?errors={$error}&data={$encoded} " );
            exit();
        } 
        else
        {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $query = $this->con->prepare("INSERT INTO users(name,email,password,address) 
                                    VALUES (:name,:email,:password_hash,:address)");
            $query->bindParam("name", $name, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
            $query->bindParam("address", $address, PDO::PARAM_STR);
            $successed = $query->execute();
            if($successed){
                $query = $this->con->prepare("SELECT * FROM users WHERE email=:email");
                $query->bindParam("email", $email, PDO::PARAM_STR);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user'] = $result;    
                $_SESSION['username'] = $result['name'];
                $_SESSION['type'] ="user";
                unset($_SESSION['CAPTCHA_CODE']);

                header('location: ../index.php' );
                exit();
            }else{
                $error=json_encode(["sever error exist"]);
                header("location: ../user/register.php?errors={$error}&data={$encoded}" );
                exit();
            }
        }
    }

    public function getUserAndLogin($data) {
        extract($data);
        $encoded = json_encode($data);
        $query = $this->con->prepare("SELECT * FROM users WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            $error=json_encode(["this email not found"]);
            header("location: ../user/login.php?errors={$error}&data={$encoded} " );
            exit();
        } else if(!password_verify($password, $result['password'])){
            $error=json_encode(["Wrong password"]);
            header("location: ../user/login.php?errors={$error}&data={$encoded} " );
            exit();
        } else {
            $_SESSION['user'] = $result;    
            $_SESSION['username'] = $result['name'];
            $_SESSION['type'] ="user";
            unset($_SESSION['CAPTCHA_CODE']);

            header('location: ../index.php' );
            exit();
        }
    }

    public function update($user_id,$data) {
        extract($data);
        //$address = nl2br($address);
        $query = $this->con->prepare("UPDATE users SET name=:name , email = :email , address =:address WHERE id={$user_id}");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("address", $address, PDO::PARAM_STR);
        $successed = $query->execute();
        return $successed;
    }

    public function updatePhoto($user_id,$photo) {
        $query = $this->con->prepare("UPDATE users SET photo=:photo WHERE id={$user_id}");
        $query->bindParam("photo", $photo, PDO::PARAM_STR);
        $successed = $query->execute();
        return $successed;
    }

    public function changePassword($user_id,$data) {
        extract($data);
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $query = $this->con->prepare("UPDATE users SET password=:hash WHERE id={$user_id}");
        $query->bindParam("hash", $hash, PDO::PARAM_STR);
        $successed = $query->execute();
        return $successed;
    }

    public function getAllOrders($user_id) {
        $query = $this->con->prepare("SELECT R.name as res_name  , M.* 
                                    from meals M,restaurants R,users U,user_meals UM 
                                    where U.id = :user_id and U.id = UM.user_id and M.id = UM.meal_id 
                                    and R.id = M.restaurant_id
                                    ");
        $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllSubscribes($user_id) {
        $query = $this->con->prepare("SELECT R.name as res_name , R.id as res_id  , P.name as pack_name , US.*
                                    from packages P,restaurants R,users U,user_subscripes US 
                                    where U.id = :user_id and U.id = US.user_id and P.id = US.package_id 
                                    and R.id = P.restaurant_id
                                    ");
        $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
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