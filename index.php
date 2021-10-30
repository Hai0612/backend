<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
require('Core/constant.php');
require('./Core/Database.php');
require('./Models/BaseModel.php');
require('./Core/Session.php');
require('./Controllers/BaseController.php');
require('JWT.php');
if(isset($_REQUEST['controller']) && !empty($_REQUEST['controller'])){
    $controllerName = ucfirst((strtolower($_REQUEST['controller']) ?? 'Welcome') .'Controller'); 
    
    if(isset($_REQUEST['action'])){
        $actionName = strtolower($_REQUEST['action']?? 'index');
        require("./Controllers/${controllerName}.php");
        $controllerOb = new $controllerName;
        $controllerOb->$actionName();
    }else{
       
        $actionName = 'index';
        require("./Controllers/${controllerName}.php");
        $controllerOb = new $controllerName;
        $controllerOb->$actionName();
       
    }
} else{
   
    // require('./Views/frontend/home/index.php');
    header("Location:".BASE_URL ."index.php?controller=home");
}

    
?>