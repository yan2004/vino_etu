<div class="cellier">
    <h1>Mon cellier :</h1>
<?php
foreach ($data as $cle => $bouteille) {
      
    ?>
    <!-- <div class="bouteille" data-quantite=""> -->
    <div class="bouteille">
        <div class="tuile">
            <div class="img">
                <img src="https:<?php echo $bouteille['url_image'] ?>">
            </div>
            <div class="description" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">
                <div>
                    <p class="nom"><?php echo $bouteille['nom'] ?></p>
                    <p class="pays"><?php echo $bouteille['type'] ?> | <?php echo $bouteille['pays'] ?></p>
                </div>
                <div>
                    <p class="millesime">Millesime : <?php echo $bouteille['millesime'] ?></p>
                    <p class="quantite">Quantité : <?php echo $bouteille['quantite'] ?></p>
                </div>
                
            </div>
        </div>

        <div class="options">
            <div>
                <a href="<?php echo $bouteille['url_saq'] ?>">Voir SAQ</a>
            </div>
            <div data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">
                <!--<button class='btnModifier'><a href="index.php?requete=modifierBouteilleCellier">Modifier</a></button>-->
                <button class='btnModifier'>Modifier</button>
                <button class='btnAjouter'>Ajouter</button>
                <button class='btnBoire'>Boire</button>
            </div>
            
        </div>
    </div>
    
<?php


}

?>	
</div>


