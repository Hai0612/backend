<?php 
class ProductModel extends BaseModel{

    const TABLE = 'products';
    public function getAllProduct($table){
        return $this->all($table);
    }

    public function getProductByIndex($table, $id){
        return $this->getWithCond($table, [
            'id' => $id,
        ]);
    }

    public function getProductsByCategory($table, $category){
        if($category == 'All'){
            return $this->all($table);
        }
        $sql = "SELECT * FROM products inner join product_category on products.category_id = product_category.id_ where product_category.name_category = '" . $category . "';";
        return $this->queryWithSql($sql);
    }

    public function getProductQuantity($id) {
        $sql = "SELECT product_inventory.quantity FROM products join product_inventory on products.inventory_id = product_inventory.id and products.id = {$id};";
        return $this->queryWithSql($sql);
    }

    public function getRelatedProducts($id) {
        $sql = "SELECT * FROM products where products.category_id in (SELECT category_id FROM products where products.id =" . $id . ") and products.id != " . $id . ";";
        return $this->queryWithSql($sql);
    }

    public function getProductsByPrice($min, $max) {
        $sql = "SELECT * FROM products where products.price > " . $min . " and products.price < " . $max . ";";

        return $this->queryWithSql($sql);
    }

    public function fetchByMachineSearch($text){
        $sql = 'SELECT * FROM `products` WHERE products.name like \'%' . $text . '%\';';
        return $this->queryWithSql($sql);
    }

    public function editProductById($table, $id , $name, $description ,$category_id, $inventory_id, $price, $discount_id){

        return $this->editDbWithCond($table,[
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'category_id' => $category_id,
            'inventory_id' => $inventory_id,
            'price' => $price,
            'discount_id' => $discount_id,
        ]);
    }

    
    public function deleteByID($table, $id){
        return $this->deleteWithCond($table, [
            'id' => $id
        ]);
    }


    //-------------------------------
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
    // public function findByProductCode($table, $productCode){
    //     return $this->findProductCode($table, $productCode);

    // }
    // public function getCategory($table, $category){
    //     return $this->getByCategory($table, $category);
    // }
}
?>