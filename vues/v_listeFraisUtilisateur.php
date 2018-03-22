<?php

/**
 * Vue liste frais utilisateur
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
?>
<div class="row">
    <div class="col-md-8">
        
        <div class="container">
                <div class="form-group" >
                    <div class="col-md-4">
                        <form action="index.php?uc=validerFrais&action=selectionUtilisateur" 
                              method="post" role="form">
                                <label for="lstVisiteur" accesskey="n">Choisir le visiteur : </label>
                                <select id="lstVisiteur" name="lstVisiteur" onchange='this.form.submit()' class="form-control">
                                       <?php
                                        foreach ($lesVisiteurs as $unVisiteur) {
                                            $idVisiteur = $unVisiteur['id'];
                                            $nom = $unVisiteur['nom'];
                                            $prenom = $unVisiteur['prenom']; 
                                            if ($idVisiteur == $visiteurASelectionner) {
                                                ?>
                                                <option selected value="<?php echo $idVisiteur ?>">
                                                    <?php echo $nom . ' ' . $prenom ?> </option>
                                                <?php
                                                
                                            } else {
                                                ?>
                                                <option value="<?php echo $idVisiteur ?>">
                                                    <?php echo $nom . ' ' . $prenom ?> </option>
                                                <?php
                                            }
                                        }
                                        ?>        
                                </select>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form action="index.php?uc=validerFrais&action=afficherFicheFrais" 
                              method="post" role="form">
                            <input class="form-control" name="lstVisiteur" type="hidden" value="<?php echo $visiteurASelectionner ?>">   
                            <label for="lstMois" accesskey="n">Mois : </label>
                                
                                <select id="lstMois" name="lstMois"  class="form-control">
                                    <?php
                                    if (count($lesMois)){
                                        foreach ($lesMois as $unMois) {
                                            $mois = $unMois['mois'];
                                            $numAnnee = $unMois['numAnnee'];
                                            $numMois = $unMois['numMois'];
                                            if ($mois == $moisASelectionner) {
                                                ?>
                                                <option selected value="<?php echo $mois ?>">
                                                    <?php echo $numMois . '/' . $numAnnee ?> </option>
                                                <?php
                                                
                                            } else {
                                                ?>
                                                <option value="<?php echo $mois ?>">
                                                    <?php echo $numMois . '/' . $numAnnee ?> </option>
                                                <?php
                                            }
                                        }
                                    }else{?>
                                    <option value="0">Pas de fiche pour ce visiteur</option><?php
                                    }
                                    ?>
                                </select> </br>
                            
                                    <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                                  accept=""role="button">
                        </form>
                    </div>
                                                                                                            
                </div>
            
            
            
        </div>
        
    </div>
</div>
