<?php

include('autoload.php');

if(isset($_POST['action']))
{
    if(isset($_POST['id']))
    {
        echo $controller->$_POST['action']($_POST['id']);
    }

    if($_POST['action'] === "output" && isset($_POST['data']))
    {
        $data = json_decode($_POST['data'],true);
        echo $view->getFormattedColumns($data,true);
    }
}

