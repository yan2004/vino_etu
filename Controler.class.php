<?php
/**
 * Class Controler
 * Gère les requêtes HTTP
 * 
 * @author Yan Jin et Marianne Soucy
 * @version 1.0
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */

class Controler 
{
	/**
	 * Traite la requête
	 * @return void
	 */
	public function gerer()
	{
		switch ($_GET['requete']) {
			case 'authentification':
				$this->authentification("");
				break;
			case 'listeBouteille':
				$this->listeBouteille();
				break;
			case 'resultatRecherche':
				$this->resultatRecherche();
				break;
			case 'autocompleteBouteille':
				$this->autocompleteBouteille();
				break;
			case 'ajouterNouvelleBouteilleCellier':
				$this->ajouterNouvelleBouteilleCellier();
				break;
			case 'ajouterBouteilleCellier':
				$this->ajouterBouteilleCellier();
				break;
			case 'boireBouteilleCellier':
				$this->boireBouteilleCellier();
				break;
			case 'formModificationBtl':
				$this->formModificationBtl();
					break;
			case 'sauvegardeBouteille':
				$this->sauvegardeBouteille();
				break;
			case 'supprimerBouteilleCellier':
				$this->supprimerBouteilleCellier();
				break;
			case 'accueilUsager':
				$this->accueilUsager();
				break;
			case 'modifierCompte':
				$this->modifierCompte();
				break;
			case 'creerCompte':
				$this->creerCompte();
				break;
			case 'sauvegardeCompte':
				$this->sauvegardeCompte();
				break;
			case 'importationSAQ':
				$this->importationSAQ();
				break;
			case 'gererUsager':
				$this->gererUsager();
				break;
			case 'sauvegarderSupprimer':
				$this->sauvegarderSupprimer();
				break;
			case 'deconnexion':
				$this->deconnexion();
				break;
			case 'cookieLogin':
				$this->authentification("cookieLogin");
				break;
			default:
				$this->accueil();
				break;
		}
	}

	/**
	 * Fonction servant à authentifier un usager ou un admin
	 */
	private function authentification($mode)
	{
		$auth = new Authentification();
		$body = json_decode(file_get_contents('php://input'));

		//autologin avec COOKIE
		if($mode == "cookieLogin")
		{
			$valide = $auth->validerAuthentification($_COOKIE['courriel'], $_COOKIE['password']);
			
			if($valide){

				// sauvegarde de l'usager authentifié
				$_SESSION["courriel"] = $_COOKIE['courriel'];
				
				$responseObj = new stdClass();
				$responseObj->success = true;
				$responseJSON = json_encode($responseObj);
				echo $responseJSON;

				// ****************************************************************
				// TODO : FAIRE UNE CONSTANTE AVEC L'URL DANS LE HAUT DU DOCUMENT
				// POUR QUE ÇA SOIT PLUS ACCESSIBLE/FACILE À REPÉRER ET CHANGER

				// $BaseURL = "http://localhost:8888/vino/vino_etu/";
				$BaseURL = "http://localhost/projetWeb2/vino_etu/";
				$url     = "Location:".$BaseURL."index.php?requete=accueilUsager";
				header($url);
				
			}else{
				$responseObj = new stdClass();
				$responseObj->success = false;
				$responseObj->msg = "Combinaison invalide.";
				$responseJSON = json_encode($responseObj);
				echo $responseJSON;
			}

		}else
		{
			//validations back end
			if(isset($body->courriel) && isset($body->password) && !empty(trim($body->courriel)) && !empty(trim($body->password))){

				// test regex
				$regexCourriel = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/i';
				$regexPassword = '/^(?=.*[0-9])(?=.*[a-z])([a-z0-9!@#$%^&*;.,\-_\'"]{4,})$/i';

				if (preg_match($regexCourriel, $body->courriel) != 0 && preg_match($regexPassword, $body->password) != 0){

					$valide = $auth->validerAuthentification($body->courriel, $body->password);

					if($valide){
						// sauvegarde de l'usager authentifié
						$_SESSION["courriel"] = $body->courriel;

						setcookie("courriel", $body->courriel, time()+(60*60*24*30));
						setcookie("password", $body->password, time()+(60*60*24*30));

						$responseObj = new stdClass();
						$responseObj->success = true;
						$responseJSON = json_encode($responseObj);
						echo $responseJSON;
					}else{
						$responseObj = new stdClass();
						$responseObj->success = false;
						$responseObj->msg = "Combinaison invalide.";
						$responseJSON = json_encode($responseObj);
						echo $responseJSON;
					}
				}else{
					$responseObj = new stdClass();
					$responseObj->success = false;
					$responseObj->msg = "";
					$responseJSON = json_encode($responseObj);
					echo $responseJSON;
				}
			}else{
				$responseObj = new stdClass();
				$responseObj->success = false;
				$responseObj->msg = "";
				$responseJSON = json_encode($responseObj);
				echo $responseJSON;
			}
		}
	}

