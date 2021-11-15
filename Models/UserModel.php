<?php
class UserModel extends BaseModel
{
    const TABLE = 'user';
    public function getAllUsername($table)
    {
        return $this->all($table);
    }
    public function checkLogin($table, $username, $password)
    {
        $conditions = [
            'username' => $username,
            'password' => $password
        ];
        return $this->checkExistInDB($table, $conditions);
    }
    public function getLogin($table, $username)
    {
        $sql = "SELECT * FROM user JOIN user_address on user.id = user_address.id_user WHERE user.username = '" . $username . "'";
        return $this->queryWithSql($sql);
    }

    public function fetchAllUser($table) {
        return $this->all($table);
    }

    public function getUserInfo($table, $id)
    {
        $sql = "SELECT * FROM user join user_address on user.id = user_address.id_user where user.id = {$id};";
        return $this->queryWithSql($sql);
    }
    public function getUserPaymentInfo($user_id)
    {
        $sql = "SELECT * FROM user_payment where user_id = {$user_id};";
        return $this->queryWithSql($sql);
    }
    public function signup($table, $username, $password, $first_name, $last_name, $date, $email, $phone, $url, $address, $city, $postal_code, $country)
    {
        $flag = $this->checkExistInDB($table, [
            'username' => $username,
        ]);
        if($flag){
            return 0;
        }
        if (!$flag) {
            $flag = $this->addAccount($username, $password, $first_name, $last_name, $date, $email, $phone, $url);
            $this->addUserInfo($address, $city, $postal_code, $country);
        }
        return $flag;
    }
    public function checkSignup($table, $username)
    {
        return $this->checkExistInDB($table, [
            'username' => $username,
        ]);
    }
    public function addAccount($username, $password, $first_name, $last_name, $date, $email, $phone, $url)
    {

        return $this->insertDB('user', [
            'username' => $username,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'date' => $date,
            'email' => $email,
            'phone' => $phone,
            'url' => $url,
        ]);
    }
    public function addUserInfo($address, $city, $postal_code, $country)
    {
        return $this->insertDB('user_address', [
            'address' => $address,
            'city' => $city,
            'postal_code' => $postal_code,
            'country' => $country,
        ]);
    }
    public function updateUserInfo($table, $first_name, $last_name, $email, $phone, $url, $id)
    {
        return $this->editDbWithCond(
            $table,
            [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone' => $phone,
                'url' => $url, 
            ],
            [
                'id' => $id,
            ]
        );
    }
    public function updateUserPassword($table, $id, $new_password) {
        return $this->editDbWithCond(
            $table,
            [
                'password' => $new_password,
            ],
            [
                'id' => $id,
            ]
        );
    }
    public function checkUserPassword($table, $id, $old_password) {
        $sql = "SELECT * FROM user WHERE user.id = {$id} AND user.password = '{$old_password}'";
        return $this->queryWithSql($sql);
    }
    public function updateUserAddressInfo($table, $address, $city, $postal_code, $country, $id_user)
    {
        return $this->editDbWithCond(
            $table,
            [
                'address' => $address,
                'city' => $city,
                'postal_code' => $postal_code,
                'country' => $country,
            ],
            [
                'id_user' => $id_user,
            ]
        );
    }
}