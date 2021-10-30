<?php 
class ProductModel extends BaseModel{

    const TABLE = 'products';
    public function getAll($table, $pageNumber = null){
        return $this->all($table , [
            
        ],null, null, $pageNumber);
    }
    public function getDetail($table , $productCode = null){
        if($productCode !== false){
            return $this->getWithCond($table,[
                'productCode' => $productCode
            ]);
        }
        return null;
    }
    public function getListHot($table){
        return $this->getWithGroup($table, [
            'productLine',
        ]);
    }
    public function delete($table , $productCode){
        return $this->deleteWithCond($table, [
            'productCode' => $productCode,
        ]);
    }
    // public function findByProductCode($table, $productCode){
    //     return $this->findProductCode($table, $productCode);

    // }
    // public function getCategory($table, $category){
    //     return $this->getByCategory($table, $category);
    // }
}
?>