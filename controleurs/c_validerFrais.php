<?php

/**
 * Contrôleur validation des fiche de frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    Abdelbasset DAAS <abdelbasset.daas@hotmail.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */


$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = $_SESSION['idVisiteur'];
$lesVisiteurs  = $pdo->getVisiteurs();

switch ($action){
    case 'selectionUtilisateur':
        
        if(!isset($_POST['lstVisiteur'])){
            $visiteurASelectionner = $lesVisiteurs[0]['id'];           
        }else{
            $visiteurASelectionner = filter_input(INPUT_POST,'lstVisiteur', FILTER_SANITIZE_STRING);
        }
        $lesMois = $pdo->getFichesCloturees($visiteurASelectionner,'CL');
         $lesCles = array_keys($lesMois);
        if($lesCles){
       $moisASelectionner = $lesCles[0];
        }
        
        include 'vues/v_listeFraisUtilisateur.php';
        
        break;
        
        
    case 'afficherFicheFrais':
            
        if (isset($_POST['lstMois']) && isset($_POST['lstVisiteur'])){ 
            
            $visiteurASelectionner = filter_input(INPUT_POST,'lstVisiteur', FILTER_SANITIZE_STRING);
            $_SESSION['visiteur']=$visiteurASelectionner;
            $lesMois = $pdo->getFichesCloturees($visiteurASelectionner,'CL');            
            $lesMoisASelectionner = filter_input(INPUT_POST,'lstMois', FILTER_SANITIZE_STRING);
            $_SESSION['mois']= $lesMoisASelectionner;
         
            if ($lesMoisASelectionner==0){
               ajouterErreur('Pas de fiche pour ce visiteur');             
                include 'vues/v_listeFraisUtilisateur.php';
                include 'vues/v_erreurs.php';
          }else{ 
            $nbJustificatifs = $pdo->getNbjustificatifs($visiteurASelectionner, $lesMoisASelectionner);
            $lesFraisForfait = $pdo->getLesFraisForfait($visiteurASelectionner,$lesMoisASelectionner);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurASelectionner,$lesMoisASelectionner);
            include 'vues/v_listeFraisUtilisateur.php';
            include 'vues/v_validerFrais.php'; 
            
           }
           
        }       
        break;
    
    case 'MajFicheFrais':
        
        
        $visiteurASelectionner = $_SESSION['visiteur'];
        $lesMoisASelectionner = $_SESSION['mois'];
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        
    // Mise à jour de la fiche frais
        
     if (isset($_POST['lesFrais'])){   
        if(lesQteFraisValides($lesFrais)){
            $pdo->majFraisForfait($visiteurASelectionner, $lesMoisASelectionner, $lesFrais);
            ajouterSucces("Mise à jour réussi!");
            include 'vues/v_succes.php';
        }else{
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        } 
     
    }
    //Mise à jour des frais hors frais.
    
    if (isset($_POST['montant'])){
        
        $idFraisHF = $_SESSION['id'];
        $date = filter_input(INPUT_POST, 'date', FILTER_DEFAULT, FILTER_SANITIZE_STRING);
        $libelle= filter_input(INPUT_POST, 'libelle', FILTER_DEFAULT, FILTER_SANITIZE_STRING);
        $montant= filter_input(INPUT_POST, 'montant', FILTER_DEFAULT, FILTER_SANITIZE_STRING);
        valideInfosFrais($date, $libelle, $montant);
        if (!nbErreurs()){
            $pdo->majFraisHorsForfait($idFraisHF, $date, $libelle,$montant);
            ajouterSucces("Mise à jour réussi!");
            include 'vues/v_succes.php';
        }else{
            ajouterErreur("Le champ n'a pas été mis à jour");
            include 'vues/v_erreurs.php';
        }
    } 
    
    // Mise à jour nombre justificatifs
    if(isset ($_POST['nbJustificatif'])){
        $visiteurASelectionner = $_SESSION['visiteur'];
        $lesMoisASelectionner = $_SESSION['mois'];
        $nbJustificatifs = filter_input(INPUT_POST, 'nbJustificatif', FILTER_DEFAULT, FILTER_SANITIZE_STRING);
        $nbJustifPresent=$pdo->getNbjustificatifs($visiteurASelectionner, $lesMoisASelectionner);
        if (!nbErreurs()&& $nbJustificatifs!=$nbJustifPresent) {
            $pdo->majNbJustificatifs($visiteurASelectionner, $lesMoisASelectionner, $nbJustificatifs);
            ajouterSucces("Mise à jour réussi!");
            include 'vues/v_succes.php';
        }else{
            ajouterErreur("Le champ n'a pas été mis à jour");
            include 'vues/v_erreurs.php';
        }
     } 
     
     if (isset($_POST['idFraisRefuse'])) {
            $idHF = filter_input(INPUT_POST, 'idFraisRefuse', FILTER_SANITIZE_STRING);
            $pdo->refuserFraisHF($idHF);
            if (nbSucces()) {
                include 'vues/v_succes.php';
            }else if (nbErreurs()) {
                include 'vues/v_erreurs.php';
            }
     }
        
     if (isset($_POST['idFraisReporte'])) {
        $idHF = filter_input(INPUT_POST, 'idFraisReporte', FILTER_SANITIZE_STRING);
        $pdo->reporterFraisHF($idHF,$visiteurASelectionner,$lesMoisASelectionner);
        if (nbSucces()) {
           include 'vues/v_succes.php';
        }else if (nbErreurs()) {
           include 'vues/v_erreurs.php';
           }
     }
        
        $lesMois = $pdo->getFichesCloturees($visiteurASelectionner,'CL');
        $nbJustificatifs = $pdo->getNbjustificatifs($visiteurASelectionner, $lesMoisASelectionner);
        $lesFraisForfait = $pdo->getLesFraisForfait($visiteurASelectionner,$lesMoisASelectionner);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurASelectionner,$lesMoisASelectionner);
        include 'vues/v_listeFraisUtilisateur.php';
        include 'vues/v_validerFrais.php';
        
        
        break;
    
    case 'Validation':
        
        //Mise à jour de la date de modification, de l'etat de la fiche et du montant.
        $visiteurASelectionner = $_SESSION['visiteur'];
        $lesMoisASelectionner = $_SESSION['mois'];
        
        $totalFraisForfait = $pdo-> getTotalFraisForfait($visiteurASelectionner,$lesMoisASelectionner);  
        $totalFraisHorsForfait = $pdo-> getTotalHorsFraisForfait($visiteurASelectionner,$lesMoisASelectionner);      
        $total= $totalFraisForfait + $totalFraisHorsForfait;
        
         if (!nbErreurs()) {
            $pdo->majMontantFicheFrais($visiteurASelectionner, $lesMoisASelectionner, $total);
            $pdo->majEtatFicheFrais($visiteurASelectionner, $lesMoisASelectionner, 'VA');
            ajouterSucces("la fiche a été validé !");
            include 'vues/v_succes.php';
        }else{
             ajouterErreur("la fiche n'a pas été validée !");
             include 'vues/v_erreurs.php';
        }
        
        $lesMois = $pdo->getFichesCloturees($visiteurASelectionner,'CL');
        $nbJustificatifs = $pdo->getNbjustificatifs($visiteurASelectionner, $lesMoisASelectionner);
        $lesFraisForfait = $pdo->getLesFraisForfait($visiteurASelectionner,$lesMoisASelectionner);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurASelectionner,$lesMoisASelectionner);
        include 'vues/v_listeFraisUtilisateur.php';
        include 'vues/v_validerFrais.php';
        
        
        break;
    
        
}

