<?php
require_once dirname(__FILE__) . '/../../class/myAuthClass.php';
require_once dirname(__FILE__) . '/../../class/etudiant.class.php';

//--------------------------------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
//--------------------------------------------------------------------------------------
if (!myAuthClass::is_auth($_SESSION))
{
    header('Location: index.php');
    exit();
}
//--------------------------------------------------------------------------------------
$etudiant = new Etudiant($db);
$etudiants = [];
$updateEtudiant = null;

//--------------------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if (isset($_POST['rechercher']))
    {
        $searchParams = [
            'numetu'    => $_POST['searchNumetu']    ?? '',
            'nometu'    => $_POST['searchNometu']    ?? '',
            'prenometu' => $_POST['searchPrenometu'] ?? '',
            'datnaietu' => $_POST['searchDatnaietu'] ?? '',
            'annetu'    => $_POST['searchAnnetu']    ?? '',
            'adretu'    => $_POST['searchAdretu']    ?? '',
            'cpetu'     => $_POST['searchCpetu']     ?? '',
            'viletu'    => $_POST['searchViletu']    ?? '',
            'teletu'    => $_POST['searchTeletu']    ?? '',
            'sexetu'    => $_POST['searchSexetu']    ?? '',
            'datentetu' => $_POST['searchDatentetu'] ?? '',
            'remetu'    => $_POST['searchRemetu']    ?? '',
        ];
        $etudiants = $etudiant->find($searchParams);
    }
    //--------------------------------------------------------------------------------------
    elseif (isset($_POST['voir_fiche']))
    {
        $numetu = intval($_POST['numetu']);
        header("Location: " . $_SERVER['PHP_SELF'] . "?element=etudiants&action=card&numetu=$numetu");
        exit();
    }
    //--------------------------------------------------------------------------------------
    elseif (isset($_POST['modifier']))
    {
        $numetu = intval($_POST['numetu']);
        $updateEtudiant = $etudiant->fetch($numetu);

        if ($updateEtudiant)
        {
            $_SESSION['edit_etudiant'] = $updateEtudiant;
            header("Location: " . $_SERVER['PHP_SELF'] . "?element=etudiants&action=add");
            exit();
        }
        else
        {
            $_SESSION['mesgs']['errors'][] = "Erreur : Étudiant introuvable.";
        }
    }
    //--------------------------------------------------------------------------------------
    elseif (isset($_POST['supprimer']))
    {
        $numetu = intval($_POST['numetu']);
        try
        {
            $etudiant->delete($numetu);
            header("Location: " . $_SERVER['PHP_SELF'] . "?element=etudiants&action=list");
            exit();
        }
        catch (Exception $e)
        {
            $_SESSION['mesgs']['errors'][] = "Erreur lors de la suppression : " . $e->getMessage();
        }
    }
}
else
{
    $etudiants = $etudiant->fetchAll();
}
