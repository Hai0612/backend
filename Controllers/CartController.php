<?php 

class CartController extends BaseController {
    private $cartModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"),true);
        $this->loadModel('CartModel');
        $this->cartModel = new CartModel;
    }
   
    
    public function index(){
        if(isset($_POST['id_user']) && $_POST['id_user'] !== ''){
            $id_user = $_POST['id_user'];
            $carts = $this->cartModel->fetchCartByUser($id_user, "nfdsfsf");
            echo json_encode(
                [
                    'status' => 200, 
                    'payload' => $carts,
                ]
                );
        }
        if(isset($_POST['username']) && $_POST['username'] !== ''){
            $username = $_POST['username'];
            $carts = $this->cartModel->fetchCartByUser('nfdsfsf',$username);
            echo json_encode(
                [
                    'status' => 200, 
                    'payload' => $carts,
                ]
            );
        }
    }
    public function addToCart(){
        
        if(isset($_POST['productCode'])){
            $flag = $this->cartModel->add_to_cart(CartModel::TABLE , $_POST['productCode']);
        }
    }
    public function showCart(){
        // if(isset($_SESSION['login'])){
        //     $this->cartModel->show_cart_by_user(ConsumerModel::TABLE, $_SESSION['login']);
        // }
    }
    public function deleteProductInCart(){

    }
    public function editBookInCart(){
        if(isset($_POST['id_book']) && isset($_POST['quantity'])){
            $id_book = $_POST['id_book'];
            $quantity = $_POST['quantity'];
            $flag = $this->cartModel->editBook(CartModel::TABLE, $id_book, $quantity);
            if($flag){
                echo json_encode(
                    [
                        'status' => 200,
                    ]
                    );
            }
        }
    }
    public function test(){
        echo $_SERVER['HTTP_AUTHORIZATION'];
    }
}
?>