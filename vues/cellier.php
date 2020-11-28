<div class="cellier">
   <div class="main-title">
       <div class="main-title-welcome">
            <h1>Le cellier de 
            <?php 
                if(isset($_SESSION["courriel"])){
                    $usager = /*$dataUsager[0]['nom']." ".*/$dataUsager[0]['prenom'];
                    echo $usager;
                }
            ?>
            &#8239;:
                <div class="main-title-call-action">
                    <button class="btn-call-action" id="btnCallActionAjt">Ajouter une bouteille</button>
                </div>
            </h1>
            
       </div>
       <!-- <div class="main-title-call-action">
           <button class="btn-call-action" id="btnCallActionAjt">Ajouter bouteille</button>
       </div> -->
    </div>
<?php
foreach ($data as $cle => $bouteille) {
      
    ?>
    <!-- <div class="bouteille" data-quantite=""> -->
    <div class="bouteille" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">
        <div class="tuile">
            <div class="img">
                <img src="https:<?php echo $bouteille['url_image'] ?>"/>
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
                <button class='btnSupprimer'>Supprimer</button>
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


