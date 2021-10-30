<?php
class UserController extends BaseController{
    private $userModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"),true);
        $this->loadModel('UserModel');
        $this->userModel = new UserModel;
    }

    public function fetchUser(){
    session_start();

        echo "fetch";
        print_r($_SESSION);
        echo "ffd";
    }
    public function login(){
        $result = false;
        if(isset($_POST['username']) && isset($_POST['password'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $flag = $this->userModel->checkLogin(UserModel::TABLE, $username, $password);
            if($flag){
                $token = JWT::encode([
                    'username' => $username,
                    'password' => $password
                ], 'MD_5');
                echo json_encode([
                    'status' => 200,
                    'token' => $token
                ]);
            }    
        }
        else{
            echo $result;
        }
    }
    public function authenticate(){
        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $account =  JWT::decode($token, "MD_5",array('HS256'));
        $flag = $this->userModel->checkLogin(UserModel::TABLE, $account->username ,$account->password);
        if($flag){
            $acc = $this->userModel->getLogin(UserModel::TABLE, $account->username, $account->password);
        }
        echo json_encode(
            [
                'status' => 200,
                'account' => $acc,
            ]
        );
        
    }
    public function getloginUser(){
        if(isset($_POST['username'])){
            $username = $_POST['username'];
            $account = $this->userModel->getLogin(UserModel::TABLE, $username); 
            echo json_encode(
                [
                    'status' => 200 ,
                    'payload' => $account[0]
                ]
            );
        }
    }
    public function signup(){
        $flag = false;
        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['date'])){
            $username = $_POST['username']  ;
            $password = $_POST['password'] ;
            $firstname = $_POST['firstname'] ;
            $lastname = $_POST['lastname'];
            $email = $_POST['email'] ;
            $date =  $_POST['date'] ;
            $flag = $this->userModel->signup(UserModel::TABLE, $username,$password, $lastname, $firstname, $email, $date);
        }
        echo $flag;
    }
   
    public function logout(){
        
    }
    public function decode($jwt, $secret){
        return JWT::decode($jwt, $secret,array('HS256'));
    }
  
}
?>