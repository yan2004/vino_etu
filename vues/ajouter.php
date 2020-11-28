<div class="ajouter">

    <div class="nouvelleBouteille" vertical layout>
        Recherche : <input type="text" name="nom_bouteille">
        <ul class="listeAutoComplete">

        </ul>
            
            <form name="fAjtBtlCellier" class="form-ajouter" id="form-ajouter-btl">
                <p>Nom : <span data-id="" class="nom_bouteille"></span></p>
                <span id="errNom_ajouter"></span> 

                <label for="millesime_ajouter">Millesime : </label>
                <input type="text" name="millesime" id="millesime_ajouter" value="">
                <span id="errMillesime"></span>
                
                <label for="quantite_ajouter">Quantite : </label>
                <input type="text" name="quantite" value="1" id="quantite_ajouter">
                <span id="errQuantite"></span>

                <label for="date_achat_ajouter">Date achat : </label>
                <input type="date" name="date_achat" id="date_achat_ajouter" value="">
                <span  id="errDate_achat"></span>

                <label for="prix_ajouter">Prix : </label>
                <input type="text" name="prix" id="prix_ajouter" value="">
                <span  id="errPrix"></span>

                <label for="garde_jusqua_ajouter">Garde : </label>
                <!-- <input type="text" name="garde_jusqua" id="garde_jusqua_ajouter"> -->
                <input type="text" name="garde" id="garde_jusqua_ajouter">
                <span  id="errGarde"></span>

                <label for="notes_ajouter">Notes</label>
                <input type="text" id="notes_ajouter" name="notes">
                <span  id="errNotes"></span>
                
                <!-- input caché avec id usager -->
                <input type="hidden" name="courriel_usager" value="<?= $_SESSION["courriel"] ?>">

                <div class="forms-btns">
                        <button value="Annuler" class="btnAnnuler">ANNULER</button>
                        <button name="ajouterBouteilleCellier" id="ajouterBouteilleCellier">AJOUTER LA BOUTEILLE</button>
                </div>
            
            </form>


            <!-- <button name="ajouterBouteilleCellier" id="ajouterBouteilleCellier">AJOUTER LA BOUTEILLE</button> -->
        </div>
    </div>
</div>
<!--<script src="./js/xxx.js"></script>-->

