<?php
session_start(); // Démarrage de la session
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once(dirname(__FILE__) . '/../class/myAuthClass.php');
$authorized = myAuthClass::is_auth($_SESSION);
if (!$authorized) {
    include dirname(__FILE__).'/../login.php';
    exit(1);
}
