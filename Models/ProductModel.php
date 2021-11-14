<?php
class ProductModel extends BaseModel
{

    const TABLE = 'products';
    public function getAllProduct($table)
    {
        return $this->all($table);
    }

    public function getProductByIndex($table, $id)
    {
        $sql = "SELECT * FROM products join product_variant on product_variant.id_product = products.id where products.id = {$id};";
        return $this->queryWithSql($sql);
    }

    public function getProductImage($table, $id)
    {
        $sql = "SELECT * FROM products join image on products.id = image.id_product where products.id = {$id};";
        return $this->queryWithSql($sql);
    }
    public function getProductsByBrand($table, $brand)
    {
        if ($brand == 'All') {
            return $this->all($table);
        }
        $sql = "SELECT * FROM products join brand on products.brand_id = brand.id_ join image on products.id = image.id_product where image.type = 'thumbnail' and brand.name_brand = '" . $brand . "';";
        return $this->queryWithSql($sql);
    }

    public function getFeaturedProduct($table)
    {
        $sql = "SELECT * FROM products join image on products.id = image.id_product where image.type = 'thumbnail' order by sold desc limit 10;";
        return $this->queryWithSql($sql);
    }

    public function getProductsByCategory($table, $category)
    {
        if ($category == 'All') {
            return $this->all($table);
        }
        $sql = "SELECT * FROM products join product_category on products.category_id = product_category.id_ join image on products.id = image.id_product where image.type = 'thumbnail' and product_category.name_category = '" . $category . "';";
        return $this->queryWithSql($sql);
    }


    // public function sortProduct($table, $criteria, $order)
    // {

    //     return $this->getWithCond($table, null, null, null, [
    //         $criteria => $order
    //     ]);
    // }

    public function getRelatedProducts($id)
    {
        $sql = "SELECT * FROM products join image on products.id = image.id_product where image.type = 'thumbnail' and products.category_id in (SELECT category_id FROM products where products.id =" . $id . ") and products.id != " . $id . ";";
        return $this->queryWithSql($sql);
    }

    public function getProductsByPrice($min, $max)
    {
        $sql = "SELECT * FROM products join image on products.id = image.id_product where image.type = 'thumbnail' and products.price >= " . $min . " and products.price <= " . $max . ";";

        return $this->queryWithSql($sql);
    }

    public function fetchByMachineSearch($text)
    {
        $sql = "SELECT * FROM products join image on products.id = image.id_product where image.type = 'thumbnail' and products.name like '%{$text}%';";
        echo $sql;
        return $this->queryWithSql($sql);
    }



    public function editProductById($table, $id, $name, $description, $price, $discount_id)
    {

        return $this->editDbWithCond($table, [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'discount_id' => $discount_id,
        ], [
            'id' => $id,
        ]);
    }


    public function deleteByID($table, $id)
    {
        return $this->deleteWithCond($table, [
            'id' => $id
        ]);
    }

   
    public function insertProduct($table, $name, $description, $category_id, $brand_id, $price, $discount_id)
    {   
        
        return $this->insertDB($table, [
            'name' => $name,
            'description' => $description,
            'category_id' => $category_id,
            'brand_id' => $brand_id,
            'price' => $price,
            'discount_id' => $discount_id,
            'createAt' => date("y-m-d"),
            'sold' => 0,
        ]);
    }
    //-------------------------------
    public function getAll($table, $pageNumber = null)
    {
        return $this->all($table, [], null, null, $pageNumber);
    }



    public function getDetail($table, $productCode = null)
    {
        if ($productCode !== false) {
            return $this->getWithCond($table, [
                'productCode' => $productCode
            ]);
        }
        return null;
    }
    public function getListHot($table)
    {
        return $this->getWithGroup($table, [
            'productLine',
        ]);
    }

    public function getProductCategoryId($category) {
        $sql = "SELECT id_ FROM product_category WHERE name_category = '{$category}';";
        $category_id = $this->queryWithSql($sql)[0]['id_'];
        return (int)$category_id;
    }

    public function getProductBrandId($brand) {
        $sql = "SELECT id_ FROM brand WHERE name_brand = '{$brand}';";
        $brand_id = $this->queryWithSql($sql)[0]['id_'];
        return (int)$brand_id;
    }
    // public function findByProductCode($table, $productCode){
    //     return $this->findProductCode($table, $productCode);

    // }
    // public function getCategory($table, $category){
    //     return $this->getByCategory($table, $category);
    // }
}
