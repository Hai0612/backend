<?php
class CartModel extends BaseModel
{
    const TABLE = 'cart';
    public function add_to_cart($table,$id_user ,$id_variant,$quantity)
    {
        return $this->insertDB($table, [
            'id_user' => $id_user,
            'id_variant' => $id_variant,
            'quantity' => $quantity,
            'created_at' => date("Y-m-d"),
            'modified_at' => date("Y-m-d"),
        ]);
    }
    public function fetchCartByUser($id_user, $username)
    {
        $sql = "SELECT cart.id, cart.id_user, cart.id_variant, products.name, cart.quantity, product_variant.color, product_variant.size, product_variant.price, image.url FROM cart INNER JOIN user ON cart.id_user = user.id 
        INNER JOIN product_variant ON cart.id_variant = product_variant.id
        INNER JOIN products on product_variant.id_product = products.id 
        join image on products.id = image.id_product where image.type = 'thumbnail' and (cart.id_user = " . $id_user .  " OR user.username = '" . $username . "');";
        return $this->queryWithSql($sql);
    }

    public function decreaseQuantityProduct($table ,$id_user , $id_variant){
        $sql = "UPDATE cart SET cart.quantity = ((SELECT cart.quantity FROM cart WHERE cart.id_user = " .$id_user. " AND cart.id_variant = " .$id_variant ." ) - 1 )  WHERE cart.id_user = " .$id_user." AND cart.id_variant = " .$id_variant;
        return $this->updateWithSql($sql);
    }
    public function increaseQuantityProduct($table ,$id_user , $id_variant){
        $sql = "UPDATE cart SET cart.quantity = ((SELECT cart.quantity FROM cart WHERE cart.id_user = " .$id_user. " AND cart.id_variant = " .$id_variant ." ) + 1 )  WHERE cart.id_user = " .$id_user." AND cart.id_variant = " .$id_variant;

        return $this->updateWithSql($sql);
    }
    public function deleteProductInCart($table ,$id_user , $id_variant){
        return $this->deleteWithCond($table, [
            'id_user' => $id_user,
            'id_variant' => $id_variant
        ]);
    }
    
    public function add($table, $id_variant)
    {
        $id_variant = $_POST['id_variant'];
        $sql = "SELECT product_variant.id, name, color, size, product_variant.price FROM product_variant join products on product_variant.id_product = products.id WHERE product_variant.id = \"" . $id_variant . "\"";
        $results =  $this->__query($sql);
        $variant = mysqli_fetch_row($results);
        echo print_r($variant);
        if (!isset($_SESSION["cart"])) {
            $cart[$id_variant] = array(
                'id_variant' => $variant[0],
                'name' => $variant[1],
                'color' => $variant[2],
                'size' => $variant[3],
                'price' => $variant[4],
                'quantity' => 1,
            );
        } else {
            $cart = $_SESSION['cart'];
            if (array_key_exists($id_variant, $cart)) {
                $cart[$id_variant] = array(
                    'id_variant' => $variant[0],
                    'name' => $variant[1],
                    'color' => $variant[2],
                    'size' => $variant[3],
                    'price' => $variant[4],
                    'quantity' => $cart[$variant]["quantity"] + 1,
                );
            } else {
                $cart[$id_variant] = array(
                    'id_variant' => $variant[0],
                    'name' => $variant[1],
                    'color' => $variant[2],
                    'size' => $variant[3],
                    'price' => $variant[4],
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
    public function editProduct($table, $id_product, $quantity)
    {
        return $this->editDbWithCond($table, [
            'quantity' => $quantity,
            'id_product' => $id_product,
        ]);
    }
    public function getNumberCart($table , $id_user){
        $sql = "SELECT sum(cart.quantity) as total from cart GROUP BY cart.id_user HAVING id_user = " . $id_user;
        return $this->queryWithSql($sql);
    }
}
