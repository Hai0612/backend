<?php
class BrandModel extends BaseModel
{
    const TABLE = 'brand';

    public function findByProductCode($table, $productCode)
    {
        // return $this->findProductCode($table, $productCode);

    }
    public function fetchAllBrand($table){
        return $this->all($table);
    }
   
}
