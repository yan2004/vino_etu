/**
 * @file Script contenant les fonctions de base
 * @author Marianne Soucy et Yan Jin
 * @version 0.1
 * @update 2020-11-17
 *
 */

  //  const BaseURL = "http://localhost:8888/vino/vino_etu/";
// const BaseURL = document.baseURI;
const BaseURL = "http://localhost/projetWeb2/vino_etu/";

// initialisation de la variable errForm pour la validation des différents formulaires
let errForm = false;

// déclaration de l'objet pour les controles du formulaire de login
const controlesLogin = {
  courriel:   {requis: true, regExp: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/i,                       msgRegExp: "Courriel invalide."},
  password:   {requis: true, regExp: /^(?=.*[0-9])(?=.*[a-z])([a-z0-9!@#$%^&*;.,\-_'"]{4,})$/i, msgRegExp: "Au moins 4 caractères avec 1 chiffre et 1 lettre."}
};

const ID_FORM_SIGNUP = "SignUp";
const ID_FORM_SIGNIN = "SignIn";

// déclaration de l'objet pour les controles du formulaire de création de compte
const controlesCreation = {
  courriel:   {requis: true, regExp: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/i,                       msgRegExp: "Courriel invalide."},
  nom:        {requis: true, regExp: /^[\u4e00-\u9fa5a-zà-ÿ\d ',\-"\.]{1,50}$/i,                msgRegExp: "1 à 50 caractères."},
  prenom:     {requis: true, regExp: /^[\u4e00-\u9fa5a-zà-ÿ\d ',\-"\.]{1,50}$/i,                msgRegExp: "1 à 50 caractères."},
  password:   {requis: true, regExp: /^(?=.*[0-9])(?=.*[a-z])([a-z0-9!@#$%^&*;.,\-_'"]{4,})$/i, msgRegExp: "Au moins 4 caractères avec 1 chiffre et 1 lettre."}
};

window.addEventListener('load', function(){

    let btnSignIn = document.getElementById("sign-in");
    let btnSignUp = document.getElementById("sign-up");

    let fS = formSignUp;
    let fL = formLogin;

    let btnEntrer = fL.entrer;
    let btnSoumettre = fS.soumettre;

    // pour faire apparaitre le formulaire de login
    btnSignIn.addEventListener("click", () =>{
      if(fS.classList.contains("display--flex")) fS.classList.replace("display--flex", "display--none");
      fL.classList.replace("display--none", "display--flex");
    });

    // pour faire apparaitre le formulaire de creation de compte
    btnSignUp.addEventListener("click", () =>{
      if(fL.classList.contains("display--flex")) fL.classList.replace("display--flex", "display--none");
      fS.classList.replace("display--none", "display--flex");
    });
    

    // ***************************************************
    // VALIDATION POUR LE FORMULAIRE DE CREATION DE COMPTE
    // ***************************************************

    // validations des inputs au change
    fS.addEventListener('change', (evt)=>{
      let nomChamp = evt.target.name;
      let controles = controlesCreation[nomChamp];
      validerChamps(fS, ID_FORM_SIGNUP, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
    });

    // évènement au clic du bouton "soumettre" lors de la création de compte
    btnSoumettre.addEventListener("click", (evt) =>{

      // pour ne pas que le formulaire se soumette
      evt.preventDefault();

      // appel de la fonction pour le traitement de la création de compte
      processSignUp();
    });

    // évènement pour la touche "enter" lors de la création de compte
    fS.addEventListener("keyup", (evt) => {

      // pour ne pas que le formulaire se soumette
      evt.preventDefault();

      let key = evt.key || evt.keyCode;
      
      if(key === 'Enter' || key === 13){
        // appel de la fonction pour le traitement de la création de compte
        processSignUp();
      }
    });

    // **************************************
    // VALIDATION POUR LE FORMULAIRE DE LOGIN
    // **************************************
    
    // validations d'un input au "change"
    fL.addEventListener('change', (evt)=>{
      let nomChamp = evt.target.name;
      let controles = controlesLogin[nomChamp];
      validerChamps(fL, ID_FORM_SIGNIN, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
    });

    // évènement au clic du bouton "entrer" lors de l'authentification
    btnEntrer.addEventListener("click", (evt) => {

      // pour ne pas que le formulaire se soumette
      evt.preventDefault();

      // appel de la fonction pour le traitement du login
      processLogin();
    });

    // évènement pour la touche "enter" lors de l'authentification
    fL.addEventListener("keyup", (evt) => {

      // pour ne pas que le formulaire se soumette
      evt.preventDefault();

      let key = evt.key || evt.keyCode;

      if(key === 'Enter' || key === 13){
        // appel de la fonction pour le traitement du login
        processLogin();
      }
    });
});



/**
 * Fonction qui traite les champs du formulaire de création de compte, et la requête ajax
 */
function processSignUp(){

  errForm = false;
  let fS = formSignUp;

  // on valide tous les champs
  for(let nomChamp in controlesCreation){
    let controles = controlesCreation[nomChamp];
    validerChamps(fS, ID_FORM_SIGNUP, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
  }

  if (!errForm){

    // objet avec paramètres du nouveau compte
    let param = {
      "courriel":fS.courriel.value,
      "nom":fS.nom.value,
      "prenom":fS.prenom.value,
      "password":fS.password.value,
    };

    let requete = new Request(BaseURL+"index.php?requete=creerCompte", {method: 'POST', body: JSON.stringify(param)});

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
        let eErrCreation = document.getElementById("errSignUpPassword");
        eErrCreation.innerText = response.msg;
      }
    })
    .catch(error => {
      console.error(error);
    });
  }
}

/**
 * Fonction qui traite les champs du formulaire de login, et la requête ajax
 */
function processLogin(){

  errForm = false;
  let fL = formLogin;

  // on valide tous les champs
  for(let nomChamp in controlesLogin){
    let controles = controlesLogin[nomChamp];
    validerChamps(fL, ID_FORM_SIGNIN, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
  }

  if (!errForm){

    // objet avec paramètres d'authentification
    let param = {
      "courriel":fL.courriel.value,
      "password":fL.password.value,
    };

    let requete = new Request(BaseURL+"index.php?requete=authentification", {method: 'POST', body: JSON.stringify(param)});

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
        let eErrAuth = document.getElementById("errSignInPassword");
        eErrAuth.innerText = response.msg;
      }
    })
    .catch(error => {
      console.error(error);
    });
  }
}


/**
 * Fonction de validation d'un champ et gestion du message d'erreur
 * @param {*} idForm 
 * @param {*} nomChamp 
 * @param {*} requis 
 * @param {*} regExp 
 * @param {*} msgRegExp 
 */
function validerChamps(form, idForm, nomChamp, requis=false, regExp=null, msgRegExp=null){

  let val = "";
  let e = form[nomChamp];
  idForm = "err" + idForm;

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

  let idSpan = idForm + nomChamp[0].toUpperCase() + nomChamp.substring(1);
  document.getElementById(idSpan).innerHTML = msgErr;

  if (msgErr !== "") errForm = true;
}
