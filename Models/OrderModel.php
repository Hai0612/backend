<?php
class OrderModel extends BaseModel
{
    const TABLE = 'orders';

    public function getOrderByStatus($table, $id_user, $status)
    {
        $sql = "SELECT * FROM {$table} WHERE status = '{$status}' AND id_user = {$id_user};";
        return $this->queryWithSql($sql);
    }
    public function countAllOrder($table){
        $sql = "SELECT COUNT(*) as total FROM " .$table;
        return $this->queryWithSql($sql);
    }
    public function fetchAllOrder($table)
    {
        return $this->all($table);
    }
    public function getOrderDetail($table, $id)
    {
        $sql = "SELECT products.id, products.name,product_variant.price,order_details.quantity_product, image.url FROM orders join order_details on orders.id = order_details.id_order join product_variant on product_variant.id = order_details.id_variant join products ON products.id = product_variant.id_product join image on product_variant.id_product = image.id_product where image.type = 'thumbnail' and orders.id = " . $id;
        return $this->queryWithSql($sql);
    }
    public function insertOrder($table,  $id_user, $orderAddress, $totalAmount, $status)
    {
        $sql = "INSERT INTO `orders`( `id_user`, `orderDate`, `orderAddress`, `requiredDate`, `shippedDate`, `totalAmount`, `status`) 
        VALUES ( " . $id_user . " , now(), '" . $orderAddress . "' , now()"   . " , now() , " . $totalAmount . ", '" . $status . "')";
        $flag = $this->updateWithSql($sql);
        if ($flag) {
            $sql1 = "SELECT max(orders.id) as max FROM orders;";
            $id = $this->queryWithSql($sql1);
            return $id[0]['max'];
        }
    }
    public function insertOrderDetail($table,  $id_order, $products)
    {
        $sql = '';
        $flag = false;
        foreach ($products as $key => $value) {
            $sql = "INSERT INTO `order_details`(`id_order`, `id_variant`, `quantity_product`) VALUES (" . $id_order . ' , ' . $value['id_variant'] . " , "  . $value['quantity'] . ");";
            $flag =  $this->updateWithSql($sql);
        }
        return $flag;
    }
}
