<?php
session_start();
// Permet d'activer l'affichage des erreurs
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once(dirname(__FILE__) . '/lib/myproject.lib.php');
require_once(dirname(__FILE__) . '/class/user.class.php'); 

$user = new User($db);


if (GETPOST('debug') == true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

echo '1';
if (isset($_POST['connect']) || isset($_POST['username']) || isset($_POST['uname'])) {
    $uname = isset($_POST['uname']) ? $_POST['uname'] : $_POST['username'];
    $psw = isset($_POST['psw']) ? $_POST['psw'] : (isset($_POST['pwd']) ? $_POST['pwd'] : $_POST['password']);


    if ($db) {

        $userconnect=$user->getUser($uname);
        
        if ($userconnect && password_verify($psw, $userconnect['password'])) {
            // Connexion réussie
            
            $_SESSION['mesgs']['confirm'][] = 'Connexion réussie ' . htmlspecialchars($userconnect['username']);
            $_SESSION['login'] = $userconnect['username'];
            $_SESSION['user'] = $userconnect;
        } else {
            // Identification impossible
            
            $_SESSION['mesgs']['errors'][] = 'Identification impossible';
        }
    } else {
        $_SESSION['mesgs']['errors'][] = 'Erreur de connexion à la base de données.';
    }
}
header('Location: index.php');
?>
