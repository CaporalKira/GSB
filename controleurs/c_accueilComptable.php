<?php

/* 
 * Gestion de l'accueil comptable.
 */


if ($estConnecte) {
    include 'vues/v_accueilComptable.php';
    
} else {
    include 'vues/v_connexion.php';
}