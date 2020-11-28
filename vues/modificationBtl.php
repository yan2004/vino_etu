<div class="modificationBtl">

    <h2>Modifier Bouteille</h2>
        
        <form action="" method="post" class="modificationBtl" name="fModificationBtl">
                <input type="hidden" name="btlIdPK" value="<?php echo $data[0]['id']; ?>">
                <input type="hidden" name="nomIdFK" value="<?php echo $data[0]['id_bouteille']; ?>">

                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="<?php echo $data[0]['nom']; ?>" readonly="true"/>
                <span id="errNom"></span>
            
                <label for="millesime">Millesime</label>
                <input type="text" name="millesime" id="millesime" value="<?php echo $data[0]['millesime']; ?>">
                <span id="errMillesime"></span>
            
                <label for="quantite">Quantite</label>
                <input type="text" name="quantite" id="quantite" value="<?php echo $data[0]['quantite']; ?>">
                <span id="errQuantite"></span>

                <label for="date_achat">Date achat</label>
                <input type="date" name="date_achat" id="date_achat" value="<?php echo $data[0]['date_achat']; ?>">
                <span id="errDate_achat"></span>

                <label for="prix">Prix</label>
                <input type="text" name="prix" id="prix" value="<?php echo $data[0]['prix']; ?>">
                <span id="errPrix"></span>

                <label for="garde">Garde</label>
                <input type="text" name="garde" id="garde" value="<?php echo $data[0]['garde_jusqua']; ?>">
                <span id="errGarde"></span>

                <label for="notes">Notes</label>
                <input type="text" name="notes" id="notes" value="<?php echo $data[0]['notes']; ?>">
                <span id="errNotes"></span>
                
                <div class="forms-btns">
                        <button value="Annuler" class="btnAnnuler">ANNULER</button>
                        <button value="Modifier" class="btnModifierBtl">MODIFIER</button>
                </div>
        </form>
    
</div>