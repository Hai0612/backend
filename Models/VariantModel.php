<?php
class VariantModel extends BaseModel
{

    const TABLE = 'product_variant';

    public function getVariantByProductIndex($table, $id_product)
    {
        return $this->getWithCond($table, [
            'id_product' => $id_product,
        ]);
    }
    public function getPriceBySize($table,$size,  $id_product){
        $sql = "SELECT product_variant.price FROM product_variant WHERE product_variant.id_product = " .$id_product . " AND product_variant.size  = '" . $size . "' LIMIT 1; ";
        return $this->queryWithSql($sql);
    }
    
}
