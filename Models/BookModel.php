<?php 
class BookModel extends BaseModel{
    const TABLE = 'books';
    public function getAllBook($table){
        return $this->all($table);
    }
    public function getByCategoryBook($table, $category){
        if($category == 'All'){
            return $this->all($table);
        }
        return $this->getWithCond($table, [
                'bookline' => $category,
            ]);
    }
    public function getBookByIndex($table, $id_book){
        return $this->getWithCond($table, [
            'id_book' => $id_book,
        ]);
    }
    public function fetchByMachineSearch($text){
        $sql = 'SELECT * FROM `books` WHERE books.name like \'%' . $text . '%\';';
        return $this->queryWithSql($sql);
    }
    public function editBookById($table,$id_book , $name, $bookLine ,$quantity, $ordered, $price, $author, $publisher, $views, $desciption, $image){

        return $this->editDbWithCond($table,[
            'id_book' => $id_book,
            'name' => $name,
            'bookLine' => $bookLine,
            'quantity' => $quantity,
            'ordered' => $ordered,
            'price' => $price,
            'author' => $author,
            'publisher' => $publisher,
            'views' => $views,
            'description' => $desciption,
            'image' => $image
        ]);
    }
    public function fetchByManyConditions($conditions){
        return $this->queryWithSql($conditions);
    }
}
?>