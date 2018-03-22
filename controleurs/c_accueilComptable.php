<?php

/**
 * Contrôleur accueil comptable
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


if ($estConnecte) {
    include 'vues/v_accueilComptable.php';
    
} else {
    include 'vues/v_connexion.php';
}