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

	});

	// pour faire apparaitre le formulaire de creation de compte
	btnSignUp.addEventListener("click", () =>{

		if(formLogin.classList.contains("display--flex")) formLogin.classList.replace("display--flex", "display--none");
		formSignUp.classList.replace("display--none", "display--flex");
		
	});

});