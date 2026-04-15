<?php
class BaseController{
    const VIEW_FOLDER_NAME='view';
    /*
        -- Description: 
            + Path name: folderName.
            + Lấy từ sau thư mục 
    */
    protected function view($viewPath, array $data=[]){
        $viewPath=self::VIEW_FOLDER_NAME.'/'.str_replace('.','/',$viewPath).'.php';
        return require ($viewPath);
    }
}
?>