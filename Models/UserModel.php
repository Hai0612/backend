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
        public function signup($table, $username, $password, $first_name ,$last_name, $date, $url){
            $flag = $this->checkExistInDB($table, [
                'username' => $username,
            ]);
            if(!$flag){
                $flag = $this->addAccount($table, $username, $password, $first_name ,$last_name, $date, $url);        
            }
            return $flag;
        }
        public function checkSignup($table, $username){
            return $this->checkExistInDB($table, [
                'username' => $username,
            ]);
        }
        public function addAccount($table, $username, $password, $first_name, $last_name , $date, $url){
            
            return $this->insertDB($table,[
                'username' => $username,
                'password' => $password,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'date' => $date,
                'url' => $url,
            ]);
        }
        
      
}

?>