/**
 * @file Script contenant les fonctions de base
 * @author Marianne Soucy et Yan Jin
 * @version 0.1
 * @update 2020-11-17
 *
 */

//const BaseURL = "http://localhost:8888/vino/vino_etu/";
const BaseURL = document.baseURI;

// console.log(BaseURL);

window.addEventListener('load', function(){

	let btnSignIn = document.getElementById("sign-in");
	let btnSignUp = document.getElementById("sign-up");

	// let btnSoumettre = formLogin.soumettre;
	// let btnConfirmer = formSignUp.confirmer;
	

	// pour faire apparaitre le formulaire de login
	btnSignIn.addEventListener("click", () =>{

		if(formSignUp.classList.contains("display--flex")) formSignUp.classList.replace("display--flex", "display--none");
    formLogin.classList.replace("display--none", "display--flex");
    document.getElementById("errConfirmer").innerText = "";

	});

	// pour faire apparaitre le formulaire de creation de compte
	btnSignUp.addEventListener("click", () =>{

		if(formLogin.classList.contains("display--flex")) formLogin.classList.replace("display--flex", "display--none");
		formSignUp.classList.replace("display--none", "display--flex");
		
	});



	/**
   * *********************
   * validation de formulaire de création du compte 
   * *********************
   */
  let fS = formSignUp;
  let errCreation = false;

  fS.addEventListener('change', (evt)=>{
    let nomChamp = evt.target.name;
    eval(nomChamp + 'Valider()');
  })
  

  fS.addEventListener("submit", function(evt){
	 errCreation = false;
	 pseudoValider();
	 nomValider();
     prenomValider();
     passwordValider();

     if (errCreation) evt.preventDefault();

   })

   function  pseudoValider() {
		let msgErr = "";
		let val = fS.pseudo.value.trim();
		let reg = new RegExp("^((?:\\w|[\\-_ ](?![\\-_ ])|[\\u00C0\\u00C1\\u00C2\\u00C3\\u00C4\\u00C5\\u00C6\\u00C7\\u00C8\\u00C9\\u00CA\\u00CB\\u00CC\\u00CD\\u00CE\\u00CF\\u00D0\\u00D1\\u00D2\\u00D3\\u00D4\\u00D5\\u00D6\\u00D8\\u00D9\\u00DA\\u00DB\\u00DC\\u00DD\\u00DF\\u00E0\\u00E1\\u00E2\\u00E3\\u00E4\\u00E5\\u00E6\\u00E7\\u00E8\\u00E9\\u00EA\\u00EB\\u00EC\\u00ED\\u00EE\\u00EF\\u00F0\\u00F1\\u00F2\\u00F3\\u00F4\\u00F5\\u00F6\\u00F9\\u00FA\\u00FB\\u00FC\\u00FD\\u00FF\\u0153])+)$", "i");
		
		//Vérifiér si au moins deux caractères
		let l = val.length;
		if(l < 5) msgErr = "Au moins cinq caractères alphabétiques";

		//Vérifiér si les caractères de séparation sont suivantes
		if(l > 1){
		if(!reg.test(val)) msgErr = "Chaque mots doivent être séparés par '-' ou '_' ou un espace.";
		}
		
		document.getElementById('errPseudo').innerHTML = msgErr;

		if (msgErr !== "") errCreation = true;
   }

   function nomValider() {
     let msgErr = "";
     let val = fS.nom.value.trim();
     let reg = new RegExp("^((?:\\w|[\\-_ ](?![\\-_ ])|[\\u00C0\\u00C1\\u00C2\\u00C3\\u00C4\\u00C5\\u00C6\\u00C7\\u00C8\\u00C9\\u00CA\\u00CB\\u00CC\\u00CD\\u00CE\\u00CF\\u00D0\\u00D1\\u00D2\\u00D3\\u00D4\\u00D5\\u00D6\\u00D8\\u00D9\\u00DA\\u00DB\\u00DC\\u00DD\\u00DF\\u00E0\\u00E1\\u00E2\\u00E3\\u00E4\\u00E5\\u00E6\\u00E7\\u00E8\\u00E9\\u00EA\\u00EB\\u00EC\\u00ED\\u00EE\\u00EF\\u00F0\\u00F1\\u00F2\\u00F3\\u00F4\\u00F5\\u00F6\\u00F9\\u00FA\\u00FB\\u00FC\\u00FD\\u00FF\\u0153])+)$", "i");
     
     //Vérifiér si au moins deux caractères
     let l = val.length;
     if(l < 2) msgErr = "Au moins deux caractères alphabétiques.";

      //Vérifiér si les caractères de séparation sont suivantes
      if(l > 1){
        if(!reg.test(val)) msgErr = "Chaque mots doivent être séparés par '-' ou '_' ou un espace.";
      }
     
     document.getElementById('errSignUpNom').innerHTML = msgErr;

     if (msgErr !== "") errCreation = true;
   }

   function prenomValider() {
      let msgErr = "";
      let val = fS.prenom.value.trim();
      let reg = new RegExp("^((?:\\w|[\\-_ ](?![\\-_ ])|[\\u00C0\\u00C1\\u00C2\\u00C3\\u00C4\\u00C5\\u00C6\\u00C7\\u00C8\\u00C9\\u00CA\\u00CB\\u00CC\\u00CD\\u00CE\\u00CF\\u00D0\\u00D1\\u00D2\\u00D3\\u00D4\\u00D5\\u00D6\\u00D8\\u00D9\\u00DA\\u00DB\\u00DC\\u00DD\\u00DF\\u00E0\\u00E1\\u00E2\\u00E3\\u00E4\\u00E5\\u00E6\\u00E7\\u00E8\\u00E9\\u00EA\\u00EB\\u00EC\\u00ED\\u00EE\\u00EF\\u00F0\\u00F1\\u00F2\\u00F3\\u00F4\\u00F5\\u00F6\\u00F9\\u00FA\\u00FB\\u00FC\\u00FD\\u00FF\\u0153])+)$", "i");
      
      //Vérifiér si au moins deux caractères
      let l = val.length;
      if(l < 2) msgErr = "Au moins deux caractères alphabétiques.";

      //Vérifiér si les caractères de séparation sont suivantes
      if(l > 1){
        if(!reg.test(val)) msgErr = "Chaque mots doivent être séparés par '-' ou '_' ou un espace.";
      }
      
      document.getElementById('errSignUpPrenom').innerHTML = msgErr;

      if (msgErr !== "") errCreation = true;
   }

   function passwordValider() {
      let msgErr = "";
      let val = fS.password.value.trim();
      let reg = new RegExp("^((?:\\w|[\\-_ ](?![\\-_ ])|[\\u00C0\\u00C1\\u00C2\\u00C3\\u00C4\\u00C5\\u00C6\\u00C7\\u00C8\\u00C9\\u00CA\\u00CB\\u00CC\\u00CD\\u00CE\\u00CF\\u00D0\\u00D1\\u00D2\\u00D3\\u00D4\\u00D5\\u00D6\\u00D8\\u00D9\\u00DA\\u00DB\\u00DC\\u00DD\\u00DF\\u00E0\\u00E1\\u00E2\\u00E3\\u00E4\\u00E5\\u00E6\\u00E7\\u00E8\\u00E9\\u00EA\\u00EB\\u00EC\\u00ED\\u00EE\\u00EF\\u00F0\\u00F1\\u00F2\\u00F3\\u00F4\\u00F5\\u00F6\\u00F9\\u00FA\\u00FB\\u00FC\\u00FD\\u00FF\\u0153])+)$", "i");
      
      //Vérifiér si au moins deux caractères
      let l = val.length;
      if(l < 2) msgErr = "Au moins deux caractères alphabétiques.";

      //Vérifiér si les caractères de séparation sont suivantes
      if(l > 1){
        if(!reg.test(val)) msgErr = "Chaque mots doivent être séparés par '-' ou '_' ou un espace.";
      }
      
      document.getElementById('errSignUpPwd').innerHTML = msgErr;

      if (msgErr !== "") errCreation = true
   }

});