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
        if(isset($_POST['content']) && isset($_POST['id_book'])){
            $id_book = $_POST['id_book'];
            $content = $_POST['content'];
            $flag =  $this->commentModel->addCmt(CommentModel::TABLE,$username = 'Hai',$id_book, $content);
            if($flag){
               
                echo json_encode($flag);
            }
        }
        // $this->getCommentByProductCode();
    }
    public function getByIdbook(){
        
        if(isset($_GET['id_book'])){
            $id_book = $_GET['id_book'];
            $listCmt = $this->commentModel->getCmtByBook(CommentModel::TABLE,$id_book);
            echo json_encode($listCmt);
        }
    
    }
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