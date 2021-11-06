<?php

class CartController extends BaseController
{
    private $cartModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->loadModel('CartModel');
        $this->cartModel = new CartModel;
    }


    public function index()
    {
        if (isset($_POST['id_user']) && $_POST['id_user'] !== '') {
            $id_user = $_POST['id_user'];
            $cart = $this->cartModel->fetchCartByUser($id_user, "nfdsfsf");
            if ($cart) {
                echo json_encode(
                    array(
                        'status' => 200,
                        'payload' => $cart,
                    )
                );
            }
            else {
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }
        }
        if (isset($_POST['username']) && $_POST['username'] !== '') {
            $username = $_POST['username'];
            $cart = $this->cartModel->fetchCartByUser('nfdsfsf', $username);
            if ($cart) {
                echo json_encode(
                    array(
                        'status' => 200,
                        'payload' => $cart,
                    )
                );
            }
            else {
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }

        }
    }

    public function decreaseQuantity(){
        if (isset($_POST['id_user']) && isset($_POST['id_variant'])) {
            $id_user = $_POST['id_user'];
            $id_variant = $_POST['id_variant'];
            $flag = $this->cartModel->decreaseQuantityProduct(CartModel::TABLE, $id_user, $id_variant);
            if ($flag) {
                echo json_encode(
                    [
                        'status' => 200,
                    ]
                );
            }
            else{
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }
        }
    }
    public function increaseQuantity(){
        if (isset($_POST['id_user']) && isset($_POST['id_variant'])) {
            $id_user = $_POST['id_user'];
            $id_variant = $_POST['id_variant'];
            $flag = $this->cartModel->increaseQuantityProduct(CartModel::TABLE, $id_user, $id_variant);
            if ($flag) {
                echo json_encode(
                    [
                        'status' => 200,
                    ]
                );
            }
            else{
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }
        }
    }
   
    public function deleteProduct()
    {
        if (isset($_POST['id_user']) && isset($_POST['id_variant'])) {
            $id_user = $_POST['id_user'];
            $id_variant = $_POST['id_variant'];
            $flag = $this->cartModel->deleteProductInCart(CartModel::TABLE, $id_user, $id_variant);
            if ($flag) {
                echo json_encode(
                    [
                        'status' => 200,
                    ]
                );
            }
            else{
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }
        }
    }
    public function addToCart()
    {
        if (isset($_POST['id_variant']) && isset($_POST['id_user']) && isset($_POST['quantity'])) {
            $id_variant = $_POST['id_variant'];
            $id_user = $_POST['id_user'];
            $quantity = $_POST['quantity'];
            $flag = $this->cartModel->add_to_cart(CartModel::TABLE ,$id_user,$id_variant, $quantity );
            if ($flag) {
                echo json_encode(
                    array(
                        'status' => 200,
                        'payload' => $flag,
                    )
                );
            }
            else {
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }
        }
    }

    //------------------------------------------------------
    public function showCart()
    {
        // if(isset($_SESSION['login'])){
        //     $this->cartModel->show_cart_by_user(ConsumerModel::TABLE, $_SESSION['login']);
        // }
    }
    public function fetchByUser()
    {   
        if (isset($_POST['id_user']) && $_POST['id_user'] !== '') {
            $id_user = $_POST['id_user'];
            $cart = $this->cartModel->fetchCartByUser($id_user, "nfdsfsf");
            if ($cart) {
                echo json_encode(
                    array(
                        'status' => 200,
                        'payload' => $cart,
                    )
                );
            }
            else {
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }
        }
        if (isset($_POST['username']) && $_POST['username'] !== '') {
            $username = $_POST['username'];
            $cart = $this->cartModel->fetchCartByUser('nfdsfsf', $username);
            if ($cart) {
                echo json_encode(
                    array(
                        'status' => 200,
                        'payload' => $cart,
                    )
                );
            }
            else {
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }

        }
    }
    public function deleteProductInCart()
    {
    }
    public function editProductInCart()
    {
        if (isset($_POST['id_product']) && isset($_POST['quantity'])) {
            $id_product = $_POST['id_product'];
            $quantity = $_POST['quantity'];
            $flag = $this->cartModel->editProduct(CartModel::TABLE, $id_product, $quantity);
            if ($flag) {
                echo json_encode(
                    [
                        'status' => 200,
                    ]
                );
            }
        }
    }
    public function test()
    {
        echo $_SERVER['HTTP_AUTHORIZATION'];
    }
}
