<?php 
    session_start();
class InfoController extends BaseController{
    // private $consumerModel ;
    // public function __construct(){
    //         $this->loadModel('ConsumerModel');
    //         $this->consumerModel = new ConsumerModel;
    // }
    // public function index(){
    //     $consumer = NULL;
        
    //     if(isset($_SESSION["login"])){
    //         $consumer = $this->consumerModel->getUser(ConsumerModel::TABLE, $_SESSION["login"]["username"]);
    //     }
       
    //     $this->view('frontend.info.index',[
    //         'consumer' => $consumer,
    //     ]);
    // }
    public function index(){
        $result = [];
        $handle = fopen("C:\Users\Hai\Downloads\ascii.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                array_push($result, $line);
            }
            fclose($handle);
        } else {
         
        } 
        echo json_encode($result);
    }
}


?>
