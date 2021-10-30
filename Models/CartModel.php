<?php 
class CartModel extends BaseModel{
    const TABLE = 'carts';
    public function add_to_cart($table, $productCode){
         return $this->add($table,[
            'productCode' => $productCode,
        ]);
    }
    public function fetchCartByUser($id_user, $username){
        $sql = "SELECT carts.id_cart, carts.id_user,  carts.id_book,books.name, carts.quantity, books.price, carts.paymented, books.image FROM `carts` INNER JOIN `user` ON carts.id_user = user.id
        INNER JOIN books ON carts.id_book = books.id_book
        WHERE carts.id_user = '".$id_user."' OR user.username = '". $username . "'" ;  
        return $this->queryWithSql($sql);
    }
    public function add($table, $productCode){
            $productCode = $_POST['productCode'];
            $sql = "SELECT * FROM products WHERE productCode = \"" . $productCode . "\""; 
            $results =  $this->__query($sql);
            
            $product = mysqli_fetch_row($results);
            if(!isset($_SESSION["cart"])){
                $cart[$productCode] = array(
                    'productCode' => $product[0],
                    'productName' => $product[1],
                    'buyPrice' =>$product[7],
                    'quantity' => 1,
                );                       
            }else{
                $cart = $_SESSION['cart'];
                if(array_key_exists($productCode, $cart)){
                    $cart[$productCode] = array(
                        'productCode' => $product[0],
                        'productName' => $product[1],
                        'buyPrice' =>$product[7],
                        'quantity' => $cart[$productCode]["quantity"] + 1,
                    );
                }else{
                    $cart[$productCode] = array(
                        'productCode' => $product[0],
                        'productName' => $product[1],
                        'buyPrice' =>$product[7],
                        'quantity' =>  1,
                    );
                }
            }
            //     $sql_get_id_consumer = "SELECT id_consumer FROM consumers WHERE consumers.username = " . "'" .$_COOKIE['username'] . "'";
            //     $res = mysqli_query($connect, $sql_get_id_consumer);
            //     $id_consumer = mysqli_fetch_row($res);
                
            // foreach($cart as $key => $value){
            //     $sql_getNum_current = "SELECT quantity FROM `carts` WHERE productCode = '" .$value['productCode']."' AND id_consumer = '" .$id_consumer[0] . "'";
            //     if(count(mysqli_fetch_all(mysqli_query($connect, $sql_getNum_current))) > 0){
            //         $num_in_table = mysqli_fetch_row(mysqli_query($connect, $sql_getNum_current))[0];
            //         if($num_in_table < $cart[$productCode]["quantity"]){
            //             echo "ýe";
            //             echo $cart[$productCode]['productCode'] . "    " . $num_in_table;
            //             $sql_delete = "DELETE FROM `carts` WHERE productCode = '" .$value['productCode']."' AND id_consumer = '" .$id_consumer[0] . "'";
            //             $query = mysqli_query($connect, $sql_delete);
            //             $sql_push_to_cart = "INSERT INTO `carts`(`productCode`, `id_consumer`, `quantity`, `order_time`) VALUES ('". $value['productCode']."','".$id_consumer[0] ."','" . $cart[$productCode]["quantity"] ."',' ". date("Y-m-d h:i:sa") ."')";
            //             $result = mysqli_query($connect, $sql_push_to_cart);
            //         }
            //     }else{
            //         $sql_push_to_cart = "INSERT INTO `carts`(`productCode`, `id_consumer`, `quantity`, `order_time`) VALUES ('". $value['productCode']."','".$id_consumer[0] ."','" . $cart[$productCode]["quantity"] ."',' ". date("Y-m-d h:i:sa") ."')";
            //         $result = mysqli_query($connect, $sql_push_to_cart);
            //     }
             
            // }
      
            $_SESSION['cart'] = $cart;
            return $_SESSION['cart'];
    }   
    public function editBook($table, $id_book,$quantity){
        return $this->editDbWithCond($table, [
            'quantity' => $quantity,
            'id_book' => $id_book,
        ]);
    }
}
?>