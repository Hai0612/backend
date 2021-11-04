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

    public function getByOption(){
        $_POST['category'] = 'T-shirt';
        $_POST['brand'] = 'Adidas';
        $_POST['price'] = 'Từ 1 - 5 triệu';
        $_POST['state'] = 1;
        if(isset($_POST['category']) && isset($_POST['brand']) && isset($_POST['price']) && isset($_POST['state'])){
            $category  = $_POST['category'];
            $brand  = $_POST['brand'];
            $price  = $_POST['price'];
            $state  = $_POST['state'];
            $products = $this->categoryModel->getProductsByOption(CategoryModel::TABLE, $category, $brand, null, $state);
            echo json_encode(
                array(
                    'status' => '200',
                    'payload' => $products,
                )
            );
        }
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
        $category_id = $_GET['category_id'] ? $_GET['category_id'] : false;
        $price = $_POST['price'] ? $_POST['price'] : false;
        $discount_id = $_POST['discount_id'] ? $_POST['discount_id']: false;
        $this->categoryModel->addProduct(CategoryModel::TABLE, $id, $name, $description, $category_id, $price, $discount_id);
    }

}
?>