	/**
	 * Fonction servant à la création d'un compte usager
	 */
	private function creerCompte()
	{
		$auth = new Authentification();

		$body = json_decode(file_get_contents('php://input'));

		// validations back end
		if	(isset($body->courriel) && isset($body->nom) && isset($body->prenom) && isset($body->password)
			&& !empty(trim($body->courriel)) && !empty(trim($body->nom)) && !empty(trim($body->prenom)) && !empty(trim($body->password))){

			// test regex
			$regexCourriel = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/i';
			$regexNomPrenom = '/^[\u4e00-\u9fa5a-zà-ÿ\d \',\-"\.]{1,50}$/i';
			$regexPassword = '/^(?=.*[0-9])(?=.*[a-z])([a-z0-9!@#$%^&*;.,\-_\'"]{4,})$/i';

			if (preg_match($regexCourriel, $body->courriel) && preg_match($regexNomPrenom, $body->nom) && preg_match($regexNomPrenom, $body->prenom) && preg_match($regexPassword, $body->password)){
				$valide = $auth->creerCompte($body->courriel, $body->nom, $body->prenom, $body->password);

				if($valide){
					$_SESSION["courriel"] = $body->courriel;
					setcookie("courriel", $body->courriel, time()+(60*60*24*30));
					setcookie("password", $body->password, time()+(60*60*24*30));

					$responseObj = new stdClass();
					$responseObj->success = true;
					$responseJSON = json_encode($responseObj);
					echo $responseJSON;
				}else{
					$responseObj = new stdClass();
					$responseObj->success = false;
					$responseObj->msg = "Ce courriel existe déjà.";
					$responseJSON = json_encode($responseObj);
					echo $responseJSON;
				}
			}else{
				$responseObj = new stdClass();
				$responseObj->success = false;
				$responseObj->msg = "";
				$responseJSON = json_encode($responseObj);
				echo $responseJSON;
			}
		}else{
			$responseObj = new stdClass();
			$responseObj->success = false;
			$responseObj->msg = "";
			$responseJSON = json_encode($responseObj);
			echo $responseJSON;
		}
	}

	/**
	 * Fonction pour affichage de l'accueil publique (usager non authentifié)
	 */
	private function accueil()
	{
		include("vues/welcome.php");     
	}

	/**
	 * Fonction pour l'affichage de l'accueil d'un usager ou d'un admin
	 */
	private function accueilUsager()
	{
		// valider la session
		if(isset($_SESSION['courriel'])){

			$auth = new Authentification();

			$admin = $auth->adminVerification($_SESSION['courriel']); 

			// vérifier si il s'agit d'un admin
			if($admin == TRUE){

				// afficher les vues accueil admin
				include("vues/enteteAdmin.php");
				include("vues/mainAdmin.php");
				include("vues/pied.php");
		
			}else{
				
				$bte = new Bouteille();
				$data = $bte->getListeBouteilleCellier();

				// pour afficher le nom d'usager
				$usager = new Usager();
				$dataUsager = $usager->getUserByCourriel($_SESSION['courriel']);

				// afficher les vues accueil d'un usager
				include("vues/entete.php");
				include("vues/cellier.php");
				include("vues/pied.php");  
			}
		}else{
			// afficher l'accueil publique
			$this->accueil();
		}
	}

	/**
	 * Fonction pour afficher le résultat de la recherche
	 */
	private function resultatRecherche()
	{
		$recherche = $_GET['recherche'];
		$bte = new Bouteille();
		$data = $bte->getListeBouteilleCellier($recherche);

		// pour afficher le nom d'usager
		$usager = new Usager();
		$dataUsager = $usager->getUserByCourriel($_SESSION['courriel']);

		include("vues/entete.php");
		include("vues/cellier.php");
		include("vues/pied.php");    
	}

