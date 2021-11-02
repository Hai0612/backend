<?php
class ProductController extends BaseController {
    private $productModel;
    private $commentModel;
    private $userModel;
    public function __construct(){
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;
        
    }

    public function getAll(){
        $products = $this->productModel->getAllProduct(ProductModel::TABLE);
        echo json_encode($products);
        echo "<pre/>";
        echo print_r($products);
    }

    public function getByIndex(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $product = $this->productModel->getProductByIndex(ProductModel::TABLE ,$id);
            echo json_encode($product);
            echo "<pre/>";
            echo print_r($product);
        }
    } 
    public function getByCategory(){
        if(isset($_GET['category'])){
            $category = $_GET['category'];
            $products = $this->productModel->getProductsByCategory(ProductModel::TABLE, $category);
            echo json_encode($products);
            echo "<pre/>";
            echo print_r($products);
        }
    }

    public function getRelated() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $products = $this->productModel->getRelatedProducts($id);
            echo json_encode($products);
            echo "<pre/>";
            echo print_r($products);
        }
    }

    public function getByPrice() {
        if (isset($_GET['min'])) {
            $min = $_GET['min'];
        }
        else $min = 0;
        if (isset($_GET['max'])) {
            $max = $_GET['max'];
        }
        // set tạm max
        else $max = 100000000;
        $products = $this->productModel->getProductsByPrice($min, $max);
        echo json_encode($products);
        echo "<pre/>";
        echo print_r($products);
    }
    
    public function searchMachine(){
        //$_POST['searchText'] = 'dài';
        if(isset($_POST['searchText'])){
            $text = $_POST['searchText'];
            $results_product = $this->productModel->fetchByMachineSearch($text);
            echo json_encode(
                array(
                    'status' => '200',
                    'payload' => $results_product
                )
            );
            echo "<pre/>";
            echo print_r($results_product);
        }
    }

    public function getQuantity() {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $quantity = $this->productModel->getProductQuantity($id);
            echo json_encode($quantity);
            echo "<pre/>";
            echo print_r($quantity);
        }
    }
    public function editProduct(){
        if(isset($_POST['name']) && isset($_POST['id'])){
            $id = $_POST['id'];
            $name  = $_POST['name'];
            $desciption = $_POST['description'];
            $category_id  = $_POST['category_id'];
            $inventory_id = $_POST['inventory_id'];
            $price = $_POST['price'];
            $discount_id = $_POST['discount_id'];
            $flag = $this->bookModel->editBookById(ProductModel::TABLE, $id , $name, $desciption, $category_id, $inventory_id, $price, $discount_id);
            if($flag){
                echo json_encode(
                    array(
                        'status' => 200,
                        'payload' => $flag,
                    )
                );
            }

        }   
    }

    public function deleteProductById(){
        if(isset($_POST['id'])){
            $flag = $this->productModel->deleteById(ProductModel::TABLE, $_POST['id']);
            if($flag){
                echo json_encode([
                    'status' => 200,
                    'message' => 'ok'
                ]);
            }
            else{
                echo json_encode([
                    'status' => 400,
                    'message' => 'bad request'
                ]);
            }
            exit;
        }
    }

    //-------------
    public function index(){
        $this->loadModel('UserModel');
        $this->userModel = new UserModel;
        if(isset($_COOKIE["username"])){
            // $user = $this->userModel->getMyAccount(UserModel::TABLE , $_COOKIE['username']);
        }
        $pageNumber = '';
        if(isset($_GET['page'])){
            $pageNumber = $_GET['page'];
        }
        
        $products = $this->productModel->getAllProduct(ProductModel::TABLE, $pageNumber);
        $list_hot = $this->productModel->getListHot(ProductModel::TABLE);
       
        $this->view('frontend.products.index', [
            'products' => $products,
            'list_hot' => $list_hot,    

        ]);
    }
    public function detail(){
        $this->loadModel('CommentModel');
        $this->commentModel = new CommentModel;
        
        $productCode = $_GET['productCode'] ? $_GET['productCode'] : false;
        $product = $this->productModel->getProductByIndex(ProductModel::TABLE , $productCode);
        // $comments = $this->commentModel->getCmtByProduct(CommentModel::TABLE , $productCode);
        $this->view('frontend.products.detail', [
            'product' => $product,
            // 'comments' => $comments,
        ]);
    }

 

    

}