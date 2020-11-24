/**
 * @file Script contenant les fonctions de base
 * @author Marianne Soucy et Yan Jin
 * @version 0.1
 * @update 2020-11-17
 *
 */

//const BaseURL = "http://localhost:8888/vino/vino_etu/";
const BaseURL = document.baseURI;

window.addEventListener('load', function(){

	let btnSignIn = document.getElementById("sign-in");
  let btnSignUp = document.getElementById("sign-up");
  
  let fS = formSignUp;
  let fL = formLogin;

  let errSignIn = false;
  let errSignUp = false;

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
  let controlesCreation = {
    courriel:   {requis: true, regExp: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/i, msgRegExp: "Courriel invalide."},
    nom:        {requis: true, regExp: /^[a-zà-ÿ]{2,}$/i,                   msgRegExp: "Au moins 2 caractères alphabétiques."},
    prenom:     {requis: true, regExp: /^[a-zà-ÿ]{2,}$/i,                   msgRegExp: "Au moins 2 caractères alphabétiques."},
    password:   {requis: true, regExp: /^[0-9a-z]{4,}$/i,                   msgRegExp: "Au moins 4 caractères alphanumériques."}
  };

  // validations inputs au change
  fS.addEventListener('change', (evt)=>{
    let nomChamp = evt.target.name;
    let controles = controlesCreation[nomChamp];
    validerChamps(fS, ID_FORM_SIGNUP, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
  });
  
  // validations au submit
  fS.addEventListener("submit", function(evt){
    errSignUp = false;
    for(let nomChamp in controlesCreation){
      let controles = controlesCreation[nomChamp];
      validerChamps(fS, ID_FORM_SIGNUP, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
    }
    if (errSignUp) evt.preventDefault();
  });

  // **************************************
  // VALIDATION POUR LE FORMULAIRE DE LOGIN
  // **************************************
  let controlesLogin = {
    courriel:   {requis: true, regExp: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/i, msgRegExp: "Courriel invalide."},
    password:   {requis: true, regExp: /^[0-9a-z]{4,}$/i,                   msgRegExp: "Au moins 4 caractères alphanumériques."}
  };

  // validations inputs au change
  fL.addEventListener('change', (evt)=>{
    let nomChamp = evt.target.name;
    let controles = controlesLogin[nomChamp];
    validerChamps(fL, ID_FORM_SIGNIN, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
  });
  
  // validations au submit
  fL.addEventListener("submit", function(evt){
    errSignIn = false;
    for(let nomChamp in controlesLogin){
      let controles = controlesLogin[nomChamp];
      validerChamps(fL, ID_FORM_SIGNIN, nomChamp, controles.requis, controles.regExp, controles.msgRegExp);
    }
    if (errSignIn) evt.preventDefault();
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
    if (msgErr !== "") idForm = true;
  }

});