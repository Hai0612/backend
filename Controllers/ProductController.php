<?php
class ProductController extends BaseController {
    private $productModel;
    private $commentModel;
    private $userModel;
    public function __construct(){
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;
        
    }
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
        
        $products = $this->productModel->getAll(ProductModel::TABLE, $pageNumber);
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
        $product = $this->productModel->getDetail(ProductModel::TABLE , $productCode);
        // $comments = $this->commentModel->getCmtByProduct(CommentModel::TABLE , $productCode);
        $this->view('frontend.products.detail', [
            'product' => $product,
            // 'comments' => $comments,
        ]);
    }
    public function deleteProduct(){
        if(isset($_POST['productCode'])){
            $flag = $this->productModel->delete(ProductModel::TABLE, $_POST['productCode']);
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

}