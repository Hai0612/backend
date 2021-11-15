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
