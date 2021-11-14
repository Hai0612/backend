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
        $brand_id = NULL;
        if (isset($_GET['brand_id'])) {
            $brand_id = $_GET['brand_id'];
        }
        $brand_id = str_replace('-', ' ', $brand_id);
        $products = $this->brandModel->showbyBrandId(BrandModel::TABLE, $brand_id, $page);
        $nextPage = (sizeof($products) === 9) ? ($page + 1) : $page;
        $this->view('frontend.brand.index', [
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
    
    public function addbrand()
    {   
        // $_POST['id_'] = 10;
        // $_POST['name_brand'] = " brand";
        // $_POST['desc_brand'] = "new desc";
        // $_POST['image'] = "new image"; 
        if (isset($_POST['id_']) && isset($_POST['name_brand']) && isset($_POST['desc_brand']) && isset($_POST['image'])) {
            $id_ = $_POST['id_'];
            $name_brand = $_POST['name_brand'];
            $desc_brand = $_POST['desc_brand'];
            $image = $_POST['image'];
            $flag = $this->brandModel->insertBrand(BrandModel::TABLE, $id_, $name_brand, $desc_brand, $image);
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

    public function editBrand()
    {   
        // $_POST['id_'] = 10;
        // $_POST['name_brand'] = "new name";
        // $_POST['desc_brand'] = "newer desc";
        // $_POST['image'] = "newer image";
        if (isset($_POST['id_']) && isset($_POST['name_brand']) && isset($_POST['desc_brand']) && isset($_POST['image'])) {
            $id_ = $_POST['id_'];
            $name_brand = $_POST['name_brand'];
            $desc_brand = $_POST['desc_brand'];
            $image = $_POST['image'];
            $flag = $this->brandModel->editBrandById(BrandModel::TABLE, $id_, $name_brand, $desc_brand, $image);
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


    public function deleteBrand()
    {   
        // $_POST['id_'] = 10;
        if (isset($_POST['id_'])) {
            $flag = $this->brandModel->deleteById(BrandModel::TABLE, $_POST['id_']);
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
}
