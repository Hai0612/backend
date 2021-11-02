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
        // $_POST['id_user'] = 1;
        if (isset($_POST['id_user']) && $_POST['id_user'] !== '') {
            $id_user = $_POST['id_user'];
            $cart = $this->cartModel->fetchCartByUser($id_user, "nfdsfsf");
            echo json_encode(
                [
                    'status' => 200,
                    'payload' => $cart,
                ]
            );
            echo "<pre/>";
            echo print_r($cart);
        }
        if (isset($_POST['username']) && $_POST['username'] !== '') {
            $username = $_POST['username'];
            $cart = $this->cartModel->fetchCartByUser('nfdsfsf', $username);
            echo json_encode(
                [
                    'status' => 200,
                    'payload' => $cart,
                ]
            );
            echo "<pre/>";
            echo print_r($cart);
        }
    }
    public function addToCart()
    {
        // $_POST['id_product'] = 3;
        if (isset($_POST['id_product'])) {
            $flag = $this->cartModel->add_to_cart(CartModel::TABLE, $_POST['id_product']);
        }
    }
    public function showCart()
    {
        // if(isset($_SESSION['login'])){
        //     $this->cartModel->show_cart_by_user(ConsumerModel::TABLE, $_SESSION['login']);
        // }
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
