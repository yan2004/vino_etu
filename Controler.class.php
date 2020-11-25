<?php
/**
 * Class Controler
 * Gère les requêtes HTTP
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2019-01-21
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
					$this->authentification();
					break;
				case 'listeBouteille':
					$this->listeBouteille();
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
				case 'modifierBouteilleCellier':
					$this->modifierBouteilleCellier();
					break;
				case 'formModificationBtl':
				 	$this->formModificationBtl();
					 break;
				case 'sauvegardeBouteille':
					$this->sauvegardeBouteille();
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
				case 'deconnexion':
					$this->deconnexion();
					break;
				default:
					$this->accueil();
					break;
			}
		}

		private function authentification()
		{
			$auth = new Authentification();
			$body = json_decode(file_get_contents('php://input'));

			//validations back end
			if(isset($body->courriel) && isset($body->password) && !empty(trim($body->courriel)) && !empty(trim($body->password))){

				// test regex
				// $regexCourriel = '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/i';
				$regexCourriel = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/i';
				$regexPassword = '/^[0-9a-z]{4,}$/i';

				if (preg_match($regexCourriel, $body->courriel) != 0 && preg_match($regexPassword, $body->password) != 0){

					$valide = $auth->validerAuthentification($body->courriel, $body->password);

					if($valide){
						// sauvegarde de l'usager authentifié
						$_SESSION["courriel"] = $body->courriel;

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

		private function creerCompte()
		{
			$auth = new Authentification();

			$body = json_decode(file_get_contents('php://input'));

			// validations back end
			if	(isset($body->courriel) && isset($body->nom) && isset($body->prenom) && isset($body->password)
				&& !empty(trim($body->courriel)) && !empty(trim($body->nom)) && !empty(trim($body->prenom)) && !empty(trim($body->password))){

				// test regex
				$regexCourriel = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/i';
				$regexNomPrenom = '/^[a-zà-ÿ]{2,}$/i';
				$regexPassword = '/^[0-9a-z]{4,}$/i';

				if (preg_match($regexCourriel, $body->courriel) && preg_match($regexNomPrenom, $body->nom) && preg_match($regexNomPrenom, $body->prenom) && preg_match($regexPassword, $body->password)){
					$valide = $auth->creerCompte($body->courriel, $body->nom, $body->prenom, $body->password);

					if($valide){
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

		// accueil publique (usager qui n'est pas encore authentifié)
		private function accueil()
		{
			include("vues/welcome.php");     
		}

		// cette méthode se nommait "accueil" avant
		private function accueilUsager()
		{
			if(isset($_SESSION['courriel'])){
				$bte = new Bouteille();
				$data = $bte->getListeBouteilleCellier();
				include("vues/entete.php");
				include("vues/cellier.php");
				include("vues/pied.php");  
			}else{
				$this->accueil();
			}  
		}

		private function listeBouteille()
		{
			$bte = new Bouteille();
            $cellier = $bte->getListeBouteilleCellier();
            echo json_encode($cellier);  
		}
		
		private function autocompleteBouteille()
		{
			$bte = new Bouteille();
			$body = json_decode(file_get_contents('php://input'));
            $listeBouteille = $bte->autocomplete($body->nom);
            echo json_encode($listeBouteille);    
		}

		private function ajouterNouvelleBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));

			if(!empty($body)){
				$bte = new Bouteille();

				$resultat = $bte->ajouterBouteilleCellier($body);
				echo json_encode($resultat);
			}
			else{
				include("vues/entete.php");
				include("vues/ajouter.php");
				include("vues/pied.php");
			}
		}
		
		private function boireBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));
			
			$bte = new Bouteille();
			$resultat = $bte->modifierQuantiteBouteilleCellier($body->id, -1);
			echo json_encode($resultat);
		}

		private function ajouterBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));
			
			$bte = new Bouteille();
			$resultat = $bte->modifierQuantiteBouteilleCellier($body->id, 1);
			echo json_encode($resultat);
		}

		private function modifierBouteilleCellier()
		{
			$bte = new Bouteille();
			$data = $bte->getListeBouteilleCellierById($_GET['id']);
			echo json_encode($data);

			//  include("vues/entete.php");
			//  include("vues/modificationBtl.php");
			//  include("vues/pied.php");
			
		}

		 private function formModificationBtl()
		 {
			
			   $data =json_decode($_GET['dataBtls'], true);
			   //var_dump($data[0]);
		
			   include("vues/entete.php");
			   include("vues/modificationBtl.php");
			   include("vues/pied.php");
			  
			   
		 }

		private function sauvegardeBouteille()
		{
			$requestPayload = file_get_contents('php://input');
			$object = json_decode($requestPayload, true);
			//var_dump($object);

			$bte = new Bouteille();
			$resultat = $bte->modificationInfoBtl($object['btlIdPK'],$object['date_achat'],$object['garde'],$object['notes'],$object['prix'],$object['quantite'],$object['millesime']);

		}

		private function modifierCompte()
		{
			$usager = new Usager();
			$data = $usager->getUserByCourriel($_SESSION['courriel']);
			
			include("vues/entete.php");
			include("vues/compte.php");
			include("vues/pied.php");

		}

		private function sauvegardeCompte()
		{
			/**
			 * *******************
			 * To Do
			 * récupérer id d'usager quand authentification
			 * *******************
			 */
			$usager = new Usager();
			$usager->sauvegardeModificationCompte($_POST['userId'], $_POST['nom'],$_POST['prenom'], $_POST['mot_de_passe']); 

			$bte = new Bouteille();
			$data = $bte->getListeBouteilleCellier();
			include("vues/entete.php");
			include("vues/cellier.php");
			include("vues/pied.php"); 
		}
		
		private function getCurrentUser()
		{

		}

		private function deconnexion(){

			//fermer la session usager
			session_destroy();

			$this->accueil();
		}


}
?>















