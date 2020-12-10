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
            <form name="formLogin" class="form-accueil display--flex">
            
                <div>
                    <label for="courriel">Courriel :</label>
                    <input type="email" name="courriel" id="courriel"/>
                    <span id="errSignInCourriel"></span>
                </div>

                <div>
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" id="password"/>
                    <span id="errSignInPassword"></span>
                </div>
                
                <div class="login-btns">
                    <button type="button" id="sign-up">S'INSCRIRE</button>
                    <button type="button" name="entrer">ENTRER</button>
                </div>
                
            </form>

            <!-- Formulaire de création de compte -->
            <form name="formSignUp" class="form-accueil display--none">

                <div>
                    <label for="singUpCourriel">Courriel :</label>
                    <input type="email" name="courriel" id="singUpCourriel"/>
                    <span id="errSignUpCourriel"></span>
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
                    <span id="errSignUpPassword"></span>
                </div>

                <div class="login-btns">
                    <button type="button" id="sign-in" name="annuler">ANNULER</button>
                    <button type="button" name="soumettre">SOUMETTRE</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>