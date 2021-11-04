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
}
