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

window.addEventListener('load', function(){

  // console.log(BaseURL);

	let btnSignIn = document.getElementById("sign-in");
  let btnSignUp = document.getElementById("sign-up");

  let fS = formSignUp;
  let fL = formLogin;

  let btnEntrer = fL.entrer;
  let btnSoumettre = fS.soumettre;

  let errForm = false;

  const ID_FORM_SIGNUP = "SignUp";
  const ID_FORM_SIGNIN = "SignIn";

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

  // ^[\u4e00-\u9fa5_a-zA-Z0-9]+$ (chinese characters and numbers)
  // ^[\u4e00-\u9fa5a-zà-ÿ ',\-"]{1,}$ (pour permettre les chinese characters)
  let controlesCreation = {
    courriel:   {requis: true, regExp: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/i,                       msgRegExp: "Courriel invalide."},
    nom:        {requis: true, regExp: /^[\u4e00-\u9fa5a-zà-ÿ ',\-"]{1,}$/i,                      msgRegExp: "Au moins 1 caractère alphabétique."},
    prenom:     {requis: true, regExp: /^[\u4e00-\u9fa5a-zà-ÿ ',\-"]{1,}$/i,                      msgRegExp: "Au moins 1 caractère alphabétique."},
    password:   {requis: true, regExp: /^(?=.*[0-9])(?=.*[a-z])([a-z0-9!@#$%^&*;.,\-_'"]{4,})$/i, msgRegExp: "Au moins 4 caractères avec 1 chiffre et 1 lettre."}
  };

  // validations inputs au change
  fS.addEventListener('change', (evt)=>{
    let nomChamp = evt.target.name;
    let controles = controlesCreation[nomChamp];
    validerChamps(fS, ID_FORM_SIGNUP, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
  });

  // requête ajax au click du bouton "soumettre" lors de la creation de compte
  btnSoumettre.addEventListener("click", (evt) =>{

    evt.preventDefault();

    errForm = false;
    for(let nomChamp in controlesCreation){
      let controles = controlesCreation[nomChamp];
      validerChamps(fS, ID_FORM_SIGNUP, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
    }
    if (!errForm){

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
        // TODO : traitement de l'erreur
        console.error(error);
      });
    }
  });

  // **************************************
  // VALIDATION POUR LE FORMULAIRE DE LOGIN
  // **************************************
  let controlesLogin = {
    courriel:   {requis: true, regExp: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/i,                       msgRegExp: "Courriel invalide."},
    password:   {requis: true, regExp: /^(?=.*[0-9])(?=.*[a-z])([a-z0-9!@#$%^&*;.,\-_'"]{4,})$/i, msgRegExp: "Au moins 4 caractères avec 1 chiffre et 1 lettre."}
  };

  // validations inputs au change
  fL.addEventListener('change', (evt)=>{
    let nomChamp = evt.target.name;
    let controles = controlesLogin[nomChamp];
    validerChamps(fL, ID_FORM_SIGNIN, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
  });

  // requête ajax au click du bouton "entrer" lors de l'authentification
  btnEntrer.addEventListener("click", (evt) => {

    evt.preventDefault();

    errForm = false;
    for(let nomChamp in controlesLogin){
      let controles = controlesLogin[nomChamp];
      validerChamps(fL, ID_FORM_SIGNIN, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
    }
    if (!errForm){

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
        // TODO : traitement de l'erreur
        console.error(error);
      });
    }
  });


  /**
   * Fonction de validation des champs et gestion du message d'erreur
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

});