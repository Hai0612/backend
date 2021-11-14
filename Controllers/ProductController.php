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

    public function getImage()
    { {
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

    public function getFeatured()
    {
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

    public function addProduct()
    {
        // $_POST['id'] = 105;
        // $_POST['name'] = "Sản phẩm test 2 ";
        // $_POST['description'] = "test 3";
        // $_POST['category'] = 'Shirt';
        // $_POST['brand'] = 'Nike';
        // $_POST['price'] = 100000;
        // $_POST['discount_id'] = 2;
        if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['category']) && isset($_POST['brand']) && isset($_POST['price'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $category_id = $this->productModel->getProductCategoryId($_POST['category']);
            if ($category_id) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $category_id
                    ]
                );
            } else {
                echo json_encode(
                    [
                        'status' => 404,
                        'payload' => 'category unexist'
                    ]
                );
            }

            $brand_id = $this->productModel->getProductBrandId($_POST['brand']);
            if ($brand_id) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $brand_id
                    ]
                );
            } else {
                echo json_encode(
                    [
                        'status' => 404,
                        'payload' => 'brand unexist'
                    ]
                );
            }

            $price =  $_POST['price'];
            $discount_id = $_POST['discount_id'];
            $flag = $this->productModel->insertProduct(ProductModel::TABLE, $id, $name, $description, $category_id, $brand_id, $price, $discount_id);
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
    public function editProduct()
    {
        // $_POST['id'] = 103;
        // $_POST['name'] = "Sản phẩm test sau khi edit";
        // $_POST['description'] = "test new";
        // $_POST['price'] = 100000;
        // $_POST['discount_id'] = 1;
        if (isset($_POST['name']) && isset($_POST['id']) && isset($_POST['price'])) {
            $id = $_POST['id'];
            $name  = $_POST['name'];
            $desciption = $_POST['description'];
            $price = $_POST['price'];
            $discount_id = $_POST['discount_id'];
            $flag = $this->productModel->editProductById(ProductModel::TABLE, $id, $name, $desciption, $price, $discount_id);
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
        // $_POST['id'] = 103;
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

    public function getCategoryId()
    { {
            if (isset($_GET['text'])) {
                $text = $_GET['text'];
                $category_id = $this->productModel->getProductCategoryId(ProductModel::TABLE, $text);
                if ($category_id) {
                    echo json_encode(
                        [
                            'status' => 200,
                            'payload' => $category_id,
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
