<?php
class ProductController extends BaseController
{
    private $productModel;
    private $commentModel;
    private $userModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;
    }

    public function getAll()
    {
        $products = $this->productModel->getAllProduct(ProductModel::TABLE);
        if (count($products) > 0) {
            echo json_encode(
                [
                    'status' => 200,
                    'payload' => $products
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

    public function getImage() {
        {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $images = $this->productModel->getProductImage(ProductModel::TABLE, $id);
                if (count($images) > 0) {
                    echo json_encode(
                        [
                            'status' => 200,
                            'payload' => $images
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
        }
    }

    public function getByIndex()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $products = $this->productModel->getProductByIndex(ProductModel::TABLE, $id);
            if (count($products) > 0) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $products
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
    }

    public function getFeatured() {
        $products = $this->productModel->getFeaturedProduct(ProductModel::TABLE);
        if (count($products) > 0) {
            echo json_encode(
                [
                    'status' => 200,
                    'payload' => $products
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
    public function getByCategory()
    {
        if (isset($_GET['category'])) {
            $category = $_GET['category'];
            $products = $this->productModel->getProductsByCategory(ProductModel::TABLE, $category);
            if (count($products) > 0) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $products
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
    }

    public function getByBrand()
    {
        if (isset($_GET['brand'])) {
            $brand = $_GET['brand'];
            $products = $this->productModel->getProductsByBrand(ProductModel::TABLE, $brand);
            if (count($products) > 0) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $products
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
    }
    public function getRelated()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $products = $this->productModel->getRelatedProducts($id);
            if (count($products) > 0) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $products
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
    }

    public function getByPrice()
    {
        if (isset($_GET['min'])) {
            $min = $_GET['min'];
        } else $min = 0;
        if (isset($_GET['max'])) {
            $max = $_GET['max'];
        }
        // set tạm max
        else $max = 100000000;
        $products = $this->productModel->getProductsByPrice($min, $max);
        if (count($products) > 0) {
            echo json_encode(
                [
                    'status' => 200,
                    'payload' => $products
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

    public function searchMachine()
    {   
        if (isset($_POST['searchText'])) {
            $text = $_POST['searchText'];
            $results_product = $this->productModel->fetchByMachineSearch($text);
            echo json_encode(
                array(
                    'status' => '200',
                    'payload' => $results_product
                )
            );
        }
    }

    public function editProduct()
    {
        if (isset($_POST['name']) && isset($_POST['id'])) {
            $id = $_POST['id'];
            $name  = $_POST['name'];
            $desciption = $_POST['description'];
            $category_id  = $_POST['category_id'];
            $price = $_POST['price'];
            $discount_id = $_POST['discount_id'];
            $flag = $this->bookModel->editBookById(ProductModel::TABLE, $id, $name, $desciption, $category_id, $price, $discount_id);
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

    public function deleteProductById()
    {
        if (isset($_POST['id'])) {
            $flag = $this->productModel->deleteById(ProductModel::TABLE, $_POST['id']);
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

    //--------------------------
    public function index()
    {
        $this->loadModel('UserModel');
        $this->userModel = new UserModel;
        if (isset($_COOKIE["username"])) {
            // $user = $this->userModel->getMyAccount(UserModel::TABLE , $_COOKIE['username']);
        }
        $pageNumber = '';
        if (isset($_GET['page'])) {
            $pageNumber = $_GET['page'];
        }

        $products = $this->productModel->getAllProduct(ProductModel::TABLE, $pageNumber);
        $list_hot = $this->productModel->getListHot(ProductModel::TABLE);

        $this->view('frontend.products.index', [
            'products' => $products,
            'list_hot' => $list_hot,

        ]);
    }
    public function detail()
    {
        $this->loadModel('CommentModel');
        $this->commentModel = new CommentModel;

        $productCode = $_GET['productCode'] ? $_GET['productCode'] : false;
        $product = $this->productModel->getProductByIndex(ProductModel::TABLE, $productCode);
        // $comments = $this->commentModel->getCmtByProduct(CommentModel::TABLE , $productCode);
        $this->view('frontend.products.detail', [
            'product' => $product,
            // 'comments' => $comments,
        ]);
    }
}
