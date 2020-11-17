<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <link rel="icon" href="data:,">
    <title>Page Public</title>
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            font-family: Times, "Times New Roman", Georgia, serif;
            font-size:625%;
        }
        .welcome-container {
            display: flex;
            flex-direction: column;
            height: calc(80vh);
            width: calc(80vw);
            margin-top: calc(10vh);
        }
        .welcome-img {
            background-image: url("../images/welcome-background.jpg");
            height: calc(65vh);
            background-size: cover;
            object-fit: none; 
            display: flex;
            justify-content: center;
            align-items: center; 
            font-size: 2rem;
            color: #511730;
            font-weight: bold;
            text-shadow: 5px 5px 5px #C3979F;
        }
        .welcome-btns {
            margin-top: calc(5vh);
            display: flex;
            justify-content: space-evenly;
        }
        #sign-in, #sign-up {
            background-color: #4F646F;
            border: none;
            border-radius: 10px;
            width: calc(20vw);
            height: calc(8vh);
            cursor: pointer;
            text-align: center;
            font-size: 1rem;
        }
        a {
            color: #FFFFFF;
            text-decoration: none;
        }
        button:hover {
            transform: scale(0.95);
        }

        @media screen and (max-width: 410px) {
            #sign-in, #sign-up {
                width: calc(30vw);
                font-size: 1rem;
            }
        }

        @media screen and (min-width: 1280px), screen and (orientation: landscape){
            .welcome-img {
                font-size: 6rem;
            }
        }
    
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="HandheldFriendly" content="true">
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-img">
            <div>Bienvenue Chez VINO</div>
        </div>
        <div class="welcome-btns">
            <button id="sign-in"><a href="">ME CONNECTER</a></button>
            <button id="sign-up"><a href="">M'INSCRIRE</a></button>
        </div>
    </div>
</body>
</html>