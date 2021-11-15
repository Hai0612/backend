<?php

class  BaseController {
    const VIEW_FOLDER_NAME = 'Views';

    const MODEL_FOLDER_NAME = 'Models';
    protected function view($viewpath, array $data = [])
    {
        foreach ($data as $key =>  $value){
            $$key = $value;
        }
        return require(self::VIEW_FOLDER_NAME .'/'. str_replace('.', '/' ,$viewpath) . '.php');
    }
    protected function loadModel($modelPath){
    //    echo self::MODEL_FOLDER_NAME . '/' . $modelPath . '.php';
        require(self::MODEL_FOLDER_NAME . '/' . $modelPath . '.php');
    }

}
?>