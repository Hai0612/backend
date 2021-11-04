<?php
class CategoryModel extends BaseModel
{
    const TABLE = 'products';
    const NUM_PRODUCT_A_PAGE = 9;
    // public function getAll($table, $line = NULL){
    //     return $this->all($table,['customerName','phone','city'], $line);
    // }

    public function findByProductCode($table, $productCode)
    {
        // return $this->findProductCode($table, $productCode);

    }
    // public function getByCategory($table, $category){
    //     return $this->getByCategory($table, $category);
    // }
    public function showbyCategoryId($table, $category_id = NULL, $page = NULL)
    {
        return $this->getWithCond(
            $table,
            [
                'category_id' => $category_id,
            ],
            NULL,
            [
                self::NUM_PRODUCT_A_PAGE  * ($page - 1), self::NUM_PRODUCT_A_PAGE
            ]
        );
    }

    public function getProductsByOption($table, $category, $brand, $price, $state){
        $priceRange = '';
        if($price === "0 - 500.000") {
            $priceRange = " BETWEEN  0  AND 500000";
        }
        if($price === "Dưới 1 triệu"){
            $priceRange = " BETWEEN  500000  AND 1000000";
        }
        if($price === "Từ 1 - 5 triệu"){
            $priceRange = " BETWEEN  1000000  AND 5000000";
        }
        if($price === "Từ 5 - 10 triệu"){
            $priceRange = " > 10000000";
        }
        $conditions = "";
        if ($category != null) $conditions .= "product_category.name_category = '" .$category . "' AND ";
        if ($brand != null) $conditions .= "brand.name_brand = '" .$brand . "' AND ";
        if ($price != null) $conditions .= "product.price " .$priceRange . " AND ";
        if ($state != null) $conditions .= "month(datediff(now(), products.createAt)) < 2 AND ";
        $conditions = substr($conditions, 0, -5);
        $sql = 'SELECT * FROM products JOIN brand ON brand.id_ = products.brand_id JOIN product_category on product_category.id_ = products.category_id WHERE  ' .$conditions . ";";
        echo $sql;
        //die();
        return $this->queryWithSql($sql);
    }

    public function addProduct($table, $id, $name, $description, $category_id, $price, $discount_id)
    {
        return $this->insertDB($table, [
            'id' => $id,
            'name' => $name,
            '$description' => $description,
            'category_id' => $category_id,
            'price' => $price,
            'discount_id' => $discount_id,
        ]);
    }
}
