<?php

session_start();

require './core/Database.php';
require './model/BaseModel.php';
require './controller/BaseController.php';

$controllerName = ucfirst(strtolower($_REQUEST['controller'] ?? 'home')).'Controller';

$actionName=strtolower($_REQUEST['action'] ?? 'index');

require __DIR__.'/controller/'.$controllerName.'.php';

$controllerObject=new $controllerName();

$controllerObject->$actionName();
?>