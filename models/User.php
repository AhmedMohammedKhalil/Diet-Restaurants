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
            header('location: ../index.php' );
            exit();
        }
    }
}