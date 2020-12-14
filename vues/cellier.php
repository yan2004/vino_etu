<div class="cellier">

    <div class="bouteilles">
    <?php
    foreach ($data as $cle => $bouteille) {
    ?>

    <!--Modal Start-->
    <div class="modal-container" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h3>SUPPRIMER LA BOUTEILLE</h3>
                <p>Êtes-vous sûr de vouloir supprimer la bouteille de <?php echo $bouteille['nom'] ?></p>
            </div>
            <div class="modal-footer">
                <button value="Annuler" class="btnModalAnnuler" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">ANNULER</button>
                <button value="Supprimer" class="btnModalSupprimer" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">SUPPRIMER</button>
            </div>
        </div>
    </div>
    <!--Modal End-->

    <div class="bouteille" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">

        <div class="tuile">
            <div class="optionsIcones" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">
                <img src="./images/trash-alt-solid.svg" class='btnSupprimer'/>
                <img src="./images/edit-solid.svg" class='btnModifier'/>
            </div>
            <div class="img" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">
                <img src="<?php echo $bouteille['url_image'] ?>"/>
                <div class="bulle" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>"><p class="quantite"><?php echo $bouteille['quantite']?></p></div>
                <img class='btnAjouter' src="./images/plus-circle-solid.svg" />
                <img class='btnBoire' src="./images/minus-circle-solid.svg" />
            </div>
            <div class="description" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">
                <div>
                    <a target="_blank" href="<?php echo $bouteille['url_saq'] ?>"><p class="nom"><?php echo $bouteille['nom'] ?></p></a>
                    <p class="pays"><?php echo $bouteille['type'] ?> | <?php echo $bouteille['pays'] ?></p>
                    <p class="millesime tiny-text"><?php  if(!empty($bouteille['millesime'])) echo "Millesime : " . $bouteille['millesime'] ?></p>
                </div>
                <div>
                    <p class="prix"><?php  if($bouteille['prix'] !== "0.00") echo $bouteille['prix'] . " $"?></p>
                    <p class="date_achat tiny-text"><?php echo "Acheté le " . $bouteille['date_achat']?></p>
                    <p class="garde tiny-text"><?php  if(!empty($bouteille['garde_jusqua'])) echo "Garde jusqu'à : " . $bouteille['garde_jusqua']?></p>
                    <p class="notes tiny-text"><?php  if(!empty($bouteille['notes'])) echo "Notes : " . $bouteille['notes']?></p>
                </div>   
            </div>
        </div>
    </div>
    
    <?php
    }
    ?>	
    </div>
</div>


