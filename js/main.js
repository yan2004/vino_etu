/**
 * @file Script contenant les fonctions de base
 * @author Jonathan Martel (jmartel@cmaisonneuve.qc.ca)
 * @version 0.1
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 *
 */

//const BaseURL = "http://localhost:8888/vino/vino_etu/";
const BaseURL = document.baseURI;

console.log(BaseURL);

window.addEventListener('load', function() {

    // console.log("load");

    document.querySelectorAll(".btnBoire").forEach(function(element){

        // console.log(element);

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
            // traitement de la réponse
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

    document.querySelectorAll(".btnAjouter").forEach(function(element){

        // requête ajax au click d'un des boutons "ajouter" de la page
        element.addEventListener("click", function(evt){

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
   
    // concernant le formulaire d'ajout d'une bouteille
    let inputNomBouteille = document.querySelector("[name='nom_bouteille']");

    // console.log(inputNomBouteille);

    let liste = document.querySelector('.listeAutoComplete');

    if(inputNomBouteille){

      inputNomBouteille.addEventListener("keyup", function(evt){

        // console.log(evt);

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

            // console.log(response);
            
            // création d'un "li" pour chaque suggestion dans le DOM
            response.forEach(function(element){
              liste.innerHTML += "<li data-id='"+element.id +"'>"+element.nom+"</li>";
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
        garde_jusqua : document.querySelector("[name='garde_jusqua']"),
        notes : document.querySelector("[name='notes']"),
      };

      liste.addEventListener("click", function(evt){

        console.dir(evt.target)

        if(evt.target.tagName == "LI"){

          // on va chercher l'id de la bouteille suggérée
          bouteille.nom.dataset.id = evt.target.dataset.id;

          // on met le nom de la bouteille suggérée dans le champs "nom"
          bouteille.nom.innerHTML = evt.target.innerHTML;
          
          liste.innerHTML = "";
          inputNomBouteille.value = "";

        }
      });

      // gérer la soumission du formulaire d'ajout
      let btnAjouter = document.querySelector("[name='ajouterBouteilleCellier']");

      if(btnAjouter){

        btnAjouter.addEventListener("click", function(evt){

          // toutes les valeurs de notre formulaire (données prêtes à être envoyées au back end)

          // *******************************************************************************************************
          // ICI L'ID_USER EST HARDCODÉ POUR L'INSTANT, CAR À CE STADE NOUS N'AVONS PAS ENCORE DE GESTION DE USER
          // *******************************************************************************************************

          var param = {
            "id_bouteille":bouteille.nom.dataset.id,
            "date_achat":bouteille.date_achat.value,
            "garde_jusqua":bouteille.garde_jusqua.value,
            "notes":bouteille.notes.value,
            "prix":bouteille.prix.value,
            "quantite":bouteille.quantite.value,
            "millesime":bouteille.millesime.value,
            "id_usager":1,                                // TODO : MODIFIER POUR QUE L'ID_USAGER CHANGE DYNAMIQUEMENT
          };

          // requete ajax pour ajouter une bouteille dans le cellier
          let requete = new Request(BaseURL+"index.php?requete=ajouterNouvelleBouteilleCellier", {method: 'POST', body: JSON.stringify(param)});

            fetch(requete)
            .then(response => {

              // console.log(response);

              if (response.status === 200) {
                return response.json();
              } else {
                throw new Error('Erreur');
              }
            })
            .then(response => {

              // ***************************************************
              // ajouter un traitement au succès de la requête
              // ***************************************************

              console.log(response);
            
            })
            .catch(error => {
              console.error(error);
            });
        });
      } 
  }
});