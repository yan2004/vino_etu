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

window.addEventListener('DOMContentLoaded', function(){

  
  // if(document.getElementById("btnImportation")){
  if(typeof formImport !== 'undefined'){

    let f = formImport;

    // call 2 action importation de bouteilles SAQ
    document.getElementById("btnImportation").addEventListener("click", () =>{

      // création de l'objet avec data des inputs pour requête importation
      let dataImport = {
        "nbrPages": f.nbrPages.value,
        "nbrItems": f.nbrItems.value
      }
  
      // console.log(dataImport);
  
      let requete = new Request(BaseURL+"index.php?requete=importationSAQ", {method: 'POST', body: JSON.stringify(dataImport)});
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
  }
  

  /**
   * JS pour la page de gérer USAGER
   */
  if(document.querySelectorAll('.btnAdminSupr'))
  {

         document.querySelectorAll(".btnAdminSupr").forEach(function(element){
              element.addEventListener('click', usagerModal);
         });

         function usagerModal(evt){
          let idUsagerSupr       = evt.target.dataset.id;
          let courreilUsagerSupr = evt.target.dataset.courreil;
          let dialogContainer    = document.getElementsByClassName('modal-container-usager')[0];
          let dialogUsagerSupr   = document.getElementById('supprimerUs');
          let html = `
          <h5>Êtes-vous sûr de vouloir supprimer ${courreilUsagerSupr} ?</h5>
          <button value="annulerSupprimer" class="annulerSupprimer" data-id="${idUsagerSupr}">ANNULER</button>
          <button value="sauvegarderSupprimer" class="sauvegarderSupprimer" data-id="${idUsagerSupr}">SUPPRIMER</button>
              `;
          dialogUsagerSupr.innerHTML = html;
          dialogContainer.setAttribute("class", "modal-container-usager-display");

          let modal             = document.querySelector('.modal-container-usager-display');
          let btnModalAnnuler   = modal.querySelector('.annulerSupprimer');
          let btnModalSupprimer = modal.querySelector('.sauvegarderSupprimer');
    
          // quand un modal, autre bouton non-cliquable
          if(document.getElementById('supprimerUs').textContent.length > 0){
              document.querySelectorAll(".btnAdminSupr").forEach(function(element){
                element.setAttribute("disabled", true);
              });
          }
          
          // confirmer de supprimer l'usager
          btnModalSupprimer.addEventListener('click', confirmerSupprimer);

          function confirmerSupprimer(evt){
              let idUsagerSupr = evt.target.dataset.id;
              let usagerSupprimer = document.querySelector(`tr[data-id='${idUsagerSupr}']`);
              let data         = {'idUsagerSupr':  idUsagerSupr};

              let requete      = new Request(BaseURL+"index.php?requete=sauvegarderSupprimer", {method: 'POST', body: JSON.stringify(data)});

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
                  // supprimer l'usager du DOM
                  usagerSupprimer.remove();
                }else{
                  throw response.msg;
                }
              })
              .catch(error => {
                console.error(error);
              });

              let modal = evt.target.parentElement.parentElement;
              modal.setAttribute("class", "modal-container-usager");

              document.querySelectorAll(".btnAdminSupr").forEach(function(element){
                element.removeAttribute("disabled");
              });
          }

         // annuler de supprimer l'usager
         btnModalAnnuler.addEventListener('click', annulerSupprimer)

         function annulerSupprimer(evt){
            evt.preventDefault();
            let modal = evt.target.parentElement.parentElement;
            modal.setAttribute("class", "modal-container-usager");

            document.querySelectorAll(".btnAdminSupr").forEach(function(element){
              element.removeAttribute("disabled");
            });
         }

        }
        
  }
    

});
