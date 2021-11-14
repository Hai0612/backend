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
    public function fetchAll(){
        $users = $this->userModel->fetchAllUser(UserModel::TABLE);
        echo json_encode([
            'status' => 200,
            'payload' => $users,
        ]);
    }
    public function login()
    {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $flag = $this->userModel->checkLogin(UserModel::TABLE, $username, $password);
            $account = $this->userModel->getLogin(UserModel::TABLE, $username,$password);
            if ($flag) {
                $token = JWT::encode([
                    'username' => $username,
                    'password' => $password
                ], 'MD_5');
                echo json_encode([
                    'status' => 200,
                    'token' => $token,
                    'account' => $account,
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
            $info = $this->userModel->getUserInfo(UserModel::TABLE, $id);
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
    public function updateInfo()
    {
        $info = false;
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $url = $_POST['url'];
            $info = $this->userModel->updateUserInfo(UserModel::TABLE, $first_name, $last_name, $email, $phone, $url, $id);
            if ($info) {
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

    public function updateAddressInfo()
    {
        $info = false;
       
        if (isset($_POST['id_user'])) {
            $id_user = $_POST['id_user'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $postal_code = $_POST['postal_code'];
            $country = $_POST['country'];
            $info = $this->userModel->updateUserAddressInfo('user_address', $address, $city, $postal_code, $country, $id_user);
            if ($info) {
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

    public function updatePassword()
    {
        // $info = false;
        // $oldPwdCheck = false;
        // $_POST['id'] = 4;
        // $_POST['old_password'] = 'newerpwd';
        // $_POST['new_password'] = 'newpwd';
        if (isset($_POST['id']) && isset($_POST['old_password']) && isset($_POST['new_password'])) {
            $id = $_POST['id'];
            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            $oldPwdCheck = $this->userModel->checkUserPassword(UserModel::TABLE, $id, $old_password);
            if (count($oldPwdCheck) > 0) {
                echo 'abcd';
                $info = $this->userModel->updateUserPassword(UserModel::TABLE, $id, $new_password);
            };
            echo $info;
            // if ($info) {
            //     echo json_encode(
            //         [
            //             'status' => 200,
            //             'payload' => $info
            //         ]
            //     );
            // } else {
            //     echo json_encode(
            //         [
            //             'status' => 404,
            //         ]
            //     );
            // }
            //echo $info;
        }
    }
    public function getPaymentInfo()
    {
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
            $url = $_POST['url'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $postal_code = $_POST['postal_code'];
            $country = $_POST['country'];
            $phone = $_POST['phone'];
            $flag = $this->userModel->signup(UserModel::TABLE, $username, $password, $first_name, $last_name, $date, $email, $phone, $url, $address, $city, $postal_code, $country);
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
