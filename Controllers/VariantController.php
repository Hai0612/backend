<?php
class VariantController extends BaseController
{
    private $variantModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->loadModel('VariantModel');
        $this->variantModel = new VariantModel;
    }
    public function fetchPriceBySize(){
        if (isset($_POST['size']) && isset($_POST['id_product'])) {
            $size = $_POST['size'];
            $id_product = $_POST['id_product'];
            $price = $this->variantModel->getPriceBySize(VariantModel::TABLE,$size, $id_product);
            if ($price !== null) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $price
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
    public function getByProductIndex()
    {   
        if (isset($_GET['id_product'])) {
            $id_product = $_GET['id_product'];
            $variants = $this->variantModel->getVariantByProductIndex(VariantModel::TABLE, $id_product);
            if (count($variants) > 0) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $variants
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
