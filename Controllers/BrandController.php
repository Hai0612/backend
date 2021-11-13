<?php
class BrandController extends BaseController
{
    private $brandModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->loadModel('BrandModel');
        $this->brandModel = new BrandModel;
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

    public function fetchAll()
    {
        $brands = $this->brandModel->fetchAllBrand(BrandModel::TABLE);
        echo json_encode(
            array(
                'status' => '200',
                'payload' => $brands,
            )
        );
    }
    
   
}
