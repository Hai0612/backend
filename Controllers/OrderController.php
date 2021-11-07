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

    public function getByStatus()
    {   
        if (isset($_GET['orderstatus']) && isset($_POST['id_user'])) {
            $status = $_GET['orderstatus'];
            $id_user = $_POST['id_user'];
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


}
