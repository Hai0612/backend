<?php
class CategoryController extends BaseController
{
    private $categoryModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->loadModel('CategoryModel');
        $this->categoryModel = new CategoryModel;
    }


    public function index()
    {
        $page = 1;
        if (isset($_GET['page'])) {
            $page  = $_GET['page'];
        }
        $category_id = NULL;
        if (isset($_GET['category_id'])) {
            $category_id = $_GET['category_id'];
        }
        $category_id = str_replace('-', ' ', $category_id);
        $products = $this->categoryModel->showbyCategoryId(CategoryModel::TABLE, $category_id, $page);
        $nextPage = (sizeof($products) === 9) ? ($page + 1) : $page;
        $this->view('frontend.categories.index', [
            'products' => $products,
            'nextPage' => $nextPage,
        ]);
    }

    public function getByOption()
    {
        if (isset($_POST['category']) && isset($_POST['brand']) && isset($_POST['price']) && isset($_POST['state'])) {
            $category  = $_POST['category'];
            $brand  = $_POST['brand'];
            $price  = $_POST['price'];
            $state  = $_POST['state'];
            $products = $this->categoryModel->getProductsByOption(CategoryModel::TABLE, $category, $brand, $price, $state);
            echo json_encode(
                array(
                    'status' => '200',
                    'payload' => $products,
                )
            );
        }
    }

    public function fetchAll()
    {
        $categories = $this->categoryModel->fetchAllCategories(CategoryModel::TABLE);
        echo json_encode(
            array(
                'status' => '200',
                'payload' => $categories,
            )
        );
    }
    
    public function addCategory()
    {   
        // $_POST['id_'] = 10;
        // $_POST['name_category'] = " category";
        // $_POST['desc_category'] = "new desc";
        // $_POST['image'] = "new image"; 
        if (isset($_POST['id_']) && isset($_POST['name_category']) && isset($_POST['desc_category']) && isset($_POST['image'])) {
            $id_ = $_POST['id_'];
            $name_category = $_POST['name_category'];
            $desc_category = $_POST['desc_category'];
            $image = $_POST['image'];
            $flag = $this->categoryModel->insertCategory(CategoryModel::TABLE, $id_, $name_category, $desc_category, $image);
        }
        if ($flag) {
            echo json_encode(
                [
                    'status' => 200,
                    'payload' => $flag
                ]
            );
        } else {
            echo json_encode(
                [
                    'status' => 404,
                ]
            );
        }
    }

    public function editCategory()
    {   
        // $_POST['id_'] = 10;
        // $_POST['name_category'] = "new name";
        // $_POST['desc_category'] = "newer desc";
        // $_POST['image'] = "newer image";
        if (isset($_POST['id_']) && isset($_POST['name_category']) && isset($_POST['desc_category']) && isset($_POST['image'])) {
            $id_ = $_POST['id_'];
            $name_category = $_POST['name_category'];
            $desc_category = $_POST['desc_category'];
            $image = $_POST['image'];
            $flag = $this->categoryModel->editCategoryById(CategoryModel::TABLE, $id_, $name_category, $desc_category, $image);
            if ($flag) {
                echo json_encode(
                    array(
                        'status' => 200,
                        'payload' => $flag,
                    )
                );
            } else {
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }
        }
    }


    public function deleteCategory()
    {   
        // $_POST['id_'] = 10;
        if (isset($_POST['id_'])) {
            $flag = $this->categoryModel->deleteById(CategoryModel::TABLE, $_POST['id_']);
            if ($flag) {
                echo json_encode([
                    'status' => 200,
                    'message' => 'ok'
                ]);
            } else {
                echo json_encode([
                    'status' => 400,
                    'message' => 'bad request'
                ]);
            }
            exit;
        }
    }
    // public function addProductByCategory()
    // {
    //     $id = 21;
    //     $name =  'Áo siêu nhân';
    //     $description = 'Áo có hình siêu nhân';
    //     $category_id = 1;
    //     $inventory_id = 21;
    //     $price = 40000;
    //     $discount_id = 1;


    //     $id = $_POST['id'] ? $_POST['id'] : false;
    //     $name =  $_POST['name'] ? $_POST['name'] : false;
    //     $description = $_POST['description'] ? $_POST['description'] : false;
    //     $category_id = $_GET['category_id'] ? $_GET['category_id'] : false;
    //     $price = $_POST['price'] ? $_POST['price'] : false;
    //     $discount_id = $_POST['discount_id'] ? $_POST['discount_id'] : false;
    //     $this->categoryModel->addProduct(CategoryModel::TABLE, $id, $name, $description, $category_id, $price, $discount_id);
    // }
}
