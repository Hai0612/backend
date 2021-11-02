<?php
// Session::init();
class ImageController extends BaseController{
    private $imageModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"),true);
        $this->loadModel("ImageModel");
        $this->imageModel = new ImageModel;
    }
    public function getByIdProduct(){  
        if(isset($_GET['id_product'])){
            $id_product = $_GET['id_product'];
            $listImage = $this->imageModel->getImagesByProduct(ImageModel::TABLE,$id_product);
            echo json_encode($listImage);
            echo "<pre/>";
            echo print_r($listImage);
        }
    
    }
}
?>