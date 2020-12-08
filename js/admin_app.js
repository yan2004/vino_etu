/**
 * @file Script contenant les fonctions de base
 * @author Marianne Soucy et Yan Jin
 * @version 0.1
 * @update 2020-12-01
 *
 */

//  const BaseURL = "http://localhost:8888/vino/vino_etu/";
// const BaseURL = document.baseURI;
const BaseURL = "http://localhost/projetWeb2/vino_etu/";

window.addEventListener('load', function(){

	// call 2 action importation de bouteilles SAQ
	document.getElementById("btnImportation").addEventListener("click", () =>{

		let requete = new Request(BaseURL+"index.php?requete=importationSAQ", {method: 'POST'});
		fetch(requete)
        .then(response => {
            if (response.status === 200) {
              return response.text();
            } else {
              throw new Error('Erreur');
            }
        })
        .then(response => {

			// affichage du rapport reçue de l'importation des bouteilles dans le DOM
			document.getElementById("rapportImportation").innerHTML = response;
        })
        .catch(error => {
          console.error(error);
        });
	});
});