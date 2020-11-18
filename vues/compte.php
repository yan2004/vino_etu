<div class="compte">

    <h2>Modifier Info De Compte</h2>
        
        <form action="index.php?requete=sauvegardeCompte" method="post" class="modifierCompte">
                <input type="hidden" name="userId" value="<?php if($_SESSION['currentUserId'] != null)echo $_SESSION['currentUserId'] ?>">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" placeholder="<?php if($_SESSION['currentUserNom'] != null)echo $_SESSION['currentUserNom'] ?>"></br>
            
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" placeholder="<?php if($_SESSION['currentUserPrenom'] != null)echo $_SESSION['currentUserPrenom'] ?>"></br>
            
                <label for="mot_de_passe">Mot de passe</label>
                <input type="text" name="mot_de_passe" id="mot_de_passe"></br>
                
                <input type="submit" value="Modifier" class="btnModifierCompte">
        </form>

    
</div>
</div>