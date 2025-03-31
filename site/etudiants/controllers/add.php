<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
$editData = $_SESSION['edit_etudiant'] ?? null;

if (isset($_SESSION['edit_etudiant']) && isset($_POST['confirm']) && $editData)
{
    unset($_SESSION['edit_etudiant']);
    header("Location: " . $_SERVER['PHP_SELF'] . "?element=etudiants&action=list");
    exit();
}
//--------------------------------------------------------------------------------------
// Remplir les champs si modification sinon on laisse vide
$nometu = $editData['nometu'] ?? '';
$prenometu = $editData['prenometu'] ?? '';
$datnaietu = $editData['datnaietu'] ?? '';
$annetu = $editData['annetu'] ?? '';
$adretu = $editData['adretu'] ?? '';
$cpetu = $editData['cpetu'] ?? '';
$viletu = $editData['viletu'] ?? '';
$teletu = $editData['teletu'] ?? '';
$remetu = $editData['remetu'] ?? '';
$sexetu = $editData['sexetu'] ?? '';
//--------------------------------------------------------------------------------------
if (isset($_POST['confirm']))
{
    $etudiant = new Etudiant($db);

    $etudiant->setData('nometu', $_POST['nometu']);
    $etudiant->setData('prenometu', $_POST['prenometu']);
    $etudiant->setData('datnaietu', $_POST['datnaietu']);
    $etudiant->setData('annetu', $_POST['annetu']);
    $etudiant->setData('adretu', $_POST['adretu']);
    $etudiant->setData('cpetu', $_POST['cpetu']);
    $etudiant->setData('viletu', $_POST['viletu']);
    $etudiant->setData('teletu', $_POST['teletu']);
    $etudiant->setData('remetu', $_POST['remetu']);
    $etudiant->setData('sexetu', $_POST['sexetu']);

    try
    {
        if ($editData)
        {
            $etudiant->update($editData['numetu']);
            unset($_SESSION['edit_etudiant']);
            $_SESSION['mesgs']['confirm'][] = "Étudiant mis à jour avec succès.";
        }
        else
        {
            $etudiant->create();
            $_SESSION['mesgs']['confirm'][] = "Étudiant ajouté avec succès.";
        }
    }
    catch (Exception $e)
    {
        $_SESSION['mesgs']['errors'][] = 'Erreur : ' . $e->getMessage();
    }
}

?>
