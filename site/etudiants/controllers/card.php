<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//--------------------------------------------------------------------------------------
require_once dirname(__FILE__) . '/../../class/myAuthClass.php';
require_once dirname(__FILE__) . '/../../class/etudiant.class.php';
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
if (!isset($_SESSION['mesgs'])) {
    $_SESSION['mesgs'] = [];
}

if (!isset($_SESSION['mesgs']['confirm'])) {
    $_SESSION['mesgs']['confirm'] = [];
}

if (!isset($_SESSION['mesgs']['errors'])) {
    $_SESSION['mesgs']['errors'] = [];
}
//--------------------------------------------------------------------------------------
$etudiant = new Etudiant($db);
$studentData = null;
//--------------------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if (isset($_POST['retour_liste'])) 
    {
        header("Location: " . $_SERVER['PHP_SELF'] . "?element=etudiants&action=list");
        exit();
    }
}
//--------------------------------------------------------------------------------------
if (isset($_GET['numetu'])) 
{
    $numetu = intval($_GET['numetu']);
    $studentData = $etudiant->fetch($numetu);

    if (!$studentData) 
    {
        $_SESSION['mesgs']['errors'][] = "Erreur : Étudiant introuvable.";
        header("Location: " . $_SERVER['PHP_SELF'] . "?element=etudiants&action=list");
        exit();
    }

    $stmt = $db->prepare("
        SELECT cm.*, m.nommod
        FROM classement_module cm
        INNER JOIN modules m ON cm.nummod = m.nummod
        WHERE cm.numetu = :numetu
        ORDER BY cm.rang ASC
    ");
    $stmt->execute([':numetu' => $numetu]);
    $classementData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} 
else 
{
    $_SESSION['mesgs']['errors'][] = "Erreur : Aucun étudiant sélectionné.";
    header("Location: " . $_SERVER['PHP_SELF'] . "?element=etudiants&action=list");
    exit();
}