	/**
	 * Fonction qui affiche la liste des bouteilles dans un cellier
	 */
	private function listeBouteille()
	{
		$bte = new Bouteille();
		$cellier = $bte->getListeBouteilleCellier();

		echo json_encode($cellier);  
	}
	
	/**
	 * Fonction pour la fonctionnalité d'autocomplete dans les formulaires de bouteilles
	 */
	private function autocompleteBouteille()
	{
		$bte = new Bouteille();
		$body = json_decode(file_get_contents('php://input'));
		$listeBouteille = $bte->autocomplete($body->nom);
		echo json_encode($listeBouteille);    
	}

	/**
	 * Fonction pour ajouter une nouvelle bouteille au cellier d'un usager
	 */
	private function ajouterNouvelleBouteilleCellier()
	{
		$body = json_decode(file_get_contents('php://input'));

		if(!empty($body)){

			if(isset($body->id_bouteille) && isset($body->date_achat) && isset($body->prix) && isset($body->quantite)
				&& !empty(trim($body->id_bouteille)) && !empty($body->date_achat) && !empty($body->prix)){

				// test regex
				$regexPrix = '/^(0|00|[1-9]\d*)(\.[0-9]{2})$/';
				$regexQuantite = '/^(0|[1-9]\d*)$/';
				$regexDateAchat = '/^[1-2][0-9]{3}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/';
				// champs non obligatoires
				$regexNotesGarde = '/^[0-9a-zà-ÿ\'",\.\-;!)(?@#$%^&:*+_ ]{0,200}$/i';
				$regexMillesime = '/^[1-2][0-9]{3}$/';

				$champsOptValides = true;

				// validation des champs non-obligatoires
				if(isset($body->notes) && !empty($body->notes) && !preg_match($regexNotesGarde, $body->notes) || 
				isset($body->garde) && !empty($body->garde) && !preg_match($regexNotesGarde, $body->garde) || 
				isset($body->millesime) && !empty($body->millesime) && !preg_match($regexMillesime, $body->millesime)){
					$champsOptValides = false;
				}
				
				if(preg_match($regexPrix, $body->prix) && preg_match($regexQuantite, $body->quantite) && preg_match($regexDateAchat, $body->date_achat) && $champsOptValides){

					$bte = new Bouteille();

					$resultat = $bte->ajouterBouteilleCellier($body);

					if($resultat){
						$responseObj = new stdClass();
						$responseObj->success = true;
						$responseJSON = json_encode($responseObj);
						echo $responseJSON;
					}else{
						$responseObj = new stdClass();
						$responseObj->success = false;
						$responseObj->msg = "Impossible d'ajouter cette bouteille.";
						$responseJSON = json_encode($responseObj);
						echo $responseJSON;
					}
				}else{
					$responseObj = new stdClass();
					$responseObj->success = false;
					$responseObj->msg = "Un ou plusieurs champs invalides.";
					$responseJSON = json_encode($responseObj);
					echo $responseJSON;
				}
			}else{
				$responseObj = new stdClass();
				$responseObj->success = false;
				$responseObj->msg = "Veuillez remplir les champs obligatoires (nom, date d'achat, prix et quantité).";
				$responseJSON = json_encode($responseObj);
				echo $responseJSON;
			}

		}else{
			include("vues/entete.php");
			include("vues/ajouter.php");
			include("vues/pied.php");
		}
	}
	
	/**
	 * Fonction pour diminuer la quantité d'une bouteille dans un cellier de 1 unité
	 */
	private function boireBouteilleCellier()
	{
		$body = json_decode(file_get_contents('php://input'));
		
		$bte = new Bouteille();
		$resultat = $bte->modifierQuantiteBouteilleCellier($body->id, -1);
		echo json_encode($resultat);
	}

	/**
	 * Fonction pour augmenter la quantité d'une bouteille dans un cellier de 1 unité
	 */
	private function ajouterBouteilleCellier()
	{
		$body = json_decode(file_get_contents('php://input'));
		
		$bte = new Bouteille();
		$resultat = $bte->modifierQuantiteBouteilleCellier($body->id, 1);
		echo json_encode($resultat);
	}

