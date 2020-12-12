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
  // at current page, it does'nt exite this element;
  if(document.getElementById("btnImportation"))
  {
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
  }
  

  /**
   * JS pour la page de gérer USAGER
   */
  if(document.querySelectorAll('.btnAdminSupr'))
  {

    /**
     * showModal() n'est pas supporté par safari et firefox
     */
        // document.querySelectorAll(".btnAdminSupr").forEach(function(element){
        //     element.addEventListener('click', usagerModal);
        // });

        // function usagerModal(evt){
        //     let idUsager  = evt.target.dataset.id;
        //     let courreil = evt.target.dataset.courreil;
        //     let eDialog  = document.getElementById('modaleUsager');
        //     let html     = `
        //     <div class="actions">
        //         <button onclick="document.getElementById('modaleUsager').close()" id="modale-focus">x</button>
        //     </div>
        //     <h6>Êtes-vous sûr de vouloir supprimer ${courreil} ?</h6>
        //     <button value="sauvegarderSupprimer" class="sauvegarderSupprimer" data-id="${idUsager}">Supprimer</button>
        //         `;
        //       eDialog.innerHTML = html;
        //       eDialog.showModal();
        //      document.getElementById('modale-focus').focus();

        //      if(uModaleWindow.length > 0){
        //         // keydown, fermer la fenêtre de modale
        //         window.addEventListener('keydown',function(evt){
        //             if(evt.keyCode == 27){
        //                 eDialog.close();
        //             };
        //         });

        //          let sauvegarderSupprimer = document.getElementsByClassName('sauvegarderSupprimer')[0];
        //          sauvegarderSupprimer.addEventListener('click', supprimerUsager);
        //      };

        // }
        //     let uModaleWindow = document.getElementsByClassName('actions');

        
        // function supprimerUsager(evt){
        //      let idUsagerSupr = evt.target.dataset.id;
        //      // DOM de rangé à être supprimé
        //      let usagerSupr   = document.querySelector(`tr[data-id='${idUsagerSupr}']`);
        //      let data         = {'idUsagerSupr':  idUsagerSupr};
        //      let requete      = new Request(BaseURL+"index.php?requete=sauvegarderSupprimer", {method: 'POST', body: JSON.stringify(data)});

        //      fetch(requete)
        //      .then(response => {
        //          if (response.status === 200) {
        //            return response.json();
        //          } else {
        //            throw new Error('Erreur');
        //          }
        //      })
        //      .then(response => {
        //        if(response.success){
        //          // supprimer l'usager du DOM
        //          usagerSupr.remove();
        //        }else{
        //          throw response.msg;
        //        }
        //      })
        //      .catch(error => {
        //        console.error(error);
        //      });

        //      // la fenêtre de modale est fermée
        //      let eDialog  = document.getElementById('modaleUsager');
        //      eDialog.close();
        // }

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
