<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
            $lesMois = $pdo->getFichesCloturees($visiteurASelectionner,'CL');            
            $lesMoisASelectionner = filter_input(INPUT_POST,'lstMois', FILTER_SANITIZE_STRING);
         
            if ($lesMoisASelectionner==0){
               ajouterErreur('Pas de fiche pour ce visiteur');             
                include 'vues/v_listeFraisUtilisateur.php';
                include 'vues/v_erreurs.php';
          }else{                    
            $lesFraisForfait = $pdo->getLesFraisForfait($visiteurASelectionner,$lesMoisASelectionner);
            include 'vues/v_listeFraisUtilisateur.php';
            include 'vues/v_validerFrais.php'; 
           }
           
        }       
        break;
    
    case 'MajFicheFrais':
        
        
        $visiteurASelectionner = filter_input(INPUT_POST,'lstVisiteur', FILTER_SANITIZE_STRING);
        $lesMoisASelectionner = filter_input(INPUT_POST,'lstMois', FILTER_SANITIZE_STRING);
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    if (lesQteFraisValides($lesFrais)) {
        $pdo->majFraisForfait($visiteurASelectionner, $lesMoisASelectionner, $lesFrais);
    } else {
        ajouterErreur('Les valeurs des frais doivent être numériques');
        include 'vues/v_erreurs.php';
    }   
        $lesMois = $pdo->getFichesCloturees($visiteurASelectionner,'CL');
        $lesFraisForfait = $pdo->getLesFraisForfait($visiteurASelectionner,$lesMoisASelectionner);
        include 'vues/v_listeFraisUtilisateur.php';
        include 'vues/v_validerFrais.php';
        
        break;
    
    case 'Validation':
        break;
    
        
}

