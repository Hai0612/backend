<?php 
Session::init();
class ImageModel extends BaseModel {
    const TABLE = "image";
    
    public function __construct()
    {
        $this->connect = $this->connect();
    }
    public function getImagesByProduct($table, $id_product){
        return $this->getWithCond($table,[
                'id_product' => $id_product,
        ]);
    }
}

?>