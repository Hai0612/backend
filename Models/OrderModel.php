<?php
class OrderModel extends BaseModel
{
    const TABLE = 'orders';
    public function getOrderByStatus($table, $status) {
    $sql = "SELECT * FROM {$table} WHERE status = '{$status}';";
    return $this->queryWithSql($sql);
    }
}
