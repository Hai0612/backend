<?php
class BrandModel extends BaseModel
{
    const TABLE = 'brand';
    const NUM_PRODUCT_A_PAGE = 9;
    public function findByProductCode($table, $productCode)
    {
        // return $this->findProductCode($table, $productCode);

    }
    public function fetchAllBrand($table){
        return $this->all($table);
    }
    
    public function showbyBrandId($table, $brand_id = NULL, $page = NULL)
    {
        return $this->getWithCond(
            $table,
            [
                'brand_id' => $brand_id,
            ],
            NULL,
            [
                self::NUM_PRODUCT_A_PAGE  * ($page - 1), self::NUM_PRODUCT_A_PAGE
            ]
        );
    }
    public function insertBrand($table, $name_brand, $desc_brand, $image)
    {
        return $this->insertDB($table, [
            'name_brand' => $name_brand,
            'desc_brand' => $desc_brand,
            'image' => $image,
        ]);
    }

    public function editBrandById($table, $id_, $name_brand, $desc_brand, $image)
    {

        return $this->editDbWithCond($table, [
            'name_brand' => $name_brand,
            'desc_brand' => $desc_brand,
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
