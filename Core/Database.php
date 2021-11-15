<?php 
class Database{
    
    const HOST = 'localhost';
    const USERNAME = 'root';
    const  PASSWORD = '123456789';
    const DB_NAME = 'ecommerce';
    public function connect(){
        $connect = mysqli_connect(self::HOST, self::USERNAME, self::PASSWORD, self::DB_NAME);

        mysqli_set_charset($connect, "utf8");
        if(mysqli_connect_errno() === 0 ){
            return $connect;
        }
        else{
            echo "Error";
            die();
        }
    }

}
?>