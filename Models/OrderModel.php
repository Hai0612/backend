<?php
class OrderModel extends BaseModel
{
    const TABLE = 'orders';
    public function getOrderByStatus($table, $id_user, $status) {
    $sql = "SELECT * FROM {$table} WHERE status = '{$status}' AND id_user = {$id_user};";
    return $this->queryWithSql($sql);
    }

    public function getOrderDetail($table, $id) {
        $sql = "SELECT * FROM orders join order_details on orders.id = order_details.id_order join product_variant on product_variant.id = id_variant 
        join image on products.id = image.id_product where image.type = 'thumbnail' and orders.id = {$id};";
        return $this->queryWithSql($sql);
    }
}