	/**
	 * Fonction pour afficher le formulaire de modification d'une bouteille
	 */
	private function formModificationBtl()
	{
		$bte = new Bouteille();
		$data = $bte->getListeBouteilleCellierById($_GET['id']);
		
		include("vues/entete.php");
		include("vues/modificationBtl.php");
		include("vues/pied.php");
	}

	/**
	 * Fonction pour sauvegarder les informations d'une bouteille
	 */
	private function sauvegardeBouteille()
	{
		$requestPayload = file_get_contents('php://input');
		$object = json_decode($requestPayload, true);

		if(isset($object['nomBtl']) && isset($object['date_achat']) && isset($object['prix']) && isset($object['quantite'])
			&& !empty($object['nomBtl']) && !empty($object['date_achat']) && !empty($object['prix'])){

			// test regex
			$regexPrix = '/^(0|00|[1-9]\d*)(\.[0-9]{2})$/';
			$regexQuantite = '/^(0|[1-9]\d*)$/';
			$regexDateAchat = '/^[1-2][0-9]{3}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/';
			// champs non obligatoires
			$regexNotesGarde = '/^[0-9a-zà-ÿ\'",\.\-;!)(?@#$%^&:*+_ ]{0,200}$/i';
			$regexMillesime = '/^[1-2][0-9]{3}$/';

			$champsOptValides = true;

			// validation des champs non-obligatoires
			if(isset($object['notes']) && !empty($object['notes']) && !preg_match($regexNotesGarde, $object['notes']) || 
			isset($object['garde']) && !empty($object['garde']) && !preg_match($regexNotesGarde, $object['garde']) || 
			isset($object['millesime']) && !empty($object['millesime']) && !preg_match($regexMillesime, $object['millesime'])){
				$champsOptValides = false;
			}
			
			if(preg_match($regexPrix, $object['prix']) && preg_match($regexQuantite, $object['quantite']) && preg_match($regexDateAchat, $object['date_achat']) && $champsOptValides){

				$bte = new Bouteille();
				$resultat = $bte->modificationInfoBtl($object['nomBtl'],$object['btlIdPK'],$object['date_achat'],$object['garde'],$object['notes'],$object['prix'],$object['quantite'],$object['millesime']);
				
				if($resultat){
					$responseObj = new stdClass();
					$responseObj->success = true;
					$responseJSON = json_encode($responseObj);
					echo $responseJSON;
				}else{
					$responseObj = new stdClass();
					$responseObj->success = false;
					$responseObj->msg = "Impossible de modifier cette bouteille.";
					$responseJSON = json_encode($responseObj);
					echo $responseJSON;
				}
			}else{
				$responseObj = new stdClass();
				$responseObj->success = false;
				$responseObj->msg = "Un ou plusieurs champs invalides.";
				$responseJSON = json_encode($responseObj);
				echo $responseJSON;
			}
		}else{
			$responseObj = new stdClass();
			$responseObj->success = false;
			$responseObj->msg = "Veuillez remplir les champs obligatoires (nom, date d'achat, prix et quantité).";
			$responseJSON = json_encode($responseObj);
			echo $responseJSON;
		}
	}

	/**
	 * Fonction pour supprimer une bouteille d'un cellier
	 */
	private function supprimerBouteilleCellier(){

		$body = json_decode(file_get_contents('php://input'));

		if(isset($_SESSION['courriel']) && isset($body->id)){

			$bte = new Bouteille();

			$resultat = $bte->supprimerBouteilleCellier($body);

			if($resultat){
				$responseObj = new stdClass();
				$responseObj->success = true;
				$responseJSON = json_encode($responseObj);
				echo $responseJSON;
			}else{
				$responseObj = new stdClass();
				$responseObj->success = false;
				$responseObj->msg = "Impossible de supprimer la bouteille.";
				$responseJSON = json_encode($responseObj);
				echo $responseJSON;
			}
		}else{
			$responseObj = new stdClass();
			$responseObj->success = false;
			$responseObj->msg = "Paramètres manquants.";
			$responseJSON = json_encode($responseObj);
			echo $responseJSON;
		}

	}

	/**
	 * Fonction pour modifier les informations du compte d'un usager
	 */
	private function modifierCompte()
	{
		$usager = new Usager();
		$data = $usager->getUserByCourriel($_SESSION['courriel']);
		
		include("vues/entete.php");
		include("vues/compte.php");
		include("vues/pied.php");
	}

