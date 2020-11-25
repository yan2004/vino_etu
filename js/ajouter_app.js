 /**
    * ****************
    * Validation Formulaire d'Ajouter une bouteille
    * ****************
    */
 
let ajouterBouteilleCellier = document.querySelector('button');

//remplir la valeur par défaut Date_achat par AUJOURD'HUI
let date_achat_ajouter = document.getElementById('date_achat_ajouter');
date_achat_ajouter.valueAsDate = new Date();
