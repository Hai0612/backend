<?php
class OrderController extends BaseController
{
    private $orderModel;
    private $commentModel;
    private $userModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->loadModel('OrderModel');
        $this->orderModel = new OrderModel;
    }
    public function fetchAll(){
        $orders = $this->orderModel->fetchAllOrder(OrderModel::TABLE);
        echo json_encode([
            'status' => 200,
            'payload' => $orders,
        ]);
    }
    public function getByStatus()
    {   
        if (isset($_GET['orderstatus']) && isset($_POST['id_user'])) {
            $id_user = $_POST['id_user'];
            $status = $_GET['orderstatus'];
            $orders = $this->orderModel->getOrderByStatus(OrderModel::TABLE, $id_user, $status);
            if ($orders) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $orders
                    ]
                );
            } else {
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }
        }
    }

    public function getDetail() {
        if (isset($_GET['order_id'])) {
            $id_order = $_GET['order_id'];
            $products = $this->orderModel->getOrderDetail(OrderModel::TABLE, $id_order);
            if ($products) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $products
                    ]
                );
            } else {
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }
        }
    }
    public function addOrder(){
        if (isset($_POST['id_user']) && $_POST['orderAddress'] && $_POST['totalAmount'] && $_POST['status']) {
            $id_user = $_POST['id_user'];
            $orderAddress = $_POST['orderAddress'];
            $totalAmount = $_POST['totalAmount'];
            $status = $_POST['status'];

            $flag = $this->orderModel->insertOrder(OrderModel::TABLE, $id_user, $orderAddress, $totalAmount, $status);
            if ($flag) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $flag
                    ]
                );
            } else {
                echo json_encode(
                    [
                        'status' => 404,
                    ]
                );
            }
        }
        
    }
    public function addOrderDetail(){
      
    if (isset($_POST['products']) && $_POST['id_order']) {
        $products = $_POST['products'];
        $id_order = $_POST['id_order'];
        // print_r($products);
        $flag = $this->orderModel->insertOrderDetail(OrderModel::TABLE,$id_order, $products);
        if ($flag) {
            echo json_encode(
                [
                    'status' => 200,
                    'payload' => $flag
                ]
            );
        } else {
            echo json_encode(
                [
                    'status' => 404,
                ]
            );
        }
    }
}

}
