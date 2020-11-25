<div class="ajouter">

    <div class="nouvelleBouteille" vertical layout>
        Recherche : <input type="text" name="nom_bouteille">
        <ul class="listeAutoComplete">

        </ul>
            <div class="form-ajouter">
               
                <p>Nom : <span data-id="" class="nom_bouteille"></span></p>
                <label>Millesime : </label><input name="millesime">
                <label>Quantite : </label><input name="quantite" value="1">
                <label>Date achat : </label><input name="date_achat">
                <label>Prix : </label><input name="prix">
                <label>Garde : </label><input name="garde_jusqua">
                <label for="notes">Notes</label> <input id="notes" name="notes">
                
                <!-- input caché avec id usager -->
                <input type="hidden" name="courriel_usager" value="<?= $_SESSION['courriel'] ?>">
            </div>
            <button name="ajouterBouteilleCellier">AJOUTER LA BOUTEILLE (CHAMPS TOUS OBLIGATOIRES)</button>
        </div>
    </div>
</div>
