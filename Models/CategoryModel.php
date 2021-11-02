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
    public function addProduct($table, $id, $name, $description, $category_id, $inventory_id, $price, $discount_id)
    {
        return $this->insertDB($table, [
            'id' => $id,
            'name' => $name,
            '$description' => $description,
            'category_id' => $category_id,
            'inventory_id' => $inventory_id,
            'price' => $price,
            'discount_id' => $discount_id,
        ]);
    }
}
