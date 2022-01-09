<?php
include_once('../models/User.php');
class UserController{

    
    public static function show_login($userroute = '../user/') {
        header('Location: '.$userroute.'login.php');
    }

    public static function show_register($userroute = '../user/') {
        header('Location: '.$userroute.'register.php');
    }

    public function login($userroute = '../user/') {
        
        $error=[];
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['login'])) {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $data = [
                    'email'=>$email,
                    'password' => $password,
                ];
               $encoded= json_encode($data);
                if(strlen($password)<8){
                    $error=json_encode(['password must be greater than 8 digit']);
                    header('Location: '.$userroute."login.php?errors={$error}&data={$encoded}");
                    exit();
                }
                $user = new User();
                $user->getUserAndLogin($data);
            }
        }
        
    }

    public function register() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['register'])) {
                $name=trim($_POST['name']);
                $email = trim($_POST['email']);
                $address = trim($_POST['address']);
                $password = trim($_POST['password']);
                $confirm_password = trim($_POST['confirm_password']);
                $data = [
                    'email'=>$email,
                    'name'=>$name,
                    'address'=>$address,
                    'password' => $password,
                ];
                $encoded= json_encode($data);
                $error=[];
                if (empty($name)) {
                    array_push($error,"name required");
                } 
                if (!empty($name) && is_numeric($name)) {
                    array_push($error,"name must be contains letters (not number only)");
                } 
                if (strlen($password)<8) {
                    array_push($error,"password must be greater than 8 digit");
                } 
                if ($password!=$confirm_password) {
                    array_push($error,"passwords not matched");
                } 
                if (empty($address)) {
                    array_push($error,"address required");
                } 
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: ../user/register.php?errors={$error}&data={$encoded}" );
                    exit();
                }
                $user = new User();
                $user->insert($data);

            }
        }


        
    }

    public function showProfile ($userroute = '../user/') {
        header('Location: '.$userroute);
    }
    public function showSubscribes ($userroute = '../user/') {
        $user_id = $_SESSION['user']['id'];
        $user = new user(); 
        $subscribes = $user->getAllSubscribes($user_id);
        $encoded = base64_encode(json_encode($subscribes));
        header('Location: '.$userroute.'subscribes.php?subscribes='.$encoded);
    }
    public function showOrders ($userroute = '../user/') {
        $user_id = $_SESSION['user']['id'];
        $user = new user(); 
        $orders = $user->getAllOrders($user_id);
        $encoded = base64_encode(json_encode($orders));
        header('Location: '.$userroute.'orders.php?orders='.$encoded);
    }
    public function showSettings ($userroute = '../user/') {
        header('Location: '.$userroute.'settings.php');
    }
    public function showChangePassword ($userroute = '../user/') {
        header('Location: '.$userroute.'changepassword.php');
    }
    public function showUpdatePhoto ($userroute = '../user/') {
        header('Location: '.$userroute.'updatePhoto.php');
    }

    public function editUser ($userroute = '../user/') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['userEdit'])) {
                $name=trim($_POST['name']);
                $email = trim($_POST['email']);
                $address = trim($_POST['address']);
                $data = [
                    'email'=>$email,
                    'name'=>$name,
                    'address'=>$address,
                ];
                $encoded= json_encode($data);
                $error=[];
                if (empty($name)) {
                    array_push($error,"name required");
                } 
                if (!empty($name) && is_numeric($name)) {
                    array_push($error,"name must be contains letters (not number only)");
                } 
                if (empty($address)) {
                    array_push($error,"address required");
                } 
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: {$userroute}settings.php?errors={$error}&data={$encoded}" );
                    exit();
                }
                $user = new User();
                $user_id = $_SESSION['user']['id'];
                $success = $user->update($user_id,$data);
                if($success) {
                    $_SESSION['user']['name'] = $name;
                    $_SESSION['username'] = $name;
                    $_SESSION['user']['email'] = $email;
                    $_SESSION['user']['address'] = $address;
                    header("location: {$userroute}" );
                }

            }
        }
        
    }
    public function updatePhoto ($userroute = '../user/') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['updatephoto'])) {

                // Upload Variables

				$photoName = $_FILES['photo']['name'];
				$photoSize = $_FILES['photo']['size'];
				$photoTmp	= $_FILES['photo']['tmp_name'];
				// List Of Allowed File Typed To Upload

				$photoAllowedExtension = array("jpeg", "jpg", "png");

				// Get photo Extension
                $explode = explode('.', $photoName);
				$photoExtension = strtolower(end($explode));
                $error = [];
                if (! empty($photoName) && ! in_array($photoExtension, $photoAllowedExtension)) {
					$error[] = 'This Extension Is Not <strong>Allowed</strong>';
				}

				if ($photoSize > 4194304) {
					$error[] = 'photo Cant Be Larger Than <strong>4MB</strong>';
				}

                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: {$userroute}updatePhoto.php?errors={$error}" );
                    exit();
                }
                
                $user_id = $_SESSION['user']['id'];
                $oldphoto = $_SESSION['user']['photo'];
                $path = '../uploads/users/'.$user_id;
                echo $oldphoto;
                if(!is_dir($path)) {
                    mkdir($path);
                } 
                if($oldphoto != null) {
                    unlink($path.'/'.$oldphoto);
                }
				move_uploaded_file($photoTmp, '../uploads/users/'.$user_id.'/'. $photoName);

                $user = new User();
                $success = $user->updatePhoto($user_id,$photoName);
                if($success) {
                    $_SESSION['user']['photo'] = $photoName;
                    header("location: ../user/" );
                }

            }
        }
        
    }
    public function changePassword ($userroute = '../user/') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['change_pass'])) {
                $password = trim($_POST['password']);
                $confirm_password = trim($_POST['confirm_password']);
                $data = [
                    'password' => $password
                ];
                $error=[];
                if(strlen($password)<8) {
                    array_push($error,"password must be greater than 8 digit");
                } 
                if ($password!=$confirm_password) {
                    array_push($error,"passwords not matched");
                } 
                if(!empty($error))
                {
                    $error=json_encode($error);
                    header("location: {$userroute}changepassword.php?errors={$error}" );
                    exit();
                }
                $user = new User();
                $user_id = $_SESSION['user']['id'];
                $success = $user->changePassword($user_id,$data);
                if($success) {
                    $_SESSION['user']['password'] = password_hash($password, PASSWORD_BCRYPT);
                    header("location: ../user/" );
                }

            }
        }
        
    }


    public function userDetails($id) {
        $userModel = new User();
        $user = base64_encode(json_encode($userModel->getUser($id)));
        header("location: ../restaurants/user_details.php?user={$user}" );

    }
    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['type']);
        unset($_SESSION['username']);
        header('location:../index.php');
    }

}