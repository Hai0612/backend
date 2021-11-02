<?php 
Session::init();
class CommentModel extends BaseModel {
    const TABLE = "comments";
    
    public function __construct()
    {
        $this->connect = $this->connect();
    }
    public function getCmtByProduct($table, $id_product){

        return $this->getWithCond($table,[
                'id_product' => $id_product,
        ],null , null ,[
            'date' => 'DESC'
      ]);
    }
    public function increVoteByID($table, $id_comment){
        $sql = ' UPDATE `comments` SET comments.vote = ((SELECT comments.vote FROM comments WHERE comments.id_comment = \''. $id_comment .'\') + 1) WHERE comments.id_comment = \''.$id_comment.'\'';
        return $this->queryWithSql($table,  $sql);
    }
    public function addCmt($table, $id_user, $id_product, $content){   
        // $length_id = 10;    
        // $id_comment =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length_id);     
        return $this->insertDB($table, [
            'id_user' => $id_user,
            'id_product' => $id_product,
            'content' => $content,
            'date' => date("Y-m-d H:i:s"),
            ]);
    }
}

?>