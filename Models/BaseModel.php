<?php
class BaseModel extends Database{
    protected $connect; 
    protected function __query($sql)
    {
        return mysqli_query($this->connect, $sql );
    }
    public function __construct()
    {
        $this->connect = $this->connect();
    }
    public function all($table, array $columns = [], $orderBys = ['name'=> 'asc'], $limit = 100, $pageNumber = null )
    {   
        $cols = '';
        foreach($columns as $value){
                $cols = $cols  .' '.$value . ', ';
                $cols = substr($cols, 0 , -2);
                
            } 
        if($cols !== ''){
            $sql = "SELECT" .' '.$columns. " FROM ${table}";
        }else{
            $sql = "SELECT *". " FROM ${table}";
        }
        $query = $this->__query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query))
        {
            array_push($data, $row);
        }
    
        return $data;
    }
    public function getWithCond($table, $conditions, $columns = NULL ,$limit = NULL, $orders = []){
        // handle conditions
        $conds = '';
        foreach($conditions as $key => $value){
            $conds .= $key;
            $conds .= ' = ' . "\"". $value . "\"". " AND ";
        }
        $conds = substr($conds, 0 , -4);
        $cols = '';
        if($columns !== NULL){
            foreach($columns as $value){
                $cols = $cols  .' '.$value . ', ';
              

            } 
            $cols = substr($cols, 0 , -2);
        }else{
            $cols = " * ";
        }

        //handle limit
        $lm = "LIMIT ";
        if($limit !== NULL){
            $lm .=  $limit[0] . ', ' . $limit[1];
        }else{
            $lm = '';
        }
        
        //handle order
        $ords = 'ORDER BY ';
        foreach($orders as $key => $value){
            $ords .= $key . ' ' .$value;
        }
        if($ords === 'ORDER BY '){
            $ords = '';
        }
        //
        $sql = "SELECT" . $cols. " FROM " . $table. " WHERE ". $conds .' '  .$ords . ' ' .$lm;
        
        $query = $this->__query($sql);
        $data = [];
        
        while($row = mysqli_fetch_assoc($query))
        {
            array_push($data, $row);
        }
        return $data;
    }

    public function getWithGroup($table, $arrayGroup, $listCol = NULL , $limit = NULL){
        $groupCols = '';
        foreach($arrayGroup as $value){
            $groupCols .= $value;
        }
        $sql = "";
        if($groupCols !== '' && $listCol === NULL){
            $sql = "SELECT * FROM " .$table ." GROUP BY " .$groupCols; 
        }
     
        $query = $this->__query($sql);
        $data = [];
        while($row = mysqli_fetch_assoc($query))
        {
            array_push($data, $row);
        }
        return $data;
        
    }
    public function getWithManyTable($arrayTable, $conditions, $columns = NULL ,$limit = NULL){
        $conds = '';
        foreach($conditions as $key => $value){
            $conds .= $key;
            $conds .= ' = ' . "\"". $value . "\"". " AND ";
        }
        $conds = substr($conds, 0 , -4);
        $cols = '';
        if($columns !== NULL){
            foreach($columns as $value){
                $cols = $cols  .' '.$value . ', ';
              

            } 
            $cols = substr($cols, 0 , -2);
        }else{
            $cols = " * ";
        }
        $sel = "";
        if($limit !== NULL){
            $sel .= "LIMIT ". $limit[0] . ', ' . $limit[1];
        }
        
        $sql = NULL;
        $sql = "SELECT" . $cols. " FROM " . $arrayTable[0]." INNER JOIN " . $arrayTable[1] . " ON " . $arrayTable[0] . ".productCode = " . $arrayTable[1]
                                .  ".productCode". " WHERE ". $conds .$sel ;
        $query = $this->__query($sql);
        $data = [];
        
        while($row = mysqli_fetch_assoc($query))
        {
            array_push($data, $row);
        }
        return $data;
    
    }
    public function checkExistInDB($table, $conditions = null){
      
        $cond = '';
        foreach($conditions as $key => $value){
            $cond .= $key .' = ' . "\"".$value . "\"" . ' AND '; 
        }
        $cond = substr($cond, 0 , -4);

        $sql = "SELECT * FROM  " .$table. " WHERE " . $cond;
        $query = $this->__query($sql);
        if($users = mysqli_fetch_assoc($query)){
            return 1;
        }
        else{
            return 0;
        }
    }

    // add Database
    public function insertDB($table, $data){
        
        $cols = "";
        $row = "";
        foreach($data as $key => $value){
            $cols .= $key . ", ";
            $row .= '\'' . $value  . '\'' . ', ';
        }
        $cols = substr($cols, 0, -2);
        $row = substr($row, 0, -2);
        $sql = "INSERT INTO " . '`'. $table . '` ('. $cols. ") VALUES ( " .$row.  " )";
        $query = $this->__query($sql);
        var_dump($query);
        if($query){
            return 1;
        }
        return 0;
    }
    public function queryWithSql($sql){
        $data = [];
        $query = $this->__query($sql);
    
        while($row = mysqli_fetch_assoc($query))
        {
            array_push($data, $row);
        }
        return $data;

    }
    public function deleteWithCond($table, $conditions = NULL){
        $cond = '';
        foreach($conditions as $key => $value){
            $cond .= $key .' = ' . "\"".$value . "\"" . ' AND '; 
        }
        $cond = substr($cond, 0 , -4);
        $sql = "DELETE FROM " . $table . " WHERE " . $cond;
        echo $sql;
        die();
        $query = $this->__query($sql);  
        if($query){
            return true;
        }
        return false;
    }
    public function editDbWithCond($table, $conditions = NULL){
        $cond = '';
        $id_b = '';
        foreach($conditions as $key => $value){
            if($key == 'id_book'){
                $id_b = $value;
            }
            $cond .= '`'. $key . '`' .' = \''. $value . '\' ,';
        }
        $cond = substr($cond, 0 , -1);
        $sql = 'UPDATE '. $table . ' SET ' .$cond .' WHERE id_book = \'' . $id_b .'\'';
        $query = $this->__query($sql);
        if($query){
            return true;
        }
        else{
            return false;
        }
    }

  
}   

?>