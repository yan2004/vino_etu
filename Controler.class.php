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
	// constantes pour les validations regex
	const REGEX_COURRIEL	= '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/i';
	const REGEX_PASSWORD	= '/^(?=.*[0-9])(?=.*[a-z])([a-z0-9!@#$%^&*;.,\-_\'"]{4,})$/i';
	const REGEX_NOM_PRENOM	= '/^[\u4e00-\u9fa5a-zà-ÿ\d \',\-"\.]{1,50}$/i';
	const REGEX_PRIX		= '/^(0|00|[1-9]\d*)(\.[0-9]{2})$/';
	const REGEX_QUANTITE	= '/^(0|[1-9]\d*)$/';
	const REGEX_DATE_ACHAT	= '/^[1-2][0-9]{3}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/';
	// champs non obligatoires
	const REGEX_NOTES_GARDE = '/^[0-9a-zà-ÿ\'",\.\-;!)(?@#$%^&:*+_ ]{0,200}$/i';
	const REGEX_MILLESIME	= '/^[1-2][0-9]{3}$/';


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

				$this->sendResponseObject(true);

				// $BaseURL = "http://localhost:8888/vino/vino_etu/";
				$BaseURL = "http://localhost/projetWeb2/vino_etu/";
				$url     = "Location:".$BaseURL."index.php?requete=accueilUsager";
				header($url);
				
			}else{
				$this->sendResponseObject(false, "Combinaison invalide.");
			}

		}else
		{
			// validations back end
			if(isset($body->courriel) && isset($body->password) && !empty(trim($body->courriel)) && !empty(trim($body->password))){

				// test regex
				if (preg_match(self::REGEX_COURRIEL, $body->courriel) != 0 && preg_match(self::REGEX_PASSWORD, $body->password) != 0){

					$valide = $auth->validerAuthentification($body->courriel, $body->password);

					if($valide){
						// sauvegarde de l'usager authentifié
						$_SESSION["courriel"] = $body->courriel;

						setcookie("courriel", $body->courriel, time()+(60*60*24*30));
						setcookie("password", $body->password, time()+(60*60*24*30));

						$this->sendResponseObject(true);

					}else{
						$this->sendResponseObject(false, "Combinaison invalide.");
					}
				}else{
					$this->sendResponseObject(false);
				}
			}else{
				$this->sendResponseObject(false);
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
			if (preg_match(self::REGEX_COURRIEL, $body->courriel) && preg_match(self::REGEX_NOM_PRENOM, $body->nom) && preg_match(self::REGEX_NOM_PRENOM, $body->prenom) && preg_match(self::REGEX_PASSWORD, $body->password)){
				$valide = $auth->creerCompte($body->courriel, $body->nom, $body->prenom, $body->password);

				if($valide){
					$_SESSION["courriel"] = $body->courriel;
					setcookie("courriel", $body->courriel, time()+(60*60*24*30));
					setcookie("password", $body->password, time()+(60*60*24*30));

					$this->sendResponseObject(true);
				}else{
					$this->sendResponseObject(false, "Ce courriel existe déjà.");
				}
			}else{
				$this->sendResponseObject(false);
			}
		}else{
			$this->sendResponseObject(false);
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

				$champsOptValides = true;

				// validation des champs non-obligatoires
				if(isset($body->notes) && !empty($body->notes) && !preg_match(self::REGEX_NOTES_GARDE, $body->notes) || 
				isset($body->garde) && !empty($body->garde) && !preg_match(self::REGEX_NOTES_GARDE, $body->garde) || 
				isset($body->millesime) && !empty($body->millesime) && !preg_match(self::REGEX_MILLESIME, $body->millesime)){
					$champsOptValides = false;
				}
				
				if(preg_match(self::REGEX_PRIX, $body->prix) && preg_match(self::REGEX_QUANTITE, $body->quantite) && preg_match(self::REGEX_DATE_ACHAT, $body->date_achat) && $champsOptValides){

					$bte = new Bouteille();

					$resultat = $bte->ajouterBouteilleCellier($body);

					if($resultat){
						$this->sendResponseObject(true);
					}else{
						$this->sendResponseObject(false, "Impossible d'ajouter cette bouteille.");
					}
				}else{
					$this->sendResponseObject(false, "Un ou plusieurs champs invalides.");
				}
			}else{
				$this->sendResponseObject(false, "Veuillez remplir les champs obligatoires (nom, date d'achat, prix et quantité).");
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

			$champsOptValides = true;

			// validation des champs non-obligatoires
			if(isset($object['notes']) && !empty($object['notes']) && !preg_match(self::REGEX_NOTES_GARDE, $object['notes']) || 
			isset($object['garde']) && !empty($object['garde']) && !preg_match(self::REGEX_NOTES_GARDE, $object['garde']) || 
			isset($object['millesime']) && !empty($object['millesime']) && !preg_match(self::REGEX_MILLESIME, $object['millesime'])){
				$champsOptValides = false;
			}
			
			if(preg_match(self::REGEX_PRIX, $object['prix']) && preg_match(self::REGEX_QUANTITE, $object['quantite']) && preg_match(self::REGEX_DATE_ACHAT, $object['date_achat']) && $champsOptValides){

				$bte = new Bouteille();
				$resultat = $bte->modificationInfoBtl($object['nomBtl'],$object['btlIdPK'],$object['date_achat'],$object['garde'],$object['notes'],$object['prix'],$object['quantite'],$object['millesime']);
				
				if($resultat){
					$this->sendResponseObject(true);
				}else{
					$this->sendResponseObject(false, "Impossible de modifier cette bouteille.");
				}
			}else{
				$this->sendResponseObject(false, "Un ou plusieurs champs invalides.");
			}
		}else{
			$this->sendResponseObject(false, "Veuillez remplir les champs obligatoires (nom, date d'achat, prix et quantité).");
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
				$this->sendResponseObject(true);
			}else{
				$this->sendResponseObject(false, "Impossible de supprimer la bouteille.");
			}
		}else{
			$this->sendResponseObject(false, "Paramètres manquants.");
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

			// cas par defaut si on a pas change le password
			$passwordValide = true;

			// le seul cas où la validation du password serait incorecte
			if(isset($body->mot_de_passe) && !empty($body->mot_de_passe) && !preg_match(self::REGEX_PASSWORD, $body->mot_de_passe)){
				$passwordValide = false;
			}
			
			if(preg_match(self::REGEX_NOM_PRENOM, $body->nom) && preg_match(self::REGEX_NOM_PRENOM, $body->prenom) && $passwordValide){

				$usager = new Usager();
				$resultat = $usager->sauvegardeModificationCompte($body->nom,$body->prenom, $body->mot_de_passe); 

				if($resultat){
					$this->sendResponseObject(true);
				}else{
					$this->sendResponseObject(false, "Impossible de modifier les informations.");
				}
			}else{
				$this->sendResponseObject(false, "Paramètres Invalides.");
			}
		}else{
			$this->sendResponseObject(false, "Paramètres manquants.");
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
				$this->sendResponseObject(true);
			}else{
				$this->sendResponseObject(false, "Impossible de supprimer l'usager.");
			}
		}else{
			$this->sendResponseObject(false, "Paramètres manquants.");
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

	/**
	 * Fonction qui crée un objet de réponse et envoi le résultat du succès ou non de la validation
	 */
	private function sendResponseObject($succes, $msg = ""){

		$responseObj = new stdClass();
		$responseObj->success = $succes;
		$responseObj->msg = $msg;
		$responseJSON = json_encode($responseObj);
		echo $responseJSON;
	}
}
?>















