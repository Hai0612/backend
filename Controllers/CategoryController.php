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
        $category_id = NULL;
        if(isset($_GET['category_id'])){
            $category_id = $_GET['category_id'];
        }
        $category_id = str_replace('-', ' ', $category_id);
        $products = $this->categoryModel->showbyCategoryId(CategoryModel::TABLE, $category_id  , $page);
        $nextPage = (sizeof($products) === 9) ? ( $page +1 ) : $page;
           $this->view('frontend.categories.index',[
               'products' => $products,
               'nextPage' => $nextPage,
           ]);
    }
    public function addProductByCategory(){
        // $id = 21;
        // $name =  'Áo siêu nhân';
        // $description = 'Áo có hình siêu nhân';
        // $category_id = 1;
        // $inventory_id = 21;
        // $price = 40000;
        // $discount_id = 1;
        
        
        $id = $_POST['id'] ? $_POST['id'] : false;
        $name =  $_POST['name'] ? $_POST['name'] : false;
        $description = $_POST['description'] ? $_POST['description'] : false;
        $category_id = $_GET['category_id'] ? $_GET['category_id'] :false;
        $inventory_id = $_POST['inventory_id'] ? $_POST['inventory_id'] : false;
        $price = $_POST['price'] ? $_POST['price'] : false;
        $discount_id = $_POST['discount_id'] ? $_POST['discount_id']: false;
        $this->categoryModel->addProduct(CategoryModel::TABLE, $id, $name, $description, $category_id, $inventory_id, $price, $discount_id);
        header("Location:" .BASE_URL ."index.php?controller=category&category_id=" .$category_id);
    }

}
?>