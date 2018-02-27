<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<hr>

<!-- Fiche Forfait -->

<div class="row">    
    <div id="validerFrais">
        <h2 style= "color: orange">Valider la fiche de frais</h2>
    </div>
    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">
        <form method="post" 
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

<!-- Tableau Hors Forfait -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">Descriptif des éléments hors forfait - 
            <!--<?php echo $nbJustificatifs ?>--> 
            justificatifs reçus</div>
        
                <table class="table table-bordered table-responsive">
        
                    <tr>
                        <th class="date">Date</th>
                        <th class="libelle">Libellé</th>
                        <th class='montant'>Montant</th>                
                    </tr>

                    <?php
                   // foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                     //   $date = $unFraisHorsForfait['date'];
                     //   $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                      //  $montant = $unFraisHorsForfait['montant']; ?>

                    <tr>               
                        <td>
                            <div class="col-md-8">
                            <form method="post" action="modif.php">
                                <p>
                                        <input class="form-control" type="text" name="nom" />								
                                </p>
                                </form>
                            </div>    
                        </td>
                        <td><div class="col-md-8">
                            <input class="form-control" type="text" name="nom" />
                            </div>
                        </td> 
                        <td><div class="col-md-8">
                            <input class="form-control" type="text" name="nom" /> 
                            </div>
                        </td>
                        
                        <td><div>
                            <button class="btn btn-success" type="submit">Corriger</button>
                            <button class="btn btn-danger" type="reset">Réintitaliser</button> 
                            </div>
                        </td>

                    </tr>
            <?php
       // }
        ?>
                </table>
        </div> 
    </div>
</div>

<hr>

<!-- Vue Justificatif -->

<div class="col-md-4">
    <label for="lstMois" accesskey="n">Nombre de justificatif : </label>
    <div>
        <input class="form-control" type="text" name="nom" />
    </div>
        <button class="btn btn-success" type="submit">Valider</button>
        <button class="btn btn-danger" type="reset">Réintitaliser</button>
<div>
<hr>