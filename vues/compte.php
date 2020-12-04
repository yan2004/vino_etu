<div class="compte">
    <h2>Modifier mes informations</h2>
        <form class="modifierCompte" id="fCompte">    
                <h3>Informations générales</h3>
                
                <input type="hidden" name="userId" value="<?php echo $data[0]['id']; ?>">
                <input type="hidden" name="courriel" value="<?php echo $data[0]['courriel']; ?>">

                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="<?php echo $data[0]['nom']; ?>">
                <span id="errNom"></span>
            
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" value="<?php echo $data[0]['prenom']; ?>">
                <span id="errPrenom"></span>

                <h3>Mot de passe</h3>
                
                <label for="mot_de_passe">Nouveau mot de passe</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe">
                <span id="errMot_de_passe"></span>

                <label for="mot_de_passe_conf">Confirmation du nouveau mot de passe</label>
                <input type="password" name="mot_de_passe_conf" id="mot_de_passe_conf">
                <span id="errMot_de_passe_conf"></span>
                
                <div class="forms-btns">
                        <button value="Annuler" class="btnAnnuler">ANNULER</button>
                        <button value="Modifier" class="btnModifierCompte">MODIFIER</button>
                </div>
        </form>
</div>