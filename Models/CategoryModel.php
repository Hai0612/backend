<?php 
class CategoryModel extends BaseModel {
    const TABLE = 'products';
    const NUM_PRODUCT_A_PAGE = 9;
    // public function getAll($table, $line = NULL){
    //     return $this->all($table,['customerName','phone','city'], $line);
    // }
   
    public function findByProductCode($table, $productCode){
       // return $this->findProductCode($table, $productCode);

    }
    // public function getByCategory($table, $category){
    //     return $this->getByCategory($table, $category);
    // }
    public function showbyline($table, $line = NULL , $page = NULL){
            return $this->getWithCond($table, [
                'productLine' => $line,
            ], NULL,[
                self::NUM_PRODUCT_A_PAGE  * ($page-1), self::NUM_PRODUCT_A_PAGE 
            ] 
            );
    }
    public function addProduct($table, $code,$name,$line,  $vendor, $scale, $quantity,$price, $msrp, $image, $desc){
        return $this->insertDB($table, [
            'productCode' => $code,
            'productName' => $name,
            'productLine' => $line,
            'productScale' => $scale,
            'productVendor' => $vendor,
            'productDescription' => $desc,
            'quantityInStock' => $quantity,
            'buyPrice' => $price,
            'MSRP' => $msrp
        ]);
    }
}
?>