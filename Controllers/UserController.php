<?php
class UserController extends BaseController
{
    private $userModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->loadModel('UserModel');
        $this->userModel = new UserModel;
    }

    public function fetchUser()
    {
        session_start();

        echo "fetch";
        print_r($_SESSION);
        echo "ffd";
    }
    public function login()
    {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $flag = $this->userModel->checkLogin(UserModel::TABLE, $username, $password);
            if ($flag) {
                $token = JWT::encode([
                    'username' => $username,
                    'password' => $password
                ], 'MD_5');
                echo json_encode([
                    'status' => 200,
                    'token' => $token
                ]);
            } else {
                echo json_encode([
                    'status' => 404,
                ]);
            }
        }
    }
    public function authenticate()
    {
        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $account =  JWT::decode($token, "MD_5", array('HS256'));
        $flag = $this->userModel->checkLogin(UserModel::TABLE, $account->username, $account->password);
        if ($flag) {
            $acc = $this->userModel->getLogin(UserModel::TABLE, $account->username, $account->password);
        }
        echo json_encode(
            [
                'status' => 200,
                'account' => $acc,
            ]
        );
    }
    public function getloginUser()
    {
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $account = $this->userModel->getLogin(UserModel::TABLE, $username);
            echo json_encode(
                [
                    'status' => 200,
                    'payload' => $account[0]
                ]
            );
        }
    }
    public function getInfo()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $info = $this->userModel->getUserInfo($id);
            if (count($info) > 0) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $info
                    ]
                );
            } else {
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }
        }
    }
    public function getPaymentInfo()
    {
        $_POST['user_id'] = 4;
        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            $payment = $this->userModel->getUserPaymentInfo($user_id);
            if (count($payment) > 0) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $payment
                    ]
                );
            } else {
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }
        }
    }
    public function signup()
    {

        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['date'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $date =  $_POST['date'];
            $url = 'abcde.xyz/' . $username;
            $address = $_POST['address'];
            $city = $_POST['city'];
            $postal_code = $_POST['postal_code'];
            $country = $_POST['country'];
            $telephone = $_POST['telephone'];
            $flag = $this->userModel->signup(UserModel::TABLE, $username, $password, $first_name, $last_name, $date, $email, $url, $address, $city, $postal_code, $country, $telephone);
        }
        if ($flag) {
            echo json_encode(
                [
                    'status' => 200,
                    'payload' => $flag
                ]
            );
        } else {
            echo json_encode(
                [
                    'status' => 404,
                ]
            );
        }
    }

    public function logout()
    {
    }
    public function decode($jwt, $secret)
    {
        return JWT::decode($jwt, $secret, array('HS256'));
    }
}
