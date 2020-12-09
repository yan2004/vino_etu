<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Un petit verre de vino</title>

		<meta charset="utf-8">
		<meta http-equiv="cache-control" content="no-cache">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

		<meta name="description" content="Un petit verre de vino">
		<meta name="author" content="Jonathan Martel (jmartel@cmaisonneuve.qc.ca)">

		<link rel="stylesheet" href="./css/normalize.css" type="text/css" media="screen">
		<link rel="stylesheet" href="./css/base_h5bp.css" type="text/css" media="screen">
		<link rel="stylesheet" href="./css/main.css" type="text/css" media="screen">
		<base href="<?php echo BASEURL; ?>">
		<script src="./js/main.js"></script>
	</head>
	<body >
		<header>
			<nav>
				<input id="nav-toggle" type="checkbox">
				<div class="logo"><a href="?requete=accueilUsager"><img src="./images/logo-couleurs-v2.svg" alt="vino-logo"></a></div>

				<!-- Barre de recherche -->
				<div id="recherche">
					<input name="searchInput" type="text" id="searchInput" value="<?= $_GET['recherche'] ?>" placeholder="rechercher dans le cellier">
					<img id="searchArrow" src="./images/arrow-alt-circle-right-solid.svg"></img>
				</div>

				<ul class="links">
					<li><a href="?requete=ajouterNouvelleBouteilleCellier">AJOUTER UNE BOUTEILLE</a></li>
					<li><a href="?requete=modifierCompte">MON COMPTE</a></li>
					<li><a href="?requete=deconnexion">DÉCONNEXION</a></li>
				</ul>
				<label for="nav-toggle" class="icon-burger">
					<div class="line"></div>
					<div class="line"></div>
					<div class="line"></div>
				</label>
			</nav>
		</header>
		<main>
			