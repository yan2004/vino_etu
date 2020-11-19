<div class="ajouter">

    <div class="nouvelleBouteille" vertical layout>
        Recherche : <input type="text" name="nom_bouteille">
        <ul class="listeAutoComplete">

        </ul>
            <div >
                <!-- PEUT-ETRE AJOUTER UN DATA-ID-BOUTEILLE ET DATA-ID-USAGER ? À SUIVRE... -->
                <p>Nom : <span data-id="" class="nom_bouteille"></span></p>
                <p>Millesime : <input name="millesime"></p>
                <p>Quantite : <input name="quantite" value="1"></p>
                <p>Date achat : <input name="date_achat"></p>
                <p>Prix : <input name="prix"></p>
                <p>Garde : <input name="garde_jusqua"></p>
                <p>Notes <input name="notes"></p>
                
                <!-- input caché avec id usager -->
                <input type="hidden" name="pseudo_usager" value="<?= $_SESSION['pseudo'] ?>">
            </div>
            <button name="ajouterBouteilleCellier">Ajouter la bouteille (champs tous obligatoires)</button>
        </div>
    </div>
</div>
