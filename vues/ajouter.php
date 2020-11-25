<div class="ajouter">

    <div class="nouvelleBouteille" vertical layout>
        Recherche : <input type="text" name="nom_bouteille">
        <ul class="listeAutoComplete">

        </ul>
            <div class="form-ajouter">
               
                <p>Nom : <span data-id="" class="nom_bouteille"></span></p>
                <span id="errNom_ajouter"></span> 

                <label for="millesime_ajouter">Millesime : </label>
                <input name="millesime" id="millesime_ajouter" placeholder="2020">
                
                <label for="quantite_ajouter">Quantite : </label>
                <input name="quantite" value="1" id="quantite">
                <span id="errQuantite_ajouter"></span>

                <label for="date_achat_ajouter">Date achat : </label>
                <input type="date" name="date_achat" id="date_achat_ajouter" value="">

                <label for="prix_ajouter">Prix : </label>
                <input name="prix" id="prix_ajouter" value="">
                <span id="errPrix_ajouter"></span>

                <label for="garde_jusqua_ajouter">Garde : </label>
                <input name="garde_jusqua" id="garde_jusqua_ajouter">

                <label for="notes">Notes</label>
                <input id="notes" name="notes">
                
                <!-- input caché avec id usager -->
                <input type="hidden" name="courriel_usager" value="<?= $_SESSION["courriel"] ?>">
            </div>
            <button name="ajouterBouteilleCellier">AJOUTER LA BOUTEILLE</button>
        </div>
    </div>
</div>
<!--<script src="./js/ajouter_app.js"></script>-->
