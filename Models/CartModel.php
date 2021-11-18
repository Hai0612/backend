<?php
class CartModel extends BaseModel
{
    const TABLE = 'cart';
    public function add_to_cart($table,$id_user ,$id_variant,$quantity)
    {
        $flag = $this->checkExistInDB($table, [
            'id_user' => $id_user,
            'id_variant' => $id_variant,
        ]);
        if($flag){
            $newsql =  "UPDATE cart SET cart.quantity = ((SELECT cart.quantity WHERE cart.id_user = 1 AND cart.id_variant = 2) + ". $quantity . ") WHERE cart.id_user = " .$id_user. " AND cart.id_variant = " . $id_variant;
            return $this->updateWithSql($newsql);
        }
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
        join image on products.id = image.id_product where image.type = 'thumbnail' and cart.status = 0 and (cart.id_user = " . $id_user .  " OR user.username = '" . $username . "');";
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
        $sql = "SELECT sum(cart.quantity) as total from cart WHERE status = 0 GROUP BY cart.id_user HAVING id_user = " . $id_user;
        
        return $this->queryWithSql($sql);
    }
    public function changStatusCart($table, $id_user, $id_variant, $value){
        $sql = "UPDATE cart SET cart.status = ".$value." WHERE cart.id_user = " .$id_user . " AND cart.id_variant = " .$id_variant; 
        return $this->updateWithSql($sql);
    }
    public function resetStatusByUser($table, $id_user){
        $sql = "UPDATE cart SET cart.status = 0 WHERE cart.id_user = " . $id_user. " AND cart.status = 1";
        return $this->updateWithSql($sql);
    }
    
}
