<?php
class CategoryModel extends BaseModel
{
    const TABLE = 'product_category';
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

    public function fetchAllCategories($table) {
        return $this->all($table);
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
            $priceRange = " BETWEEN  5000000  AND 10000000";
        }
        if($price === "Trên 10 triệu"){
            $priceRange = " > 10000000 ";
        }
        $conditions = "";
        if ($category != null) $conditions .= "product_category.name_category = '" .$category . "' AND ";
        if ($brand != null) $conditions .= "brand.name_brand = '" .$brand . "' AND ";
        if ($price != null) $conditions .= "products.price " .$priceRange . " AND ";
        if ($state != null) $conditions .= "datediff(now(), products.createAt) < 60 AND ";
        $conditions = substr($conditions, 0, -5);
        $sql = 'SELECT * FROM products JOIN brand ON brand.id_ = products.brand_id JOIN product_category on product_category.id_ = products.category_id join image on products.id = image.id_product where image.type = "thumbnail" AND ' .$conditions . ";";
        return $this->queryWithSql($sql);
    }

    public function insertCategory($table, $name_category, $desc_category, $image)
    {
        return $this->insertDB($table, [
            'name_category' => $name_category,
            'desc_category' => $desc_category,
            'image' => $image,
        ]);
    }

    public function editCategoryById($table, $id_, $name_category, $desc_category, $image)
    {

        return $this->editDbWithCond($table, [
            'name_category' => $name_category,
            'desc_category' => $desc_category,
            'image' => $image,
        ], [
            'id_' => $id_,
        ]);
    }

    public function deleteByID($table, $id_)
    {
        return $this->deleteWithCond($table, [
            'id_' => $id_
        ]);
    }
}
