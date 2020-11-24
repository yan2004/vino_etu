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


    document.querySelectorAll(".btnBoire").forEach(function(element){


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


    // requête ajax au click d'un des boutons "modifier" de la page
    document.querySelectorAll(".btnModifier").forEach(function(element){

      element.addEventListener("click", function(evt){

        let id = evt.target.parentElement.dataset.id;
        
        // call ajax
        let xhr = new XMLHttpRequest();
        let method = "GET";
        let url = BaseURL+"index.php?requete=modifierBouteilleCellier&id="+id;
        //let url = BaseURL+"index.php?requete=formModificationBtl";
        let asynchronous = true;
        // receiving response from url
        xhr.onreadystatechange = function(){
          if(this.readyState == 4 && this.status == 200){
           
            //converting JSON back to array
            //let dataBtls = JSON.parse(this.responseText);
            let dataBtls = this.responseText;
            //console.log(dataBtls);

            window.location.href = BaseURL+"index.php?requete=formModificationBtl&dataBtls="+dataBtls+"&id="+id;
            
           }
        }
        xhr.open(method, url, asynchronous);
        // Sending ajax request
        xhr.send();
      });
    });

  //if(typeof fMdBtl !== 'undefined'){
    let fMdBtl = fModificationBtl;
    let erreurBtl = false;
    fMdBtl.addEventListener('change', (evt)=>{
      let nomChamp = evt.target.name;
      eval(nomChamp + 'ValiderBtl()');
    })

    let btnModifierBtl = document.getElementsByClassName('btnModifierBtl')[0];
    fMdBtl.addEventListener("submit", function(evt){
        
        erreurBtl = false;
        
        nomValiderBtl();
        millesimeValiderBtl();
        quantiteValiderBtl();
        date_achatValiderBtl();
        prixValiderBtl();
        gardeValiderBtl();
        notesValiderBtl();

        /*** *********************
        * requête ajax par méthode POST 
        */
        const dataBtlEnvoyer = {
            'btlIdPK':    fMdBtl.btlIdPK.value,
            'nomIdFK':    fMdBtl.nomIdFK.value,
            'nomBtl':     fMdBtl.nom.value,
            'millesime':  fMdBtl.millesime.value,
            'quantite':   fMdBtl.quantite.value,
            'date_achat': fMdBtl.date_achat.value,
            'prix':       fMdBtl.prix.value,
            'garde':      fMdBtl.garde.value,
            'notes':      fMdBtl.notes.value
        }

        const jsonStingBtl = JSON.stringify(dataBtlEnvoyer);
        //console.log(jsonStingBtl);
        let ajax = new XMLHttpRequest();

        ajax.open('POST', BaseURL+"index.php?requete=sauvegardeBouteille");
        ajax.setRequestHeader('Content-Type', 'application/json');
        ajax.send(jsonStingBtl);

        //window.location.href = BaseURL+"index.php?requete=accueilUsager";
        if (erreurBtl) evt.preventDefault();
        //evt.preventDefault();
    });
    

    function nomValiderBtl(){
        let msgErr = "";
        let val = fMdBtl.nom.value.trim();
        let reg = new RegExp("^((?:\\w|[\\-_ ](?![\\-_ ])|[\\u00C0\\u00C1\\u00C2\\u00C3\\u00C4\\u00C5\\u00C6\\u00C7\\u00C8\\u00C9\\u00CA\\u00CB\\u00CC\\u00CD\\u00CE\\u00CF\\u00D0\\u00D1\\u00D2\\u00D3\\u00D4\\u00D5\\u00D6\\u00D8\\u00D9\\u00DA\\u00DB\\u00DC\\u00DD\\u00DF\\u00E0\\u00E1\\u00E2\\u00E3\\u00E4\\u00E5\\u00E6\\u00E7\\u00E8\\u00E9\\u00EA\\u00EB\\u00EC\\u00ED\\u00EE\\u00EF\\u00F0\\u00F1\\u00F2\\u00F3\\u00F4\\u00F5\\u00F6\\u00F9\\u00FA\\u00FB\\u00FC\\u00FD\\u00FF\\u0153])+)$", "i");
            
        //Vérifier si au moins trois caractères
        let l = val.length;
        if(l < 3) msgErr = "Au moins 3 caractères!";
            
        document.getElementById('errNom').innerHTML = msgErr;
      
        if (msgErr !== "") erreurBtl = true;
   }

    function millesimeValiderBtl(){
      let msgErr = "";
      let val = fMdBtl.millesime.value.trim();
      let reg = new RegExp("[1-2][0-9]{3}$");
            
      //Vérifier si 4 numéros
      let l = val.length;
      if(l>0){
        if(l !== 4) msgErr = "4 chiffres commencent par 1YYY ou 2YYY!";
        else {
          if(!reg.test(val)) msgErr = "4 chiffres commencent par 1YYY ou 2YYY!"
        }
      }
            
      document.getElementById('errMillesime').innerHTML = msgErr;
      
      if (msgErr !== "") erreurBtl = true;
    }

      function quantiteValiderBtl(){
        let msgErr = "";
        let val = fMdBtl.quantite.value.trim();
        let reg = new RegExp("[1-9][0-9]*");
            
        //Vérifier si int
        let l = val.length;
        if(l <1) msgErr = "Champ obligatoire!";

        if(l >= 1) {
          if(!reg.test(val)) msgErr = "Veuillez vérifier si numéro entier!";
        }
            
        document.getElementById('errQuantite').innerHTML = msgErr;
      
        if (msgErr !== "") erreurBtl = true;
      }

      function date_achatValiderBtl(){
        let msgErr = "";
        let val = fMdBtl.date_achat.value.split('-');
        
        let y = val[0];
        if(y > new Date().getFullYear()) msgErr = "Format yyyy-mm-dd!";
        
        document.getElementById('errDateAchat').innerHTML = msgErr;
      
        if (msgErr !== "") erreurBtl = true;
      }

      function prixValiderBtl(){
        let msgErr = "";
        let val = fMdBtl.prix.value.trim();
        let reg = new RegExp("^([0-9]{0,2}((.)[0-9]{0,2}))$");
            
        let l = val.length;
        if(l < 1) msgErr = "Champ obligatoire!";

        if(l > 1) {
          if(!reg.test(val)) msgErr = "Maximum de 8 chiffres avant la virgule décimale (.) ；</br> Maximum de 4 chiffres après la virgule décimale!";
        }
            
        document.getElementById('errPrix').innerHTML = msgErr;
      
        if (msgErr !== "") erreurBtl = true;
      }

      function gardeValiderBtl(){
        let msgErr = "";
        let valGarde = fMdBtl.garde.value.split('-');
        let valAchat = fMdBtl.date_achat.value.split('-');
            
        let ymdGarde = valGarde[0]+valGarde[1]+valGarde[2];
        let ymdAchat = valAchat[0]+valAchat[1]+valAchat[2];
          
        if (parseInt(ymdGarde) < parseInt(ymdAchat)) msgErr = "Veuille vérifier si choisir la date correctement!";
            
        document.getElementById('errGarde').innerHTML = msgErr;
      
        if (msgErr !== "") erreurBtl = true;
      }

      function notesValiderBtl(){
        let msgErr = "";
        let val = fMdBtl.notes.value.trim();
        let reg = new RegExp("\w*[a-zA-Z]\w*");
            
        //Champ non-obligatoire
        let l = val.length;
        if(l > 0) {
          if(!reg.test(val)) msgErr = "un mot au moins avec une lettre ou / et un nombre quelconque!";
        }else {
          msgErr = "";
        }
            
        document.getElementById('errNotes').innerHTML = msgErr;
      
        if (msgErr !== "") erreurBtl = true;
      }
  //}

   
    // concernant le formulaire d'ajout d'une bouteille
    let inputNomBouteille = document.querySelector("[name='nom_bouteille']");

    let liste = document.querySelector('.listeAutoComplete');

    if(inputNomBouteille){

      inputNomBouteille.addEventListener("keyup", function(evt){

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
        pseudo : document.querySelector("[name='pseudo_usager']"), // pseudo de l'usager en session
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

          var param = {
            "id_bouteille":bouteille.nom.dataset.id,
            "date_achat":bouteille.date_achat.value,
            "garde_jusqua":bouteille.garde_jusqua.value,
            "notes":bouteille.notes.value,
            "prix":bouteille.prix.value,
            "quantite":bouteille.quantite.value,
            "millesime":bouteille.millesime.value,
            "pseudo":bouteille.pseudo.value,
          };

          // requete ajax pour ajouter une bouteille dans le cellier
          let requete = new Request(BaseURL+"index.php?requete=ajouterNouvelleBouteilleCellier", {method: 'POST', body: JSON.stringify(param)});

            fetch(requete)
            .then(response => {

              if (response.status === 200) {
                return response;
              } else {
                throw new Error('Erreur');
              }
            })
            .then(response => {

              // redirection vers l'accueilUsager pour affichage des bouteilles dans son cellier
              window.location = BaseURL+"index.php?requete=accueilUsager";
            
            })
            .catch(error => {
              console.error(error);
            });
        });
      } 
  }


  /**
   * *********************
   * validation de formulaire de modification du compte 
   * *********************
   */
  if(typeof fCompte !== 'undefined'){

    
    let f = fCompte;
    let erreurCmpt = false;

    f.addEventListener('change', (evt)=>{
      let nomChamp = evt.target.name;
      eval(nomChamp + 'Valider()');
    })
    
    let btnModCmpt = document.getElementsByClassName('btnModifierCompte')[0];

    f.addEventListener("submit", function(evt){
      console.log("sybmit");
      erreurCmpt = false;
      nomValider();
      prenomValider();
      mot_de_passeValider();

      if (erreurCmpt) evt.preventDefault();

    })
  }
   function nomValider() {
     let msgErr = "";
     let val = f.nom.value.trim();
     let reg = new RegExp("^((?:\\w|[\\-_ ](?![\\-_ ])|[\\u00C0\\u00C1\\u00C2\\u00C3\\u00C4\\u00C5\\u00C6\\u00C7\\u00C8\\u00C9\\u00CA\\u00CB\\u00CC\\u00CD\\u00CE\\u00CF\\u00D0\\u00D1\\u00D2\\u00D3\\u00D4\\u00D5\\u00D6\\u00D8\\u00D9\\u00DA\\u00DB\\u00DC\\u00DD\\u00DF\\u00E0\\u00E1\\u00E2\\u00E3\\u00E4\\u00E5\\u00E6\\u00E7\\u00E8\\u00E9\\u00EA\\u00EB\\u00EC\\u00ED\\u00EE\\u00EF\\u00F0\\u00F1\\u00F2\\u00F3\\u00F4\\u00F5\\u00F6\\u00F9\\u00FA\\u00FB\\u00FC\\u00FD\\u00FF\\u0153])+)$", "i");
     
     //Vérifier si au moins deux caractères
     let l = val.length;
     if(l < 2) msgErr = "Au moins deux caractères alphabétiques";

      //Vérifier si les caractères de séparation sont suivantes
      if(l > 1){
        if(!reg.test(val)) msgErr = "Les caractères de séparation (- ou _ ou espace) sont autorisés, mais n'autorise pas qu'ils se suivent.";
      }
     
     document.getElementById('errNom').innerHTML = msgErr;

     if (msgErr !== "") erreurCmpt = true;
   }

   function prenomValider() {
      let msgErr = "";
      let val = f.prenom.value.trim();
      let reg = new RegExp("^((?:\\w|[\\-_ ](?![\\-_ ])|[\\u00C0\\u00C1\\u00C2\\u00C3\\u00C4\\u00C5\\u00C6\\u00C7\\u00C8\\u00C9\\u00CA\\u00CB\\u00CC\\u00CD\\u00CE\\u00CF\\u00D0\\u00D1\\u00D2\\u00D3\\u00D4\\u00D5\\u00D6\\u00D8\\u00D9\\u00DA\\u00DB\\u00DC\\u00DD\\u00DF\\u00E0\\u00E1\\u00E2\\u00E3\\u00E4\\u00E5\\u00E6\\u00E7\\u00E8\\u00E9\\u00EA\\u00EB\\u00EC\\u00ED\\u00EE\\u00EF\\u00F0\\u00F1\\u00F2\\u00F3\\u00F4\\u00F5\\u00F6\\u00F9\\u00FA\\u00FB\\u00FC\\u00FD\\u00FF\\u0153])+)$", "i");
      
      //Vérifier si au moins deux caractères
      let l = val.length;
      if(l < 2) msgErr = "Au moins deux caractères alphabétiques";

      //Vérifier si les caractères de séparation sont suivantes
      if(l > 1){
        if(!reg.test(val)) msgErr = "Les caractères de séparation (- ou _ ou espace) sont autorisés, mais n'autorise pas qu'ils se suivent.";
      }
      
      document.getElementById('errPrenom').innerHTML = msgErr;

      if (msgErr !== "") erreurCmpt = true;
   }

   function mot_de_passeValider() {
      let msgErr = "";
      let val = f.mot_de_passe.value.trim();
      let reg = new RegExp("^((?:\\w|[\\-_ ](?![\\-_ ])|[\\u00C0\\u00C1\\u00C2\\u00C3\\u00C4\\u00C5\\u00C6\\u00C7\\u00C8\\u00C9\\u00CA\\u00CB\\u00CC\\u00CD\\u00CE\\u00CF\\u00D0\\u00D1\\u00D2\\u00D3\\u00D4\\u00D5\\u00D6\\u00D8\\u00D9\\u00DA\\u00DB\\u00DC\\u00DD\\u00DF\\u00E0\\u00E1\\u00E2\\u00E3\\u00E4\\u00E5\\u00E6\\u00E7\\u00E8\\u00E9\\u00EA\\u00EB\\u00EC\\u00ED\\u00EE\\u00EF\\u00F0\\u00F1\\u00F2\\u00F3\\u00F4\\u00F5\\u00F6\\u00F9\\u00FA\\u00FB\\u00FC\\u00FD\\u00FF\\u0153])+)$", "i");
      
      //Vérifier si au moins deux caractères
      let l = val.length;
      if(l < 2) msgErr = "Au moins deux caractères alphabétiques";

      //Vérifier si les caractères de séparation sont suivantes
      if(l > 1){
        if(!reg.test(val)) msgErr = "Les caractères de séparation (- ou _ ou espace) sont autorisés, mais n'autorise pas qu'ils se suivent.";
      }
      
      document.getElementById('errMDP').innerHTML = msgErr;

      if (msgErr !== "") erreurCmpt = true
   }


});