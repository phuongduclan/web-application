<?php
class BaseController{
    const VIEW_FOLDER_NAME='view';
    const MODEL_FOLDER_NAME='model';
    /*
        -- Description: 
            + Path name: folderName.
            + Lấy từ sau thư mục 
    */
    protected function view($viewPath, array $data=[])
    {
        // Hàm extract() xử lí mảng thành biến
        extract($data);
        $viewPath=self::VIEW_FOLDER_NAME.'/'.str_replace('.','/',$viewPath).'.php';
        return require ($viewPath);
    }
    protected function loadModel($modelPath)
    {
        $modelPath=self::MODEL_FOLDER_NAME.'/'.$modelPath.'.php';
        return require ($modelPath);
    }

}
?>