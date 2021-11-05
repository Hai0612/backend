<?php 
class UserModel extends BaseModel{
    const TABLE = 'user';
        public function getAllUsername($table){
            return $this->all($table);
        }
        public function checkLogin($table, $username , $password){
            $conditions = [
                'username' => $username,
                'password' =>$password
            ];
            return $this->checkExistInDB($table, $conditions);
        }
        public function getLogin($table, $username ){
            return $this->getWithCond($table, [
                'username' => $username,
            ]);
        }
        public function getUserInfo($id) {
            $sql = "SELECT * FROM user join user_address on user.id = user_address.id_user where user.id = {$id};";
            return $this->queryWithSql($sql);
        }
        public function getUserPaymentInfo($user_id) {
            $sql = "SELECT * FROM user_payment where user_id = {$user_id};";
            return $this->queryWithSql($sql);
        }
        public function signup($table, $username, $password, $first_name, $last_name, $date, $email, $url, $address, $city, $postal_code, $country, $telephone){
            $flag = $this->checkExistInDB($table, [
                'username' => $username,
            ]);
            if(!$flag){
                $flag = $this->addAccount($username, $password, $first_name , $last_name, $date, $email, $url);   
                $this->addUserInfo($address, $city, $postal_code, $country, $telephone);     
            }
            return $flag;
        }
        public function checkSignup($table, $username){
            return $this->checkExistInDB($table, [
                'username' => $username,
            ]);
        }
        public function addAccount($username, $password, $first_name, $last_name, $date, $email, $url){
            
            return $this->insertDB('user',[
                'username' => $username,
                'password' => $password,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'date' => $date,
                'email' => $email,
                'url' => $url,
            ]);
        }

        public function addUserInfo($address, $city, $postal_code, $country, $telephone){
            return $this->insertDB('user_address',[
                'address' => $address,
                'city' => $city,
                'postal_code' => $postal_code,
                'country' => $country,
                'telephone' => $telephone,
            ]);
        }
        
}

?>