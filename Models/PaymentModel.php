<?php
class PaymentModel extends BaseModel
{
    const TABLE1 = 'payment_detail';
    const TABLE2 = 'user_payment';
    public function index(){

    }
    public function insertUserPay($table ,$user_id, $card_type, $provider, $account_no, $expiry ){
        $flag = $this->checkExistInDB($table,[
            'user_id' =>$user_id,
            'card_type' => $card_type,
            'account_no' => 0,
        ]);
        if($flag){
            return 0;
        }else{
            return $this->insertDB($table ,[
                'user_id' => $user_id,
                'card_type' => $card_type,
                'provider' => $provider,
                'account_no' => $account_no,
                'expiry' => $expiry
                ]
            );
        }
    }
    public function insertPayDet($table,$id, $payment_type, $card_id){
        return $this->insertDB($table ,[
            'id' => $id,
            'payment_type' => $payment_type,
            'card_id' => $card_id,
            'created_at' => 'now()' ,
            ]
        );
    }
}
