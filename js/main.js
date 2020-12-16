/**
 * @file Script contenant les fonctions de base
 * @author Jin Yan, Marianne Soucy et Jonathan Martel
 * @version 0.2
 * @update 2020-11-24
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 *
 */

const BaseURL = "http://localhost:8888/vino/vino_etu/";
//const BaseURL = "http://localhost/projetWeb2/vino_etu/";
// const BaseURL = document.baseURI;

// déclaration de l'objet avec les controles à effectuer pour chaque champs de la modification de compte
const controlesModifCompte = {
  nom:            {requis: true, regExp: /^[\u4e00-\u9fa5a-zà-ÿ\d ',\-"\.]{1,50}$/i,                  msgRegExp: "1 à 50 caractères."},
  prenom:         {requis: true, regExp: /^[\u4e00-\u9fa5a-zà-ÿ\d ',\-"\.]{1,50}$/i,                  msgRegExp: "1 à 50 caractères."},
  mot_de_passe:   {requis: false, regExp: /^(?=.*[0-9])(?=.*[a-z])([a-z0-9!@#$%^&*;.,\-_'"]{4,})$/i,  msgRegExp: "Au moins 4 caractères avec 1 chiffre et 1 lettre."},
};

// déclaration de l'objet avec les controles à effectuer pour chaque champs d'une bouteille
const controlesModifBtl = {
  millesime:  {requis: false, regExp: /^[1-2][0-9]{3}$/,                                             msgRegExp: "4 chiffres commencent par 1YYY ou 2YYY."},
  quantite:   {requis: true,  regExp: /^(0|[1-9]\d*)$/,                                              msgRegExp: "Inscrire un entier naturel (de 0 à ...)"},
  date_achat: {requis: true,  regExp: /^[1-2][0-9]{3}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/,  msgRegExp: "Format yyyy-mm-dd."},
  prix:       {requis: true,  regExp: /^(0|00|[1-9]\d*)(\.[0-9]{2})$/,                               msgRegExp: "Prix format xx.xx"},
  garde:      {requis: false, regExp: /^[0-9a-zà-ÿ'",\.\-;!)(?@#$%^&:*+_ ]{0,200}$/i,                msgRegExp: "Maximum 200 caractères alphanumériques."},
  notes:      {requis: false, regExp: /^[0-9a-zà-ÿ'",\.\-;!)(?@#$%^&:*+_ ]{0,200}$/i,                msgRegExp: "Maximum 200 caractères alphanumériques."}
};



// initialisation de la variable errForm pour la validation des différents formulaires
let errForm = false;

window.addEventListener('load', function() {

  // création de l'objet "bouteille" avec tous les champs du form
  let bouteille = {
    nom : document.querySelector(".nom_bouteille"),
    millesime : document.querySelector("[name='millesime']"),
    quantite : document.querySelector("[name='quantite']"),
    date_achat : document.querySelector("[name='date_achat']"),
    prix : document.querySelector("[name='prix']"),
    garde_jusqua : document.querySelector("[name='garde']"),
    notes : document.querySelector("[name='notes']"),
    courriel : document.querySelector("[name='courriel_usager']"), // courriel de l'usager en session
  };

  // ******************
  // BARRE DE RECHERCHE
  // ******************

  let barreRecherche = document.getElementById("searchInput");
  let flecheRecherche = document.getElementById("searchArrow");

  // au change dans le input
  barreRecherche.addEventListener("change", (evt) => {

    evt.preventDefault();
    // console.log("au change");

    //recuperer la valeur de l'input
    let valRecherche = evt.target.value.trim();

    // console.log(valRecherche);
    window.location.href = BaseURL+"index.php?requete=resultatRecherche&recherche="+valRecherche;
  });

  // au clic sur la flèche
  flecheRecherche.addEventListener("click", (evt) => {

    evt.preventDefault();
    // console.log("au click");

    //recuperer la valeur de l'input
    let valRecherche = barreRecherche.value.trim();
 
    // console.log(valRecherche);
    window.location.href = BaseURL+"index.php?requete=resultatRecherche&recherche="+valRecherche;
  });


  // ************************************
  // DIMINUER LA QUANTITÉ D'UNE BOUTEILLE
  // ************************************

  document.querySelectorAll(".btnBoire").forEach(function(element){

    // requête ajax au click d'un des boutons "boire" de la page
    element.addEventListener("click", function(evt){

        // on prend l'id de la bouteille et la quantité
        let id = evt.target.parentElement.dataset.id;
        let eQuantite = document.querySelector(`.bulle[data-id='${id}'] .quantite`);

        let requete = new Request(BaseURL+"index.php?requete=boireBouteilleCellier", {method: 'POST', body: '{"id": '+id+'}'});

        fetch(requete)
        .then(response => {
            if (response.status === 200) {
              return response.json();
            } else {
              throw new Error('Erreur');
            }
        })
        .then(response => {

          // update de la quantité sur la page
          if(response.success){
            eQuantite.innerHTML = `${response.quantite}`;
          }
        })
        .catch(error => {
          console.error(error);
        });
    });

  });

  // ***********************************
  // AJOUTER LA QUANTITÉ D'UNE BOUTEILLE
  // ***********************************

  document.querySelectorAll(".btnAjouter").forEach(function(element){

    // requête ajax au click d'un des boutons "ajouter" de la page
    element.addEventListener("click", function(evt){

      // recuperer l'id de la bouteille et la quantité
      let id = evt.target.parentElement.dataset.id;
      let eQuantite = document.querySelector(`.bulle[data-id='${id}'] .quantite`);

      let requete = new Request(BaseURL+"index.php?requete=ajouterBouteilleCellier", {method: 'POST', body: '{"id": '+id+'}'});

      fetch(requete)
      .then(response => {
        if (response.status === 200) {
          return response.json();
        } else {
          throw new Error('Erreur');
        }
      })
      .then(response => {

        // update de la quantité sur la page
        if(response.success){
          eQuantite.innerHTML = `${response.quantite}`;
        }
      })
      .catch(error => {
        console.error(error);
      });
    });

  });

  // **********************************
  // SUPPRIMER UNE BOUTEILLE DU CELLIER
  // **********************************

  document.querySelectorAll(".btnSupprimer").forEach(function(element){

    // requête ajax au click d'un des boutons "boire" de la page
    element.addEventListener("click", function(evt){

      //assurer s'il y a un modal, on ne peux pas cliquer une autre btn de supprimer
      if(document.querySelectorAll('.modal-container-display') && document.querySelectorAll('.modal-container-display').length==0){

        // traiter modal
        // let modalId = evt.target.parentElement.parentElement.parentElement.firstElementChild.dataset.id;
        let modalId = evt.target.parentElement.dataset.id;
        let modals = document.getElementsByClassName('modal-container');

        for (let i = 0; i < modals.length; i++){

          //obtenir la valeur de dataset
          if(modals[i].getAttribute('data-id') == modalId){
            
            modals[i].setAttribute("class", "modal-container-display");
            
            //select l'élément de modal
            let modal = document.querySelector('.modal-container-display');
            let btnModalSupprimer = modal.querySelector('.btnModalSupprimer');
            let btnModalAnnuler = modal.querySelector('.btnModalAnnuler');

            // quand cliquer le bouton de confirmation de SUPPRIMER
            btnModalSupprimer.addEventListener('click', (evt)=>{
              let id = evt.target.dataset.id;

              // récupération de l'élément du DOM contenant la bouteille en question
              let laBouteille = document.querySelector(`.bouteille[data-id='${id}']`);

              let requete = new Request(BaseURL+"index.php?requete=supprimerBouteilleCellier", {method: 'POST', body: '{"id": '+id+'}'});

              fetch(requete)
              .then(response => {
                  if (response.status === 200) {
                    return response.json();
                  } else {
                    throw new Error('Erreur');
                  }
              })
              .then(response => {
                if(response.success){
                  // supprimer la bouteille du DOM
                  laBouteille.remove();
                  // console.log(id);
                  modal.setAttribute("class", "modal-container");
                }else{
                  throw response.msg;
                }
              })
              .catch(error => {
                console.error(error);
              });

            })

            // quand cliquer le bouton de ANNULER de supprimer
            btnModalAnnuler.addEventListener('click', (evt)=>{
              evt.preventDefault();
              let modal = evt.target.parentElement.parentElement.parentElement;
              modal.setAttribute("class", "modal-container");
              
            });
          }
        }
      }
    });
  });


  // **********************************
  // MODIFIER LES INFOS D'UNE BOUTEILLE
  // **********************************

  document.querySelectorAll(".btnModifier").forEach(function(element){

    element.addEventListener("click", function(evt){

      // pour empêcher que le formulaire se soumette (submit) au serveur
      evt.preventDefault();

      // récupération de l'id de la bouteille
      let id = evt.target.parentElement.dataset.id;

      // redirection vers le template avec formulaire de modification d'une bouteille
      window.location.href = BaseURL+"index.php?requete=formModificationBtl&id="+id;
    });
  });

  // *********************************************************
  // VALIDATIONS DU FORMULAIRE DE MODIFICATION D'UNE BOUTEILLE
  // *********************************************************

  // si le formulaire est accessible dans le DOM, on effectue les validations
  if(typeof fModificationBtl !== 'undefined'){

    let fMdBtl = fModificationBtl;
    let btnModifierBtl = document.getElementsByClassName('btnModifierBtl')[0];

    // validation des valeurs d'inputs au "change" avec l'objet des controles
    fMdBtl.addEventListener('change', (evt)=>{
      let nomChamp = evt.target.name;
      let controles = controlesModifBtl[nomChamp];
      // appel de la fonction qui valide et detecte les erreurs lors du remplissage des champs
      validerChamps(fMdBtl, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
    });

    // redirection à l'accueil (cellier) au clic sur le bouton "annuler"
    let btnAnnuler = document.querySelector(".btnAnnuler");
    btnAnnuler.addEventListener("click", function(evt){
      evt.preventDefault();
      window.location.href = BaseURL+"index.php?requete=accueilUsager";
    });
    
    // validation des valeurs au clic sur le bouton "modifier", avant l'envoi des infos au serveur
    btnModifierBtl.addEventListener("click", function(evt){

      // empêcher que le formulaire se soumette (submit) au serveur et refresh la page
      evt.preventDefault();

      // appel de la fonction pour le traitement du formulaire
      processModifBouteille();
    });

    // évènement pour la touche "enter" lors de l'authentification
    fMdBtl.addEventListener("keyup", (evt) => {

      // pour ne pas que le formulaire se soumette
      evt.preventDefault();

      let key = evt.key || evt.keyCode;

      if(key === 'Enter' || key === 13){
        // appel de la fonction pour le traitement du login
        processModifBouteille();
      }
    });
  }

  // ******************************************************
  // AUTOCOMPLETE POUR L'AJOUT DE BOUTEILLE DANS LE CELLIER
  // ******************************************************

  // champ de recherche
  let inputNomBouteille = document.querySelector("[name='nom_bouteille']");

  // région d'affichage la liste de suggestions
  let liste = document.querySelector('.listeAutoComplete');

  if(inputNomBouteille){

    inputNomBouteille.addEventListener("keyup", function(evt){

      let nom = inputNomBouteille.value;

      // vider la liste de suggestions
      liste.innerHTML = "";

      if(nom){

        // requête ajax pour générer les suggestions
        let requete = new Request(BaseURL+"index.php?requete=autocompleteBouteille", {method: 'POST', body: '{"nom": "'+nom+'"}'});

        fetch(requete)
        .then(response => {
            if (response.status === 200) {
              return response.json();
            } else {
              throw new Error('Erreur');
            }
        })
        .then(response => {
          // création d'un "li" pour chaque suggestion dans le DOM
          response.forEach(function(element){
            liste.innerHTML += "<li data-id='"+element.id +"' data-prix='"+element.prix_saq+"'>"+element.nom+"</li>";
          });

        })
        .catch(error => {
          console.error(error);
        });
      }
    });

    liste.addEventListener("click", function(evt){

      if(evt.target.tagName == "LI"){

        // on va chercher l'id de la bouteille suggérée
        bouteille.nom.dataset.id = evt.target.dataset.id;

        // on met le nom de la bouteille suggérée dans le champs "nom"
        bouteille.nom.innerHTML = evt.target.innerHTML;

        // on va cherche le prix de bouteille choisi et le met dans le champ de Prix
        let prix = evt.target.dataset.prix;
        if(document.getElementById('prix_ajouter')){
          let prixEle = document.getElementById('prix_ajouter');

          // NON : prixEle.setAttribute('value', prix);
          prixEle.value = prix;

          // vide le span d'erreur lors de la selection
          document.getElementById("errPrix").innerHTML = "";
        }
        
        liste.innerHTML = "";
        inputNomBouteille.value = "";

        // vide le span d'erreur lors de la selection
        document.getElementById("errNom_ajouter").innerHTML = "";
      }
    });

    // **********************************************************
    // VALIDATIONS DU FORMULAIRE D'AJOUT D'UNE NOUVELLE BOUTEILLE
    // **********************************************************
    
    if(typeof fAjtBtlCellier !== 'undefined'){

      let btnAjouter = document.querySelector("[name='ajouterBouteilleCellier']");
      let fAjtBtlCellier = document.getElementById('form-ajouter-btl');

      // La valeur par défaut de champ Date, aujourd'hui
      let dateAjtBtl = document.getElementById('date_achat_ajouter');
      dateAjtBtl.valueAsDate = new Date();

      // validation des valeurs d'inputs au "change" avec l'objet des controles
      fAjtBtlCellier.addEventListener('change', (evt)=>{
        let nomChamp = evt.target.name;

        // l'objet de controles est le même que celui pour la modification, car il s'agit des même champs
        let controles = controlesModifBtl[nomChamp];
        validerChamps(fAjtBtlCellier, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
      });

      // redirection à l'accueil (cellier) au clic sur le bouton "annuler"
      let btnAnnuler = document.querySelector(".btnAnnuler");
      btnAnnuler.addEventListener("click", function(evt){
        evt.preventDefault();
        window.location.href = BaseURL+"index.php?requete=accueilUsager";
      });
      
      // validation des valeurs au clic sur le bouton "ajouter", avant l'envoi des infos au serveur
      btnAjouter.addEventListener("click", function(evt){

        // empêcher que le formulaire se soumette (submit) au serveur et refresh la page
        evt.preventDefault();

        // appel de la fonction pour le traitement de l'ajout
        processAjoutBouteille(bouteille);
      });

      // évènement pour la touche "enter" lors de l'ajout
      fAjtBtlCellier.addEventListener("keyup", (evt) => {

        // pour ne pas que le formulaire se soumette
        evt.preventDefault();

        let key = evt.key || evt.keyCode;

        if(key === 'Enter' || key === 13){
          // appel de la fonction pour le traitement de l'ajout
          processAjoutBouteille(bouteille);
        }
      });
    }
  }

  // ********************************************************************
  // VALIDATIONS DU FORMULAIRE DE MODIFICATION DES INFOS DU COMPTE USAGER
  // ********************************************************************

  if(document.getElementById('fCompte')){

    let f = document.getElementById('fCompte');

    // validation des valeurs d'inputs au "change" avec l'objet des controles
    f.addEventListener('change', (evt)=>{
      let nomChamp = evt.target.name;
      let controles = controlesModifCompte[nomChamp];
      if(nomChamp === "mot_de_passe_conf"){
        // validation spéciale pour la confirmation du mot de passe
        mot_de_passe_confValider();
      }else{
        if(nomChamp === "mot_de_passe") mot_de_passe_confValider();
        // appel de la fonction qui valide et detecte les erreurs lors du remplissage des champs
        validerChamps(f, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
      }
    });

    // redirection à l'accueil (cellier) au clic sur le bouton "annuler"
    let btnAnnuler = document.querySelector(".btnAnnuler");
    btnAnnuler.addEventListener("click", function(evt){
      evt.preventDefault();
      window.location.href = BaseURL+"index.php?requete=accueilUsager";
    });

    let btnModCmpt = document.getElementsByClassName('btnModifierCompte')[0];

    // validation des valeurs au clic sur le bouton "modifier", avant l'envoi des infos au serveur
    btnModCmpt.addEventListener("click", function(evt){

      // empêcher que le formulaire se soumette (submit) au serveur et refresh la page
      evt.preventDefault();

      // appel de la fonction pour le traitement de la modification des infos de compte
      processModifCompte();
      
    });

    // évènement pour la touche "enter" lors de la modification des infos de compte
    f.addEventListener("keyup", (evt) => {

      // pour ne pas que le formulaire se soumette tout de suite
      evt.preventDefault();

      let key = evt.key || evt.keyCode;

      if(key === 'Enter' || key === 13){
        
        // appel de la fonction pour le traitement de la modification des infos de compte
        processModifCompte();
      }
    });
  }

  
  // *********************************************************************************************************
  // CLIC DU BOUTON "CALL TO ACTION" POUR OUVRIR LE FORMULAIRE D'AJOUT D'UNE NOUVELLE BOUTEILLE
  // *********************************************************************************************************

  if(document.getElementById('btnCallActionAjt'))
  {
    let btnCallActionAjt = document.getElementById('btnCallActionAjt');
    btnCallActionAjt.addEventListener("click", function(){
      // redirection vers template avec formulaire d'ajout d'une nouvelle bouteille
      window.location.href = BaseURL+"index.php?requete=ajouterNouvelleBouteilleCellier";
    });
  }

});



// ************************************
// FONCTIONS UTILISÉES DANS LE DOCUMENT
// ************************************

/**
 * Fonction qui traite les champs du formulaire de modification de bouteille, et la requête ajax
 */
function processModifBouteille(){

  errForm = false;
  let fMdBtl = fModificationBtl;
  let eNom = document.querySelector("span.nom_bouteille");

  // Création de l'objet contenant les valeurs des inputs pour envoi au serveur
  let dataBtlEnvoyer = {
      'btlIdPK':    fMdBtl.btlIdPK.value,
      'nomIdFK':    fMdBtl.nomIdFK.value,
      'nomBtl':     eNom.innerText,
      'millesime':  fMdBtl.millesime.value,
      'quantite':   fMdBtl.quantite.value,
      'date_achat': fMdBtl.date_achat.value,
      'prix':       fMdBtl.prix.value,
      'garde':      fMdBtl.garde.value,
      'notes':      fMdBtl.notes.value
  }

  // validation avec l'objet de controles
  for(let nomChamp in controlesModifBtl){
    let controles = controlesModifBtl[nomChamp];
    // appel de la fonction qui valide et detecte les erreurs lors du remplissage des champs
    validerChamps(fMdBtl, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
  }

  //validation spéciale pour la date
  if(new Date(fMdBtl.date_achat.value + " EST") > new Date()){
    errForm = true;
    document.getElementById("errDate_achat").innerHTML = "Date d'achat invalide.";
  }

  // si la validation du formulaire n'a détecté aucune erreur, on envoi au serveur les modifications
  if(!errForm){

    // requête ajax pour envoi des données au serveur pour l'update
    let requete = new Request(BaseURL+"index.php?requete=sauvegardeBouteille", {method: 'POST', body: JSON.stringify(dataBtlEnvoyer)});

    fetch(requete)
    .then(response => {
      if (response.status === 200) {
        return response.json();
      } else {
        throw new Error('Erreur');
      }
    })
    .then(response => {
      if(response.success){
        // redirection vers l'accueilUsager pour affichage des bouteilles dans son cellier
        window.location = BaseURL+"index.php?requete=accueilUsager";
      }else{
        // messages d'erreur provenant des validations back-end
        let eSpanErrAjout = document.getElementById("errNotes");
        eSpanErrAjout.innerText = response.msg;
      }
    })
    .catch(error => {
      console.error(error);
    });
  }

}

/**
 * Fonction qui traite les champs du formulaire de l'ajout de bouteille, et la requête ajax
 */
function processAjoutBouteille(data){

  // toutes les valeurs de notre formulaire (données prêtes à être envoyées au back end)
  let param = {
    "id_bouteille":data.nom.dataset.id,
    "date_achat":data.date_achat.value,
    "garde_jusqua":data.garde_jusqua.value,
    "notes":data.notes.value,
    "prix":data.prix.value,
    "quantite":data.quantite.value,
    "millesime":data.millesime.value,
    "courriel":data.courriel.value,
  };

  let fAjtBtlCellier = document.getElementById('form-ajouter-btl');
  errForm = false;

  // validation avec l'objet de controles
  for(let nomChamp in controlesModifBtl){
    let controles = controlesModifBtl[nomChamp];
    validerChamps(fAjtBtlCellier, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
  }

  //validation spéciale pour la date
  if(new Date(fAjtBtlCellier.date_achat.value + " EST") > new Date()){
    errForm = true;
    document.getElementById("errDate_achat").innerHTML = "Date d'achat invalide.";
  }

  //validation spéciale pour le nom : obligatoire seulement, car il s'agit d'un autocomplete
  let spanNom = document.getElementsByClassName('nom_bouteille')[0];
  if(spanNom.innerText === ""){
    errForm = true;
    document.getElementById("errNom_ajouter").innerHTML = "Obligatoire.";
  }else{
    document.getElementById("errNom_ajouter").innerHTML = "";
  }

  // si la validation du formulaire n'a détecté aucune erreur, on envoi au serveur la nouvelle bouteille
  if(!errForm){

    // requete ajax pour ajouter une bouteille dans le cellier
    let requete = new Request(BaseURL+"index.php?requete=ajouterNouvelleBouteilleCellier", {method: 'POST', body: JSON.stringify(param)});

    fetch(requete)
    .then(response => {
      if (response.status === 200) {
        return response.json();
        // return response.text();
      } else {
        throw new Error('Erreur');
      }
    })
    .then(response => {
      if(response.success) {
        
        // redirection vers l'accueilUsager pour affichage des bouteilles dans son cellier
        window.location = BaseURL+"index.php?requete=accueilUsager";
      }else{
        // messages d'erreur provenant des validations back-end
        let eSpanErrAjout = document.getElementById("errNotes");
        eSpanErrAjout.innerText = response.msg;
      }
    })
    .catch(error => {
      console.error(error);
    });
  }

}

/**
 * Fonction qui traite les champs du formulaire de modification de compte, et la requête ajax
 */
function processModifCompte(){

  let f = document.getElementById('fCompte');

  // Création de l'objet contenant les valeurs des inputs pour envoi au serveur
  let dataCompte = {
    'nom':    f.nom.value,
    'prenom':  f.prenom.value,
    'mot_de_passe':   f.mot_de_passe.value
  } 

  errForm = false;

  // validation avec l'objet de controles
  for(let nomChamp in controlesModifCompte){
    let controles = controlesModifCompte[nomChamp];
    // appel de la fonction qui valide et detecte les erreurs lors du remplissage des champs
    validerChamps(f, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
  }

  //validation spéciale pour la confirmation de mot de passe
  mot_de_passe_confValider();

  // si la validation du formulaire n'a détecté aucune erreur, on envoi au serveur les modifications
  if(!errForm){

    // requête ajax pour envoi des données au serveur pour l'update
    let requete = new Request(BaseURL+"index.php?requete=sauvegardeCompte", {method: 'POST', body: JSON.stringify(dataCompte)});

    fetch(requete)
    .then(response => {
      if (response.status === 200) {
        return response.json();
      } else {
        throw new Error('Erreur');
      }
    })
    .then(response => {
      if(response.success){

        // redirection vers l'accueilUsager pour affichage des bouteilles dans son cellier
        window.location = BaseURL+"index.php?requete=accueilUsager";
      }else{
        // messages d'erreur provenant des validations back-end
        let eSpanErrAjout = document.getElementById("errNotes");
        eSpanErrAjout.innerText = response.msg;
      }
    })
    .catch(error => {
      console.error(error);
    });
  }

}

/**
 * Fonction servant à valider le champs de confirmation de mot de passe
 */
function mot_de_passe_confValider() {
  let valConf = document.querySelector('#fCompte #mot_de_passe_conf').value.trim();
  let val     = document.querySelector('#fCompte #mot_de_passe').value.trim();

  let msgErr = "";

  // vérifier si le mot de passe inscrit dans le champs de confirmation est de même valeur que celui dans le champs mot de passe
  if(valConf !== val){
    if(valConf === ""){
      msgErr = "Obligatoire.";
    }else{
      msgErr = "Mot de passe et Confirmation ne correspondent pas.";
    }
    errForm = true;          
  }
  // affichage du message d'erreur
  document.getElementById('errMot_de_passe_conf').innerHTML = msgErr;
}


/**
 * Fonction de validation des champs et gestion des messages d'erreur
 * @param {*} idForm 
 * @param {*} nomChamp 
 * @param {*} requis 
 * @param {*} regExp 
 * @param {*} msgRegExp 
 */
function validerChamps(form, nomChamp, requis=false, regExp=null, msgRegExp=null){

  let val = "";
  // récupération de l'élément
  let e = form[nomChamp];

  // recuperation de la valeur du champ
  e.value = e.value.trim();
  val = e.value;

  // gestion de l'affichage des messages d'erreur
  let msgErr = "";
  if (val === "" && requis){
    msgErr = "Obligatoire";
  } else if (regExp !== null && !regExp.test(val) && val !== ""){
    msgErr = msgRegExp;
  }

  // construction du nom du span où sera affiché l'erreur
  let idSpan = "err" + nomChamp[0].toUpperCase() + nomChamp.substring(1);
  document.getElementById(idSpan).innerHTML = msgErr;

  if (msgErr !== "") errForm = true;
}