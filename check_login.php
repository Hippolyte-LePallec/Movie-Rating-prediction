<?php
session_start();
// Permet d'activer l'affichage des erreurs
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once(dirname(__FILE__) . '/lib/myproject.lib.php');
if (GETPOST('debug') == true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}
require_once(dirname(__FILE__) . '/class/myAuthClass.php');
if (isset($_POST['connect']) || isset($_POST['username']) || isset($_POST['uname'])) {
    $uname = isset($_POST['uname']) ? $_POST['uname'] : $_POST['username'];
    $psw = isset($_POST['psw']) ? $_POST['psw'] : (isset($_POST['pwd']) ? $_POST['pwd'] : $_POST['password']);
    $user = myAuthClass::authenticate($uname, $psw);
    if ($user["rowid"] > 0)
    {
        $_SESSION['mesgs']['confirm'][] = 'Connexion réussie ' . $user['username'];
        $_SESSION['login'] = $user['username'];
        $_SESSION['user'] = $user;
    }
    else{
        $_SESSION['mesgs']['errors'][] = 'Identification impossible';
    }
}
header('Location:index.php');
?>