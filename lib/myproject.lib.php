<?php

require_once(dirname(__FILE__) . '/../vendor/autoload.php');

function GETPOST($paramname)
{
    if (isset($_POST[$paramname]) && !empty($_POST[$paramname]))
        return $_POST[$paramname];
    if (isset($_GET[$paramname]) && !empty($_GET[$paramname]))
        return $_GET[$paramname];
    return null;
}

function GETPOSTISSET($paramname)
{
    return (isset($_POST[$paramname]) || isset($_GET[$paramname]));
}