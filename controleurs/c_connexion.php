<?php
/**
 * Gestion de la connexion
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (!$uc) {
    $uc = 'demandeconnexion';
}

switch ($action) {
case 'demandeConnexion':
    include 'vues/v_connexion.php';
    break;
case 'valideConnexion':
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
    
    if ($role == 'utilisateur_VM'){
        $utilisateur = $pdo->getInfosVisiteur($login, $mdp);
       }else{
           $utilisateur = $pdo->getInfosComptable($login, $mdp);
       }
    if (!is_array($utilisateur)|| !isset($utilisateur)) {
         ajouterErreur('Login ou mot de passe incorrect');
        include 'vues/v_erreurs.php';
        include 'vues/v_connexion.php';
        
    }else {
        $id = $utilisateur['id'];
        $nom = $utilisateur['nom'];
        $prenom = $utilisateur['prenom'];
        connecter($id, $nom, $prenom,$role);
        header('Location: index.php');
       
    }
    break;
default:
    include 'vues/v_connexion.php';
    break;
}
