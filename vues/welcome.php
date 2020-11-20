<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <link rel="icon" href="data:,">
    <title>Accueil</title>

    <link rel="stylesheet" href="./css/accueil_app.css" type="text/css" media="screen">

    <script src="./js/accueil_app.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="HandheldFriendly" content="true">
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-img">
            <h1>Bienvenue Chez VINO</h1>

            <!-- Formulaire de login -->
            <form name="formLogin" class="form-accueil <?php echo $data &&  property_exists($data,'success') ? "display--flex" : "display--none"; ?>" method="post" action="index.php?requete=authentification">   
                <div>
                    <label for="pseudo">Nom d'utilisateur :</label>
                    <input type="text" name="pseudo" id="pseudo"/>
                </div>

                <div>
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" id="password"/>
                </div>
                <button type="submit" name="soumettre">SOUMETTRE</button>
                <span id="msgSuccess"><?php if($data && $data->msgSuccess) echo $data->msgSuccess ?></span>
            </form>

            <!-- Formulaire de création de compte -->
            <form name="formSignUp" class="form-accueil <?php echo $data &&  property_exists($data,'msgErreur') ? "display--flex" : "display--none"; ?>" method="post" action="index.php?requete=creerCompte">

                <div>
                    <label for="pseudo">Nom d'utilisateur :</label>
                    <input type="text" name="pseudo" id="singUpPseudo"/>
                    <span id="errPseudo"></span>
                </div>

                <div>
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom" id="singUpNom"/>
                    <span id="errSignUpNom"></span>
                </div>

                <div>
                    <label for="prenom">Prénom :</label>
                    <input type="text" name="prenom" id="singUpPrenom"/>
                    <span id="errSignUpPrenom"></span>
                </div>
                
                <div>
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" id="singUpPassword"/>
                    <span id="errSignUpPwd"></span>
                </div>
                <button type="submit" name="confirmer">CONFIRMER</button>
                <span id="errConfirmer"><?php if($data && $data->msgErreur) echo $data->msgErreur ?></span>
            </form>
        </div>

        <div class="welcome-btns">
            <button id="sign-in">CONNEXION</button>
            <button id="sign-up">INSCRIPTION</button>
        </div>
    </div>
</body>
</html>