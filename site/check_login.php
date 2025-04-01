<?php
session_start();
require_once 'class/myAuthClass.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $auth = new myAuthClass();
    if ($auth->authenticate($username, $password)) {
        $_SESSION['user'] = $username;
        header('Location: index.php');
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
