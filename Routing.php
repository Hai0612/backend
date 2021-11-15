<?php 
class Routing{
    public function get($routername, $callback){
        if(is_string($callback)){
            return $this->string_handler($callback);
        }
        else{
            $callback($callback);
        }
    }
    public function string_handler($string){
        if(strpos($string , "@")){
            return $this->class_handler($string);
        }else{
            return $string;
        }
    }
    public function class_handler($string){
        $exp = explode("@", $string);
        $className = $exp[0];
        $functionName = $exp[1] ;
        require "controller/$className.php";
        $obj = new $className;
        return $obj->$functionName();
    }
}

?>