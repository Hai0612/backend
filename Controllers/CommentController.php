<?php
// Session::init();
class CommentController extends BaseController{
    private $commentModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"),true);
        $this->loadModel("CommentModel");
        $this->commentModel = new CommentModel;
    }
    public function addComment(){

        if(isset($_POST['content']) && isset($_POST['id_product'])){
            $id_product = $_POST['id_product'];
            $id_user = $_POST['id_user'];
            $content = $_POST['content'];
            $flag =  $this->commentModel->addCmt(CommentModel::TABLE, $id_user, $id_product, $content);
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
        // $this->getCommentByProductCode();
    }
    public function getByIdProduct(){
        
        if(isset($_GET['id_product'])){
            $id_product = $_GET['id_product'];
            $listCmt = $this->commentModel->getCmtByProduct($id_product);
            if ($listCmt) {
                echo json_encode(
                    [
                        'status' => 200,
                        'payload' => $listCmt
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
    //-----------------------
    public function increVote(){
        if(isset($_GET['id_comment'])){
            $id_comment = $_GET['id_comment'];
            $flag = $this->commentModel->increVoteByID(CommentModel::TABLE, $id_comment);
            echo json_encode($flag);
        }
    }
    public function getCmtByUser(){
        
    }
}
?>