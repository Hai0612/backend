<?php 
Session::init();
class CommentModel extends BaseModel {
    const TABLE = "comments";
    
    public function __construct()
    {
        $this->connect = $this->connect();
    }
    public function getCmtByBook($table, $id_book){

        return $this->getWithCond($table,[
                'id_book' => $id_book,
        ],null , null ,[
            'time' => 'DESC'
      ]);
    }
    public function increVoteByID($table, $id_comment){
        $sql = ' UPDATE `comments` SET comments.vote = ((SELECT comments.vote FROM comments WHERE comments.id_comment = \''. $id_comment .'\') + 1) WHERE comments.id_comment = \''.$id_comment.'\'';
        return $this->queryWithSql($table,  $sql);
    }
    public function addCmt($table,$user,$id_book, $content){   
        $length_id= 10;    
        $id_comment =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length_id);     
        return $this->insertDB($table, [
            'id_comment' => $id_comment,
            'id_user' => $user,
            'id_book' => $id_book,
            'content' => $content,
            'time' => strval(date("Y-m-d h:i:sa")),
            'vote' => 1,
            ]);
    }
}

?>