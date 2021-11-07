<?php
class OrderModel extends BaseModel
{
    const TABLE = 'orders';
    public function getOrderByStatus($table, $id_user, $status) {
    $sql = "SELECT * FROM {$table} WHERE status = '{$status}' AND id_user = {$id_user};";
    return $this->queryWithSql($sql);
    }

    public function getOrderDetail($table, $id) {
        $sql = "SELECT * FROM orders join order_details on orders.id = order_details.id_order join product_variant on product_variant.id = id_variant WHERE orders.id = {$id};";
        echo $sql;
        return $this->queryWithSql($sql);
    }
}
