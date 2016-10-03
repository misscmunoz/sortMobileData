<?php
function __autoload($class) {
    include_once("./$class.php");
}

$model = new Model();
$controller = new Controller($model);
$view = new View($controller, $model);
