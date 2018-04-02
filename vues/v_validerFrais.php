<?php

/**
 * Vue Validation des frais
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
<hr>

<!-- Fiche Forfait ------------------------------------------------------------>

<div class="row">    
    <div id="validerFrais">
        <h2 style= "color: orange">Valider la fiche de frais</h2>
    </div>
    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">
        <form method="post" name="FraisForfait"
              action="index.php?uc=validerFrais&action=MajFicheFrais" 
              role="form">
            <input class="form-control" name="lstVisiteur" type="hidden" value="<?php echo $visiteurASelectionner ?>">  
             
            <fieldset>       
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </div>
                    <?php
                }
                ?>
                <button class="btn btn-success" type="submit">Corriger</button>
                <button class="btn btn-danger" type="reset">Réintitaliser</button>
            </fieldset>
        </form>
    </div>
</div>
<hr>

<!-- Tableau Hors Forfait ----------------------------------------------------->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">Descriptif des éléments hors forfait - 
            <?php echo $nbJustificatifs ?> 
            justificatifs reçus</div>
        <form action="index.php?uc=validerFrais&action=MajFicheFrais" name="FraisHF"
                      method="post" role="form">
                <table class="table table-bordered table-responsive">
        
                    <tr>
                        <th class="date">Date</th>
                        <th class="libelle">Libellé</th>
                        <th class='montant'>Montant</th>                
                    </tr>
                
                    <?php
                    foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                        $idHF = $unFraisHorsForfait ['id'];
                        $date = $unFraisHorsForfait['date'];
                        $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                        $montant = $unFraisHorsForfait['montant']; 
                        $_SESSION ['id']= $idHF; ?>
                   <tr>               
                        <td>
                            <div class="col-md-8">
                                <input type="text" id="date" 
                               name="date"
                               size="10" maxlength="10" 
                               value="<?php echo $date ?>" 
                               class="form-control">
                                <?php
                           $_SESSION['date']= $date;
                           ?>
                            </div>    
                        </td>
                        <td><div class="col-md-12">
                                 <input type="text" id="libelle" 
                               name="libelle"
                               size="10" maxlength="100" 
                               value="<?php echo $libelle ?>" 
                               class="form-control">
                                 <?php
                           $_SESSION['libelle']= $libelle;
                           ?>
                            </div>
                        </td> 
                        <td><div class="col-md-8">
                                 <input type="text" id="montant" 
                               name="montant"
                               size="10" maxlength="5" 
                               value="<?php echo $montant ?>" min="0"
                               class="form-control">
                                 <?php
                           $_SESSION['montant']= $montant;
                           ?>
                            </div>
                        </td>
                        
                        <td align="center">
                            <div class="col-md-9">
                            <button class="btn btn-success" type="submit">Corriger</button> 
                            <button class="btn btn-danger" type="reset">Réintitaliser</button> 
                            <div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only"></span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li align="center">
                                        <form method="post"
                                              action="index.php?uc=validerFrais&action=MajFicheFrais"
                                              id="refuser-frais"
                                              role="form">
                                            <input class="form-control" name="idFraisRefuse" type="hidden" value="<?php echo $idHF ?>">
                                            <a href="#" onclick="this.closest('form').submit()">Refuser</a>
                                        </form>
                                    </li>
                                    <li class="divider"></li>
                                    <li align="center">
                                        <form method="post"
                                              action="index.php?uc=validerFrais&action=MajFicheFrais"
                                              id="reporter-frais"
                                              role="form">
                                            <input class="form-control" name="idFraisReporte" type="hidden" value="<?php echo $idHF ?>">
                                            <a href="#" onclick="this.closest('form').submit()">Reporter</a>
                                        </form>
                                    </li>
                                </ul>
</div>
                        </td>

                    </tr>
        
            <?php
        }
        ?>
                </table>
        </form>
        </div> 
    </div>
</div>

<hr>

<!-- Vue Justificatif --------------------------------------------------------->

<div class="col-md-4">
    
     <form action="index.php?uc=validerFrais&action=MajFicheFrais" 
           method="post" role="form">
    <label for="lstMois" accesskey="n">Nombre de justificatif : </label>
    <div>
        <input class="form-control" type="number" name="nbJustificatif" value="0" min="0"/>
    </div>
        <button class="btn btn-success" type="submit">Corriger</button>
        <button class="btn btn-danger" type="reset">Réintitaliser</button>
        </form>
<div>
<hr>

<div class="col-md-12">
     <form action="index.php?uc=validerFrais&action=Validation" 
           method="post" role="form"> 
        <button class="btn btn-success" type="submit">Valider la fiche</button>   
        </form>
    <div><br><br><br><br>