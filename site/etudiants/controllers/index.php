<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//--------------------------------------------------------------------------------------
require_once dirname(__FILE__) . '/../../class/myAuthClass.php';
require_once dirname(__FILE__) . '/../../class/classement.class.php';
//--------------------------------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) 
{
    session_start();
}
if (!myAuthClass::is_auth($_SESSION)) 
{
    header('Location: index.php');
    exit();
}
//--------------------------------------------------------------------------------------
if (!isset($_SESSION['mesgs'])) 
{
    $_SESSION['mesgs'] = [];
}
if (!isset($_SESSION['mesgs']['confirm'])) 
{
    $_SESSION['mesgs']['confirm'] = [];
}
if (!isset($_SESSION['mesgs']['errors'])) 
{
    $_SESSION['mesgs']['errors'] = [];
}
//--------------------------------------------------------------------------------------
$classement = new Classement($db);
$classementsParAnnee = [];

$classementsParAnnee = $classement->getClassementParAnnee();
