<?php 
class CartModel extends BaseModel{
    const TABLE = 'cart';
    public function add_to_cart($table, $id_product){
         return $this->add($table,[
            'id_product' => $id_product,
        ]);
    }
    public function fetchCartByUser($id_user, $username){
        $sql = "SELECT cart.id, cart.id_user, cart.id_product, products.name, cart.quantity, products.price FROM cart INNER JOIN user ON cart.id_user = user.id 
        INNER JOIN products ON cart.id_product = products.id WHERE cart.id_user = " . $id_user .  " OR user.username = '". $username . "';" ;  
        return $this->queryWithSql($sql);
    }
    public function add($table, $id_product){
            $id_product = $_POST['id_product'];
            $sql = "SELECT * FROM products WHERE id = \"" . $id_product . "\""; 
            $results =  $this->__query($sql);
            
            $product = mysqli_fetch_row($results);
            if(!isset($_SESSION["cart"])){
                $cart[$id_product] = array(
                    'id_product' => $product[0],
                    'name' => $product[1],
                    'price' =>$product[5],
                    'quantity' => 1,
                );                       
            }else{
                $cart = $_SESSION['cart'];
                if(array_key_exists($id_product, $cart)){
                    $cart[$id_product] = array(
                        'id_product' => $product[0],
                        'name' => $product[1],
                        'price' =>$product[5],
                        'quantity' => $cart[$id_product]["quantity"] + 1,
                    );
                }else{
                    $cart[$id_product] = array(
                        'id_product' => $product[0],
                        'name' => $product[1],
                        'price' =>$product[5],
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
    public function editProduct($table, $id_product, $quantity){
        return $this->editDbWithCond($table, [
            'quantity' => $quantity,
            'id_product' => $id_product,
        ]);
    }
}
?>