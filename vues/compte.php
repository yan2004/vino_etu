<div class="compte">
    <h2>Modifier mes informations</h2>
        <form action="index.php?requete=sauvegardeCompte" method="post" class="modifierCompte" name="fCompte">
                <input type="hidden" name="userId" value="<?php echo $data[0]['id']; ?>">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" placeholder="<?php echo $data[0]['nom']; ?>">
                <span id="errNom"></span>
            
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" placeholder="<?php echo $data[0]['prenom']; ?>">
                <span id="errPrenom"></span>
            
                <label for="mot_de_passe">Mot de passe</label>
                <input type="text" name="mot_de_passe" id="mot_de_passe">
                <span id="errMDP"></span>
                
                <button type="submit" value="Modifier" class="btnModifierCompte">MODIFIER</button>
        </form>
</div>