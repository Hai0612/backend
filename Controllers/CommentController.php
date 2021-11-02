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
        $_POST['content'] = 'abcd test 2';
        $_POST['id_product'] = 3;
        if(isset($_POST['content']) && isset($_POST['id_product'])){
            $id_book = $_POST['id_product'];
            $content = $_POST['content'];
            $flag =  $this->commentModel->addCmt(CommentModel::TABLE, $id_user = 2, $id_book, $content);
            if($flag){
               
                echo json_encode($flag);
            }
        }
        // $this->getCommentByProductCode();
    }
    public function getByIdProduct(){
        
        if(isset($_GET['id_product'])){
            $id_product = $_GET['id_product'];
            $listCmt = $this->commentModel->getCmtByProduct(CommentModel::TABLE,$id_product);
            echo json_encode($listCmt);
            echo "<pre/>";
            echo print_r($listCmt);
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