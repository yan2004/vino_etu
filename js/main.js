/**
 * @file Script contenant les fonctions de base
 * @author Jin Yan, Marianne Soucy et Jonathan Martel
 * @version 0.2
 * @update 2020-11-24
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 *
 */

// const BaseURL = "http://localhost:8888/vino/vino_etu/";
const BaseURL = "http://localhost/projetWeb2/vino_etu/";
// const BaseURL = document.baseURI;

// console.log(BaseURL);

// initialisation de la variable errForm pour la validation des différents formulaires
let errForm = false;

window.addEventListener('load', function() {

  // ************************************
  // DIMINUER LA QUANTITÉ D'UNE BOUTEILLE
  // ************************************

  document.querySelectorAll(".btnBoire").forEach(function(element){

    // requête ajax au click d'un des boutons "boire" de la page
    element.addEventListener("click", function(evt){

        let id = evt.target.parentElement.dataset.id;
        let eQuantite = document.querySelector(`.description[data-id='${id}'] .quantite`);
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
            eQuantite.innerHTML = `Quantité : ${response.quantite}`;
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

      // recuperer l'id de la bouteille
      let id = evt.target.parentElement.dataset.id;
      let eQuantite = document.querySelector(`.description[data-id='${id}'] .quantite`);
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
          eQuantite.innerHTML = `Quantité : ${response.quantite}`;
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

        let id = evt.target.parentElement.dataset.id;

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
          }else{
            throw response.msg;
          }
        })
        .catch(error => {
          console.error(error);
        });
    });

  });


  // **********************************
  // MODIFIER LES INFOS D'UNE BOUTEILLE
  // **********************************

  // TODO : AJOUTER LA FONCTIONNALITÉ D'AUTO-COMPLETE POUR LE NOM DE LA BOUTEILLE

  document.querySelectorAll(".btnModifier").forEach(function(element){

    // requête ajax au click d'un des boutons "modifier" de la page
    element.addEventListener("click", function(evt){

      // pour empêcher que le formulaire se soumette (submit) au serveur
      evt.preventDefault();
      let id = evt.target.parentElement.dataset.id;
      
      // call ajax
      let xhr = new XMLHttpRequest();
      let method = "GET";
      let url = BaseURL+"index.php?requete=modifierBouteilleCellier&id="+id;
      //let url = BaseURL+"index.php?requete=formModificationBtl";
      let asynchronous = true;
      // receiving response from url
      xhr.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          
          //converting JSON back to array
          //let dataBtls = JSON.parse(this.responseText);
          let dataBtls = this.responseText;
          //console.log(dataBtls);
          window.location.href = BaseURL+"index.php?requete=formModificationBtl&dataBtls="+dataBtls+"&id="+id;
          }
      }
      xhr.open(method, url, asynchronous);
      // Sending ajax request
      xhr.send();
    });
  });

  // *********************************************************
  // VALIDATIONS DU FORMULAIRE DE MODIFICATION D'UNE BOUTEILLE
  // *********************************************************
   
  // construction de l'objet avec les controles qui seront effectués
  // *** LE NOM N'Y EST PAS, CAR IL Y AURA UN AUTO-COMPLETE ***
  let controlesModifBtl = {
    millesime:  {requis: false, regExp: /^[1-2][0-9]{3}$/,                                             msgRegExp: "4 chiffres commencent par 1YYY ou 2YYY."},
    quantite:   {requis: true,  regExp: /^(0|[1-9]\d*)$/,                                              msgRegExp: "Inscrire un entier naturel (de 0 à ...)"},
    date_achat: {requis: true,  regExp: /^[1-2][0-9]{3}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/,  msgRegExp: "Format yyyy-mm-dd."},
    prix:       {requis: true,  regExp: /^(0|[1-9]\d*)(\.[0-9]{2})$/,                                  msgRegExp: "Prix format xx.xx"},
    garde:      {requis: false, regExp: /^[0-9a-zà-ÿ'",\.\-; ]{0,200}$/i,                              msgRegExp: "Maximum 200 caractères alphanumériques."},
    notes:      {requis: false, regExp: /^[0-9a-zà-ÿ'",\.\-; ]{0,200}$/i,                              msgRegExp: "Maximum 200 caractères alphanumériques."}
  };

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

      errForm = false;

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

      // Création de l'objet contenant les valeurs des inputs pour envoi au serveur
      let dataBtlEnvoyer = {
          'btlIdPK':    fMdBtl.btlIdPK.value,
          'nomIdFK':    fMdBtl.nomIdFK.value,
          'nomBtl':     fMdBtl.nom.value,
          'millesime':  fMdBtl.millesime.value,
          'quantite':   fMdBtl.quantite.value,
          'date_achat': fMdBtl.date_achat.value,
          'prix':       fMdBtl.prix.value,
          'garde':      fMdBtl.garde.value,
          'notes':      fMdBtl.notes.value
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

          // NOUVEAU CODE PERMETTANT DES MESSAGES DE VALIDATIONS BACK À L'ÉCHEC D'UNE REQUÊTE:
          // ********************************************************************************
          }else{
            // messages d'erreur provenant des validations back-end
            let eSpanErrAjout = document.getElementById("errNotes");
            eSpanErrAjout.innerText = response.msg;
          }
          // *******************************************************************************
        })
        .catch(error => {
          // TODO : traitement de l'erreur
          console.error(error);
        });
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

    liste.addEventListener("click", function(evt){

      if(evt.target.tagName == "LI"){

        // on va chercher l'id de la bouteille suggérée
        bouteille.nom.dataset.id = evt.target.dataset.id;

        // on met le nom de la bouteille suggérée dans le champs "nom"
        bouteille.nom.innerHTML = evt.target.innerHTML;
        
        liste.innerHTML = "";
        inputNomBouteille.value = "";

        // on va cherche le prix de bouteille choisi et le met dans le champ de Prix
        let prix = evt.target.dataset.prix;
        if(document.getElementById('prix_ajouter')){
          let prixEle = document.getElementById('prix_ajouter');
          prixEle.setAttribute('value', prix);
        }

      }
    });

    // **********************************************************
    // VALIDATIONS DU FORMULAIRE D'AJOUT D'UNE NOUVELLE BOUTEILLE
    // **********************************************************
    
    //let fAjtBtlCellier = document.getElementById('form-ajouter-btl');
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
        }

        // toutes les valeurs de notre formulaire (données prêtes à être envoyées au back end)
        var param = {
          "id_bouteille":bouteille.nom.dataset.id,
          "date_achat":bouteille.date_achat.value,
          "garde_jusqua":bouteille.garde_jusqua.value,
          "notes":bouteille.notes.value,
          "prix":bouteille.prix.value,
          "quantite":bouteille.quantite.value,
          "millesime":bouteille.millesime.value,
          "courriel":bouteille.courriel.value,
        };

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

            // NOUVEAU CODE PERMETTANT DES MESSAGES DE VALIDATIONS BACK À L'ÉCHEC D'UNE REQUÊTE:
            // ********************************************************************************
            if(response.success) {
              
              // redirection vers l'accueilUsager pour affichage des bouteilles dans son cellier
              window.location = BaseURL+"index.php?requete=accueilUsager";
            }else{
              // messages d'erreur provenant des validations back-end
              let eSpanErrAjout = document.getElementById("errNotes");
              eSpanErrAjout.innerText = response.msg;
            }
            // *******************************************************************************

            // ANCIEN CODE SANS VALIDATIONS BACK END:
            // redirection vers l'accueilUsager pour affichage des bouteilles dans son cellier
            // window.location = BaseURL+"index.php?requete=accueilUsager";
          })
          .catch(error => {
            console.error(error);
          });
        }
      });
    }
  }

  // ********************************************************************
  // VALIDATIONS DU FORMULAIRE DE MODIFICATION DES INFOS DU COMPTE USAGER
  // ********************************************************************

  if(document.getElementById('fCompte')){

    let f = document.getElementById('fCompte');
    
    let erreurCmpt = false;

    f.addEventListener('change', (evt)=>{
      let nomChamp = evt.target.name;
      eval(nomChamp + 'Valider()');
    })
    
    let btnModCmpt = document.getElementsByClassName('btnModifierCompte')[0];

    f.addEventListener("submit", function(evt){
      console.log("sybmit");
      erreurCmpt = false;
      nomValider();
      prenomValider();
      mot_de_passeValider();
      mot_de_passe_confValider();

      if (erreurCmpt) evt.preventDefault();

    })
  }
   function nomValider() {
     let msgErr = "";
     let val = document.querySelector('#fCompte #nom').value.trim();
     let reg = new RegExp("^((?:\\w|[\\-_ ](?![\\-_ ])|[\\u00C0\\u00C1\\u00C2\\u00C3\\u00C4\\u00C5\\u00C6\\u00C7\\u00C8\\u00C9\\u00CA\\u00CB\\u00CC\\u00CD\\u00CE\\u00CF\\u00D0\\u00D1\\u00D2\\u00D3\\u00D4\\u00D5\\u00D6\\u00D8\\u00D9\\u00DA\\u00DB\\u00DC\\u00DD\\u00DF\\u00E0\\u00E1\\u00E2\\u00E3\\u00E4\\u00E5\\u00E6\\u00E7\\u00E8\\u00E9\\u00EA\\u00EB\\u00EC\\u00ED\\u00EE\\u00EF\\u00F0\\u00F1\\u00F2\\u00F3\\u00F4\\u00F5\\u00F6\\u00F9\\u00FA\\u00FB\\u00FC\\u00FD\\u00FF\\u0153])+)$", "i");
     
     //Vérifier si au moins deux caractères
     let l = val.length;
     if(l < 2) msgErr = "Au moins deux caractères alphabétiques!";

      //Vérifier si les caractères de séparation sont suivantes
      if(l > 1){
        if(!reg.test(val)) msgErr = "Les caractères de séparation (- ou _ ou espace) sont autorisés, mais n'autorise pas qu'ils se suivent!";
      }
     
     document.getElementById('errNom').innerHTML = msgErr;
     if (msgErr !== "") erreurCmpt = true;
   }

   function prenomValider() {
      let msgErr = "";
      let val = document.querySelector('#fCompte #prenom').value.trim();
      let reg = new RegExp("^((?:\\w|[\\-_ ](?![\\-_ ])|[\\u00C0\\u00C1\\u00C2\\u00C3\\u00C4\\u00C5\\u00C6\\u00C7\\u00C8\\u00C9\\u00CA\\u00CB\\u00CC\\u00CD\\u00CE\\u00CF\\u00D0\\u00D1\\u00D2\\u00D3\\u00D4\\u00D5\\u00D6\\u00D8\\u00D9\\u00DA\\u00DB\\u00DC\\u00DD\\u00DF\\u00E0\\u00E1\\u00E2\\u00E3\\u00E4\\u00E5\\u00E6\\u00E7\\u00E8\\u00E9\\u00EA\\u00EB\\u00EC\\u00ED\\u00EE\\u00EF\\u00F0\\u00F1\\u00F2\\u00F3\\u00F4\\u00F5\\u00F6\\u00F9\\u00FA\\u00FB\\u00FC\\u00FD\\u00FF\\u0153])+)$", "i");
      
      //Vérifier si au moins deux caractères
      let l = val.length;
      if(l < 2) msgErr = "Au moins deux caractères alphabétiques!";

      //Vérifier si les caractères de séparation sont suivantes
      if(l > 1){
        if(!reg.test(val)) msgErr = "Les caractères de séparation (- ou _ ou espace) sont autorisés, mais n'autorise pas qu'ils se suivent!";
      }
      
      document.getElementById('errPrenom').innerHTML = msgErr;
      if (msgErr !== "") erreurCmpt = true;
   }

   function mot_de_passeValider() {
      let msgErr = "";
      let val = document.querySelector('#fCompte #mot_de_passe').value.trim();

      if(val.length < 5) {
        msgErr = "Au moins 5 caractères!";
      }
      if(val.search(/[a-z]/i) < 0) {
        msgErr = "Au moins 1 lettres!"
      }
      if(val.search(/[0-9]/) < 0) {
        msgErr = "Au moin 1 chiffre!"
      }

      document.getElementById('errMDP').innerHTML = msgErr;
      if (msgErr !== "") erreurCmpt = true
   }

   function mot_de_passe_confValider() {
      let msgErr  = "";
      let valConf = document.querySelector('#fCompte #mot_de_passe_conf').value.trim();
      let val     = document.querySelector('#fCompte #mot_de_passe').value.trim();
      if(valConf !== val) msgErr = "Mot de passe et Confirmation ne correspond pas!";
      document.getElementById('errConf').innerHTML = msgErr;
      if (msgErr !== "") erreurCmpt = true
   }


  // *********************************************************************************************************
  // REQUET AJAX AU CLIC DU BOUTON "CALL TO ACTION" POUR OUVRIR LE FORMULAIRE D'AJOUT D'UNE NOUVELLE BOUTEILLE
  // *********************************************************************************************************

  if(document.getElementById('btnCallActionAjt'))
  {
    let btnCallActionAjt = document.getElementById('btnCallActionAjt');
    btnCallActionAjt.addEventListener("click", function(evt){

      let url = BaseURL+"index.php?requete=ajouterNouvelleBouteilleCellier";
      fetch(url)
      .then(res=>{
        window.location.href = BaseURL+"index.php?requete=ajouterNouvelleBouteilleCellier";
      })
      .catch(error => {
        console.error(error);
      });

    });
  }

});



// ************************************
// FONCTIONS UTILISÉES DANS LE DOCUMENT
// ************************************

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