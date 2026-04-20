<?php

session_start();

require './core/Database.php';
require './model/BaseModel.php';
require './controller/BaseController.php';

// Hàm ucfirst() để ghi hoa chữ cái đầu.
$controllerName = ucfirst((strtolower($_REQUEST['controller']) ?? 'Homepage').'Controller');

$actionName=strtolower($_REQUEST['action'] ?? 'index');

require "./Controller/${controllerName}.php";

$controllerObject=new $controllerName();

$controllerObject->$actionName();
?>