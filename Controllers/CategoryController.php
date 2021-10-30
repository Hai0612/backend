<?php 
class CategoryController extends BaseController {
    private $categoryModel;
    public function __construct()
    {
        $this->loadModel('CategoryModel');
        $this->categoryModel = new CategoryModel;
    }
   
    
    public function index(){
        $page = 1;
        if(isset($_GET['page'])){
            $page  = $_GET['page'];
        }
        $line = NULL;
        if(isset($_GET['line'])){
            $line = $_GET['line'];
        }
        $line = str_replace('-', ' ', $line);
        $products = $this->categoryModel->showbyline(CategoryModel::TABLE, $line  , $page);
        $nextPage = (sizeof($products) === 9) ? ( $page +1 ) : $page;
           $this->view('frontend.categories.index',[
               'products' => $products,
               'nextPage' => $nextPage,
           ]);
    }
    public function addProductByCategory(){
        $code = $_POST['code'] ? $_POST['code'] : false;
        $name =  $_POST['name'] ? $_POST['name'] : false;
        $vendor = $_POST['vendor'] ? $_POST['vendor'] : false;
        $line = $_GET['line'] ? $_GET['line'] :false;
        $scale = $_POST['scale'] ? $_POST['scale'] : false;
        $quantity = $_POST['quantity'] ? $_POST['quantity'] : false;
        $price = $_POST['price'] ? $_POST['price'] : false;
        $msrp = $_POST['msrp'] ? $_POST['msrp']: false;
        $image = $_POST['image'] ? $_POST['image'] : false;
        $desc = $_POST['desc'] ? $_POST['desc'] : false;
        $this->categoryModel->addProduct(CategoryModel::TABLE, $code, $name, $line,  $vendor,$scale, $quantity,$price, $msrp, $image, $desc);
        header("Location:" .BASE_URL ."index.php?controller=category&line=" .$line);
    }
}
?>