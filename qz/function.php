<?php
function index($entryController = 'empty'){
    $controller = @$_GET['c'];
    $action = @$_GET['a'];
    $controller = ($controller == null)?$entryController:$controller;
    $action = ($action == null)?'emptyAction':$action;
    require_once "./Controller/$controller.php";
    $controller = $controller.'Controller';
    $a = new $controller();
    $a->$action();
}