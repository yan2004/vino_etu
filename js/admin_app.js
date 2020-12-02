/**
 * @file Script contenant les fonctions de base
 * @author Marianne Soucy et Yan Jin
 * @version 0.1
 * @update 2020-12-01
 *
 */

const BaseURL = "http://localhost:8888/vino/vino_etu/";
// const BaseURL = document.baseURI;
//const BaseURL = "http://localhost/projetWeb2/vino_etu/";

window.addEventListener('load', function(){

	//deconnexion
	if(document.querySelectorAll('.links li')[0]){
		let btnDeconnexion = document.querySelectorAll('.links li')[0];
		btnDeconnexion.addEventListener("click", (evt)=>{
		  localStorage.removeItem('param');
		})
	  };

	//call 2 action importation 
	document.getElementById("btnImportation").addEventListener("click", (evt) =>{
		let requete = new Request(BaseURL+"index.php?requete=importationSAQ", {method: 'POST'});
		fetch(requete)
        .then(response => {
            if (response.status === 200) {
			  console.log(response);
              return response.text();//.json();
            } else {
              throw new Error('Erreur');
            }
        })
        .then(response => {
			console.log(response);
			document.getElementById("rapportImportation").innerHTML = response;
        })
        .catch(error => {
          console.error(error);
        });
	});
});