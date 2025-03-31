<?php
session_start(); // Démarrage de la session
session_unset(); // Nettoyage des valeurs de session
$_SESSION['mesgs']['confirm'][] = 'Vous avez été correctement déconnecté';
header('Location:index.php');