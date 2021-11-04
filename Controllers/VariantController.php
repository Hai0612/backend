<?php
class VariantController extends BaseController
{
    private $variantModel;
    public function __construct()
    {
        $this->loadModel('VariantModel');
        $this->variantModel = new VariantModel;
    }

    public function getByProductIndex()
    {
        if (isset($_GET['id_product'])) {
            $id_product = $_GET['id_product'];
            $variants = $this->variantModel->getVariantByProductIndex(VariantModel::TABLE, $id_product);
            if ($variants) {
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
