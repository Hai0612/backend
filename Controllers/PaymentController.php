<?php
class PaymentController extends BaseController
{
    private $paymentModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->loadModel('PaymentModel');
        $this->paymentModel = new PaymentModel;
    }
    public function insertUserPayment(){

        if(isset($_POST['user_id']) && isset($_POST['card_type']) && isset($_POST['provider']) && isset($_POST['account_no']) && isset($_POST['expiry'])){
            $user_id = $_POST['user_id'] ;
            $card_type = $_POST['card_type'] ;
            $provider = $_POST['provider'] ;
            $account_no = $_POST['account_no'] ;
            $expiry = $_POST['expiry'] ;
            $flag = $this->paymentModel->insertUserPay(PaymentModel::TABLE2, $user_id, $card_type, $provider, $account_no, $expiry);
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
    public function insertUserPaymentCOD(){

        if(isset($_POST['user_id']) && isset($_POST['card_type']) && isset($_POST['provider']) && isset($_POST['account_no']) && isset($_POST['expiry'])){
            $user_id = $_POST['user_id'] ;
            $card_type = $_POST['card_type'] ;
            $provider = $_POST['provider'] ;
            $account_no = $_POST['account_no'] ;
            $expiry = $_POST['expiry'] ;
            $flag = $this->paymentModel->insertUserPay(PaymentModel::TABLE2, $user_id, $card_type, $provider, $account_no, $expiry);
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

    
    public function insertPaymentDetail(){
        if(isset($_POST['id']) && isset($_POST['payment_type']) && isset($_POST['card_id'])){
            $id = $_POST['id'] ;
            $payment_type = $_POST['payment_type'] ;
            $card_id = intval($_POST['card_id']) ;
            $flag = $this->paymentModel->insertPayDet(PaymentModel::TABLE1, $id, $payment_type, $card_id);
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
