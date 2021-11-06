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
        if (isset($_GET['orderstatus'])) {
            $status = $_GET['orderstatus'];
            $orders = $this->orderModel->getOrderByStatus(OrderModel::TABLE, $status);
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
}
