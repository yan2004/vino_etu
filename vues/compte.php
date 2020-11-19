<div class="compte">

    <h2>Modifier Info De Compte</h2>
        
        <form action="index.php?requete=sauvegardeCompte" method="post" class="modifierCompte" name="fCompte">
                <input type="hidden" name="userId" value="<?php echo $data[0]['id']; ?>">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" placeholder="<?php echo $data[0]['nom']; ?>"></br>
                <span id="errNom"></span>
            
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" placeholder="<?php echo $data[0]['prenom']; ?>"></br>
                <span id="errPrenom"></span>
            
                <label for="mot_de_passe">Mot de passe</label>
                <input type="text" name="mot_de_passe" id="mot_de_passe"></br>
                <span id="errMDP"></span>
                
                <input type="submit" value="Modifier" class="btnModifierCompte">
        </form>

    
</div>
</div>
