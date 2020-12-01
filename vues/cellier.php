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
    <div class="bouteilles gallery gallery--2">
    <?php
    foreach ($data as $cle => $bouteille) {
    ?>
    <!-- <div class="bouteille" data-quantite=""> -->
    <div class="bouteille" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">
        <div class="tuile">
            <div class="optionsIcones" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">
                <!-- <button class='btnSupprimer'>Supprimer</button>
                <button class='btnModifier'>Modifier</button>
                <button class='btnAjouter'>Ajouter</button>
                <button class='btnBoire'>Boire</button> -->
                <img src="./images/trash-alt-solid.svg" class='btnSupprimer'/>
                <img src="./images/edit-solid.svg" class='btnModifier'/>
                <!-- <img src="./images/plus-circle-solid.svg" class='btnAjouter'/>
                <img src="./images/minus-circle-solid.svg" class='btnBoire'/> -->
            </div>
            <div class="img" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">
                <img src="https:<?php echo $bouteille['url_image'] ?>"/>
                <div class="bulle" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>"><p class="quantite"><?php echo $bouteille['quantite']?></p></div>
                <img class='btnAjouter' src="./images/plus-circle-solid.svg" />
                <img class='btnBoire' src="./images/minus-circle-solid.svg" />
            </div>
            <div class="description" data-id="<?php echo $bouteille['id_bouteille_collection'] ?>">
                <div>
                    <a href="<?php echo $bouteille['url_saq'] ?>"><p class="nom"><?php echo $bouteille['nom'] ?></p></a>
                    <p class="pays"><?php echo $bouteille['type'] ?> | <?php echo $bouteille['pays'] ?></p>
                    <p class="millesime tiny-text"><?php  if(!empty($bouteille['millesime'])) echo "Millesime : " . $bouteille['millesime'] ?></p>
                </div>
                <div>
                    <!-- <p class="millesime">Millesime : <?php /*echo $bouteille['millesime'] */?></p> -->
                    <!-- <p class="quantite">Quantité : <?php /*echo $bouteille['quantite'] */?></p> -->
                    
                    <p class="prix tiny-text"><?php  if($bouteille['prix'] !== "0.00") echo $bouteille['prix'] . " $"?></p>
                    <p class="date_achat tiny-text"><?php  if(empty($bouteille['millesime'])) echo "Acheté le " . $bouteille['date_achat']?></p>
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