	/**
	 * Fonction pour sauvegarder les informations du compte usager
	 */
	private function sauvegardeCompte()
	{
		$body = json_decode(file_get_contents('php://input'));

		if(isset($_SESSION['courriel']) && isset($body->nom) && isset($body->prenom) && !empty($body->nom) && !empty($body->prenom)){

			// test regex
			$regexNomPrenom = '/^[\u4e00-\u9fa5a-zà-ÿ\d \',\-"\.]{1,50}$/i';
			$regexPassword = '/^(?=.*[0-9])(?=.*[a-z])([a-z0-9!@#$%^&*;.,\-_\'"]{4,})$/i';

			// cas par defaut si on a pas change le password
			$passwordValide = true;

			// le seul cas où la validation du password serait incorecte
			if(isset($body->mot_de_passe) && !empty($body->mot_de_passe) && !preg_match($regexPassword, $body->mot_de_passe)){
				$passwordValide = false;
			}
			
			if(preg_match($regexNomPrenom, $body->nom) && preg_match($regexNomPrenom, $body->prenom) && $passwordValide){

				$usager = new Usager();
				$resultat = $usager->sauvegardeModificationCompte($body->nom,$body->prenom, $body->mot_de_passe); 

				if($resultat){
					$responseObj = new stdClass();
					$responseObj->success = true;
					$responseJSON = json_encode($responseObj);
					echo $responseJSON;
				}else{
					$responseObj = new stdClass();
					$responseObj->success = false;
					$responseObj->msg = "Impossible de modifier les informations.";
					$responseJSON = json_encode($responseObj);
					echo $responseJSON;
				}
			}else{
				$responseObj = new stdClass();
				$responseObj->success = false;
				$responseObj->msg = "Paramètres Invalides.";
				$responseJSON = json_encode($responseObj);
				echo $responseJSON;
			}
		}else{
			$responseObj = new stdClass();
			$responseObj->success = false;
			$responseObj->msg = "Paramètres manquants.";
			$responseJSON = json_encode($responseObj);
			echo $responseJSON;
		}
	}

	/**
	 * Fonction pour importer des bouteilles du site de la SAQ dans la bd
	 */
	private function importationSAQ(){

		$body = json_decode(file_get_contents('php://input'));

		$nbrPages = $body->nbrPages;
		$nombreItems = $body->nbrItems; //24, 48 ou 96

		include("updateSAQ.php");  
	}

	/**
	 * Fonction pour afficher la vue de la gestion d'usagers dans l'admin
	 */
	private function gererUsager(){

		$usager = new Admin();
		$data = $usager->getListeUsagers();

		include("vues/enteteAdmin.php");
		include("vues/gererUsager.php");
		include("vues/pied.php");
	}

	/**
	 * Fonction pour supprimer un usager de la bd
	 */
	private function sauvegarderSupprimer(){

		$body = json_decode(file_get_contents('php://input'));
		
			if(isset($body->idUsagerSupr)){

			$usager = new Admin();

			$resultat = $usager->supprimerUsager($body->idUsagerSupr);
				
			if($resultat){
				$responseObj = new stdClass();
				$responseObj->success = true;
				$responseJSON = json_encode($responseObj);
				echo $responseJSON;
			}else{
				$responseObj = new stdClass();
				$responseObj->success = false;
				$responseObj->msg = "Impossible de supprimer l'usager.";
				$responseJSON = json_encode($responseObj);
				echo $responseJSON;
			}
		}else{
			$responseObj = new stdClass();
			$responseObj->success = false;
			$responseObj->msg = "Paramètres manquants.";
			$responseJSON = json_encode($responseObj);
			echo $responseJSON;
		}
	}

	/**
	 * Fonction pour se déconnecter
	 */
	private function deconnexion(){

		//fermer la session usager
		session_destroy();

		//Supprimer $_COOKIE
		if(isset($_COOKIE['courriel']))
		{
			setcookie('courriel', NULL);
			unset($_COOKIE['courriel']);
		}

		if(isset($_COOKIE['password']))
		{
			setcookie('password', NULL);
			unset($_COOKIE['password']); 
		}

		$this->accueil();
	}
}
?>















